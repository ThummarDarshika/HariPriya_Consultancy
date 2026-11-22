<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectMedia;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProjectMediaController extends Controller
{
    private const IMAGE_MAX_KILOBYTES = 20 * 1024;

    private const VIDEO_MAX_KILOBYTES = 100 * 1024;

    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        return view('admin.project-media.index', [
            'items' => ProjectMedia::query()
                ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search): void {
                    $query->where('title', 'like', '%'.$search.'%')
                        ->orWhere('media_type', 'like', '%'.$search.'%');
                }))
                ->orderBy('sort_order')
                ->orderBy('id')
                ->when($search !== '', fn ($query) => $query->paginate(24)->withQueryString(), fn ($query) => $query->get()),
            'search' => $search,
            'imageMaximumMegabytes' => $this->maximumMegabytes('image'),
            'videoMaximumMegabytes' => $this->maximumMegabytes('video'),
        ]);
    }

    public function create(Request $request): View
    {
        $mediaType = $request->query('type', 'image');
        abort_unless(in_array($mediaType, ['image', 'video'], true), 404);

        return view('admin.project-media.form', [
            'item' => new ProjectMedia(['media_type' => $mediaType, 'sort_order' => 0, 'is_active' => true]),
            'maximumMegabytes' => $this->maximumMegabytes($mediaType),
        ]);
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $mediaType = $request->input('media_type');
        $multipleImages = $mediaType === 'image' && is_array($request->file('media_upload'));
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'media_type' => ['required', Rule::in(['image', 'video'])],
            'media_upload' => $multipleImages ? ['required', 'array', 'min:1', 'max:20'] : $this->uploadRules($mediaType, true),
            'media_upload.*' => $multipleImages ? $this->uploadRules('image', true) : [],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
        ], array_merge($this->uploadMessages($request, $mediaType), $multipleImages ? [
            'media_upload.max' => 'Choose up to 20 images at a time.',
            'media_upload.*.max' => 'Each image must be no larger than 20 MB.',
        ] : []));

        $files = $multipleImages ? array_values($request->file('media_upload')) : [$request->file('media_upload')];
        $data['sort_order'] = $data['sort_order'] ?? ((int) ProjectMedia::query()->max('sort_order') + 1);
        $data['is_active'] = true;
        unset($data['media_upload']);
        $storedPaths = [];
        try {
            DB::transaction(function () use ($files, $data, &$storedPaths): void {
                foreach ($files as $index => $file) {
                    $filePath = $this->storeUploadedFile($file);
                    $storedPaths[] = $filePath;
                    ProjectMedia::query()->create(array_merge($data, [
                        'file_path' => $filePath,
                        'sort_order' => $data['sort_order'] + $index,
                    ]));
                }
            });
        } catch (\Throwable $exception) {
            foreach ($storedPaths as $filePath) {
                $this->deleteStoredFile($filePath);
            }
            throw $exception;
        }

        if ($request->expectsJson()) {
            $request->session()->flash('status', 'Project media added.');

            return response()->json(['message' => 'Project media added.', 'count' => count($files)], 201);
        }

        return redirect()->route('admin.project-media.index')->with('status', 'Project media added.');
    }

    public function edit(ProjectMedia $projectMedium): View
    {
        return view('admin.project-media.form', [
            'item' => $projectMedium,
            'maximumMegabytes' => $this->maximumMegabytes($projectMedium->media_type),
        ]);
    }

    public function update(Request $request, ProjectMedia $projectMedium): RedirectResponse|JsonResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'media_upload' => $this->uploadRules($projectMedium->media_type, false),
            'sort_order' => ['sometimes', 'integer', 'min:0'],
        ], $this->uploadMessages($request, $projectMedium->media_type));

        $previousPath = $projectMedium->file_path;
        if ($request->hasFile('media_upload')) {
            $data['file_path'] = $this->storeUploadedFile($request->file('media_upload'));
        }
        $data['is_active'] = true;
        unset($data['media_upload']);
        $projectMedium->update($data);

        if ($previousPath !== $projectMedium->file_path) {
            $this->deleteStoredFile($previousPath);
        }

        if ($request->expectsJson()) {
            $request->session()->flash('status', 'Project media saved.');

            return response()->json(['message' => 'Project media saved.']);
        }

        return redirect()->route('admin.project-media.index')->with('status', 'Project media saved.');
    }

    public function destroy(ProjectMedia $projectMedium): RedirectResponse
    {
        $filePath = $projectMedium->file_path;
        $projectMedium->delete();
        $this->deleteStoredFile($filePath);

        return redirect()->route('admin.project-media.index')->with('status', 'Project media deleted.');
    }

    /** @return array<int, string> */
    private function uploadRules(?string $mediaType, bool $required): array
    {
        $presence = $required ? 'required' : 'nullable';

        return $mediaType === 'video'
            ? [$presence, 'file', 'mimetypes:video/mp4,video/webm,video/ogg', 'extensions:mp4,webm,ogg,ogv', 'max:'.self::VIDEO_MAX_KILOBYTES]
            : [$presence, 'image', 'mimes:jpg,jpeg,png,webp,gif', 'extensions:jpg,jpeg,png,webp,gif', 'max:'.self::IMAGE_MAX_KILOBYTES];
    }

    /** @return array<string, string> */
    private function uploadMessages(Request $request, ?string $mediaType): array
    {
        $isVideo = $mediaType === 'video';
        $formats = $isVideo ? 'MP4, WebM, OGG or OGV' : 'JPG, JPEG, PNG, WebP or GIF';
        $uploadedFile = $request->file('media_upload');
        $uploadedMegabytes = $uploadedFile instanceof UploadedFile && $uploadedFile->getSize() > 0
            ? number_format($uploadedFile->getSize() / 1048576, 1)
            : null;
        $maximumMegabytes = $this->maximumMegabytes($mediaType);
        $sizeMessage = $uploadedMegabytes !== null
            ? 'The selected '.($isVideo ? 'video' : 'image').' is '.$uploadedMegabytes.' MB. The maximum allowed size is '.$maximumMegabytes.' MB.'
            : 'The maximum allowed '.($isVideo ? 'video' : 'image').' size is '.$maximumMegabytes.' MB.';

        return [
            'media_upload.required' => $isVideo ? 'Please choose a video file.' : 'Please choose an image file.',
            'media_upload.image' => 'The selected file must be a valid image.',
            'media_upload.file' => 'The selected file must be a valid video.',
            'media_upload.mimes' => 'Unsupported image format. Upload a '.$formats.' file.',
            'media_upload.mimetypes' => 'Unsupported video format. Upload a '.$formats.' file.',
            'media_upload.extensions' => 'Unsupported file extension. Upload a '.$formats.' file.',
            'media_upload.max' => $sizeMessage,
            'media_upload.uploaded' => $uploadedFile instanceof UploadedFile && $uploadedFile->getError() === UPLOAD_ERR_INI_SIZE
                ? 'The server rejected this upload because its PHP file limit is '.ini_get('upload_max_filesize').'. The selected file may be larger than that limit.'
                : 'The upload failed. Check the file and try again.',
        ];
    }

    private function maximumMegabytes(?string $mediaType): int
    {
        return $mediaType === 'video' ? intdiv(self::VIDEO_MAX_KILOBYTES, 1024) : intdiv(self::IMAGE_MAX_KILOBYTES, 1024);
    }

    private function deleteStoredFile(string $filePath): void
    {
        if (str_starts_with($filePath, '/storage/project-media/')) {
            Storage::disk('public')->delete(substr($filePath, strlen('/storage/')));
        }
    }

    private function storeUploadedFile(UploadedFile $file): string
    {
        $storedPath = $file->store('project-media', 'public');
        if ($storedPath === false) {
            throw ValidationException::withMessages(['media_upload' => 'Upload could not be saved. Please try again.']);
        }

        return Storage::disk('public')->url($storedPath);
    }
}
