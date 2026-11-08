<?php

namespace Tests\Feature;

use App\Mail\SenderSetupTestMail;
use App\Models\MailSenderSetting;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Tests\TestCase;

class NotificationSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_administrators_can_view_and_update_notification_settings(): void
    {
        $this->get(route('admin.notification-settings.edit'))->assertRedirect(route('login'));
        $this->put(route('admin.notification-settings.update'), ['receiver_email' => 'owner@example.com'])->assertRedirect(route('login'));
        $this->put(route('admin.notification-settings.sender.update'), [])->assertRedirect(route('login'));

        $this->actingAs(User::factory()->create());

        $this->get(route('admin.notification-settings.edit'))->assertForbidden();
        $this->put(route('admin.notification-settings.update'), ['receiver_email' => 'owner@example.com'])->assertForbidden();
        $this->put(route('admin.notification-settings.sender.update'), [])->assertForbidden();
        $this->assertDatabaseCount('site_settings', 0);
    }

    public function test_admin_can_save_a_valid_receiver_email(): void
    {
        config()->set('mail.contact_inquiry.to', 'previous@example.com');
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $this->get(route('admin.notification-settings.edit'))->assertSee('previous@example.com');
        $this->put(route('admin.notification-settings.update'), ['receiver_email' => 'owner@example.com'])
            ->assertRedirect(route('admin.notification-settings.edit'))
            ->assertSessionHas('status', 'Notification receiver email saved.');

        $this->assertDatabaseHas('site_settings', ['key' => SiteSetting::NOTIFICATION_EMAIL, 'value' => 'owner@example.com']);
        $this->get(route('admin.notification-settings.edit'))->assertSee('value="owner@example.com"', false);
    }

    public function test_invalid_receiver_email_does_not_replace_the_saved_address(): void
    {
        SiteSetting::query()->create(['key' => SiteSetting::NOTIFICATION_EMAIL, 'value' => 'owner@example.com']);
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $this->put(route('admin.notification-settings.update'), ['receiver_email' => 'invalid'])
            ->assertSessionHasErrors('receiver_email');

        $this->assertDatabaseHas('site_settings', ['key' => SiteSetting::NOTIFICATION_EMAIL, 'value' => 'owner@example.com']);
    }

    public function test_admin_can_verify_and_save_an_encrypted_sender_mailbox(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        SiteSetting::query()->create(['key' => SiteSetting::NOTIFICATION_EMAIL, 'value' => 'owner@example.com']);
        Mail::fake();

        $this->put(route('admin.notification-settings.sender.update'), $this->senderDetails())
            ->assertRedirect(route('admin.notification-settings.edit'))
            ->assertSessionHas('status');

        Mail::assertSent(SenderSetupTestMail::class, fn (SenderSetupTestMail $mail): bool => $mail->hasTo('owner@example.com'));
        $sender = MailSenderSetting::query()->firstOrFail();
        $this->assertSame('test-app-password', $sender->smtp_password);
        $this->assertNotSame('test-app-password', $sender->getRawOriginal('smtp_password'));
        $this->get(route('admin.notification-settings.edit'))
            ->assertSee('sender@example.com')
            ->assertDontSee('test-app-password');
    }

    public function test_failed_verification_keeps_the_existing_sender(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $original = MailSenderSetting::query()->create([
            'email' => 'old@example.com', 'name' => 'Old', 'smtp_host' => 'smtp.example.com',
            'smtp_port' => 587, 'smtp_scheme' => 'smtp', 'smtp_username' => 'old@example.com',
            'smtp_password' => 'old-password',
        ]);
        Mail::shouldReceive('mailer')->once()->with('configured_sender')->andThrow(new RuntimeException('SMTP failed'));

        $this->put(route('admin.notification-settings.sender.update'), $this->senderDetails())
            ->assertSessionHasErrors('smtp_password');

        $original->refresh();
        $this->assertSame('old@example.com', $original->email);
        $this->assertSame('old-password', $original->smtp_password);
    }

    /** @return array<string, string|int> */
    private function senderDetails(): array
    {
        return [
            'sender_email' => 'sender@example.com', 'sender_name' => 'HARIPRIYA',
            'smtp_host' => 'smtp.example.com', 'smtp_port' => 587, 'smtp_scheme' => 'smtp',
            'smtp_username' => 'sender@example.com', 'smtp_password' => 'test-app-password',
        ];
    }
}
