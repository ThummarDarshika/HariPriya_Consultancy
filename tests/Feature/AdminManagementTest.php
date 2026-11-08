<?php

namespace Tests\Feature;

use App\Models\ContactSubmission;
use App\Models\JobApplication;
use App\Models\ProjectMedia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_administrator_login_accepts_a_capitalized_email_but_still_checks_the_password(): void
    {
        $administrator = User::factory()->create([
            'email' => 'haresh@example.com',
            'is_admin' => true,
            'password' => 'CorrectPassword123!',
        ]);

        $this->post(route('admin.login.store'), [
            'email' => 'Haresh@example.com',
            'password' => 'WrongPassword123!',
        ])->assertSessionHasErrors('email');
        $this->assertGuest();

        $this->post(route('admin.login.store'), [
            'email' => 'Haresh@example.com',
            'password' => 'CorrectPassword123!',
        ])->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($administrator);
    }

    public function test_only_administrators_can_delete_submissions_and_applications(): void
    {
        $submission = ContactSubmission::create(['name' => 'Asha', 'email' => 'asha@example.com', 'phone' => '9876543210', 'message' => 'Hello']);
        $application = JobApplication::factory()->create();

        $this->delete(route('admin.contact-submissions.destroy', $submission))->assertRedirect(route('login'));
        $this->delete(route('admin.job-applications.destroy', $application))->assertRedirect(route('login'));

        $this->actingAs(User::factory()->create());
        $this->delete(route('admin.contact-submissions.destroy', $submission))->assertForbidden();
        $this->delete(route('admin.job-applications.destroy', $application))->assertForbidden();

        $this->assertDatabaseHas('contact_submissions', ['id' => $submission->id]);
        $this->assertDatabaseHas('job_applications', ['id' => $application->id]);
    }

    public function test_administrator_can_delete_a_submission_and_an_application_resume(): void
    {
        Storage::fake('local');
        $submission = ContactSubmission::create(['name' => 'Asha', 'email' => 'asha@example.com', 'phone' => '9876543210', 'message' => 'Hello']);
        $application = JobApplication::factory()->create(['resume_path' => 'job-applications/asha.pdf']);
        Storage::disk('local')->put($application->resume_path, 'resume');
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $this->get(route('admin.contact-submissions.index'))->assertOk()->assertSee('Delete Asha');
        $this->get(route('admin.job-applications.index'))->assertOk()->assertSee('Delete '.$application->full_name);
        $this->delete(route('admin.contact-submissions.destroy', $submission))->assertRedirect(route('admin.contact-submissions.index'));
        $this->delete(route('admin.job-applications.destroy', $application))->assertRedirect(route('admin.job-applications.index'));

        $this->assertDatabaseMissing('contact_submissions', ['id' => $submission->id]);
        $this->assertDatabaseMissing('job_applications', ['id' => $application->id]);
        Storage::disk('local')->assertMissing('job-applications/asha.pdf');
    }

    public function test_administrator_can_change_password_only_with_correct_current_password_and_confirmation(): void
    {
        $this->get(route('admin.password.edit'))->assertRedirect(route('login'));
        $this->actingAs(User::factory()->create());
        $this->get(route('admin.password.edit'))->assertForbidden();

        $administrator = User::factory()->create(['is_admin' => true, 'password' => 'OldPassword123!']);
        $this->actingAs($administrator);

        $this->get(route('admin.password.edit'))->assertOk()->assertSee('Current password');
        $this->put(route('admin.password.update'), [
            'old_password' => 'wrong', 'password' => 'NewPassword123!', 'password_confirmation' => 'NewPassword123!',
        ])->assertSessionHasErrors('old_password');
        $this->put(route('admin.password.update'), [
            'old_password' => 'OldPassword123!', 'password' => 'NewPassword123!', 'password_confirmation' => 'different',
        ])->assertSessionHasErrors('password');
        $this->assertTrue(Hash::check('OldPassword123!', $administrator->fresh()->password));

        $this->put(route('admin.password.update'), [
            'old_password' => 'OldPassword123!', 'password' => 'NewPassword123!', 'password_confirmation' => 'NewPassword123!',
        ])->assertRedirect(route('admin.password.edit'))->assertSessionHas('status', 'Password updated.');

        $this->assertTrue(Hash::check('NewPassword123!', $administrator->fresh()->password));
    }

    public function test_admin_list_pages_use_the_shared_table(): void
    {
        ProjectMedia::factory()->create();
        $this->actingAs(User::factory()->create(['is_admin' => true]));

        foreach ([
            route('admin.companies.index'),
            route('admin.certificates.index'),
            route('admin.project-media.index'),
            route('admin.collections.index', 'products'),
            route('admin.job-openings.index'),
            route('admin.job-applications.index'),
            route('admin.contact-submissions.index'),
        ] as $url) {
            $this->get($url)->assertOk()->assertSee('class="admin-list__table"', false);
        }
    }
}
