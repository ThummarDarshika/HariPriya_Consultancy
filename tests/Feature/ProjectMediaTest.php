<?php

namespace Tests\Feature;

use App\Models\ProjectMedia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProjectMediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_administrators_can_manage_project_media(): void
    {
        $this->get('/projects')->assertOk();
        $this->get('/admin/project-media')->assertRedirect('/admin/login');
        $this->post('/admin/project-media', [])->assertRedirect('/admin/login');

        $this->actingAs(User::factory()->create());

        $this->get('/admin/project-media')->assertForbidden();
        $this->post('/admin/project-media', [])->assertForbidden();
        $this->assertDatabaseCount('project_media', 0);
    }

    public function test_admin_can_upload_an_image_and_video_and_both_pages_show_them(): void
    {
        Storage::fake('public');
        $this->actingAs($this->administrator());

        $this->get('/admin/project-media')->assertOk()->assertSee('Add image')->assertSee('Add video');
        $this->get('/admin/project-media/create?type=video')->assertOk()->assertSee('video/mp4');

        $this->post('/admin/project-media', [
            'title' => 'Precision assembly',
            'media_type' => 'image',
            'media_upload' => UploadedFile::fake()->image('assembly.jpg'),
            'sort_order' => 2,
            'is_active' => '1',
        ])->assertRedirect('/admin/project-media');

        $this->post('/admin/project-media', [
            'title' => 'Production in motion',
            'media_type' => 'video',
            'media_upload' => UploadedFile::fake()->create('process.mp4', 100, 'video/mp4'),
            'sort_order' => 1,
            'is_active' => '1',
        ])->assertRedirect('/admin/project-media');

        $image = ProjectMedia::query()->where('media_type', 'image')->firstOrFail();
        $video = ProjectMedia::query()->where('media_type', 'video')->firstOrFail();
        $this->assertStringStartsWith('/storage/project-media/', $image->file_path);
        $this->assertStringStartsWith('/storage/project-media/', $video->file_path);
        Storage::disk('public')->assertExists(substr($image->file_path, strlen('/storage/')));
        Storage::disk('public')->assertExists(substr($video->file_path, strlen('/storage/')));

        $this->get('/projects')->assertOk()
            ->assertSeeInOrder(['Production in motion', 'Precision assembly'])
            ->assertSee('data-cms-collection="project-media"', false)
            ->assertSee($image->file_path)
            ->assertSee($video->file_path);
        $this->get('/admin/editor?page=projects')->assertOk()
            ->assertSee('Projects built to perform')
            ->assertSee('Production in motion')
            ->assertSee('data-cms-collection="project-media"', false);
    }

    public function test_admin_can_upload_multiple_images_and_invalid_batches_save_nothing(): void
    {
        Storage::fake('public');
        $this->actingAs($this->administrator());

        $details = ['title' => 'PEB Shed', 'media_type' => 'image', 'sort_order' => 3, 'is_active' => '1'];
        $this->post('/admin/project-media', array_merge($details, [
            'media_upload' => [UploadedFile::fake()->image('front.jpg'), UploadedFile::fake()->image('side.png')],
        ]))->assertRedirect('/admin/project-media');

        $items = ProjectMedia::query()->orderBy('sort_order')->get();
        $this->assertCount(2, $items);
        $this->assertSame([3, 4], $items->pluck('sort_order')->all());
        foreach ($items as $item) {
            $this->assertSame('PEB Shed', $item->title);
            Storage::disk('public')->assertExists(substr($item->file_path, strlen('/storage/')));
            $this->get('/projects')->assertSee($item->file_path);
        }

        $this->post('/admin/project-media', array_merge($details, [
            'media_upload' => [UploadedFile::fake()->image('valid.jpg'), UploadedFile::fake()->create('invalid.pdf', 10, 'application/pdf')],
        ]))->assertSessionHasErrors('media_upload.1');
        $this->assertDatabaseCount('project_media', 2);
        $this->assertCount(2, Storage::disk('public')->allFiles('project-media'));
    }

    public function test_project_gallery_paginates_twenty_items_on_public_page_and_in_editor(): void
    {
        foreach (range(1, 21) as $position) {
            ProjectMedia::factory()->create([
                'title' => 'Project '.$position,
                'sort_order' => $position,
            ]);
        }

        $this->get('/projects')->assertOk()
            ->assertSee('Project 1')
            ->assertSee('Project 20')
            ->assertDontSee('Project 21')
            ->assertSee('media_page=2', false);

        $this->get('/projects?media_page=2')->assertOk()
            ->assertSee('Project 21')
            ->assertDontSee('Project 20')
            ->assertSee('21 projects');

        $this->actingAs($this->administrator());

        $this->get('/admin/editor?page=projects')->assertOk()
            ->assertSee('Project 20')
            ->assertDontSee('Project 21')
            ->assertSee('page=projects&amp;media_page=2', false);

        $this->get('/admin/editor?page=projects&media_page=2')->assertOk()
            ->assertSee('Project 21')
            ->assertDontSee('Project 20');
    }

    public function test_admin_project_media_index_displays_images_and_videos_in_a_table(): void
    {
        ProjectMedia::factory()->create(['title' => 'Assembly image']);
        ProjectMedia::factory()->video()->create(['title' => 'Assembly video']);
        $this->actingAs($this->administrator());

        $this->get('/admin/project-media')->assertOk()
            ->assertSee('<table class="admin-list__table">', false)
            ->assertSee('Assembly image')
            ->assertSee('Assembly video')
            ->assertSee('Preview')
            ->assertSee('Status');
    }

    public function test_admin_project_media_searches_title_and_type_across_paginated_results(): void
    {
        foreach (range(1, 25) as $position) {
            ProjectMedia::factory()->create([
                'title' => 'Assembly '.str_pad((string) $position, 2, '0', STR_PAD_LEFT),
                'sort_order' => $position,
            ]);
        }

        ProjectMedia::factory()->video()->create(['title' => 'Production reel']);
        $this->actingAs($this->administrator());

        $this->get('/admin/project-media?search=Assembly')->assertOk()
            ->assertSee('Assembly 24')
            ->assertDontSee('Assembly 25')
            ->assertDontSee('Production reel')
            ->assertSee('search=Assembly', false);

        $this->get('/admin/project-media?search=Assembly&page=2')->assertOk()
            ->assertSee('Assembly 25')
            ->assertDontSee('Assembly 24')
            ->assertDontSee('Production reel');

        $this->get('/admin/project-media?search=video')->assertOk()
            ->assertSee('Production reel')
            ->assertDontSee('Assembly 01');
    }

    public function test_admin_can_edit_title_and_file_then_delete_media(): void
    {
        Storage::fake('public');
        $this->actingAs($this->administrator());
        $item = ProjectMedia::factory()->create([
            'title' => 'Old title',
            'file_path' => '/storage/project-media/old.jpg',
        ]);
        Storage::disk('public')->put('project-media/old.jpg', 'old image');

        $this->put('/admin/project-media/'.$item->id, [
            'title' => 'Updated title',
            'media_upload' => UploadedFile::fake()->image('replacement.png'),
            'sort_order' => 3,
        ])->assertRedirect('/admin/project-media');

        $item->refresh();
        $this->assertSame('Updated title', $item->title);
        $this->assertTrue($item->is_active);
        Storage::disk('public')->assertMissing('project-media/old.jpg');
        Storage::disk('public')->assertExists(substr($item->file_path, strlen('/storage/')));
        $this->get('/projects')->assertSee('Updated title');

        $this->put('/admin/project-media/'.$item->id, [
            'title' => 'Updated title',
            'sort_order' => 3,
            'is_active' => '1',
        ])->assertRedirect('/admin/project-media');
        $this->get('/projects')->assertSee('Updated title');

        $storedPath = $item->file_path;
        $this->delete('/admin/project-media/'.$item->id)->assertRedirect('/admin/project-media');

        $this->assertDatabaseCount('project_media', 0);
        Storage::disk('public')->assertMissing(substr($storedPath, strlen('/storage/')));
        $this->get('/projects')->assertDontSee('Updated title');
    }

    public function test_project_upload_requires_matching_file_type_and_title(): void
    {
        Storage::fake('public');
        $this->actingAs($this->administrator());

        $this->post('/admin/project-media', [
            'media_type' => 'image',
            'media_upload' => UploadedFile::fake()->create('clip.mp4', 100, 'video/mp4'),
            'sort_order' => 0,
        ])->assertSessionHasErrors(['title', 'media_upload']);
        $this->post('/admin/project-media', [
            'title' => 'Wrong video',
            'media_type' => 'video',
            'media_upload' => UploadedFile::fake()->image('photo.png'),
            'sort_order' => 0,
        ])->assertSessionHasErrors('media_upload');

        $this->assertDatabaseCount('project_media', 0);
    }

    public function test_project_upload_reports_file_size_and_extension_errors(): void
    {
        Storage::fake('public');
        $this->actingAs($this->administrator());

        $this->post('/admin/project-media', [
            'title' => 'Large process video',
            'media_type' => 'video',
            'media_upload' => UploadedFile::fake()->create('process.mp4', 101 * 1024, 'video/mp4'),
            'sort_order' => 0,
        ])->assertSessionHasErrors(['media_upload' => 'The selected video is 101.0 MB. The maximum allowed size is 100 MB.']);

        $this->post('/admin/project-media', [
            'title' => 'Large project image',
            'media_type' => 'image',
            'media_upload' => UploadedFile::fake()->image('project.jpg')->size(21 * 1024),
            'sort_order' => 0,
        ])->assertSessionHasErrors(['media_upload' => 'The selected image is 21.0 MB. The maximum allowed size is 20 MB.']);

        $this->post('/admin/project-media', [
            'title' => 'Wrong image extension',
            'media_type' => 'image',
            'media_upload' => UploadedFile::fake()->image('photo.txt'),
            'sort_order' => 0,
        ])->assertSessionHasErrors(['media_upload' => 'Unsupported file extension. Upload a JPG, JPEG, PNG, WebP or GIF file.']);

        $this->assertDatabaseCount('project_media', 0);
    }

    public function test_admin_can_upload_real_project_image_and_video_files(): void
    {
        Storage::fake('public');
        $this->actingAs($this->administrator());

        foreach ([
            ['title' => 'Real image', 'type' => 'image', 'file' => 'hero-BK9Dnytd.webp'],
            ['title' => 'Real video', 'type' => 'video', 'file' => 'video-JGTIV9SH.mp4'],
            ['title' => 'Real WebM', 'type' => 'video', 'file' => 'video-Cu_LDHlO.webm'],
        ] as $media) {
            $this->post('/admin/project-media', [
                'title' => $media['title'],
                'media_type' => $media['type'],
                'media_upload' => new UploadedFile(public_path('assets/'.$media['file']), $media['file'], test: true),
                'sort_order' => 0,
                'is_active' => '1',
            ])->assertRedirect('/admin/project-media')->assertSessionHasNoErrors();
        }

        $this->assertDatabaseCount('project_media', 3);

        foreach (ProjectMedia::all() as $item) {
            Storage::disk('public')->assertExists(substr($item->file_path, strlen('/storage/')));
        }
    }

    public function test_project_upload_accepts_files_above_the_previous_limits(): void
    {
        Storage::fake('public');
        $this->actingAs($this->administrator());

        $this->post('/admin/project-media', [
            'title' => 'Large image',
            'media_type' => 'image',
            'media_upload' => UploadedFile::fake()->image('large.jpg')->size(6 * 1024),
            'sort_order' => 0,
        ])->assertRedirect('/admin/project-media')->assertSessionHasNoErrors();

        $this->post('/admin/project-media', [
            'title' => 'Large video',
            'media_type' => 'video',
            'media_upload' => UploadedFile::fake()->create('large.mp4', 9 * 1024, 'video/mp4'),
            'sort_order' => 0,
        ])->assertRedirect('/admin/project-media')->assertSessionHasNoErrors();

        $this->assertDatabaseCount('project_media', 2);
    }

    public function test_project_titles_are_escaped_and_page_text_can_be_published_in_editor(): void
    {
        $this->actingAs($this->administrator());
        ProjectMedia::factory()->create(['title' => '<script>alert(1)</script>']);

        $this->get('/projects')->assertOk()
            ->assertSee('&lt;script&gt;', false)
            ->assertDontSee('<script>alert(1)</script>', false);
        $this->postJson('/api/site-content/save', [
            'page' => 'projects',
            'changes' => [[
                'key' => 'projects/main/section:0/div:3/div:0/h1:0/text:0',
                'type' => 'text',
                'value' => 'Our latest projects',
            ]],
        ])->assertOk();
        $this->assertDatabaseHas('site_contents', ['page' => 'projects', 'value' => 'Our latest projects']);
        $this->get('/projects')->assertSee('Our latest projects');
        $this->get('/admin/editor?page=projects')->assertSee('Our latest projects');
    }

    public function test_project_dialog_saves_multiple_images_and_video_and_preserves_media_on_edit(): void
    {
        Storage::fake('public');
        $this->actingAs($this->administrator());
        $this->get('/admin/project-media')->assertOk()->assertSee('data-project-dialog', false)->assertSee('project-dialog.js');
        $this->postJson('/admin/project-media', ['title' => 'Missing media', 'media_type' => 'image'])->assertUnprocessable()->assertJsonValidationErrors('media_upload');
        $this->post('/admin/project-media', [
            'title' => 'Image project', 'media_type' => 'image',
            'media_upload' => [UploadedFile::fake()->image('front.jpg'), UploadedFile::fake()->image('side.png')],
        ], ['Accept' => 'application/json'])->assertCreated()->assertJsonPath('count', 2);
        $this->post('/admin/project-media', [
            'title' => 'Video project', 'media_type' => 'video', 'media_upload' => UploadedFile::fake()->create('video.mp4', 100, 'video/mp4'),
        ], ['Accept' => 'application/json'])->assertCreated()->assertJsonPath('count', 1);
        $this->assertDatabaseCount('project_media', 3);
        foreach (['image', 'video'] as $kind) {
            $item = ProjectMedia::query()->where('media_type', $kind)->firstOrFail();
            $previous = $item->file_path;
            $position = $item->sort_order;
            $this->get('/admin/project-media')->assertOk()->assertSee('data-project-file="'.$previous.'"', false)->assertSee('data-project-kind="'.$kind.'"', false);
            $this->post('/admin/project-media/'.$item->id, ['_method' => 'PUT', 'title' => ''], ['Accept' => 'application/json'])->assertUnprocessable()->assertJsonValidationErrors('title');
            $this->assertSame($previous, $item->fresh()->file_path);
            $this->post('/admin/project-media/'.$item->id, ['_method' => 'PUT', 'title' => 'Changed project'], ['Accept' => 'application/json'])->assertOk()->assertJsonPath('message', 'Project media saved.');
            $this->assertSame($previous, $item->fresh()->file_path);
            $this->assertSame($position, $item->fresh()->sort_order);
            $this->post('/admin/project-media/'.$item->id, [
                '_method' => 'PUT', 'title' => 'Changed project', 'media_upload' => $kind === 'image' ? UploadedFile::fake()->image('replacement.jpg') : UploadedFile::fake()->create('replacement.mp4', 100, 'video/mp4'),
            ], ['Accept' => 'application/json'])->assertOk();
            $this->assertNotSame($previous, $item->fresh()->file_path);
            Storage::disk('public')->assertMissing(substr($previous, strlen('/storage/')));
            Storage::disk('public')->assertExists(substr($item->fresh()->file_path, strlen('/storage/')));
            $this->get('/projects')->assertOk()->assertSee($item->fresh()->file_path);
        }
    }

    public function test_administrator_can_bulk_delete_selected_project_media_and_remove_stored_files(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('project-media/one.jpg', 'one');
        Storage::disk('public')->put('project-media/two.mp4', 'two');
        Storage::disk('public')->put('project-media/three.jpg', 'three');

        $first = ProjectMedia::factory()->create(['title' => 'Media One', 'file_path' => '/storage/project-media/one.jpg']);
        $second = ProjectMedia::factory()->video()->create(['title' => 'Media Two', 'file_path' => '/storage/project-media/two.mp4']);
        $third = ProjectMedia::factory()->create(['title' => 'Media Three', 'file_path' => '/storage/project-media/three.jpg']);

        $this->delete(route('admin.project-media.bulk-destroy'), ['ids' => [$first->id]])
            ->assertRedirect(route('login'));

        $this->actingAs(User::factory()->create());
        $this->delete(route('admin.project-media.bulk-destroy'), ['ids' => [$first->id]])
            ->assertForbidden();
        $this->assertDatabaseHas('project_media', ['id' => $first->id]);

        $this->actingAs($this->administrator());

        $this->get(route('admin.project-media.index'))
            ->assertOk()
            ->assertSee('data-bulk-select-all', false)
            ->assertSee('data-bulk-select-item', false)
            ->assertSee('form="bulk-delete-project-media-form"', false)
            ->assertSee('company-bulk-delete.js', false)
            ->assertSee('Delete selected');

        $this->from(route('admin.project-media.index'))
            ->delete(route('admin.project-media.bulk-destroy'), ['ids' => []])
            ->assertRedirect(route('admin.project-media.index'))
            ->assertSessionHasErrors('ids');

        $this->from(route('admin.project-media.index'))
            ->delete(route('admin.project-media.bulk-destroy'), ['ids' => [$first->id, $second->id]])
            ->assertRedirect(route('admin.project-media.index'))
            ->assertSessionHas('status', '2 project media items deleted.');

        $this->assertDatabaseMissing('project_media', ['id' => $first->id]);
        $this->assertDatabaseMissing('project_media', ['id' => $second->id]);
        $this->assertDatabaseHas('project_media', ['id' => $third->id]);
        Storage::disk('public')->assertMissing('project-media/one.jpg');
        Storage::disk('public')->assertMissing('project-media/two.mp4');
        Storage::disk('public')->assertExists('project-media/three.jpg');
    }

    private function administrator(): User
    {
        $administrator = User::factory()->create();
        $administrator->is_admin = true;
        $administrator->save();

        return $administrator;
    }
}
