<aside class="admin-sidebar" data-cms-ignore aria-label="Admin navigation">
    <a class="admin-sidebar__brand" href="{{ route('admin.dashboard') }}">HARIPRIYA <span>ADMIN</span></a>
    <nav class="admin-sidebar__nav">
        <a class="{{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a>
        <a class="{{ request()->routeIs('admin.editor') ? 'is-active' : '' }}" href="{{ route('admin.editor', ['page' => 'home']) }}">Live Visual Editor</a>

        <div class="admin-sidebar__group">
            <span class="admin-sidebar__heading">Site settings</span>
            <a class="{{ request()->routeIs('admin.site-assets.*') ? 'is-active' : '' }}" href="{{ route('admin.site-assets.index') }}">Site media</a>
            <a class="{{ request()->routeIs('admin.brochure') ? 'is-active' : '' }}" href="{{ route('admin.brochure') }}">Download brochure</a>
            <a class="{{ request()->routeIs('admin.companies.*') ? 'is-active' : '' }}" href="{{ route('admin.companies.index') }}">Companies</a>
            <a class="{{ request()->routeIs('admin.certificates.*') ? 'is-active' : '' }}" href="{{ route('admin.certificates.index') }}">Certificates</a>
        </div>

        <div class="admin-sidebar__group">
            <span class="admin-sidebar__heading">Content</span>
            @foreach (config('cms.collections') as $key => $label)
                <a class="{{ request()->routeIs('admin.collections.*') && request()->route('collection') === $key ? 'is-active' : '' }}" href="{{ route('admin.collections.index', $key) }}">{{ $label }}</a>
            @endforeach
        </div>

        <div class="admin-sidebar__group">
            <span class="admin-sidebar__heading">Messages</span>
            <a class="{{ request()->routeIs('admin.contact-submissions.*') ? 'is-active' : '' }}" href="{{ route('admin.contact-submissions.index') }}">Contact submissions</a>
        </div>
    </nav>
    <form method="post" action="{{ route('admin.logout') }}" class="admin-sidebar__logout">@csrf<button type="submit">Sign out</button></form>
</aside>
