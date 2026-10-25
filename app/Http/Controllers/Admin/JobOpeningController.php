<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobOpening;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class JobOpeningController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();
        $items = JobOpening::query()
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search): void {
                $query->where('title', 'like', '%'.$search.'%')->orWhere('department', 'like', '%'.$search.'%')->orWhere('location', 'like', '%'.$search.'%');
            }))
            ->withCount('applications')->orderBy('sort_order')->latest('id')->paginate(20)->withQueryString();

        return view('admin.job-openings.index', compact('items', 'search'));
    }

    public function create(): View
    {
        return view('admin.job-openings.form', ['item' => new JobOpening(['is_active' => true])]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['sort_order'] = (int) JobOpening::query()->max('sort_order') + 1;
        JobOpening::query()->create($data);

        return redirect()->route('admin.job-openings.index')->with('status', 'Job opening added.');
    }

    public function edit(JobOpening $jobOpening): View
    {
        return view('admin.job-openings.form', ['item' => $jobOpening]);
    }

    public function update(Request $request, JobOpening $jobOpening): RedirectResponse
    {
        $jobOpening->update($this->validatedData($request));

        return redirect()->route('admin.job-openings.index')->with('status', 'Job opening updated.');
    }

    public function destroy(JobOpening $jobOpening): RedirectResponse
    {
        $jobOpening->delete();

        return redirect()->route('admin.job-openings.index')->with('status', 'Job opening removed. Existing applications remain available.');
    }

    /** @return array<string, mixed> */
    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:120'],
            'location' => ['required', 'string', 'max:160'],
            'employment_type' => ['required', Rule::in(['Full-time', 'Part-time', 'Contract', 'Internship'])],
            'description' => ['required', 'string', 'max:10000'],
            'responsibilities' => ['required', 'string', 'max:10000'],
            'requirements' => ['required', 'string', 'max:10000'],
            'is_active' => ['sometimes', 'boolean'],
        ]);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function uniqueSlug(string $title): string
    {
        $base = trim(Str::substr(Str::slug($title), 0, 220), '-') ?: 'job-opening';
        $slug = $base;
        $suffix = 2;

        while (JobOpening::withTrashed()->where('slug', $slug)->exists()) {
            $slug = $base.'-'.$suffix;
            $suffix++;
        }

        return $slug;
    }
}
