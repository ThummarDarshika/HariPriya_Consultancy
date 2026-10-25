<?php

namespace Tests\Feature;

use App\Models\JobApplication;
use App\Models\JobOpening;
use App\Models\SiteContent;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CareerFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_open_jobs_are_visible_and_can_be_applied_to(): void
    {
        $open = JobOpening::factory()->create(['title' => 'Production Engineer', 'slug' => 'production-engineer']);
        $hidden = JobOpening::factory()->hidden()->create(['title' => 'Hidden Role', 'slug' => 'hidden-role']);

        $this->get('/career')->assertOk()->assertSee('Production Engineer')->assertDontSee('Hidden Role');
        $this->get('/career/'.$open->slug)->assertOk()->assertSee('Apply for this role');
        $this->get('/career/'.$hidden->slug)->assertNotFound();
        $this->post('/career/'.$hidden->slug.'/apply', [])->assertNotFound();
    }

    public function test_application_requires_candidate_details_and_resume(): void
    {
        $opening = JobOpening::factory()->create();

        $this->post('/career/'.$opening->slug.'/apply', [])
            ->assertSessionHasErrors(['full_name', 'email', 'phone', 'location', 'qualification', 'experience_years', 'cover_letter', 'resume', 'consent']);
        $this->assertDatabaseCount('job_applications', 0);
    }

    public function test_invalid_resume_is_rejected_without_saving_candidate_details(): void
    {
        Storage::fake('local');
        $opening = JobOpening::factory()->create();

        $this->post('/career/'.$opening->slug.'/apply', [
            'full_name' => 'Asha Shah', 'email' => 'asha@example.com', 'phone' => '9876543210',
            'location' => 'Ahmedabad', 'qualification' => 'B.E. Mechanical', 'experience_years' => 3,
            'cover_letter' => 'I have experience in quality inspection and production systems.',
            'resume' => UploadedFile::fake()->create('resume.txt', 10, 'text/plain'), 'consent' => '1',
        ])->assertSessionHasErrors('resume');

        $this->assertDatabaseCount('job_applications', 0);
        $this->assertSame([], Storage::disk('local')->allFiles('job-applications'));
    }

    public function test_resume_errors_explain_the_file_extension_and_actual_size(): void
    {
        Storage::fake('local');
        $opening = JobOpening::factory()->create();
        $details = [
            'full_name' => 'Asha Shah', 'email' => 'asha@example.com', 'phone' => '9876543210',
            'location' => 'Ahmedabad', 'qualification' => 'B.E. Mechanical', 'experience_years' => 3,
            'cover_letter' => 'I have experience in quality inspection and production systems.', 'consent' => '1',
        ];

        $this->postJson('/career/'.$opening->slug.'/apply', [
            ...$details, 'resume' => UploadedFile::fake()->createWithContent('resume.txt', 'Plain text'),
        ])->assertUnprocessable()->assertJsonPath('errors.resume.0', 'The selected file has a .txt extension. Upload PDF, DOC or DOCX.');

        $oversizedPdf = UploadedFile::fake()->createWithContent('resume.pdf', "%PDF-1.4\n".str_repeat(' ', 6 * 1048576)."\n%%EOF");
        $this->postJson('/career/'.$opening->slug.'/apply', [
            ...$details, 'resume' => $oversizedPdf,
        ])->assertUnprocessable()->assertJsonPath('errors.resume.0', 'Your resume is 6.00 MB; the maximum allowed size is 5 MB.');

        $this->assertDatabaseCount('job_applications', 0);
    }

    public function test_career_application_requires_an_exact_ten_digit_mobile_number(): void
    {
        $opening = JobOpening::factory()->create();

        $this->postJson('/career/'.$opening->slug.'/apply', [
            'full_name' => 'Asha Shah', 'email' => 'asha@example.com', 'phone' => '+91 9876543210',
            'location' => 'Ahmedabad', 'qualification' => 'B.E. Mechanical', 'experience_years' => 3,
            'cover_letter' => 'I have experience in quality inspection and production systems.',
            'resume' => UploadedFile::fake()->createWithContent('resume.pdf', "%PDF-1.4\n%%EOF"), 'consent' => '1',
        ])->assertUnprocessable()->assertJsonPath('errors.phone.0', 'Enter a 10-digit mobile number using numbers only.');

        $this->assertDatabaseCount('job_applications', 0);
    }

    public function test_request_above_the_php_upload_limit_returns_a_resume_error(): void
    {
        $opening = JobOpening::factory()->create();

        $this->withServerVariables(['CONTENT_LENGTH' => 11 * 1048576])
            ->postJson('/career/'.$opening->slug.'/apply', [])
            ->assertStatus(413)
            ->assertJsonPath('errors.resume.0', 'The upload is too large (11.00 MB request; server request limit 10M). The resume limit is 5 MB.');
    }

    public function test_candidate_application_is_saved_and_resume_is_private_to_admin(): void
    {
        Storage::fake('local');
        $opening = JobOpening::factory()->create(['title' => 'Quality Engineer']);

        $this->post('/career/'.$opening->slug.'/apply', [
            'full_name' => 'Asha Shah', 'email' => 'asha@example.com', 'phone' => '9876543210',
            'location' => 'Ahmedabad', 'qualification' => 'B.E. Mechanical', 'experience_years' => 3,
            'cover_letter' => 'I have experience in quality inspection and production systems.',
            'resume' => UploadedFile::fake()->createWithContent('resume.pdf', "%PDF-1.4\n1 0 obj\n<<>>\nendobj\n%%EOF"), 'consent' => '1',
        ])->assertRedirect()->assertSessionHas('career_status');

        $application = JobApplication::query()->firstOrFail();
        $this->assertSame('Quality Engineer', $application->role_title);
        Storage::disk('local')->assertExists($application->resume_path);
        $this->get('/admin/job-applications/'.$application->id.'/resume')->assertRedirect('/admin/login');

        $administrator = User::factory()->create(['is_admin' => true]);
        $this->actingAs($administrator);

        $this->get('/admin/job-openings/create')
            ->assertOk()
            ->assertSee('Show on website')
            ->assertDontSee('URL slug')
            ->assertDontSee('Display order');
        $this->get('/admin/job-applications?search=Asha')->assertOk()->assertSee('Asha Shah');
        $this->get('/admin/job-applications/'.$application->id)->assertOk()->assertSee('Quality Engineer');
        $this->get('/admin/job-applications/'.$application->id.'/resume')->assertOk();
    }

    public function test_admin_can_manage_multiple_jobs_and_applications_survive_job_removal(): void
    {
        $this->get('/admin/job-openings')->assertRedirect('/admin/login');
        $administrator = User::factory()->create(['is_admin' => true]);
        $this->actingAs($administrator);

        $details = [
            'title' => 'CNC Operator', 'department' => 'Production', 'location' => 'Ahmedabad',
            'employment_type' => 'Full-time', 'description' => 'Operate CNC machinery.',
            'responsibilities' => 'Set up and inspect components.', 'requirements' => 'CNC experience.',
            'is_active' => 1,
        ];
        $this->post('/admin/job-openings', $details)->assertRedirect('/admin/job-openings');
        $first = JobOpening::query()->firstOrFail();
        $this->post('/admin/job-openings', [...$details, 'title' => 'Quality Inspector'])->assertRedirect('/admin/job-openings');
        $this->post('/admin/job-openings', [...$details, 'title' => 'CNC Operator'])->assertRedirect('/admin/job-openings');
        $this->assertDatabaseHas('job_openings', ['title' => 'CNC Operator', 'slug' => 'cnc-operator-2']);
        $this->get('/admin/job-openings?search=CNC')->assertOk()->assertSee('CNC Operator')->assertDontSee('Quality Inspector');

        $this->put('/admin/job-openings/'.$first->id, [...$details, 'title' => 'Senior CNC Operator'])
            ->assertRedirect('/admin/job-openings');
        $this->assertDatabaseHas('job_openings', ['id' => $first->id, 'title' => 'Senior CNC Operator', 'slug' => 'cnc-operator']);

        $first->refresh();
        $application = JobApplication::factory()->create(['job_opening_id' => $first->id, 'role_title' => $first->title]);
        $this->delete('/admin/job-openings/'.$first->id)->assertRedirect('/admin/job-openings');
        $this->assertSoftDeleted('job_openings', ['id' => $first->id]);
        $this->get('/career/'.$first->slug)->assertNotFound();
        $this->get('/admin/job-applications/'.$application->id)->assertOk()->assertSee('Senior CNC Operator');
    }

    public function test_admin_application_list_is_searchable_and_paginated(): void
    {
        $administrator = User::factory()->create(['is_admin' => true]);
        $this->actingAs($administrator);
        $opening = JobOpening::factory()->create();
        JobApplication::factory()->count(21)->create(['job_opening_id' => $opening->id]);
        JobApplication::factory()->create(['job_opening_id' => $opening->id, 'full_name' => 'Unique Candidate']);

        $this->get('/admin/job-applications')->assertOk()->assertSee('page=2');
        $this->get('/admin/job-applications?search=Unique')->assertOk()->assertSee('Unique Candidate');
        $this->get('/admin/job-applications?search=NoSuchName')->assertOk()->assertDontSee('Unique Candidate');
    }

    public function test_admin_application_dates_show_india_time_from_utc_storage(): void
    {
        $administrator = User::factory()->create(['is_admin' => true]);
        $this->actingAs($administrator);
        $application = JobApplication::factory()->create([
            'created_at' => CarbonImmutable::parse('2026-10-19 08:30:00', 'UTC'),
        ]);

        $this->get('/admin/job-applications')->assertOk()->assertSee('19 Oct 2026, 02:00 PM IST');
        $this->get('/admin/job-applications/'.$application->id)->assertOk()->assertSee('Submitted 19 Oct 2026, 02:00 PM IST');
        $this->assertSame('2026-10-19 08:30:00', $application->fresh()->created_at->format('Y-m-d H:i:s'));
    }

    public function test_career_editor_uses_public_pages_and_keeps_job_data_managed_in_admin(): void
    {
        $opening = JobOpening::factory()->create(['title' => 'Production Engineer', 'description' => 'Database controlled role description.']);
        $administrator = User::factory()->create(['is_admin' => true]);
        $this->actingAs($administrator);

        $this->get('/admin/editor?page=career')
            ->assertOk()
            ->assertSee('cms-editor-toolbar')
            ->assertSee('data-cms-collection="job-openings"', false)
            ->assertSee('href="#openings" data-cms-editor-ignore', false)
            ->assertSee('Production Engineer')
            ->assertSee('Career Detail');

        $this->get('/admin/editor?page=career-detail')
            ->assertOk()
            ->assertSee('cms-editor-toolbar')
            ->assertSee('<h1 data-cms-ignore>Production Engineer</h1>', false)
            ->assertSee('href="#apply" data-cms-editor-ignore', false)
            ->assertSee('data-career-submit data-cms-editor-ignore', false)
            ->assertSee('Database controlled role description.');

        $this->postJson('/api/site-content/save', [
            'page' => 'career',
            'changes' => [[
                'key' => 'career/main/div:0/section:0/div:0/h1:0/text:0',
                'type' => 'text',
                'value' => 'Find your next opportunity.',
            ]],
        ])->assertOk();

        $this->postJson('/api/site-content/save', [
            'page' => 'career-detail',
            'changes' => [[
                'key' => 'career-detail/main/div:0/section:0/div:0/a:0/text:0',
                'type' => 'text',
                'value' => '← Browse all roles',
            ]],
        ])->assertOk();

        $this->assertDatabaseHas('site_contents', ['page' => 'career', 'value' => 'Find your next opportunity.']);
        $this->get('/career')->assertOk()->assertSee('cms-page" content="career"', false)->assertSee('Find your next opportunity.');
        $this->get('/career/'.$opening->slug)->assertOk()->assertSee('cms-page" content="career-detail"', false)->assertSee('Browse all roles');
        $this->assertDatabaseHas('job_openings', ['id' => $opening->id, 'title' => 'Production Engineer', 'description' => 'Database controlled role description.']);
        $this->assertSame(2, SiteContent::query()->whereIn('page', ['career', 'career-detail'])->count());
    }

    public function test_products_link_is_removed_from_header_but_remains_in_footer(): void
    {
        $html = $this->get('/career')->assertOk()->getContent();
        preg_match('/<header>.*?<\/header>/s', $html, $header);
        preg_match('/<footer[^>]*>.*?<\/footer>/s', $html, $footer);

        $productsLink = 'href="'.route('products').'"';
        $this->assertSame(0, substr_count($header[0] ?? '', $productsLink));
        $this->assertSame(1, substr_count($footer[0] ?? '', $productsLink));
    }
}
