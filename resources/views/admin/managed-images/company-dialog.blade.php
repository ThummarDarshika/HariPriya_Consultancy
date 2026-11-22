@php($itemLabel = $kind === 'companies' ? 'company' : 'certificate')
<dialog class="company-dialog" aria-labelledby="company-dialog-title" data-company-dialog data-item-label="{{ $itemLabel }}">
    <header class="company-dialog__header">
        <h2 id="company-dialog-title">Add {{ $itemLabel }}</h2>
        <button type="button" class="company-dialog__close" data-company-close aria-label="Close {{ $itemLabel }} form"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg></button>
    </header>
    <form method="post" action="{{ route('admin.'.$kind.'.store') }}" enctype="multipart/form-data" data-company-form data-create-url="{{ route('admin.'.$kind.'.store') }}" novalidate>
        @csrf
        <input type="hidden" name="_method" value="POST">
        <div class="company-dialog__fields">
            <label for="company-dialog-image">{{ ucfirst($itemLabel) }} image *</label>
            <input id="company-dialog-image" name="image_upload" type="file" accept="image/png,image/jpeg,image/webp,image/gif" data-crop-width="{{ $kind === 'companies' ? 684 : 900 }}" data-crop-height="{{ $kind === 'companies' ? 468 : 1200 }}" aria-describedby="company-image-error">
            <p id="company-image-error" data-company-error="image_upload" class="company-dialog__error" role="alert" hidden></p>
            <label for="company-dialog-name">{{ ucfirst($itemLabel) }} name *</label>
            <input id="company-dialog-name" name="name" type="text" maxlength="255" required autocomplete="{{ $kind === 'companies' ? 'organization' : 'off' }}" aria-describedby="company-name-error">
            <p id="company-name-error" data-company-error="name" class="company-dialog__error" role="alert" hidden></p>
            <p data-company-error="form" class="company-dialog__error" role="alert" hidden></p>
        </div>
        <footer class="company-dialog__footer">
            <button type="button" class="company-dialog__cancel" data-company-close>Cancel</button>
            <button type="submit" class="company-dialog__save">Add {{ $itemLabel }}</button>
        </footer>
    </form>
</dialog>
