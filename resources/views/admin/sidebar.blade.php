<aside class="admin-sidebar" data-cms-ignore aria-label="Admin navigation">
    <div class="admin-sidebar__brand-row">
        <a class="admin-sidebar__brand" href="{{ route('admin.dashboard') }}" aria-label="HARIPRIYA Admin dashboard">
            <span class="admin-sidebar__brand-full">HARIPRIYA</span>
            <span class="admin-sidebar__brand-admin">ADMIN</span>
            <span class="admin-sidebar__brand-mark" aria-hidden="true">HP</span>
        </a>
        <button type="button" class="admin-sidebar__toggle" data-admin-sidebar-toggle aria-label="{{ request()->routeIs('admin.editor') ? 'Expand sidebar' : 'Collapse sidebar' }}" aria-controls="admin-sidebar-navigation" aria-expanded="{{ request()->routeIs('admin.editor') ? 'false' : 'true' }}" title="{{ request()->routeIs('admin.editor') ? 'Expand sidebar' : 'Collapse sidebar' }}">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m14.5 5-7 7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
        </button>
    </div>
    <nav class="admin-sidebar__nav" id="admin-sidebar-navigation">
        <a class="{{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" href="{{ route('admin.dashboard') }}" title="Dashboard">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3.5" y="3.5" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.8"/><rect x="13.5" y="3.5" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.8"/><rect x="3.5" y="13.5" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.8"/><rect x="13.5" y="13.5" width="7" height="7" rx="1" stroke="currentColor" stroke-width="1.8"/></svg>
            <span class="admin-sidebar__label">Dashboard</span>
        </a>
        <a class="{{ request()->routeIs('admin.editor') ? 'is-active' : '' }}" href="{{ route('admin.editor', ['page' => 'home']) }}" title="Live Visual Editor">
            <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m14 6 4 4M4 20l4.2-.8L19 8.4a2.12 2.12 0 0 0-3-3L5.2 16.2 4 20Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M4 20h16" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>
            <span class="admin-sidebar__label">Live Visual Editor</span>
        </a>

        <div class="admin-sidebar__group">
            <span class="admin-sidebar__heading">Site settings</span>
            <a class="{{ request()->routeIs('admin.site-assets.*') ? 'is-active' : '' }}" href="{{ route('admin.site-assets.index') }}" title="Site media"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.8"/><circle cx="8.5" cy="9" r="1.5" stroke="currentColor" stroke-width="1.5"/><path d="m4 17 5-5 3 3 3-4 5 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg><span class="admin-sidebar__label">Site media</span></a>
            <a class="{{ request()->routeIs('admin.brochure') ? 'is-active' : '' }}" href="{{ route('admin.brochure') }}" title="Download brochure"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3v12m0 0 4-4m-4 4-4-4M5 17v3h14v-3" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg><span class="admin-sidebar__label">Download brochure</span></a>
            <a class="{{ request()->routeIs('admin.companies.*') ? 'is-active' : '' }}" href="{{ route('admin.companies.index') }}" title="Companies"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M4 20V5a1 1 0 0 1 1-1h9v16M14 9h5a1 1 0 0 1 1 1v10M2.5 20h19" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="M7 8h3M7 12h3M7 16h3M17 13h1M17 16h1" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg><span class="admin-sidebar__label">Companies</span></a>
            <a class="{{ request()->routeIs('admin.certificates.*') ? 'is-active' : '' }}" href="{{ route('admin.certificates.index') }}" title="Certificates"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3 14.8 5l3.5.1.8 3.4 2 2.8-2 2.8-.8 3.4-3.5.1L12 20l-2.8-2.4-3.5-.1-.8-3.4-2-2.8 2-2.8.8-3.4 3.5-.1L12 3Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><path d="m9 12 2 2 4-4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg><span class="admin-sidebar__label">Certificates</span></a>
        </div>

        <div class="admin-sidebar__group">
            <span class="admin-sidebar__heading">Content</span>
            <a class="{{ request()->routeIs('admin.project-media.*') ? 'is-active' : '' }}" href="{{ route('admin.project-media.index') }}" title="Project media">
                <svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="2.5" y="4" width="19" height="16" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="m4 16 4.5-4.5 3 3 3.5-4 5 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><circle cx="8" cy="8.5" r="1.4" stroke="currentColor" stroke-width="1.5"/><path d="m15 6.5 4 2.5-4 2.5v-5Z" fill="currentColor"/></svg>
                <span class="admin-sidebar__label">Project media</span>
            </a>
            <a class="{{ request()->routeIs('admin.job-openings.*') ? 'is-active' : '' }}" href="{{ route('admin.job-openings.index') }}" title="Job openings"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="7" width="18" height="13" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12h18" stroke="currentColor" stroke-width="1.8"/></svg><span class="admin-sidebar__label">Job openings</span></a>
            <a class="{{ request()->routeIs('admin.privacy-policy.*') ? 'is-active' : '' }}" href="{{ route('admin.privacy-policy.edit') }}" title="Privacy Policy"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M6 3.5h9l3 3V20H6a2 2 0 0 1-2-2V5.5a2 2 0 0 1 2-2Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M15 3.5V7h3M8 11h7M8 14h7M8 17h5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg><span class="admin-sidebar__label">Privacy Policy</span></a>
            @foreach (config('cms.collections') as $key => $label)
                <a class="{{ request()->routeIs('admin.collections.*') && request()->route('collection') === $key ? 'is-active' : '' }}" href="{{ route('admin.collections.index', $key) }}" title="{{ $label }}">
                    <svg viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        @if ($key === 'products')
                            <path d="m12 3 8 4.5v9L12 21l-8-4.5v-9L12 3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="m4.5 7.8 7.5 4.4 7.5-4.4M12 12.2V21" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                        @elseif ($key === 'services')
                            <path d="M14.7 6.3a4.5 4.5 0 0 0-5.9 5.9L4 17l3 3 4.8-4.8a4.5 4.5 0 0 0 5.9-5.9l-3 3-3-3 3-3Z" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="m15.5 4.5 4 4" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        @elseif ($key === 'blogs')
                            <path d="M5 4.5A2.5 2.5 0 0 1 7.5 2H20v18H7.5A2.5 2.5 0 0 1 5 17.5v-13Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M5 17.5A2.5 2.5 0 0 1 7.5 15H20M9 7h7M9 10h7" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        @elseif ($key === 'testimonials')
                            <path d="M20 11.5a7.5 7.5 0 0 1-7.5 7.5H7l-4 2v-6.2a7.5 7.5 0 1 1 17-3.3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M8 10h.01M12.5 10h.01M17 10h.01" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/>
                        @elseif ($key === 'case-studies')
                            <rect x="3" y="7" width="18" height="13" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2M3 12h18m-11 0v2h4v-2" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                        @elseif ($key === 'faqs')
                            <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.8"/><path d="M9.5 9a2.6 2.6 0 1 1 4.4 1.9c-1.1 1-1.9 1.3-1.9 2.8M12 17h.01" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                        @elseif ($key === 'team-members')
                            <path d="M16 20v-1.5a3.5 3.5 0 0 0-3.5-3.5h-5A3.5 3.5 0 0 0 4 18.5V20m6-9a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm5-6.7a3.5 3.5 0 0 1 0 6.4M17 15h1.5a3.5 3.5 0 0 1 3.5 3.5V20" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        @endif
                    </svg>
                    <span class="admin-sidebar__label">{{ $label }}</span>
                </a>
            @endforeach
        </div>

        <div class="admin-sidebar__group">
            <span class="admin-sidebar__heading">Messages</span>
            <a class="{{ request()->routeIs('admin.contact-submissions.*') ? 'is-active' : '' }}" href="{{ route('admin.contact-submissions.index') }}" title="Contact submissions"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="m4 7 8 6 8-6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg><span class="admin-sidebar__label">Contact submissions</span></a>
            <a class="{{ request()->routeIs('admin.job-applications.*') ? 'is-active' : '' }}" href="{{ route('admin.job-applications.index') }}" title="Job applications"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M5 3h10l4 4v14H5V3Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/><path d="M15 3v5h4M8 12h8M8 16h8" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg><span class="admin-sidebar__label">Job applications</span></a>
        </div>
    </nav>
    <form method="post" action="{{ route('admin.logout') }}" class="admin-sidebar__logout">@csrf<button type="submit" title="Sign out"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M10 4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h5m5-4 4-4-4-4m4 4H9" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg><span class="admin-sidebar__label">Sign out</span></button></form>
