<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>New website inquiry</title>
</head>
<body style="margin:0;padding:24px;background:#f5f5f5;font-family:Arial,sans-serif;color:#1b1b1b">
    <div style="max-width:640px;margin:0 auto;background:#ffffff;border:1px solid #e5e5e5;border-radius:12px;overflow:hidden">
        <div style="background:#171717;padding:24px 28px;color:#ffffff">
            <h1 style="margin:0;font-size:22px">New website inquiry</h1>
        </div>
        <div style="padding:28px">
            <p style="margin:0 0 24px;line-height:1.5">A new message was submitted through the contact form.</p>
            <p style="margin:0 0 14px"><strong>Name:</strong> {{ $submission->name }}</p>
            <p style="margin:0 0 14px"><strong>Email:</strong> {{ $submission->email }}</p>
            <p style="margin:0 0 14px"><strong>Phone:</strong> {{ $submission->phone ?: 'Not provided' }}</p>
            <p style="margin:0 0 24px"><strong>Subject:</strong> {{ $submission->subject ?: 'Not provided' }}</p>
            <div style="border-top:1px solid #e5e5e5;padding-top:20px">
                <strong>Message</strong>
                <div style="margin-top:10px;line-height:1.6;white-space:pre-wrap;overflow-wrap:anywhere">{{ $submission->message }}</div>
            </div>
        </div>
    </div>
</body>
</html>
