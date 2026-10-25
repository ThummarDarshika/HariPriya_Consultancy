<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class CompanyController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        return view('admin.managed-images.index', [
            'items' => Company::query()
                ->when($search !== '', fn ($query) => $query->where('name', 'like', '%'.$search.'%'))
                ->orderBy('sort_order')
                ->orderBy('id')
                ->paginate(30)
                ->withQueryString(),
            'kind' => 'companies',
            'title' => 'Companies',
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.managed-images.form', [
            'item' => new Company(['is_active' => true, 'sort_order' => 0]),
            'kind' => 'companies',
            'title' => 'Company',
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

        $data['image_path'] = '/storage/'.$request->file('image_upload')->store('companies', 'public');
        $data['is_active'] = $request->boolean('is_active');
        unset($data['image_upload']);
        Company::query()->create($data);

        return redirect()->route('admin.companies.index')->with('status', 'Company added.');
    }

    public function edit(Company $company): View
    {
        return view('admin.managed-images.form', [
            'item' => $company,
            'kind' => 'companies',
            'title' => 'Company',
        ]);
    }

    public function update(Request $request, Company $company): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'sort_order' => ['required', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        $previous = $company->image_path;
        if ($request->hasFile('image_upload')) {
            $data['image_path'] = '/storage/'.$request->file('image_upload')->store('companies', 'public');
        }
        $data['is_active'] = $request->boolean('is_active');
        unset($data['image_upload']);
        $company->update($data);

        if ($previous !== $company->image_path && str_starts_with($previous, '/storage/companies/')) {
            Storage::disk('public')->delete(substr($previous, strlen('/storage/')));
        }

        return redirect()->route('admin.companies.index')->with('status', 'Company saved.');
    }

    public function destroy(Company $company): RedirectResponse
    {
        $company->delete();

        return redirect()->route('admin.companies.index')->with('status', 'Company deleted.');
    }
}
