<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class JobApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();
        $applications = JobApplication::query()
            ->when($search !== '', fn ($query) => $query->where(function ($query) use ($search): void {
                $query->where('full_name', 'like', '%'.$search.'%')->orWhere('email', 'like', '%'.$search.'%')->orWhere('phone', 'like', '%'.$search.'%')->orWhere('role_title', 'like', '%'.$search.'%');
            }))
            ->latest()->paginate(20)->withQueryString();

        return view('admin.job-applications.index', compact('applications', 'search'));
    }

    public function show(JobApplication $jobApplication): View
    {
        return view('admin.job-applications.show', compact('jobApplication'));
    }

    public function resume(JobApplication $jobApplication): StreamedResponse
    {
        abort_unless(Storage::disk('local')->exists($jobApplication->resume_path), 404);

        $extension = pathinfo($jobApplication->resume_path, PATHINFO_EXTENSION);

        return Storage::disk('local')->download($jobApplication->resume_path, 'resume-'.$jobApplication->id.'.'.$extension);
    }
}
