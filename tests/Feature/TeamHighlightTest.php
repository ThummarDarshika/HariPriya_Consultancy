<?php

namespace Tests\Feature;

use App\Models\CollectionItem;
use App\Models\SiteAsset;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeamHighlightTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_and_about_use_the_first_four_published_team_members_and_count_the_rest(): void
    {
        $members = collect([5, 1, 1, 2, 3, 6])->map(fn (int $position, int $index) => CollectionItem::factory()->create([
            'collection' => 'team-members', 'title' => 'Member '.$index, 'image' => '/storage/team/member-'.$index.'.jpg', 'sort_order' => $position,
        ]));
        $draft = CollectionItem::factory()->create(['collection' => 'team-members', 'status' => 'draft', 'sort_order' => 0]);
        CollectionItem::factory()->create(['collection' => 'services', 'title' => 'Not a team member']);

        foreach (['/', '/about', '/admin/editor?page=home', '/admin/editor?page=about'] as $url) {
            if (str_starts_with($url, '/admin')) {
                $this->actingAs(User::factory()->create(['is_admin' => true]));
            }
            $response = $this->get($url)->assertOk();
            $response->assertSeeInOrder($members->only([1, 2, 3, 4])->map(fn ($member) => 'data-team-member-id="'.$member->id.'"')->all(), false)
                ->assertSee('aria-label="2 more team members"', false)
                ->assertDontSee('data-team-member-id="'.$draft->id.'"', false)
                ->assertDontSee('data-team-member-id="'.$members[0]->id.'"', false)
                ->assertDontSee('data-team-member-id="'.$members[5]->id.'"', false);
            $this->assertSame(4, substr_count($response->getContent(), 'data-team-member-id='));
        }

        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $newOrder = [$draft->id, $members[5]->id, $members[0]->id, $members[1]->id, $members[2]->id, $members[3]->id, $members[4]->id];
        $this->postJson('/admin/order/collections/team-members', ['ids' => $newOrder])->assertOk();
        foreach (['/', '/about'] as $url) {
            $this->get($url)->assertOk()->assertSeeInOrder(array_map(fn (int $id): string => 'data-team-member-id="'.$id.'"', array_slice($newOrder, 1, 4)), false);
        }
    }

    public function test_empty_and_small_teams_do_not_show_a_fake_count_or_template_avatars(): void
    {
        foreach (['/', '/about'] as $url) {
            $this->get($url)->assertOk()->assertDontSee('data-team-member-id=', false)->assertDontSee('more team members');
        }
        foreach (range(1, 4) as $position) {
            CollectionItem::factory()->create(['collection' => 'team-members', 'sort_order' => $position, 'image' => $position === 1 ? null : '/storage/team/'.$position.'.jpg']);
            foreach (['/', '/about'] as $url) {
                $response = $this->get($url)->assertOk()->assertDontSee('more team members');
                $this->assertSame($position, substr_count($response->getContent(), 'data-team-member-id='));
            }
        }
    }

    public function test_legacy_team_highlight_uploads_are_no_longer_shown_in_site_media(): void
    {
        foreach (range(1, 4) as $number) {
            SiteAsset::factory()->create(['key' => 'about.team_avatar_'.$number, 'page' => 'about', 'kind' => 'image', 'label' => 'Team highlight image '.$number, 'value' => '/storage/old-avatar-'.$number.'.jpg']);
        }
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $this->get('/admin/site-assets')->assertOk()->assertDontSee('Team highlight image');
        foreach (['/', '/about'] as $url) {
            $this->get($url)->assertOk()->assertDontSee('/storage/old-avatar-');
        }
    }
}
