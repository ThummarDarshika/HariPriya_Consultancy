<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CertificateController extends Controller
{
    use HandlesBulkDeletion;

    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        return view('admin.managed-images.index', [
            'items' => Certificate::query()
                ->when($search !== '', fn ($query) => $query->where('name', 'like', '%'.$search.'%'))
                ->orderBy('sort_order')
                ->orderBy('id')
                ->when($search !== '', fn ($query) => $query->paginate(30)->withQueryString(), fn ($query) => $query->get()),
            'kind' => 'certificates',
            'title' => 'Certificates',
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.managed-images.form', [
            'item' => new Certificate(['is_active' => true, 'sort_order' => 0]),
            'kind' => 'certificates',
            'title' => 'Certificate',
        ]);
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image_upload' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
        ]);

        $data['image_path'] = '/storage/'.$request->file('image_upload')->store('certificates', 'public');
        $data['sort_order'] = $data['sort_order'] ?? ((int) Certificate::query()->max('sort_order') + 1);
        $data['is_active'] = true;
        unset($data['image_upload']);
        Certificate::query()->create($data);

        if ($request->expectsJson()) {
            $request->session()->flash('status', 'Certificate added.');

            return response()->json(['message' => 'Certificate added.'], 201);
        }

        return redirect()->route('admin.certificates.index')->with('status', 'Certificate added.');
    }

    public function edit(Certificate $certificate): View
    {
        return view('admin.managed-images.form', [
            'item' => $certificate,
            'kind' => 'certificates',
            'title' => 'Certificate',
        ]);
    }

    public function update(Request $request, Certificate $certificate): RedirectResponse|JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
        ]);

        $previous = $certificate->image_path;
        if ($request->hasFile('image_upload')) {
            $data['image_path'] = '/storage/'.$request->file('image_upload')->store('certificates', 'public');
        }
        $data['is_active'] = true;
        unset($data['image_upload']);
        $certificate->update($data);

        if ($previous !== $certificate->image_path) {
            $this->deleteStoredPublicPath($previous, ['/storage/certificates/']);
        }

        if ($request->expectsJson()) {
            $request->session()->flash('status', 'Certificate saved.');

            return response()->json(['message' => 'Certificate saved.']);
        }

        return redirect()->route('admin.certificates.index')->with('status', 'Certificate saved.');
    }

    public function destroy(Certificate $certificate): RedirectResponse
    {
        $certificate->delete();

        return redirect()->route('admin.certificates.index')->with('status', 'Certificate deleted.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        return $this->executeBulkDestroy(
            $request,
            fn () => Certificate::query(),
            Rule::exists(Certificate::class, 'id')->whereNull('deleted_at'),
            'admin.certificates.index',
            [],
            'Certificate deleted.',
            ':count certificates deleted.',
            ['image_path'],
            ['/storage/certificates/'],
        );
    }
}
