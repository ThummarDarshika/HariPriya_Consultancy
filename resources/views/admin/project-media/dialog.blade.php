<dialog class="company-dialog project-dialog" aria-labelledby="project-dialog-title" data-project-dialog>
    <header class="company-dialog__header">
        <h2 id="project-dialog-title">Add project</h2>
        <button type="button" class="company-dialog__close" data-project-close aria-label="Close project form"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></button>
    </header>
    <form method="post" action="{{ route('admin.project-media.store') }}" enctype="multipart/form-data" data-project-form data-create-url="{{ route('admin.project-media.store') }}" novalidate>
        @csrf
        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="media_type" value="image">
        <div class="company-dialog__fields">
            <div data-project-image-field>
                <label for="project-dialog-image">Project image *</label>
                <input id="project-dialog-image" name="media_upload" type="file" accept="image/png,image/jpeg,image/webp,image/gif" data-project-image data-crop-width="1200" data-crop-height="900" data-max-bytes="{{ $imageMaximumMegabytes * 1048576 }}" aria-describedby="project-file-error">
                <span class="project-dialog__image-count" data-project-image-count hidden></span>
            </div>
            <div data-project-video-field hidden>
                <label for="project-dialog-video">Project video *</label>
                <div class="project-dialog__video-preview" data-project-video-preview hidden><video controls preload="metadata" playsinline aria-label="Project video preview"></video></div>
                <input id="project-dialog-video" name="media_upload" type="file" accept=".mp4,.webm,.ogg,.ogv,video/mp4,video/webm,video/ogg" data-project-video data-media-kind="video" data-max-bytes="{{ $videoMaximumMegabytes * 1048576 }}" class="image-upload-native" aria-describedby="project-file-error" disabled>
                <button type="button" class="project-dialog__video-picker" data-project-video-select><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3" y="4" width="18" height="16" rx="3" stroke="currentColor" stroke-width="1.5"/><path d="m10 8 6 4-6 4V8Z" fill="currentColor"/></svg><span>Select video</span></button>
            </div>
            <p id="project-file-error" data-project-error="media_upload" class="company-dialog__error" role="alert" hidden></p>
            <label for="project-dialog-name">Project title *</label>
            <input id="project-dialog-name" name="title" type="text" maxlength="255" required aria-describedby="project-title-error">
            <p id="project-title-error" data-project-error="title" class="company-dialog__error" role="alert" hidden></p>
            <p data-project-error="form" class="company-dialog__error" role="alert" hidden></p>
        </div>
        <footer class="company-dialog__footer">
            <button type="button" class="company-dialog__cancel" data-project-close>Cancel</button>
            <button type="submit" class="company-dialog__save">Add project</button>
        </footer>
    </form>
</dialog>
