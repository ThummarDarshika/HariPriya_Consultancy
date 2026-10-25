<?php

namespace Tests\Feature;

use App\Mail\NewJobApplication;
use App\Models\JobApplication;
use App\Models\JobOpening;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Tests\TestCase;

class JobApplicationNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_application_sends_a_brief_email_to_the_contact_recipient(): void
    {
        config()->set('mail.contact_inquiry.to', 'owner@example.com');
        config()->set('mail.from.address', 'website@example.com');
        Storage::fake('local');
        Mail::fake();
        $opening = JobOpening::factory()->create(['title' => 'Production Engineer']);

        $this->postJson(route('career.apply', $opening->slug), $this->applicationDetails())
            ->assertOk()
            ->assertJsonPath('message', 'Your application has been submitted successfully.');

        $application = JobApplication::query()->firstOrFail();
        Storage::disk('local')->assertExists($application->resume_path);

        Mail::assertSent(NewJobApplication::class, function (NewJobApplication $mail): bool {
            $this->assertTrue($mail->hasTo('owner@example.com'));
            $mail->assertHasSubject('New job application received')
                ->assertSeeInHtml('A new application has been submitted for a job opening.')
                ->assertSeeInText('Sign in to the admin panel to review it.')
                ->assertDontSeeInHtml('Asha Shah')
                ->assertDontSeeInHtml('Production Engineer')
                ->assertDontSeeInText('asha@example.com')
                ->assertDontSeeInText('9876543210');

            $mail->assertHasNoAttachments();

            return true;
        });
        Mail::assertSentCount(1);
    }

    public function test_application_is_saved_when_notification_recipient_is_not_configured(): void
    {
        config()->set('mail.contact_inquiry.to', null);
        Storage::fake('local');
        Mail::fake();
        $opening = JobOpening::factory()->create();

        $this->postJson(route('career.apply', $opening->slug), $this->applicationDetails())
            ->assertOk();

        $this->assertDatabaseHas('job_applications', ['email' => 'asha@example.com']);
        Mail::assertNothingSent();
    }

    public function test_invalid_application_is_not_saved_or_emailed(): void
    {
        config()->set('mail.contact_inquiry.to', 'owner@example.com');
        Storage::fake('local');
        Mail::fake();
        $opening = JobOpening::factory()->create();

        $this->postJson(route('career.apply', $opening->slug), [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['full_name', 'email', 'phone', 'resume']);

        $this->assertDatabaseCount('job_applications', 0);
        Mail::assertNothingSent();
    }

    public function test_mail_failure_does_not_lose_the_saved_application(): void
    {
        config()->set('mail.contact_inquiry.to', 'owner@example.com');
        config()->set('mail.from.address', 'website@example.com');
        Storage::fake('local');
        Mail::shouldReceive('to')->once()->andThrow(new RuntimeException('Mail transport unavailable'));
        $opening = JobOpening::factory()->create();

        $this->postJson(route('career.apply', $opening->slug), $this->applicationDetails())
            ->assertOk()
            ->assertJsonPath('message', 'Your application has been submitted successfully.');

        $application = JobApplication::query()->firstOrFail();
        Storage::disk('local')->assertExists($application->resume_path);
    }

    /** @return array<string, mixed> */
    private function applicationDetails(): array
    {
        return [
            'full_name' => 'Asha Shah',
            'email' => 'asha@example.com',
            'phone' => '9876543210',
            'location' => 'Ahmedabad',
            'qualification' => 'B.E. Mechanical',
            'experience_years' => 3,
            'cover_letter' => 'I have experience in quality inspection and production systems.',
            'resume' => UploadedFile::fake()->createWithContent('resume.pdf', "%PDF-1.4\n1 0 obj\n<<>>\nendobj\n%%EOF"),
            'consent' => '1',
        ];
    }
}
