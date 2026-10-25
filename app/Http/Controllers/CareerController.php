<?php

namespace App\Http\Controllers;

use App\Mail\NewJobApplication;
use App\Models\JobApplication;
use App\Models\JobOpening;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class CareerController extends Controller
{
    public function index(): View
    {
        return view('pages.career.index', [
            'cmsPage' => 'career',
            'openings' => JobOpening::query()->where('is_active', true)->orderBy('sort_order')->latest('id')->get(),
        ]);
    }

    public function show(JobOpening $jobOpening): View
    {
        abort_unless($jobOpening->is_active, 404);

        return view('pages.career.show', ['cmsPage' => 'career-detail', 'jobOpening' => $jobOpening]);
    }

    public function apply(Request $request, JobOpening $jobOpening): RedirectResponse|JsonResponse
    {
        abort_unless($jobOpening->is_active, 404);

        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:160'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'regex:/^[0-9]{10}$/'],
            'location' => ['required', 'string', 'max:160'],
            'qualification' => ['required', 'string', 'max:160'],
            'experience_years' => ['required', 'integer', 'min:0', 'max:60'],
            'current_company' => ['nullable', 'string', 'max:160'],
            'notice_period' => ['nullable', 'string', 'max:80'],
            'cover_letter' => ['required', 'string', 'min:20', 'max:5000'],
            'resume' => ['required', 'file', 'extensions:pdf,doc,docx', 'mimes:pdf,doc,docx', 'max:5120'],
            'consent' => ['accepted'],
        ], $this->validationMessages($request));

        $path = $request->file('resume')->store('job-applications', 'local');
        if ($path === false) {
            throw ValidationException::withMessages(['resume' => 'The resume could not be saved. Please try again.']);
        }

        unset($data['resume'], $data['consent']);
        try {
            JobApplication::query()->create([...$data, 'job_opening_id' => $jobOpening->id, 'role_title' => $jobOpening->title, 'resume_path' => $path]);
        } catch (Throwable $exception) {
            Storage::disk('local')->delete($path);
            throw $exception;
        }

        $recipientAddress = config('mail.contact_inquiry.to');
        $senderAddress = config('mail.from.address');

        if ($recipientAddress && $senderAddress) {
            try {
                Mail::to($recipientAddress)->send(new NewJobApplication);
            } catch (Throwable $exception) {
                report($exception);
            }
        }

        $message = 'Your application has been submitted successfully.';

        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->route('career.show', $jobOpening->slug)->with('career_status', $message);
    }

    /** @return array<string, string> */
    private function validationMessages(Request $request): array
    {
        $resume = $request->file('resume');
        $actualSize = $resume instanceof UploadedFile && $resume->isValid()
            ? number_format($resume->getSize() / 1048576, 2)
            : null;
        $extension = $resume instanceof UploadedFile ? strtolower($resume->getClientOriginalExtension()) : '';
        $detectedType = $resume instanceof UploadedFile && $resume->isValid() ? $resume->getMimeType() : null;
        $uploadError = $resume instanceof UploadedFile ? $resume->getError() : null;
        $requestSize = (int) $request->server('CONTENT_LENGTH');
        $requestSizeText = $requestSize > 0 ? ' (upload request: '.number_format($requestSize / 1048576, 2).' MB)' : '';

        $uploadFailure = match ($uploadError) {
            UPLOAD_ERR_INI_SIZE => 'The resume exceeds this server\'s upload limit of '.ini_get('upload_max_filesize').$requestSizeText.'.',
            UPLOAD_ERR_FORM_SIZE => 'The resume exceeds the upload size allowed by the form.',
            UPLOAD_ERR_PARTIAL => 'Only part of the resume was uploaded. Please try again.',
            UPLOAD_ERR_NO_TMP_DIR, UPLOAD_ERR_CANT_WRITE => 'The server could not store the uploaded resume. Please try again later.',
            default => 'The resume upload failed. Please choose the file again and retry.',
        };

        return [
            'phone.regex' => 'Enter a 10-digit mobile number using numbers only.',
            'resume.required' => 'Please choose a PDF, DOC or DOCX resume.',
            'resume.file' => 'The selected resume could not be read. Please choose the file again.',
            'resume.max' => $actualSize !== null
                ? 'Your resume is '.$actualSize.' MB; the maximum allowed size is 5 MB.'
                : 'The maximum allowed resume size is 5 MB.',
            'resume.extensions' => 'The selected file has a '.($extension === '' ? 'missing' : '.'.$extension).' extension. Upload PDF, DOC or DOCX.',
            'resume.mimes' => 'The file contents are not a valid PDF, DOC or DOCX'.($detectedType ? ' (detected: '.$detectedType.').' : '.'),
            'resume.uploaded' => $uploadFailure,
        ];
    }
}
