<details class="admin-add-menu" data-add-menu>
    <summary class="admin-add-button" aria-label="Add project" title="Add project">@include('admin.plus-icon')</summary>
    <div class="admin-add-menu__options">
        <a href="{{ route('admin.project-media.create', ['type' => 'image']) }}" data-project-open data-project-kind="image"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.8"/><circle cx="8" cy="9" r="1.5" fill="currentColor"/><path d="m4 17 5-5 3 3 3-4 5 6" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>Add image</a>
        <a href="{{ route('admin.project-media.create', ['type' => 'video']) }}" data-project-open data-project-kind="video"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.8"/><path d="m10 8 6 4-6 4V8Z" fill="currentColor"/></svg>Add video</a>
    </div>
</details>
