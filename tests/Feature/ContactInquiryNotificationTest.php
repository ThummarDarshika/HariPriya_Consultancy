<?php

namespace Tests\Feature;

use App\Mail\NewContactInquiry;
use App\Models\ContactSubmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use RuntimeException;
use Tests\TestCase;

class ContactInquiryNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_sends_a_formatted_inquiry_email_when_addresses_are_configured(): void
    {
        config()->set('mail.contact_inquiry.to', 'owner@example.com');
        config()->set('mail.from.address', 'website@example.com');
        Mail::fake();

        $this->postJson('/contact', [
            'first_name' => 'Asha',
            'last_name' => 'Shah',
            'email' => 'asha@example.com',
            'phone' => '9876543210',
            'subject' => 'Manufacturing inquiry',
            'message' => 'Please quote <script>alert(1)</script>',
        ])->assertOk()->assertJsonPath('message', 'Your message has been received.');

        $submission = ContactSubmission::query()->firstOrFail();
        $this->assertSame('Asha Shah', $submission->name);

        Mail::assertSent(NewContactInquiry::class, function (NewContactInquiry $mail) use ($submission): bool {
            $this->assertTrue($mail->hasTo('owner@example.com'));
            $this->assertSame('asha@example.com', $mail->envelope()->replyTo[0]->address);
            $mail->assertHasSubject('New website inquiry')
                ->assertSeeInHtml('Asha Shah')
                ->assertSeeInHtml('Manufacturing inquiry')
                ->assertSeeInHtml('9876543210')
                ->assertDontSeeInHtml('<script>', false)
                ->assertSeeInText('Please quote <script>alert(1)</script>');

            return $mail->submission->is($submission);
        });
        Mail::assertSentCount(1);
    }

    public function test_contact_form_keeps_the_inquiry_when_recipient_address_is_not_configured(): void
    {
        config()->set('mail.contact_inquiry.to', null);
        Mail::fake();

        $this->post('/contact', [
            'first_name' => 'Asha',
            'last_name' => 'Shah',
            'email' => 'asha@example.com',
            'phone' => '9876543210',
            'message' => 'Please call me.',
        ])->assertRedirect()->assertSessionHas('contact_status', 'Your message has been received.');

        $this->assertDatabaseHas('contact_submissions', ['email' => 'asha@example.com']);
        Mail::assertNothingSent();
    }

    public function test_invalid_contact_form_does_not_save_or_send_an_inquiry(): void
    {
        config()->set('mail.contact_inquiry.to', 'owner@example.com');
        config()->set('mail.from.address', 'website@example.com');
        Mail::fake();

        $this->postJson('/contact', [
            'first_name' => 'Asha',
            'email' => 'invalid-email',
        ])->assertUnprocessable()->assertJsonValidationErrors(['last_name', 'email', 'phone', 'message']);

        $this->assertDatabaseCount('contact_submissions', 0);
        Mail::assertNothingSent();
    }

    public function test_contact_form_requires_an_exact_ten_digit_mobile_number(): void
    {
        Mail::fake();

        $this->postJson('/contact', [
            'first_name' => 'Asha', 'last_name' => 'Shah', 'email' => 'asha@example.com',
            'phone' => '+91 9876543210', 'message' => 'Please call me.',
        ])->assertUnprocessable()->assertJsonPath('errors.phone.0', 'Enter a 10-digit mobile number using numbers only.');

        $this->assertDatabaseCount('contact_submissions', 0);
        Mail::assertNothingSent();
    }

    public function test_mail_transport_failure_does_not_lose_a_saved_inquiry(): void
    {
        config()->set('mail.contact_inquiry.to', 'owner@example.com');
        config()->set('mail.from.address', 'website@example.com');
        Mail::shouldReceive('to')->once()->andThrow(new RuntimeException('Mail transport unavailable'));

        $this->post('/contact', [
            'first_name' => 'Asha',
            'last_name' => 'Shah',
            'email' => 'asha@example.com',
            'phone' => '9876543210',
            'message' => 'Please call me.',
        ])->assertRedirect()->assertSessionHas('contact_status', 'Your message has been received.');

        $this->assertDatabaseHas('contact_submissions', ['email' => 'asha@example.com']);
    }
}
