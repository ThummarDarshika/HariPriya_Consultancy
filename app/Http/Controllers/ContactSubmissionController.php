<?php

namespace App\Http\Controllers;

use App\Mail\NewContactInquiry;
use App\Models\ContactSubmission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactSubmissionController extends Controller
{
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $data = $request->validate([
            'first_name' => ['required', 'string', 'max:128'],
            'last_name' => ['required', 'string', 'max:128'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'regex:/^[0-9]{10}$/'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ], [
            'phone.regex' => 'Enter a 10-digit mobile number using numbers only.',
        ]);

        $submission = ContactSubmission::query()->create([
            'name' => trim($data['first_name'].' '.$data['last_name']),
            'email' => $data['email'],
            'phone' => $data['phone'],
            'subject' => $data['subject'] ?? null,
            'message' => $data['message'],
        ]);

        $recipientAddress = config('mail.contact_inquiry.to');
        $senderAddress = config('mail.from.address');

        if ($recipientAddress && $senderAddress) {
            try {
                Mail::to($recipientAddress)->send(new NewContactInquiry($submission));
            } catch (Throwable $exception) {
                report($exception);
            }
        }

        $message = 'Your message has been received.';

        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return back()->with('contact_status', $message);
    }
}
