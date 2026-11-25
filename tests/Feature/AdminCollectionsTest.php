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

    public function test_client_reviews_require_an_image_and_keep_the_existing_image_on_edit(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $details = ['client_name' => 'Client', 'description' => 'Great work', 'designation' => 'Director', 'status' => 'published'];
        $this->post('/admin/collections/testimonials', $details)->assertSessionHasErrors('image_upload');
        foreach ([null, ''] as $image) {
            $item = CollectionItem::factory()->create(['collection' => 'testimonials', 'image' => $image]);
            $this->put('/admin/collections/testimonials/'.$item->id, $details)->assertSessionHasErrors('image_upload');
            $this->put('/admin/collections/testimonials/'.$item->id, $details + ['image_upload' => UploadedFile::fake()->image('client.jpg')])->assertSessionHasNoErrors()->assertRedirect();
            $savedImage = $item->fresh()->image;
            $this->assertNotEmpty($savedImage);
            $this->put('/admin/collections/testimonials/'.$item->id, $details + ['remove_image' => '1'])->assertSessionHasNoErrors()->assertRedirect();
            $this->assertSame($savedImage, $item->fresh()->image);
        }
    }

    public function test_all_collection_edits_keep_their_image_when_removal_is_requested(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        foreach (['products', 'blogs', 'services', 'case-studies', 'team-members'] as $collection) {
            $item = CollectionItem::factory()->create(['collection' => $collection, 'image' => '/storage/existing.jpg']);
            $details = ['title' => 'Updated item', 'description' => 'Details', 'status' => 'published', 'remove_image' => '1'];
            $details += match ($collection) {
                'products' => ['material' => 'Steel', 'capability' => 'Design', 'size_range' => 'Custom'],
                'blogs' => ['category' => 'News', 'summary' => 'Summary', 'article_subheading' => 'Details', 'video_url' => 'https://www.youtube.com/embed/example', 'display_date' => '22 Nov 2026'],
                'case-studies' => ['category' => 'Industrial', 'metric' => '50'],
                'team-members' => ['role' => 'Director', 'social_links' => ['instagram' => 'https://instagram.com/example', 'linkedin' => 'https://linkedin.com/in/example', 'x' => 'https://x.com/example']],
                default => [],
            };
            $this->put('/admin/collections/'.$collection.'/'.$item->id, $details)->assertSessionHasNoErrors()->assertRedirect();
            $this->assertSame('/storage/existing.jpg', $item->fresh()->image);
            $this->get('/admin/collections/'.$collection.'/'.$item->id.'/edit')->assertOk()->assertDontSee('Remove current image');
        }
    }

    public function test_all_content_dialogs_keep_the_existing_fields_and_save_images_and_updates(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        foreach (['products', 'services', 'blogs', 'testimonials', 'case-studies', 'team-members'] as $collection) {
            $details = ['title' => 'New item', 'description' => 'Description', 'status' => 'published'];
            $details += match ($collection) {
                'products' => ['material' => 'Steel', 'capability' => 'Design', 'size_range' => 'Custom'],
                'blogs' => ['category' => 'News', 'summary' => 'Summary', 'article_subheading' => 'Details', 'video_url' => 'https://www.youtube.com/embed/example', 'display_date' => '22 Nov 2026'],
                'testimonials' => ['client_name' => 'Client', 'designation' => 'Director'],
                'case-studies' => ['category' => 'Industrial', 'metric' => '50'],
                'team-members' => ['role' => 'Director', 'social_links' => ['instagram' => 'https://instagram.com/example', 'linkedin' => 'https://linkedin.com/in/example', 'x' => 'https://x.com/example']],
                default => [],
            };
            $this->get('/admin/collections/'.$collection)->assertOk()->assertSee('data-form-dialog-open', false)->assertSee('data-form-dialog', false);
            $this->get('/admin/collections/'.$collection.'/create')->assertOk()->assertSee('name="image_upload"', false);
            $response = $this->post('/admin/collections/'.$collection, $details + ['image_upload' => UploadedFile::fake()->image('image.jpg')], ['Accept' => 'application/json'])->assertCreated();
            $item = CollectionItem::query()->findOrFail($response->json('id'));
            $image = $item->image;
            $slug = $item->slug;
            $position = $item->sort_order;
            $this->get('/admin/collections/'.$collection.'/'.$item->id.'/edit')->assertOk()->assertSee('data-current-image="'.$image.'"', false);
            $changed = $details;
            $changed[$collection === 'testimonials' ? 'client_name' : 'title'] = 'Changed item';
            $this->post('/admin/collections/'.$collection.'/'.$item->id, $changed + ['_method' => 'PUT'], ['Accept' => 'application/json'])->assertOk()->assertJsonPath('id', $item->id);
            $this->assertSame($image, $item->fresh()->image);
            $this->assertSame($slug, $item->fresh()->slug);
            $this->assertSame($position, $item->fresh()->sort_order);
            $this->getJson('/api/'.$collection)->assertOk()->assertJsonFragment(['id' => $item->id, 'image' => $image]);
            $changed[$collection === 'testimonials' ? 'client_name' : 'title'] = '';
            $this->post('/admin/collections/'.$collection.'/'.$item->id, $changed + ['_method' => 'PUT'], ['Accept' => 'application/json'])->assertUnprocessable();
            $this->assertSame($image, $item->fresh()->image);
        }
        $this->get('/admin/collections/faqs')->assertOk()->assertSee('data-form-dialog-open', false);
    }

    public function test_faq_dialog_validates_question_and_answer_and_saves_add_and_edit_requests(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $this->get('/admin/collections/faqs')->assertOk()->assertSee('data-dialog-title="Add FAQ"', false)->assertSee('data-form-dialog', false);
        $this->get('/admin/collections/faqs/create')->assertOk()->assertSee('Question')->assertSee('Answer')->assertDontSee('type="file"', false);
        $this->postJson('/admin/collections/faqs', ['status' => 'published'])->assertUnprocessable()->assertJsonValidationErrors(['title', 'description']);
        $response = $this->postJson('/admin/collections/faqs', ['title' => 'How does it work?', 'description' => 'Contact our team.', 'status' => 'published'])->assertCreated();
        $item = CollectionItem::query()->findOrFail($response->json('id'));
        $slug = $item->slug;
        $position = $item->sort_order;
        $this->get('/admin/collections/faqs/'.$item->id.'/edit')->assertOk()->assertSee('Contact our team.');
        $this->get('/admin/collections/faqs')->assertOk()->assertSee('data-dialog-title="Edit FAQ"', false);
        $this->postJson('/admin/collections/faqs/'.$item->id, ['_method' => 'PUT', 'title' => '', 'description' => '', 'status' => 'published'])->assertUnprocessable()->assertJsonValidationErrors(['title', 'description']);
        $this->assertSame('Contact our team.', $item->fresh()->description);
        $this->postJson('/admin/collections/faqs/'.$item->id, ['_method' => 'PUT', 'title' => 'Updated question?', 'description' => 'Updated answer.', 'status' => 'published'])->assertOk()->assertJsonPath('id', $item->id);
        $this->assertSame($slug, $item->fresh()->slug);
        $this->assertSame($position, $item->fresh()->sort_order);
        $this->getJson('/api/faqs')->assertOk()->assertJsonFragment(['title' => 'Updated question?', 'description' => 'Updated answer.']);
    }

    public function test_contact_form_creates_read_only_submission_for_admin(): void
    {
        $this->post('/contact', [
            'first_name' => 'Asha',
            'last_name' => 'Shah',
            'email' => 'asha@example.com',
            'phone' => '9876543210',
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

    public function test_administrator_can_bulk_delete_selected_collection_items_and_remove_stored_media(): void
    {
        Storage::fake('public');

        $otherCollectionItem = CollectionItem::factory()->create(['collection' => 'services', 'title' => 'Keep Service']);

        $this->delete(route('admin.collections.bulk-destroy', 'products'), ['ids' => [$otherCollectionItem->id]])
            ->assertRedirect(route('login'));

        $this->actingAs(User::factory()->create());
        $this->delete(route('admin.collections.bulk-destroy', 'products'), ['ids' => [$otherCollectionItem->id]])
            ->assertForbidden();

        $this->actingAs(User::factory()->create(['is_admin' => true]));

        $this->from(route('admin.collections.index', 'products'))
            ->delete(route('admin.collections.bulk-destroy', 'products'), ['ids' => [$otherCollectionItem->id]])
            ->assertRedirect(route('admin.collections.index', 'products'))
            ->assertSessionHasErrors('ids.0');
        $this->assertDatabaseHas('collection_items', ['id' => $otherCollectionItem->id]);

        foreach (array_keys(config('cms.collections')) as $collection) {
            $firstPath = 'collection-items/'.$collection.'-one.jpg';
            $secondPath = 'collection-items/'.$collection.'-two.jpg';
            $iconPath = 'collection-icons/'.$collection.'-icon.png';
            $galleryPath = 'collection-items/'.$collection.'-gallery.jpg';

            Storage::disk('public')->put($firstPath, 'one');
            Storage::disk('public')->put($secondPath, 'two');
            Storage::disk('public')->put($iconPath, 'icon');
            Storage::disk('public')->put($galleryPath, 'gallery');

            $first = CollectionItem::factory()->create([
                'collection' => $collection,
                'image' => $collection === 'faqs' ? null : '/storage/'.$firstPath,
                'icon' => $collection === 'faqs' ? null : '/storage/'.$iconPath,
                'gallery' => $collection === 'faqs' ? null : ['/storage/'.$galleryPath],
            ]);
            $second = CollectionItem::factory()->create([
                'collection' => $collection,
                'image' => $collection === 'faqs' ? null : '/storage/'.$secondPath,
            ]);
            $seeded = CollectionItem::factory()->create([
                'collection' => $collection,
                'image' => $collection === 'faqs' ? null : '/assets/1-BK1k9eNG.svg',
            ]);

            $this->get(route('admin.collections.index', $collection))
                ->assertOk()
                ->assertSee('data-bulk-select-all', false)
                ->assertSee('data-bulk-select-item', false)
                ->assertSee('form="bulk-delete-collections-form"', false)
                ->assertSee('company-bulk-delete.js', false)
                ->assertSee('Delete selected');

            $this->from(route('admin.collections.index', $collection))
                ->delete(route('admin.collections.bulk-destroy', $collection), ['ids' => [$first->id, $seeded->id]])
                ->assertRedirect(route('admin.collections.index', $collection))
                ->assertSessionHas('status', '2 items deleted.');

            $this->assertDatabaseMissing('collection_items', ['id' => $first->id]);
            $this->assertDatabaseMissing('collection_items', ['id' => $seeded->id]);
            $this->assertDatabaseHas('collection_items', ['id' => $second->id]);

            if ($collection !== 'faqs') {
                Storage::disk('public')->assertMissing($firstPath);
                Storage::disk('public')->assertMissing($iconPath);
                Storage::disk('public')->assertMissing($galleryPath);
                Storage::disk('public')->assertExists($secondPath);
                $this->assertFileExists(public_path('assets/1-BK1k9eNG.svg'));
            }
        }
    }
}
