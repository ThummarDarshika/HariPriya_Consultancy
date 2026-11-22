@isset($reorderUrl)
    <div data-list-order data-url="{{ $reorderUrl }}" data-token="{{ csrf_token() }}" data-enabled="{{ ($search ?? '') === '' ? 'true' : 'false' }}">
        @if (($search ?? '') !== '') <p class="admin-list-note">Clear search to reorder.</p> @endif
        <p role="status" data-list-order-status></p>
@endisset
<div class="admin-list">
    <table class="admin-list__table">
        <thead>
            <tr>
                @foreach ($headers as $header)
                    <th scope="col">{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>{{ $slot }}</tbody>
    </table>
</div>

@isset($reorderUrl)
    </div>
    <script src="{{ asset('js/company-order.js') }}?v={{ filemtime(public_path('js/company-order.js')) }}" defer></script>
@endisset
