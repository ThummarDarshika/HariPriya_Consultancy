<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact submissions · Admin</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <main class="mx-auto max-w-6xl p-5 md:p-10">
        <a class="admin-back-link" href="{{ route('admin.dashboard') }}"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="M19 12H5m7-7-7 7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span>Dashboard</span></a>
        <div class="my-6 flex flex-wrap items-center justify-between gap-4">
            <h1 class="text-3xl font-semibold">Contact submissions</h1>
            <a href="{{ route('admin.contact-submissions.export') }}" class="rounded bg-primary px-5 py-3 text-white">Export CSV</a>
        </div>
        <form method="get" class="mb-5 flex gap-2">
            <input name="search" value="{{ $search }}" placeholder="Search name or email" class="w-full max-w-md rounded border border-default-200 p-3">
            <button class="rounded bg-default-900 px-5 text-white">Search</button>
        </form>
        <div class="overflow-x-auto rounded-lg bg-white shadow-sm">
            <table class="w-full text-left">
                <thead class="border-b border-default-200"><tr><th class="p-4">Date</th><th class="p-4">Name</th><th class="p-4">Email</th><th class="p-4">Phone</th><th class="p-4">Subject</th><th class="p-4">Actions</th></tr></thead>
                <tbody>
                    @forelse ($submissions as $submission)
                        <tr class="border-b border-default-100 align-top">
                            <td class="p-4 whitespace-nowrap">{{ $submission->created_at->format('d M Y H:i') }}</td>
                            <td class="p-4">{{ $submission->name }}</td>
                            <td class="p-4">{{ $submission->email }}</td>
                            <td class="p-4">{{ $submission->phone }}</td>
                            <td class="p-4">{{ $submission->subject }}</td>
                            <td class="p-4"><button type="button" class="rounded bg-primary px-4 py-2 text-white" data-submission-view data-submission="{{ json_encode(['date' => $submission->created_at->format('d M Y H:i'), 'name' => $submission->name, 'email' => $submission->email, 'phone' => $submission->phone, 'subject' => $submission->subject, 'message' => $submission->message], JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_HEX_TAG) }}">View</button></td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-6 text-center">No submissions yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
