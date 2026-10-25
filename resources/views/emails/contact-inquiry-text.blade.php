New website inquiry

A new message was submitted through the contact form.

Name: {!! $submission->name !!}
Email: {!! $submission->email !!}
Phone: {!! $submission->phone ?: 'Not provided' !!}
Subject: {!! $submission->subject ?: 'Not provided' !!}

Message:
{!! $submission->message !!}
