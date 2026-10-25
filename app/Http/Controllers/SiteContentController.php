<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\VisualEditorController;
use App\Models\SiteContent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SiteContentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $page = $request->validate([
            'page' => ['required', 'string', Rule::in([...VisualEditorController::PAGES, 'global'])],
        ])['page'];

        return response()->json(SiteContent::query()
            ->whereIn('page', [$page, 'global'])
            ->get(['page', 'key', 'type', 'value']));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'page' => ['required', 'string', Rule::in([...VisualEditorController::PAGES, 'global'])],
            'changes' => ['sometimes', 'array', 'max:1000'],
            'changes.*.key' => ['required', 'string', 'max:512', 'regex:/^[a-z0-9_:\/.-]+$/i'],
            'changes.*.type' => ['required', Rule::in(['text', 'textarea', 'url'])],
            'changes.*.value' => ['present', 'nullable', 'string', 'max:20000'],
            'images' => ['sometimes', 'array', 'max:100'],
            'images.*.key' => ['required', 'string', 'max:512', 'regex:/^[a-z0-9_:\/.-]+$/i'],
            'images.*.type' => ['required', Rule::in(['image', 'background'])],
            'images.*.file' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'videos' => ['sometimes', 'array', 'max:20'],
            'videos.*.key' => ['required', 'string', 'max:512', 'regex:/^[a-z0-9_:\/.\-]+$/i'],
            'videos.*.file' => ['required', 'file', 'mimetypes:video/mp4,video/webm,video/ogg', 'max:8192'],
        ]);

        $page = $validated['page'];
        $saved = [];

        if ($page === 'privacy-policy') {
            $allowedKeys = ['privacy-policy/title'];
            foreach ($validated['changes'] ?? [] as $change) {
                if ($change['type'] !== 'text' || ! in_array($change['key'], $allowedKeys, true)) {
                    throw ValidationException::withMessages(['changes' => 'Only the Privacy Policy title can be changed here.']);
                }
            }

            if (! empty($validated['images']) || ! empty($validated['videos'])) {
                throw ValidationException::withMessages(['images' => 'Privacy Policy media cannot be changed in the visual editor.']);
            }
        }

        foreach ($validated['changes'] ?? [] as $index => $change) {
            if ($change['type'] === 'url' && ! preg_match('~^(?:https?://[^\s]+|mailto:[^\s]+|tel:[+0-9() .-]+|/(?!/)[^\s]*|\#[^\s]*)$~i', $change['value'] ?? '')) {
                throw ValidationException::withMessages(["changes.$index.value" => 'Enter a valid link.']);
            }
        }

        DB::transaction(function () use ($validated, $page, &$saved): void {
            foreach ($validated['changes'] ?? [] as $change) {
                $record = SiteContent::query()->updateOrCreate(
                    ['page' => $page, 'key' => $change['key']],
                    ['type' => $change['type'], 'value' => $change['value'] ?? ''],
                );
                $saved[] = $record->only(['page', 'key', 'type', 'value']);
            }

            foreach ($validated['images'] ?? [] as $image) {
                $path = $image['file']->store('site-content', 'public');
                $record = SiteContent::query()->updateOrCreate(
                    ['page' => $page, 'key' => $image['key']],
                    ['type' => $image['type'], 'value' => Storage::disk('public')->url($path)],
                );
                $saved[] = $record->only(['page', 'key', 'type', 'value']);
            }

            foreach ($validated['videos'] ?? [] as $video) {
                $path = $video['file']->store('site-videos', 'public');
                $record = SiteContent::query()->updateOrCreate(
                    ['page' => $page, 'key' => $video['key']],
                    ['type' => 'video', 'value' => Storage::disk('public')->url($path)],
                );
                $saved[] = $record->only(['page', 'key', 'type', 'value']);
            }
        });

        return response()->json(['saved' => $saved]);
    }
}