</aside>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
<script src="{{ asset('js/admin-action-confirmations.js') }}?v={{ filemtime(public_path('js/admin-action-confirmations.js')) }}" defer></script>
<script>
    document.querySelector('.admin-sidebar__logout')?.addEventListener('submit', function (event) {
        if (this.dataset.confirmed === 'true') {
            return;
        }

        event.preventDefault();
        const form = this;
        const confirmSignOut = () => {
            form.dataset.confirmed = 'true';
            form.requestSubmit();
        };

        if (!window.Swal) {
            if (window.confirm('Are you sure you want to sign out?')) {
                confirmSignOut();
            }

            return;
        }

        window.Swal.fire({
            title: 'Sign out?',
            text: 'You will need to log in again to access the admin panel.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sign out',
            cancelButtonText: 'Stay signed in',
            confirmButtonColor: '#c9441b',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                confirmSignOut();
            }
        });
    });

    document.querySelector('[data-admin-sidebar-toggle]')?.addEventListener('click', function () {
        const isCollapsed = document.body.classList.toggle('admin-sidebar-collapsed');
        this.setAttribute('aria-expanded', String(!isCollapsed));
        this.setAttribute('aria-label', isCollapsed ? 'Expand sidebar' : 'Collapse sidebar');
        this.setAttribute('title', isCollapsed ? 'Expand sidebar' : 'Collapse sidebar');
    });
</script>
