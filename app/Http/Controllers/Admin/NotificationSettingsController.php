<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\SenderMailConfiguration;
use App\Mail\SenderSetupTestMail;
use App\Models\MailSenderSetting;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

class NotificationSettingsController extends Controller
{
    public function edit(): View
    {
        return view('admin.notification-settings', [
            'receiverEmail' => SiteSetting::notificationEmail(),
            'senderSettings' => MailSenderSetting::query()->first(),
            'fallbackSenderEmail' => config('mail.from.address'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'receiver_email' => ['required', 'email', 'max:255'],
        ]);

        SiteSetting::query()->updateOrCreate(
            ['key' => SiteSetting::NOTIFICATION_EMAIL],
            ['value' => $validated['receiver_email']],
        );

        return redirect()->route('admin.notification-settings.edit')->with('status', 'Notification receiver email saved.');
    }

    public function updateSender(Request $request, SenderMailConfiguration $mailConfiguration): RedirectResponse
    {
        $current = MailSenderSetting::query()->first();
        $validated = $request->validate([
            'sender_email' => ['required', 'email', 'max:255'],
            'sender_name' => ['required', 'string', 'max:160'],
            'smtp_host' => ['required', 'string', 'max:255', 'regex:/^[a-z0-9.-]+$/i'],
            'smtp_port' => ['required', 'integer', 'between:1,65535'],
            'smtp_scheme' => ['required', 'in:smtp,smtps'],
            'smtp_username' => ['required', 'string', 'max:255'],
            'smtp_password' => [$current ? 'nullable' : 'required', 'string', 'max:512'],
        ]);

        if (strtolower($validated['smtp_host']) === 'smtp.gmail.com'
            && strcasecmp($validated['sender_email'], $validated['smtp_username']) !== 0) {
            throw ValidationException::withMessages([
                'sender_email' => 'For Gmail SMTP, use the same address as the Gmail account entered below.',
            ]);
        }

        $password = $validated['smtp_password'] ?? $current?->smtp_password;
        $mailConfiguration->apply(
            $validated['sender_email'],
            $validated['sender_name'],
            $validated['smtp_host'],
            (int) $validated['smtp_port'],
            $validated['smtp_scheme'],
            $validated['smtp_username'],
            $password,
        );

        $testRecipient = SiteSetting::notificationEmail() ?: $validated['sender_email'];

        try {
            Mail::mailer('configured_sender')->to($testRecipient)->send(new SenderSetupTestMail);
        } catch (Throwable $exception) {
            report($exception);

            throw ValidationException::withMessages([
                'smtp_password' => 'The SMTP test failed. Check the server, port, security mode and app password. The current sender was kept.',
            ]);
        }

        MailSenderSetting::query()->updateOrCreate(
            ['id' => $current?->id ?? 1],
            [
                'email' => $validated['sender_email'],
                'name' => $validated['sender_name'],
                'smtp_host' => $validated['smtp_host'],
                'smtp_port' => $validated['smtp_port'],
                'smtp_scheme' => $validated['smtp_scheme'],
                'smtp_username' => $validated['smtp_username'],
                'smtp_password' => $password,
            ],
        );

        return redirect()->route('admin.notification-settings.edit')
            ->with('status', 'Sender saved. A test email was sent to '.$testRecipient.'. Check its From address in your inbox.');
    }
}
