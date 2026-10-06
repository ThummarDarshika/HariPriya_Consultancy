<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CertificateController extends Controller
{
    public function index(): View
    {
        return view('admin.managed-images.index', [
            'items' => Certificate::query()->orderBy('sort_order')->orderBy('id')->paginate(30),
            'kind' => 'certificates',
            'title' => 'Certificates',
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

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image_upload' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $data['image_path'] = '/storage/'.$request->file('image_upload')->store('certificates', 'public');
        $data['is_active'] = $request->boolean('is_active');
        unset($data['image_upload']);
        Certificate::query()->create($data);

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

    public function update(Request $request, Certificate $certificate): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $previous = $certificate->image_path;
        if ($request->hasFile('image_upload')) {
            $data['image_path'] = '/storage/'.$request->file('image_upload')->store('certificates', 'public');
        }
        $data['is_active'] = $request->boolean('is_active');
        unset($data['image_upload']);
        $certificate->update($data);

        if ($previous !== $certificate->image_path && str_starts_with($previous, '/storage/certificates/')) {
            Storage::disk('public')->delete(substr($previous, strlen('/storage/')));
        }

        return redirect()->route('admin.certificates.index')->with('status', 'Certificate saved.');
    }

    public function destroy(Certificate $certificate): RedirectResponse
    {
        $certificate->delete();

        return redirect()->route('admin.certificates.index')->with('status', 'Certificate deleted.');
    }
}
