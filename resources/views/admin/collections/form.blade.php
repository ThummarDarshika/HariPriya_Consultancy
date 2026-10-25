<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $item->exists ? 'Edit' : 'Add' }} {{ config('cms.collections.'.$collection) }}</title>
    <link rel="stylesheet" href="{{ asset('assets/app-DVm5M2fF.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-panel has-admin-sidebar min-h-screen bg-default-100 text-default-900">
    @include('admin.sidebar')
    <main class="admin-form-main mx-auto max-w-4xl p-5 md:p-10">
        <a class="admin-back-link" href="{{ route('admin.collections.index', $collection) }}"><svg aria-hidden="true" viewBox="0 0 24 24" fill="none"><path d="M19 12H5m7-7-7 7 7 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg><span>{{ config('cms.collections.'.$collection) }}</span></a>
        <div class="admin-form-heading">
            <div><p class="admin-form-eyebrow">{{ config('cms.collections.'.$collection) }}</p><h1>{{ $item->exists ? 'Edit item' : 'Add item' }}</h1><p>Update the content below and save your changes.</p></div>
            <span class="admin-form-badge">{{ $item->exists ? 'Editing' : 'New item' }}</span>
        </div>
        <form id="collection-item-form" data-jquery-validation @if ($item->exists) data-admin-confirm-update data-admin-confirm-remove @endif data-admin-confirm-label="{{ $item->title ?: $item->client_name }}" method="post" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.collections.update', [$collection, $item]) : route('admin.collections.store', $collection) }}" class="admin-form-card space-y-5" novalidate>
            @csrf
            @if ($item->exists) @method('PUT') @endif
            @php($isJqueryRequired = fn (string $field): bool => in_array($field, $requiredFields, true))
            <section class="admin-form-section">
                <div class="admin-form-section__heading"><span>01</span><div><h2>Item details</h2><p>Name, URL and publishing status</p></div></div>
            <div class="grid gap-5 md:grid-cols-2">
                @if ($collection === 'testimonials')
                    <label class="block">Client name *
                        <input name="client_name" value="{{ old('client_name', $item->client_name) }}" maxlength="255" @if ($isJqueryRequired('client_name')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">
                    </label>
                    @error('client_name')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
                @else
                    <label class="block">{{ $collection === 'faqs' ? 'Question' : 'Title / Name' }} *
                        <input name="title" value="{{ old('title', $item->title) }}" maxlength="255" @if ($isJqueryRequired('title')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">
                    </label>
                    @error('title')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
                @endif
                <label class="block">Slug *
                    <input name="slug" value="{{ old('slug', $item->slug) }}" maxlength="255" @if ($isJqueryRequired('slug')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>
                @error('slug')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
                @if (in_array('category', $visibleFields, true))<label class="block">Category{{ $isJqueryRequired('category') ? ' *' : '' }}
                    <input name="category" value="{{ old('category', $item->category) }}" @if ($isJqueryRequired('category')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>
                @error('category')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror @endif
                <label class="block">Status *
                    <select name="status" @if ($isJqueryRequired('status')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">
                        <option value="draft" @selected(old('status', $item->status) === 'draft')>Draft</option>
                        <option value="published" @selected(old('status', $item->status) === 'published')>Published</option>
                    </select>
                </label>
                @error('status')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
            </div>
            </section>
            @if (in_array('description', $visibleFields, true) || in_array('summary', $visibleFields, true) || $collection === 'blogs')
            <section class="admin-form-section">
                <div class="admin-form-section__heading"><span>02</span><div><h2>Content</h2><p>Add the text visitors will see</p></div></div>
            @if (in_array('description', $visibleFields, true))<label class="block">{{ $collection === 'faqs' ? 'Answer' : 'Description / Quote / Article' }}{{ $isJqueryRequired('description') ? ' *' : '' }}
                <textarea name="description" rows="8" @if ($isJqueryRequired('description')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">{{ old('description', $item->description) }}</textarea>
            </label>
            @error('description')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
            <p>Markdown formatting is supported for bold text, emphasis, and links.</p>@endif
            @if (in_array('summary', $visibleFields, true))<label class="block">Summary / Excerpt{{ $isJqueryRequired('summary') ? ' *' : '' }}
                <textarea name="summary" rows="3" @if ($isJqueryRequired('summary')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">{{ old('summary', $item->summary) }}</textarea>
            </label>@endif
            @error('summary')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
            @if ($collection === 'blogs')
                <div class="grid gap-5 md:grid-cols-2">
                    <label class="block">Article subheading{{ $isJqueryRequired('article_subheading') ? ' *' : '' }}
                        <input name="article_subheading" value="{{ old('article_subheading', $item->article_subheading) }}" @if ($isJqueryRequired('article_subheading')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">
                    </label>
                    @error('article_subheading')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
                    <label class="block">Video URL{{ $isJqueryRequired('video_url') ? ' *' : '' }}
                        <input name="video_url" type="url" value="{{ old('video_url', $item->video_url) }}" @if ($isJqueryRequired('video_url')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">
                    </label>
                    @error('video_url')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
                </div>
                <p>Separate article paragraphs, list items, and quote with a blank line to preserve the existing article layout.</p>
            @endif
            </section>
            @endif
            @if (in_array('features_text', $visibleFields, true))<label class="block">Features (one per line)
                <textarea name="features_text" rows="4" class="mt-2 block w-full rounded border border-default-200 p-3">{{ old('features_text', implode("\n", $item->features ?? [])) }}</textarea>
            </label>@endif
            <section class="admin-form-section">
                <div class="admin-form-section__heading"><span>03</span><div><h2>{{ $collection === 'faqs' ? 'Display order' : ($collection === 'team-members' ? 'Member profile' : 'Images and details') }}</h2><p>{{ $collection === 'faqs' ? 'Control where this FAQ appears' : 'Manage the item image and supporting information' }}</p></div></div>
            <div class="grid gap-5 md:grid-cols-2">
                @if (in_array('image_upload', $visibleFields, true))
                <label class="block">Primary image{{ $isJqueryRequired('image_upload') ? ' *' : '' }}
                    @if ($item->image) <img src="{{ $item->image }}" alt="Current image" class="my-2 h-24 w-24 object-cover"> @endif
                    <input name="image_upload" type="file" accept="image/png,image/jpeg,image/webp,image/gif" @if ($isJqueryRequired('image_upload')) data-jquery-required="true" @endif @if ($item->image) data-jquery-required-if-remove="true" data-has-existing-image="true" @endif class="mt-2 block w-full">
                    @if ($item->image) <span><input type="checkbox" name="remove_image" value="1"> Remove current image</span> @endif
                </label>
                @error('image_upload')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
                @endif
                @if (in_array('gallery_uploads', $visibleFields, true))
                <label class="block">Gallery images
                    @if ($item->gallery)
                        <span class="flex gap-2 my-2">
                            @foreach ($item->gallery as $galleryImage)<img src="{{ $galleryImage }}" alt="Gallery image" class="h-16 w-16 object-cover">@endforeach
                        </span>
                        <span><input type="checkbox" name="clear_gallery" value="1"> Clear gallery</span>
                    @endif
                    <input name="gallery_uploads[]" type="file" multiple accept="image/png,image/jpeg,image/webp,image/gif" class="mt-2 block w-full">
                </label>
                @endif
                @if (in_array('icon_upload', $visibleFields, true))
                <label class="block">Feature icon
                    @if ($item->icon) <img src="{{ $item->icon }}" alt="Current icon" class="my-2 h-12 w-12 object-contain"> @endif
                    <input name="icon_upload" type="file" accept="image/png,image/jpeg,image/webp,image/gif" class="mt-2 block w-full">
                </label>
                @endif
                @if (in_array('price', $visibleFields, true))
                <label class="block">Price
                    <input name="price" type="number" min="0" step="0.01" value="{{ old('price', $item->price) }}" class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>
                @endif
                <label class="block">Order index{{ $isJqueryRequired('sort_order') ? ' *' : '' }}
                    <input name="sort_order" type="number" min="0" value="{{ old('sort_order', $item->sort_order ?? 0) }}" @if ($isJqueryRequired('sort_order')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>
                @error('sort_order')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
                @if (in_array('client_name', $visibleFields, true) && $collection !== 'testimonials')<label class="block">Client name
                    <input name="client_name" value="{{ old('client_name', $item->client_name) }}" class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>@error('client_name')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror @endif
                @if (in_array('designation', $visibleFields, true))<label class="block">Designation{{ $isJqueryRequired('designation') ? ' *' : '' }}
                    <input name="designation" value="{{ old('designation', $item->designation) }}" @if ($isJqueryRequired('designation')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>@error('designation')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror @endif
                @if (in_array('company', $visibleFields, true))<label class="block">Company
                    <input name="company" value="{{ old('company', $item->company) }}" class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>@endif
                @if (in_array('rating', $visibleFields, true))<label class="block">Rating (1–5)
                    <input name="rating" type="number" min="1" max="5" value="{{ old('rating', $item->rating) }}" class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>@error('rating')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror @endif
                @if (in_array('role', $visibleFields, true))<label class="block">Role{{ $isJqueryRequired('role') ? ' *' : '' }}
                    <input name="role" value="{{ old('role', $item->role) }}" @if ($isJqueryRequired('role')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>@error('role')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror @endif
                @if (in_array('material', $visibleFields, true))<label class="block">Material{{ $isJqueryRequired('material') ? ' *' : '' }}
                    <input name="material" value="{{ old('material', $item->material) }}" @if ($isJqueryRequired('material')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>@error('material')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror @endif
                @if (in_array('capability', $visibleFields, true))<label class="block">Capability{{ $isJqueryRequired('capability') ? ' *' : '' }}
                    <input name="capability" value="{{ old('capability', $item->capability) }}" @if ($isJqueryRequired('capability')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>@error('capability')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror @endif
                @if (in_array('size_range', $visibleFields, true))<label class="block">Size range{{ $isJqueryRequired('size_range') ? ' *' : '' }}
                    <input name="size_range" value="{{ old('size_range', $item->size_range) }}" @if ($isJqueryRequired('size_range')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>@error('size_range')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror @endif
                @if (in_array('metric', $visibleFields, true))<label class="block">{{ $collection === 'case-studies' ? 'Percentage' : 'Metric' }}{{ $isJqueryRequired('metric') ? ' *' : '' }}
                    <input name="metric" value="{{ old('metric', $item->metric) }}" @if ($isJqueryRequired('metric')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>@error('metric')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror @endif
                @if (in_array('display_date', $visibleFields, true))<label class="block">Display date{{ $isJqueryRequired('display_date') ? ' *' : '' }}
                    <input name="display_date" value="{{ old('display_date', $item->display_date) }}" @if ($isJqueryRequired('display_date')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>@error('display_date')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror @endif
                @if (in_array('social_links', $visibleFields, true))
                @if ($collection !== 'team-members')<label class="block">Primary social link
                    <input name="social_links[primary]" type="url" value="{{ old('social_links.primary', $item->social_links['primary'] ?? '') }}" class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>@endif
                <label class="block">Instagram URL{{ $isJqueryRequired('social_links.instagram') ? ' *' : '' }}
                    <input name="social_links[instagram]" type="url" value="{{ old('social_links.instagram', $item->social_links['instagram'] ?? '') }}" @if ($isJqueryRequired('social_links.instagram')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>
                @error('social_links.instagram')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
                <label class="block">LinkedIn URL{{ $isJqueryRequired('social_links.linkedin') ? ' *' : '' }}
                    <input name="social_links[linkedin]" type="url" value="{{ old('social_links.linkedin', $item->social_links['linkedin'] ?? '') }}" @if ($isJqueryRequired('social_links.linkedin')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>
                @error('social_links.linkedin')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
                <label class="block">X URL{{ $isJqueryRequired('social_links.x') ? ' *' : '' }}
                    <input name="social_links[x]" type="url" value="{{ old('social_links.x', $item->social_links['x'] ?? '') }}" @if ($isJqueryRequired('social_links.x')) data-jquery-required="true" @endif class="mt-2 block w-full rounded border border-default-200 p-3">
                </label>
                @error('social_links.x')<p class="jquery-validation-error" role="alert">{{ $message }}</p>@enderror
                @endif
            </div>
            </section>
            <div class="admin-form-actions"><p>Changes are saved to your website content.</p><button class="rounded bg-primary px-6 py-3 text-white">Save item</button></div>
        </form>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="{{ asset('js/admin-jquery-validation.js') }}?v={{ filemtime(public_path('js/admin-jquery-validation.js')) }}"></script>
</body>
</html>
