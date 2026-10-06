<?php

namespace Tests\Feature;

use App\Models\CollectionItem;
use App\Models\ContactSubmission;
use App\Models\User;
use Database\Seeders\LegacyCollectionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminCollectionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_administrators_can_manage_collection_items(): void
    {
        $this->get('/admin/collections/services')->assertRedirect('/admin/login');

        $this->actingAs(User::factory()->create());
        $this->post('/admin/collections/services', [
            'title' => 'New service',
            'slug' => 'new-service',
            'status' => 'published',
            'sort_order' => 0,
        ])->assertForbidden();

        $this->assertDatabaseCount('collection_items', 0);
    }

    public function test_administrator_can_create_update_and_delete_a_collection_item(): void
    {
        Storage::fake('public');
        $administrator = User::factory()->create();
        $administrator->is_admin = true;
        $administrator->save();
        $this->actingAs($administrator);

        $this->post('/admin/collections/services', [
            'title' => 'New service',
            'slug' => 'new-service',
            'description' => 'Service description',
            'image_upload' => UploadedFile::fake()->image('service.png'),
            'status' => 'published',
            'sort_order' => 1,
        ])->assertRedirect('/admin/collections/services');

        $item = CollectionItem::query()->firstOrFail();
        $this->put('/admin/collections/services/'.$item->id, [
            'title' => 'Updated service',
            'slug' => 'new-service',
            'description' => 'Updated service description',
            'status' => 'draft',
            'sort_order' => 2,
        ])->assertRedirect('/admin/collections/services');

        $this->assertDatabaseHas('collection_items', ['id' => $item->id, 'title' => 'Updated service', 'status' => 'draft']);
        $this->delete('/admin/collections/services/'.$item->id)->assertRedirect('/admin/collections/services');
        $this->assertDatabaseCount('collection_items', 0);
        $this->getJson('/api/services')->assertExactJson([]);
    }

    public function test_administrator_can_use_collection_json_api(): void
    {
        Storage::fake('public');
        $administrator = User::factory()->create();
        $administrator->is_admin = true;
        $administrator->save();
        $this->actingAs($administrator);

        $response = $this->postJson('/api/products', [
            'title' => 'Gear',
            'slug' => 'gear',
            'description' => 'Precision machined gear housing.',
            'image_upload' => UploadedFile::fake()->image('gear.png'),
            'material' => 'Aluminum',
            'capability' => 'CNC machining',
            'size_range' => 'Custom',
            'status' => 'published',
            'sort_order' => 0,
        ])->assertCreated()->assertJsonPath('title', 'Gear');

        $id = $response->json('id');
        $this->putJson('/api/products/'.$id, [
            'title' => 'Gear housing',
            'slug' => 'gear',
            'description' => 'Updated precision machined gear housing.',
            'material' => 'Aluminum',
            'capability' => 'CNC machining',
            'size_range' => 'Custom',
            'status' => 'published',
            'sort_order' => 0,
        ])->assertOk()->assertJsonPath('title', 'Gear housing');
        $this->deleteJson('/api/products/'.$id)->assertOk()->assertJsonPath('deleted', true);
    }

    public function test_contact_form_creates_read_only_submission_for_admin(): void
    {
        $this->post('/contact', [
            'first_name' => 'Asha',
            'last_name' => 'Shah',
            'email' => 'asha@example.com',
            'message' => 'Please call me.',
        ])->assertRedirect();

        $this->assertSame('Asha Shah', ContactSubmission::query()->firstOrFail()->name);
        $this->get('/admin/contact-submissions')->assertRedirect('/admin/login');

        $administrator = User::factory()->create();
        $administrator->is_admin = true;
        $administrator->save();
        $this->actingAs($administrator);

        $this->get('/admin/contact-submissions')->assertOk()->assertSee('Asha Shah');
        $this->get('/admin/contact-submissions/export')->assertOk()->assertHeader('content-type', 'text/csv; charset=UTF-8');
    }

    public function test_public_collection_endpoint_only_returns_published_items(): void
    {
        CollectionItem::query()->create([
            'collection' => 'services', 'title' => 'Visible service', 'slug' => 'visible-service',
            'description' => '**Bold** <script>alert(1)</script>',
            'status' => 'published', 'sort_order' => 0,
        ]);
        CollectionItem::query()->create([
            'collection' => 'services', 'title' => 'Draft service', 'slug' => 'draft-service',
            'status' => 'draft', 'sort_order' => 1,
        ]);

        $this->getJson('/api/collections/services')->assertOk()->assertSee('Visible service')->assertDontSee('Draft service');
        $response = $this->getJson('/api/services')->assertOk()->assertSee('Visible service')->assertDontSee('Draft service');
        $this->assertStringContainsString('<strong>Bold</strong>', $response->json('0.description_blocks_html.0'));
        $this->assertStringNotContainsString('<script>', $response->json('0.description_blocks_html.0'));
        $this->getJson('/api/services/2')->assertNotFound();
        $this->postJson('/api/services', [
            'title' => 'Unauthorized', 'slug' => 'unauthorized', 'status' => 'published', 'sort_order' => 0,
        ])->assertUnauthorized();
    }

    public function test_legacy_collection_content_is_imported_for_admin_management(): void
    {
        $this->seed(LegacyCollectionSeeder::class);

        foreach (['services' => 6, 'products' => 8, 'blogs' => 8, 'case-studies' => 5, 'faqs' => 6, 'team-members' => 6, 'testimonials' => 5] as $collection => $count) {
            $this->assertSame($count, CollectionItem::query()->where('collection', $collection)->count(), $collection);
        }

        $this->assertNotEmpty(CollectionItem::query()->where('collection', 'blogs')->orderBy('sort_order')->firstOrFail()->description);
    }
}
