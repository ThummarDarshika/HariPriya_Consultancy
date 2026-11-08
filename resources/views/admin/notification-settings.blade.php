<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('admin.favicon')
    <title>Notification settings · Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <main class="admin-form-main">
        <div class="admin-page-bar">@include('admin.back-link', ['href' => route('admin.dashboard'), 'title' => 'Notification settings'])</div>
        @if (session('status')) <p role="status" class="mb-5 rounded bg-green-100 p-3">{{ session('status') }}</p> @endif
        <form method="post" action="{{ route('admin.notification-settings.update') }}" class="admin-form-card admin-notification-form">
            @csrf
            @method('PUT')
            <div class="admin-form-section">
                <label for="receiver_email">Receiver email</label>
                <input id="receiver_email" name="receiver_email" type="email" value="{{ old('receiver_email', $receiverEmail) }}" autocomplete="email" maxlength="255" required>
                @error('receiver_email') <p class="text-red-700" role="alert">{{ $message }}</p> @enderror
            </div>
            <div class="admin-form-actions">
                <p>Contact inquiries and job application alerts will be sent to this address.</p>
                <button type="submit">Save email</button>
            </div>
        </form>

        <form method="post" action="{{ route('admin.notification-settings.sender.update') }}" class="admin-form-card admin-notification-form mt-6">
            @csrf
            @method('PUT')
            <div class="admin-form-section">
                <div class="admin-form-section__heading"><span>02</span><div><h2>Sender email setup</h2><p>Current sender: {{ $senderSettings?->email ?? $fallbackSenderEmail ?? 'Not configured' }}</p></div></div>
                <p class="text-sm text-default-600">Use an email account you own. For Gmail, enter its App Password below; the normal Gmail password will not work.</p>
            </div>
            <div class="admin-mail-setup-guide" aria-labelledby="gmail-setup-title">
                <h3 id="gmail-setup-title">Set up with a personal Gmail account</h3>
                <p>You can use your own Gmail without buying a separate mailbox. Complete these steps in the same Google account you want to send from.</p>
                <ol>
                    <li><span>1</span><div>Turn on <a href="https://myaccount.google.com/signinoptions/twosv" target="_blank" rel="noopener noreferrer">2-Step Verification ↗</a>.</div></li>
                    <li><span>2</span><div>Open <a href="https://myaccount.google.com/apppasswords" target="_blank" rel="noopener noreferrer">Google App Passwords ↗</a>, name it “Haripriya Website”, and create a password.</div></li>
                    <li><span>3</span><div>Enter that Gmail address as both sender email and SMTP username below. Paste the new App Password, then select <strong>Verify and save sender</strong>.</div></li>
                </ol>
                <p class="admin-mail-setup-guide__note">Do not enter your regular Google password. To change accounts later, create a new App Password for the new account and verify it here.</p>
            </div>
            <div class="admin-form-section">
                <label for="sender_email">Sender email address</label>
                <input id="sender_email" name="sender_email" type="email" value="{{ old('sender_email', $senderSettings?->email) }}" autocomplete="email" maxlength="255" placeholder="haripriya@example.com" required>
                @error('sender_email') <p class="text-red-700" role="alert">{{ $message }}</p> @enderror
            </div>
            <div class="admin-form-section">
                <label for="sender_name">Display name</label>
                <input id="sender_name" name="sender_name" type="text" value="{{ old('sender_name', $senderSettings?->name ?? 'HARIPRIYA') }}" maxlength="160" required>
                @error('sender_name') <p class="text-red-700" role="alert">{{ $message }}</p> @enderror
            </div>
            <div class="admin-form-section">
                <div class="admin-form-section__heading"><span>03</span><div><h2>Mailbox connection</h2><p>Enter the SMTP details supplied by your email provider.</p></div></div>
                <label for="smtp_host">SMTP server</label>
                <input id="smtp_host" name="smtp_host" type="text" value="{{ old('smtp_host', $senderSettings?->smtp_host ?? 'smtp.gmail.com') }}" maxlength="255" required>
                @error('smtp_host') <p class="text-red-700" role="alert">{{ $message }}</p> @enderror
            </div>
            <div class="admin-form-section admin-smtp-row">
                <div>
                    <label for="smtp_port">Port</label>
                    <input id="smtp_port" name="smtp_port" type="number" min="1" max="65535" value="{{ old('smtp_port', $senderSettings?->smtp_port ?? 587) }}" required>
                    @error('smtp_port') <p class="text-red-700" role="alert">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="smtp_scheme">Security</label>
                    <select id="smtp_scheme" name="smtp_scheme" required>
                        <option value="smtp" @selected(old('smtp_scheme', $senderSettings?->smtp_scheme ?? 'smtp') === 'smtp')>STARTTLS (usually port 587)</option>
                        <option value="smtps" @selected(old('smtp_scheme', $senderSettings?->smtp_scheme) === 'smtps')>SSL/TLS (usually port 465)</option>
                    </select>
                    @error('smtp_scheme') <p class="text-red-700" role="alert">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="admin-form-section">
                <label for="smtp_username">SMTP username</label>
                <input id="smtp_username" name="smtp_username" type="text" value="{{ old('smtp_username', $senderSettings?->smtp_username) }}" autocomplete="username" maxlength="255" placeholder="Usually your full email address" required>
                @error('smtp_username') <p class="text-red-700" role="alert">{{ $message }}</p> @enderror
            </div>
            <div class="admin-form-section">
                <label for="smtp_password">{{ $senderSettings ? 'New App Password (leave blank to keep current)' : 'App Password' }}</label>
                <input id="smtp_password" name="smtp_password" type="password" autocomplete="new-password" maxlength="512" @unless ($senderSettings) required @endunless>
                @error('smtp_password') <p class="text-red-700" role="alert">{{ $message }}</p> @enderror
            </div>
            <div class="admin-form-actions">
                <p>A test email will go to the receiver address above. The sender changes only if the SMTP test succeeds.</p>
                <button type="submit">Verify and save sender</button>
            </div>
        </form>
    </main>
</body>
</html>
