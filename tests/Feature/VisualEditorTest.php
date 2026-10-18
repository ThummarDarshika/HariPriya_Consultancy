<?php

namespace Tests\Feature;

use App\Models\SiteContent;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\SharedContentSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class VisualEditorTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_open_editor_or_save_content(): void
    {
        $this->get('/admin/editor?page=home')->assertRedirect('/admin/login');
        $this->postJson('/api/site-content/save', ['page' => 'home'])->assertUnauthorized();
    }

    public function test_non_admin_cannot_open_editor_or_save_content(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/admin/editor?page=home')->assertForbidden();
        $this->postJson('/api/site-content/save', ['page' => 'home'])->assertForbidden();
    }

    public function test_administrator_can_publish_text_and_public_api_returns_it(): void
    {
        $administrator = User::factory()->create();
        $administrator->is_admin = true;
        $administrator->save();
        $this->actingAs($administrator);

        $this->get('/admin/editor?page=about')->assertOk()->assertSee('cms-editor-toolbar');
        $this->postJson('/api/site-content/save', [
            'page' => 'about',
            'changes' => [[
                'key' => 'about/main/section:0/div:0/text:0',
                'type' => 'text',
                'value' => 'A revised headline',
            ]],
        ])->assertOk()->assertJsonPath('saved.0.value', 'A revised headline');

        $this->assertSame('A revised headline', SiteContent::query()->firstOrFail()->value);
        $this->getJson('/api/site-content?page=about')->assertOk()->assertJsonFragment(['value' => 'A revised headline']);
        $this->getJson('/api/site-content?page=home')->assertOk()->assertDontSee('A revised headline');
    }

    public function test_administrator_can_publish_an_image_and_public_api_returns_its_url(): void
    {
        Storage::fake('public');
        $administrator = User::factory()->create();
        $administrator->is_admin = true;
        $administrator->save();
        $this->actingAs($administrator);

        $response = $this->post('/api/site-content/save', [
            'page' => 'home',
            'images' => [[
                'key' => 'home/main/img:0/image',
                'type' => 'image',
                'file' => UploadedFile::fake()->image('hero.png'),
            ]],
        ], ['Accept' => 'application/json']);

        $response->assertOk()->assertJsonPath('saved.0.type', 'image');
        $imageUrl = $response->json('saved.0.value');
        $this->assertStringStartsWith('/storage/site-content/', $imageUrl);
        $this->assertSame($imageUrl, SiteContent::query()->firstOrFail()->value);
        Storage::disk('public')->assertExists(substr($imageUrl, strlen('/storage/')));
        $this->getJson('/api/site-content?page=home')->assertOk()->assertJsonFragment(['value' => $imageUrl]);
        $this->get('/')->assertOk()->assertSee('cms-content-pending')->assertSee(basename($imageUrl));
        $this->get('/admin/editor?page=home')->assertOk()->assertSee(basename($imageUrl));
        $this->get('/about')->assertOk()->assertDontSee(basename($imageUrl));
    }

    public function test_administrator_can_publish_a_video_and_public_api_returns_its_url(): void
    {
        Storage::fake('public');
        $administrator = User::factory()->create();
        $administrator->is_admin = true;
        $administrator->save();
        $this->actingAs($administrator);

        $response = $this->post('/api/site-content/save', [
            'page' => 'home',
            'videos' => [[
                'key' => 'home/main/video:0/video',
                'file' => UploadedFile::fake()->create('hero.mp4', 100, 'video/mp4'),
            ]],
        ], ['Accept' => 'application/json']);

        $response->assertOk()->assertJsonPath('saved.0.type', 'video');
        $videoUrl = $response->json('saved.0.value');
        $this->assertStringStartsWith('/storage/site-videos/', $videoUrl);
        $this->assertDatabaseHas('site_contents', [
            'page' => 'home',
            'key' => 'home/main/video:0/video',
            'type' => 'video',
            'value' => $videoUrl,
        ]);
        Storage::disk('public')->assertExists(substr($videoUrl, strlen('/storage/')));
        $this->getJson('/api/site-content?page=home')->assertOk()->assertJsonFragment(['value' => $videoUrl]);
    }

    public function test_founder_details_published_from_either_page_are_shared_by_public_pages_and_editors(): void
    {
        Storage::fake('public');
        $this->seed(SharedContentSeeder::class);
        $administrator = User::factory()->create();
        $administrator->is_admin = true;
        $administrator->save();
        $this->actingAs($administrator);

        $this->postJson('/api/site-content/save', [
            'page' => 'global',
            'changes' => [
                ['key' => 'global/founder/name', 'type' => 'text', 'value' => 'Avery Stone'],
                ['key' => 'global/founder/role', 'type' => 'text', 'value' => 'Managing Director'],
            ],
        ])->assertOk()->assertJsonCount(2, 'saved');

        $this->assertDatabaseHas('site_contents', [
            'page' => 'global', 'key' => 'global/founder/name', 'value' => 'Avery Stone',
        ]);
        $this->get('/')->assertOk()->assertSee('Avery Stone')->assertSee('Managing Director');
        $this->get('/about')->assertOk()->assertSee('Avery Stone')->assertSee('Managing Director');
        $this->get('/admin/editor?page=home')->assertSee('Avery Stone');
        $this->get('/admin/editor?page=about')->assertSee('Avery Stone');

        $response = $this->post('/api/site-content/save', [
            'page' => 'global',
            'images' => [[
                'key' => 'global/founder/image',
                'type' => 'image',
                'file' => UploadedFile::fake()->image('founder.png'),
            ]],
        ], ['Accept' => 'application/json']);

        $response->assertOk()->assertJsonPath('saved.0.type', 'image');
        $imageUrl = $response->json('saved.0.value');
        $this->assertSame($imageUrl, SiteContent::query()->where('page', 'global')->where('key', 'global/founder/image')->value('value'));
        Storage::disk('public')->assertExists(substr($imageUrl, strlen('/storage/')));
        $this->get('/')->assertSee($imageUrl);
        $this->get('/about')->assertSee($imageUrl);

        $this->seed(SharedContentSeeder::class);
        $this->assertDatabaseHas('site_contents', [
            'page' => 'global', 'key' => 'global/founder/name', 'value' => 'Avery Stone',
        ]);
    }

    public function test_save_rejects_invalid_page_and_untrusted_image_path(): void
    {
        $administrator = User::factory()->create();
        $administrator->is_admin = true;
        $administrator->save();
        $this->actingAs($administrator);

        $this->postJson('/api/site-content/save', [
            'page' => 'unknown',
            'changes' => [],
        ])->assertUnprocessable();

        $this->postJson('/api/site-content/save', [
            'page' => 'home',
            'changes' => [[
                'key' => 'home/main/img:0/image',
                'type' => 'image',
                'value' => 'javascript:alert(1)',
            ]],
        ])->assertUnprocessable();

        $this->postJson('/api/site-content/save', [
            'page' => 'global',
            'changes' => [[
                'key' => 'global/header/a:0/href',
                'type' => 'url',
                'value' => 'javascript:alert(1)',
            ]],
        ])->assertUnprocessable();
    }

    public function test_admin_account_can_be_bootstrapped_from_private_configuration(): void
    {
        config()->set('cms.admin.name', 'Site Owner');
        config()->set('cms.admin.email', 'owner@example.com');
        config()->set('cms.admin.password', 'a-long-private-password');
        $this->seed(DatabaseSeeder::class);

        $this->assertDatabaseHas('users', ['email' => 'owner@example.com', 'is_admin' => true]);
        $this->post('/admin/login', [
            'email' => 'owner@example.com',
            'password' => 'a-long-private-password',
        ])->assertRedirect('/admin');
    }
}
