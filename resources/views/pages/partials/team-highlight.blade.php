@foreach ($highlightTeamMembers as $teamMember)
    @if ($teamMember->image)
        <img src="{{ $teamMember->image }}" alt="{{ $teamMember->title }}" data-team-member-id="{{ $teamMember->id }}" class="{{ $avatarSize }} p-0.5 bg-white rounded-md">
    @else
        <span data-team-member-id="{{ $teamMember->id }}" class="{{ $avatarSize }} p-0.5 bg-white rounded-md" aria-label="{{ $teamMember->title }}"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="1.5"/><path d="M4 22v-3a8 8 0 0 1 16 0v3" stroke="currentColor" stroke-width="1.5"/></svg></span>
    @endif
@endforeach
@if ($additionalTeamMemberCount > 0)
    @if ($linkBadge ?? false)
        <a href="{{ route('about') }}" class="{{ $avatarSize }} p-0.5 bg-white rounded-md" aria-label="{{ $additionalTeamMemberCount }} more team members"><div class="bg-default-900 text-white rounded flex items-center justify-center size-full">{{ $additionalTeamMemberCount }}+</div></a>
    @else
        <div class="{{ $avatarSize }} p-0.5 bg-white rounded-md" aria-label="{{ $additionalTeamMemberCount }} more team members"><div class="bg-default-900 text-white rounded flex items-center justify-center size-full">{{ $additionalTeamMemberCount }}+</div></div>
    @endif
@endif
