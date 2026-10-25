<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteAsset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SiteAssetController extends Controller
{
    public function index(): View
    {
        $managedKeys = array_keys(config('cms.managed_assets'));

        return view('admin.site-assets.index', [
            'assetGroups' => SiteAsset::query()->whereIn('key', $managedKeys)->where('key', '!=', 'brochure')->orderBy('page')->orderBy('id')->get()->groupBy('page'),
        ]);
    }

    public function brochure(): View
    {
        return view('admin.site-assets.brochure', [
            'asset' => SiteAsset::query()->where('key', 'brochure')->firstOrFail(),
        ]);
    }

    public function update(Request $request, SiteAsset $asset): RedirectResponse
    {
        if ($asset->kind === 'text') {
            $validated = $request->validate(['value' => ['required', 'string', 'max:160']]);
            $asset->update(['value' => $validated['value']]);
        } else {
            $rules = $asset->kind === 'document'
                ? ['required_without:remove', 'file', 'mimes:pdf', 'max:5120']
                : ($asset->key === 'site.logo' || $asset->key === 'site.favicon'
                    ? ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120']
                    : ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120']);
            $request->validate([
                'upload' => $rules,
                'remove' => ['sometimes', 'boolean'],
            ]);

            if ($request->hasFile('upload')) {
                $directory = $asset->kind === 'document' ? 'brochures' : 'site-assets';
                $path = $request->file('upload')->store($directory, 'public');
                $previous = $asset->value;
                $asset->update(['value' => '/storage/'.$path]);
                $this->deleteReplacedUpload($previous);
            } elseif ($asset->kind === 'document' && $request->boolean('remove')) {
                $previous = $asset->value;
                $asset->update(['value' => null]);
                $this->deleteReplacedUpload($previous);
            }
        }

        $route = $asset->key === 'brochure' ? 'admin.brochure' : 'admin.site-assets.index';

        return redirect()->route($route)->with('status', $asset->label.' saved.');
    }

    private function deleteReplacedUpload(?string $value): void
    {
        foreach (['site-assets', 'brochures'] as $directory) {
            $prefix = '/storage/'.$directory.'/';
            if ($value && str_starts_with($value, $prefix)) {
                Storage::disk('public')->delete(substr($value, strlen('/storage/')));

                return;
            }
        }
    }
}
