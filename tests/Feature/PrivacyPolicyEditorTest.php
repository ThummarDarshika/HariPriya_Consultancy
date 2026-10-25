<?php

namespace Tests\Feature;

use App\Models\SiteContent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PrivacyPolicyEditorTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_existing_policy_is_shown_until_admin_publishes_new_content(): void
    {
        $this->get('/privacy-policy')->assertOk()
            ->assertSee('Collecting Personal Information')
            ->assertSee('Last updated:')
            ->assertSee('Oct 30, 2025');
    }

    public function test_only_administrators_can_open_or_save_the_policy_editor(): void
    {
        $this->get(route('admin.privacy-policy.edit'))->assertRedirect(route('login'));
        $this->put(route('admin.privacy-policy.update'), ['body_html' => '<p>New policy</p>'])
            ->assertRedirect(route('login'));

        $this->actingAs(User::factory()->create());
        $this->get(route('admin.privacy-policy.edit'))->assertForbidden();
        $this->put(route('admin.privacy-policy.update'), ['body_html' => '<p>New policy</p>'])
            ->assertForbidden();

        $this->assertDatabaseCount('site_contents', 0);
    }

    public function test_admin_can_publish_formatted_policy_content_safely(): void
    {
        $this->actingAs($this->administrator());
        $html = '<h2>How we use data</h2><p><strong>Important</strong> <em>terms</em> <font size="5">Large text</font> <script>alert(1)</script><a href="javascript:alert(1)" onclick="alert(1)">unsafe link</a></p><ul><li>First point</li></ul>';

        $this->put(route('admin.privacy-policy.update'), ['body_html' => $html])
            ->assertRedirect(route('admin.privacy-policy.edit'))
            ->assertSessionHas('status');

        $saved = SiteContent::query()->where('page', 'privacy-policy')->where('key', 'privacy-policy/body')->firstOrFail();
        $this->assertSame('html', $saved->type);
        $this->assertStringContainsString('<strong>Important</strong>', $saved->value);
        $this->assertStringContainsString('font-size: 24px', $saved->value);
        $this->assertStringNotContainsString('<script', $saved->value);
        $this->assertStringNotContainsString('javascript:', $saved->value);
        $this->assertStringNotContainsString('onclick', $saved->value);

        $this->get('/privacy-policy')->assertOk()
            ->assertSee('<h2>How we use data</h2>', false)
            ->assertSee('<ul><li>First point</li></ul>', false)
            ->assertDontSee('<script>alert(1)</script>', false)
            ->assertDontSee('javascript:', false);
        $this->get(route('admin.privacy-policy.edit'))->assertOk()->assertSee('How we use data');
    }

    public function test_empty_policy_is_rejected_and_the_current_content_remains(): void
    {
        $this->actingAs($this->administrator());
        $this->put(route('admin.privacy-policy.update'), ['body_html' => '<p><br></p>'])
            ->assertSessionHasErrors('body_html');

        $this->assertDatabaseMissing('site_contents', ['page' => 'privacy-policy', 'key' => 'privacy-policy/body']);
    }

    public function test_visual_editor_can_only_save_the_policy_title(): void
    {
        $this->actingAs($this->administrator());

        $this->postJson(route('site-content.save'), [
            'page' => 'privacy-policy',
            'changes' => [['key' => 'privacy-policy/body', 'type' => 'text', 'value' => 'Wrong place']],
        ])->assertUnprocessable();

        $this->postJson(route('site-content.save'), [
            'page' => 'privacy-policy',
            'changes' => [['key' => 'privacy-policy/last-updated', 'type' => 'text', 'value' => 'Oct 22, 2026']],
        ])->assertUnprocessable();

        $this->postJson(route('site-content.save'), [
            'page' => 'privacy-policy',
            'changes' => [['key' => 'privacy-policy/title', 'type' => 'text', 'value' => 'Our Privacy Policy']],
        ])->assertOk()->assertJsonCount(1, 'saved');

        $this->get('/privacy-policy')->assertOk()->assertSee('Our Privacy Policy')->assertSee('Last updated: Oct 30, 2025');
        $this->get(route('admin.editor', ['page' => 'privacy-policy']))->assertOk()
            ->assertSee('data-cms-key="privacy-policy/title"', false)
            ->assertDontSee('data-cms-key="privacy-policy/last-updated"', false)
            ->assertSee('data-cms-ignore>Last updated: Oct 30, 2025', false);
    }

    public function test_last_updated_date_uses_the_policy_content_database_timestamp(): void
    {
        $this->actingAs($this->administrator());
        $this->travelTo(Carbon::parse('2026-10-22 19:30:00', 'UTC'));

        $this->put(route('admin.privacy-policy.update'), ['body_html' => '<p>First revision</p>'])
            ->assertRedirect(route('admin.privacy-policy.edit'));

        SiteContent::query()->create([
            'page' => 'privacy-policy',
            'key' => 'privacy-policy/last-updated',
            'type' => 'text',
            'value' => 'Jan 01, 2000',
        ]);

        $policyBody = SiteContent::query()->where('page', 'privacy-policy')->where('key', 'privacy-policy/body')->firstOrFail();
        $this->assertSame('2026-10-22 19:30:00', $policyBody->updated_at->format('Y-m-d H:i:s'));
        $this->get('/privacy-policy')->assertOk()->assertSee('Last updated: Oct 23, 2026');
        $this->get(route('admin.editor', ['page' => 'privacy-policy']))->assertOk()
            ->assertSee('data-cms-ignore>Last updated: Oct 23, 2026', false)
            ->assertDontSee('data-cms-key="privacy-policy/last-updated"', false);

        $this->travelTo(Carbon::parse('2026-10-24 06:00:00', 'UTC'));
        $this->put(route('admin.privacy-policy.update'), ['body_html' => '<p>Second revision</p>'])
            ->assertRedirect(route('admin.privacy-policy.edit'));

        $this->get('/privacy-policy')->assertOk()->assertSee('Last updated: Oct 24, 2026');
    }

    private function administrator(): User
    {
        $administrator = User::factory()->create();
        $administrator->is_admin = true;
        $administrator->save();

        return $administrator;
    }
}
