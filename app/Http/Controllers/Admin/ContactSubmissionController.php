<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ContactSubmissionController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->toString();
        $submissions = ContactSubmission::query()
            ->when($search, fn ($query) => $query->where(function ($query) use ($search): void {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            }))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.contact-submissions', compact('submissions', 'search'));
    }

    public function export(): StreamedResponse
    {
        return response()->streamDownload(function (): void {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Date', 'Name', 'Email', 'Phone', 'Subject', 'Message']);
            ContactSubmission::query()->orderBy('id')->chunkById(500, function ($submissions) use ($output): void {
                foreach ($submissions as $submission) {
                    fputcsv($output, [
                        $submission->created_at?->toIso8601String(),
                        $this->csvCell($submission->name),
                        $this->csvCell($submission->email),
                        $this->csvCell($submission->phone),
                        $this->csvCell($submission->subject),
                        $this->csvCell($submission->message),
                    ]);
                }
            });
            fclose($output);
        }, 'contact-submissions.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function csvCell(?string $value): string
    {
        $value ??= '';

        return preg_match('/^[\s\x00-\x1f]*[=+\-@]/u', $value) ? "'".$value : $value;
    }
}
