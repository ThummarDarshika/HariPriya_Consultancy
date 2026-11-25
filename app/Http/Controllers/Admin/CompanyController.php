<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CompanyController extends Controller
{
    use HandlesBulkDeletion;

    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();

        return view('admin.managed-images.index', [
            'items' => Company::query()
                ->when($search !== '', fn ($query) => $query->where('name', 'like', '%'.$search.'%'))
                ->orderBy('sort_order')
                ->orderBy('id')
                ->when($search !== '', fn ($query) => $query->paginate(30)->withQueryString(), fn ($query) => $query->get()),
            'kind' => 'companies',
            'title' => 'Companies',
            'search' => $search,
        ]);
    }

    public function reorder(Request $request): JsonResponse
    {
        $data = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['required', 'integer', 'distinct'],
        ]);

        DB::transaction(function () use ($data): void {
            $existingIds = Company::query()->orderBy('id')->lockForUpdate()->pluck('id')->all();
            $submittedIds = array_map(intval(...), $data['ids']);
            $sortedIds = $submittedIds;
            sort($sortedIds);
            if ($sortedIds !== $existingIds) {
                throw ValidationException::withMessages(['ids' => 'The company list changed. Reload the page and try again.']);
            }
            foreach ($submittedIds as $position => $id) {
                Company::query()->whereKey($id)->update(['sort_order' => $position]);
            }
        });

        return response()->json(['message' => 'Company order saved.']);
    }

    public function create(): View
    {
        return view('admin.managed-images.form', [
            'item' => new Company(['is_active' => true, 'sort_order' => 0]),
            'kind' => 'companies',
            'title' => 'Company',
        ]);
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image_upload' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
        ]);

        $data['sort_order'] = (Company::query()->max('sort_order') ?? -1) + 1;
        $data['image_path'] = '/storage/'.$request->file('image_upload')->store('companies', 'public');
        $data['is_active'] = true;
        unset($data['image_upload']);
        Company::query()->create($data);

        if ($request->expectsJson()) {
            $request->session()->flash('status', 'Company added.');

            return response()->json(['message' => 'Company added.'], 201);
        }

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

    public function update(Request $request, Company $company): RedirectResponse|JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'image_upload' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
        ]);

        $previous = $company->image_path;
        if ($request->hasFile('image_upload')) {
            $data['image_path'] = '/storage/'.$request->file('image_upload')->store('companies', 'public');
        }
        $data['is_active'] = true;
        unset($data['image_upload']);
        $company->update($data);

        if ($previous !== $company->image_path) {
            $this->deleteStoredPublicPath($previous, ['/storage/companies/']);
        }

        if ($request->expectsJson()) {
            $request->session()->flash('status', 'Company saved.');

            return response()->json(['message' => 'Company saved.']);
        }

        return redirect()->route('admin.companies.index')->with('status', 'Company saved.');
    }

    public function destroy(Company $company): RedirectResponse
    {
        $company->delete();

        return redirect()->route('admin.companies.index')->with('status', 'Company deleted.');
    }

    public function bulkDestroy(Request $request): RedirectResponse
    {
        return $this->executeBulkDestroy(
            $request,
            fn () => Company::query(),
            Rule::exists(Company::class, 'id')->whereNull('deleted_at'),
            'admin.companies.index',
            [],
            'Company deleted.',
            ':count companies deleted.',
            ['image_path'],
            ['/storage/companies/'],
        );
    }
}
