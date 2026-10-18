<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CollectionItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CollectionItemController extends Controller
{
    public function index(Request $request, string $collection): View
    {
        $this->checkCollection($collection);
        $visibleFields = $this->visibleFields($collection);
        $search = $request->string('search')->trim()->toString();
        $items = CollectionItem::query()
            ->where('collection', $collection)
            ->when($search, fn ($query) => $query->where(function ($query) use ($search, $visibleFields): void {
                $query->where('title', 'like', '%'.$search.'%')
                    ->when(in_array('category', $visibleFields, true), fn ($query) => $query->orWhere('category', 'like', '%'.$search.'%'));
            }))
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.collections.index', compact('collection', 'items', 'search', 'visibleFields'));
    }

    public function create(string $collection): View
    {
        $this->checkCollection($collection);

        return view('admin.collections.form', [
            'collection' => $collection,
            'item' => new CollectionItem,
            'visibleFields' => $this->visibleFields($collection),
            'requiredFields' => $this->requiredFields($collection),
        ]);
    }

    public function store(Request $request, string $collection): RedirectResponse|JsonResponse
    {
        $this->checkCollection($collection);
        $data = $this->validated($request, $collection);
        if (in_array('features_text', $this->visibleFields($collection), true)) {
            $data['features'] = $this->features($request);
        }
        $data['collection'] = $collection;
        $this->storeFiles($request, $data, null, $collection);
        $item = CollectionItem::query()->create($data);

        if ($request->expectsJson()) {
            return response()->json($item, 201);
        }

        return redirect()->route('admin.collections.index', $collection)->with('status', 'Item created.');
    }

    public function edit(string $collection, CollectionItem $item): View
    {
        $this->checkItem($collection, $item);

        return view('admin.collections.form', [
            'collection' => $collection,
            'item' => $item,
            'visibleFields' => $this->visibleFields($collection),
            'requiredFields' => $this->requiredFields($collection, $item->image !== null),
        ]);
    }

    public function update(Request $request, string $collection, CollectionItem $item): RedirectResponse|JsonResponse
    {
        $this->checkItem($collection, $item);
        $data = $this->validated($request, $collection, $item);
        if (in_array('features_text', $this->visibleFields($collection), true)) {
            $data['features'] = $this->features($request);
        }
        $this->storeFiles($request, $data, $item, $collection);
        $item->update($data);

        if ($request->expectsJson()) {
            return response()->json($item->refresh());
        }

        return redirect()->route('admin.collections.index', $collection)->with('status', 'Item updated.');
    }

    public function destroy(Request $request, string $collection, CollectionItem $item): RedirectResponse|JsonResponse
    {
        $this->checkItem($collection, $item);
        $item->delete();

        if ($request->expectsJson()) {
            return response()->json(['deleted' => true]);
        }

        return redirect()->route('admin.collections.index', $collection)->with('status', 'Item deleted.');
    }

    private function checkCollection(string $collection): void
    {
        abort_unless(array_key_exists($collection, config('cms.collections')), 404);
    }

    private function checkItem(string $collection, CollectionItem $item): void
    {
        $this->checkCollection($collection);
        abort_unless($item->collection === $collection, 404);
    }

    /** @return array<string, mixed> */
    private function validated(Request $request, string $collection, ?CollectionItem $item = null): array
    {
        $slugRule = Rule::unique('collection_items')->where('collection', $collection);
        if ($item) {
            $slugRule->ignore($item->id);
        }

        $fieldRules = [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'alpha_dash', 'max:255', $slugRule],
            'category' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:50000'],
            'summary' => ['nullable', 'string', 'max:5000'],
            'article_subheading' => ['nullable', 'string', 'max:255'],
            'video_url' => ['nullable', 'url', 'max:2048'],
            'price' => ['nullable', 'numeric', 'min:0'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'icon_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:2048'],
            'remove_image' => ['sometimes', 'boolean'],
            'gallery_uploads' => ['nullable', 'array', 'max:10'],
            'gallery_uploads.*' => ['image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'clear_gallery' => ['sometimes', 'boolean'],
            'features_text' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', Rule::in(['draft', 'published'])],
            'client_name' => ['nullable', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'company' => ['nullable', 'string', 'max:255'],
            'rating' => ['nullable', 'integer', 'between:1,5'],
            'role' => ['nullable', 'string', 'max:255'],
            'material' => ['nullable', 'string', 'max:255'],
            'capability' => ['nullable', 'string', 'max:255'],
            'size_range' => ['nullable', 'string', 'max:255'],
            'metric' => ['nullable', 'string', 'max:255'],
            'display_date' => ['nullable', 'string', 'max:64'],
            'social_links' => ['nullable', 'array'],
            'social_links.*' => ['nullable', 'url', 'max:2048'],
            'social_links.instagram' => ['nullable', 'url', 'max:2048'],
            'social_links.linkedin' => ['nullable', 'url', 'max:2048'],
            'social_links.x' => ['nullable', 'url', 'max:2048'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ];
        $requiredFields = $this->requiredFields($collection, $item?->image !== null);
        foreach ($requiredFields as $field) {
            if (array_key_exists($field, $fieldRules)) {
                $fieldRules[$field] = array_values(array_filter($fieldRules[$field], fn ($rule): bool => $rule !== 'nullable'));
                array_unshift($fieldRules[$field], 'required');
            }
        }
        if (in_array($collection, ['products', 'services', 'blogs', 'testimonials', 'case-studies', 'team-members'], true) && $item?->image !== null) {
            $fieldRules['image_upload'] = ['required_if:remove_image,1', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'];
        }
        $visibleFields = $this->visibleFields($collection);
        $alwaysVisible = ['title', 'slug', 'status', 'sort_order'];
        if ($collection === 'testimonials') {
            $fieldRules['client_name'] = ['required', 'string', 'max:255'];
            $fieldRules['description'] = ['required', 'string', 'max:50000'];
            $fieldRules['designation'] = ['required', 'string', 'max:255'];
            $alwaysVisible = ['slug', 'status', 'sort_order'];
        }
        $allowedFields = array_merge($alwaysVisible, $visibleFields, $requiredFields);
        $data = $request->validate(array_intersect_key($fieldRules, array_flip($allowedFields)) + ($collection === 'team-members' ? ['social_links.primary' => ['prohibited']] : []));
        if ($collection === 'testimonials') {
            $data['title'] = $data['client_name'];
        }

        if (! empty($data['video_url'])) {
            $host = parse_url($data['video_url'], PHP_URL_HOST);
            $path = parse_url($data['video_url'], PHP_URL_PATH);
            $scheme = parse_url($data['video_url'], PHP_URL_SCHEME);
            if ($scheme !== 'https' || ! in_array($host, ['www.youtube.com', 'www.youtube-nocookie.com'], true) || ! str_starts_with($path ?: '', '/embed/')) {
                throw ValidationException::withMessages(['video_url' => 'Use a YouTube embed URL.']);
            }
        }

        return $data;
    }

    /** @return array<int, string> */
    private function visibleFields(string $collection): array
    {
        return match ($collection) {
            'products' => ['description', 'image_upload', 'remove_image', 'material', 'capability', 'size_range'],
            'services' => ['description', 'image_upload', 'remove_image'],
            'blogs' => ['category', 'description', 'summary', 'article_subheading', 'video_url', 'image_upload', 'remove_image', 'display_date'],
            'testimonials' => ['description', 'image_upload', 'remove_image', 'client_name', 'designation', 'rating'],
            'case-studies' => ['category', 'description', 'image_upload', 'remove_image', 'metric'],
            'faqs' => ['description'],
            'team-members' => ['image_upload', 'remove_image', 'role', 'social_links'],
            default => [],
        };
    }

    /** @return array<int, string> */
    private function requiredFields(string $collection, bool $hasExistingImage = false): array
    {
        $required = ['slug', 'status', 'sort_order'];
        if ($collection !== 'testimonials') {
            $required[] = 'title';
        }

        $required = array_merge($required, match ($collection) {
            'products' => ['description', 'material', 'capability', 'size_range'],
            'services' => ['description'],
            'blogs' => ['category', 'description', 'summary', 'article_subheading', 'video_url', 'display_date'],
            'testimonials' => ['client_name', 'description', 'designation'],
            'case-studies' => ['category', 'description', 'metric'],
            'faqs' => ['description'],
            'team-members' => ['role', 'social_links.instagram', 'social_links.linkedin', 'social_links.x'],
            default => [],
        });

        if (in_array($collection, ['products', 'services', 'blogs', 'testimonials', 'case-studies', 'team-members'], true) && ! $hasExistingImage) {
            $required[] = 'image_upload';
        }

        return $required;
    }

    /** @param array<string, mixed> $data */
    private function storeFiles(Request $request, array &$data, ?CollectionItem $item, string $collection): void
    {
        $visibleFields = $this->visibleFields($collection);
        unset($data['image_upload'], $data['icon_upload'], $data['gallery_uploads'], $data['features_text'], $data['remove_image'], $data['clear_gallery']);
        if (in_array('remove_image', $visibleFields, true) && $request->boolean('remove_image')) {
            $data['image'] = null;
        }
        if (in_array('image_upload', $visibleFields, true) && $request->hasFile('image_upload')) {
            $path = $request->file('image_upload')->store('collection-items', 'public');
            $data['image'] = Storage::disk('public')->url($path);
        }
        if (in_array('icon_upload', $visibleFields, true) && $request->hasFile('icon_upload')) {
            $path = $request->file('icon_upload')->store('collection-icons', 'public');
            $data['icon'] = Storage::disk('public')->url($path);
        }

        if (in_array('gallery_uploads', $visibleFields, true) && $request->hasFile('gallery_uploads')) {
            $data['gallery'] = array_map(
                fn ($file) => Storage::disk('public')->url($file->store('collection-items', 'public')),
                $request->file('gallery_uploads'),
            );
        } elseif (in_array('clear_gallery', $visibleFields, true) && $request->boolean('clear_gallery')) {
            $data['gallery'] = [];
        } elseif ($item) {
            $data['gallery'] = $item->gallery;
        }
    }

    /** @return array<int, string> */
    private function features(Request $request): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $request->string('features_text')->toString()))));
    }
}
