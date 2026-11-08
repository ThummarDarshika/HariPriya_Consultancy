<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('admin.favicon')
    <title>Contact submissions · Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <main class="mx-auto max-w-6xl p-5 md:p-10">
        <div class="admin-page-bar">
            @include('admin.back-link', ['href' => route('admin.dashboard'), 'title' => 'Contact submissions'])
            <a href="{{ route('admin.contact-submissions.export') }}" class="rounded bg-primary px-5 py-3 text-white">Export CSV</a>
        </div>
        @if (session('status')) <p role="status" class="mb-5 rounded bg-green-100 p-3">{{ session('status') }}</p> @endif
        @include('admin.search', ['label' => 'contact submissions'])
        @component('admin.list-table', ['headers' => ['Date', 'Name', 'Email', 'Phone', 'Subject', 'Actions']])
                    @forelse ($submissions as $submission)
                        <tr class="border-b border-default-100 align-top">
                            <td class="p-4 whitespace-nowrap">{{ $submission->created_at->format('d M Y H:i') }}</td>
                            <td class="p-4">{{ $submission->name }}</td>
                            <td class="p-4">{{ $submission->email }}</td>
                            <td class="p-4">{{ $submission->phone }}</td>
                            <td class="p-4">{{ $submission->subject }}</td>
                            <td class="p-4"><div class="admin-action-buttons"><button type="button" class="admin-icon-button" aria-label="View {{ $submission->name }}" title="View" data-submission-view data-submission="{{ json_encode(['date' => $submission->created_at->format('d M Y H:i'), 'name' => $submission->name, 'email' => $submission->email, 'phone' => $submission->phone, 'subject' => $submission->subject, 'message' => $submission->message], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG) }}"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="2.5" stroke="currentColor" stroke-width="1.8"/></svg></button><form method="post" action="{{ route('admin.contact-submissions.destroy', $submission) }}" data-admin-confirm-delete data-admin-confirm-label="{{ $submission->name }}">@csrf @method('DELETE')<button type="submit" class="admin-icon-button admin-icon-button--danger" aria-label="Delete {{ $submission->name }}" title="Delete"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="M4 7h16m-10 4v6m4-6v6M5 7l1 13h12l1-13M9 7V4h6v3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></button></form></div></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-6 text-center">No submissions yet.</td></tr>
                    @endforelse
        @endcomponent
        <div class="mt-5">{{ $submissions->links() }}</div>
    </main>
    <dialog id="submission-dialog" class="submission-dialog" aria-labelledby="submission-dialog-title">
        <div class="submission-dialog__panel">
            <div class="submission-dialog__header">
                <h2 id="submission-dialog-title" class="text-2xl font-semibold">Submission details</h2>
                <button type="button" class="submission-dialog__close" data-dialog-close aria-label="Close">&times;</button>
            </div>
            <dl class="submission-dialog__details">
                <div><dt>Date</dt><dd data-detail="date"></dd></div>
                <div><dt>Name</dt><dd data-detail="name"></dd></div>
                <div><dt>Email</dt><dd data-detail="email"></dd></div>
                <div><dt>Phone</dt><dd data-detail="phone"></dd></div>
                <div><dt>Subject</dt><dd data-detail="subject"></dd></div>
                <div class="submission-dialog__message"><dt>Message</dt><dd data-detail="message"></dd></div>
            </dl>
        </div>
    </dialog>
    <script>
        const submissionDialog = document.getElementById('submission-dialog');
        document.querySelectorAll('[data-submission-view]').forEach((button) => {
            button.addEventListener('click', () => {
                const submission = JSON.parse(button.dataset.submission);
                Object.entries(submission).forEach(([key, value]) => {
                    submissionDialog.querySelector(`[data-detail="${key}"]`).textContent = value || '—';
                });
                submissionDialog.showModal();
            });
        });
        submissionDialog.querySelector('[data-dialog-close]').addEventListener('click', () => submissionDialog.close());
        submissionDialog.addEventListener('click', (event) => {
            if (event.target === submissionDialog) submissionDialog.close();
        });
    </script>
</body>
</html>
