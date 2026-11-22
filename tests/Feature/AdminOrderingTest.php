<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\CollectionItem;
use App\Models\Company;
use App\Models\JobOpening;
use App\Models\ProjectMedia;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminOrderingTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_administrators_can_reorder_lists(): void
    {
        $this->postJson('/admin/order/companies', ['ids' => [1]])->assertUnauthorized();
        $this->actingAs(User::factory()->create());
        $this->postJson('/admin/order/companies', ['ids' => [1]])->assertForbidden();
    }

    public function test_all_managed_lists_save_order_and_reject_incomplete_or_duplicate_lists(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        foreach (['companies' => Company::class, 'certificates' => Certificate::class, 'project-media' => ProjectMedia::class, 'job-openings' => JobOpening::class] as $kind => $model) {
            $first = $model::factory()->create(['sort_order' => 4]);
            $second = $model::factory()->create(['sort_order' => 8]);
            $this->postJson('/admin/order/'.$kind, ['ids' => [$second->id, $first->id]])->assertOk();
            $this->assertSame(0, $second->fresh()->sort_order);
            $this->assertSame(1, $first->fresh()->sort_order);
            $this->get('/admin/'.$kind)->assertOk()->assertSeeInOrder(['data-order-id="'.$second->id.'"', 'data-order-id="'.$first->id.'"'], false);
            $this->get('/admin/'.$kind.'?search='.urlencode($first->name ?? $first->title))->assertOk()->assertSee('data-enabled="false"', false);
            $this->postJson('/admin/order/'.$kind, ['ids' => [$first->id]])->assertUnprocessable();
            $this->postJson('/admin/order/'.$kind, ['ids' => [$first->id, $first->id]])->assertUnprocessable();
            $this->postJson('/admin/order/'.$kind, ['ids' => ['first' => $first->id, 'second' => $second->id]])->assertUnprocessable();
            $this->assertSame(0, $second->fresh()->sort_order);
        }
    }

    public function test_collection_order_is_scoped_and_rejects_other_collection_records(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        foreach (array_keys(config('cms.collections')) as $collection) {
            $first = CollectionItem::factory()->create(['collection' => $collection, 'sort_order' => 3]);
            $second = CollectionItem::factory()->create(['collection' => $collection, 'sort_order' => 7]);
            $this->postJson('/admin/order/collections/'.$collection, ['ids' => [$second->id, $first->id]])->assertOk();
            $this->assertSame(0, $second->fresh()->sort_order);
            $this->get('/admin/collections/'.$collection)->assertOk()->assertSeeInOrder(['data-order-id="'.$second->id.'"', 'data-order-id="'.$first->id.'"'], false);
        }
        $other = CollectionItem::query()->where('collection', 'services')->firstOrFail();
        $this->postJson('/admin/order/collections/products', ['ids' => [$other->id]])->assertUnprocessable();
        $this->postJson('/admin/order/collections/not-a-collection', ['ids' => [$other->id]])->assertNotFound();
        $this->postJson('/admin/order/users', ['ids' => [$other->id]])->assertNotFound();
    }

    public function test_slugs_are_generated_uniquely_and_existing_urls_and_order_are_preserved(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $details = ['title' => 'RCC Structural Design', 'description' => 'Details', 'status' => 'published', 'slug' => 'RCC Structural Design'];
        $this->post('/admin/collections/faqs', $details)->assertRedirect('/admin/collections/faqs');
        $this->post('/admin/collections/faqs', $details)->assertRedirect('/admin/collections/faqs');
        $items = CollectionItem::query()->orderBy('id')->get();
        $this->assertSame(['rcc-structural-design', 'rcc-structural-design-2'], $items->pluck('slug')->all());
        $item = $items->first();
        $item->update(['sort_order' => 12]);
        $this->put('/admin/collections/faqs/'.$item->id, ['title' => 'Changed title', 'description' => 'Changed details', 'status' => 'published'])->assertRedirect();
        $this->assertSame('rcc-structural-design', $item->fresh()->slug);
        $this->assertSame(12, $item->fresh()->sort_order);
        $this->post('/admin/collections/faqs', ['title' => '!!!', 'description' => 'Details', 'status' => 'published'])->assertRedirect();
        $this->assertDatabaseHas('collection_items', ['collection' => 'faqs', 'slug' => 'item']);
    }

    public function test_new_images_append_without_manual_order_and_edits_keep_their_position(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        Certificate::factory()->create(['sort_order' => 6]);
        $this->post('/admin/certificates', [
            'name' => 'New certificate', 'image_upload' => UploadedFile::fake()->image('certificate.jpg'), 'is_active' => '1',
        ])->assertRedirect();
        $certificate = Certificate::query()->where('name', 'New certificate')->firstOrFail();
        $this->assertSame(7, $certificate->sort_order);
        $this->put('/admin/certificates/'.$certificate->id, ['name' => 'Changed certificate', 'is_active' => '1'])->assertRedirect();
        $this->assertSame(7, $certificate->fresh()->sort_order);
        ProjectMedia::factory()->create(['sort_order' => 5]);
        $this->post('/admin/project-media', [
            'title' => 'New project', 'media_type' => 'image', 'media_upload' => UploadedFile::fake()->image('project.jpg'), 'is_active' => '1',
        ])->assertRedirect();
        $project = ProjectMedia::query()->where('title', 'New project')->firstOrFail();
        $this->assertSame(6, $project->sort_order);
        $this->put('/admin/project-media/'.$project->id, ['title' => 'Changed project', 'is_active' => '1'])->assertRedirect();
        $this->assertSame(6, $project->fresh()->sort_order);
    }

    public function test_managed_items_are_always_visible_without_a_visibility_checkbox(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        foreach (['companies' => Company::class, 'certificates' => Certificate::class, 'project-media' => ProjectMedia::class, 'job-openings' => JobOpening::class] as $kind => $model) {
            $details = match ($kind) {
                'companies', 'certificates' => ['name' => 'Visible item', 'image_upload' => UploadedFile::fake()->image('image.jpg')],
                'project-media' => ['title' => 'Visible project', 'media_type' => 'image', 'media_upload' => UploadedFile::fake()->image('project.jpg')],
                'job-openings' => JobOpening::factory()->make()->only(['title', 'department', 'location', 'employment_type', 'description', 'responsibilities', 'requirements']),
            };
            $this->post('/admin/'.$kind, $details)->assertRedirect('/admin/'.$kind);
            $item = $model::query()->latest('id')->firstOrFail();
            $this->assertTrue($item->is_active);
            $item->update(['is_active' => false]);
            $this->put('/admin/'.$kind.'/'.$item->id, array_merge($details, ['is_active' => '0']))->assertRedirect('/admin/'.$kind);
            $this->assertTrue($item->fresh()->is_active);
            $this->get('/admin/'.$kind.'/'.$item->id.'/edit')->assertOk()->assertDontSee('Show on website')->assertDontSee('name="is_active"', false);
        }
    }

    public function test_existing_hidden_items_are_published_by_the_visibility_migration(): void
    {
        foreach ([Company::class, Certificate::class, ProjectMedia::class, JobOpening::class] as $model) {
            $model::factory()->create(['is_active' => false]);
        }
        $migration = require database_path('migrations/2026_11_21_132540_make_admin_managed_items_always_visible.php');
        $migration->up();
        foreach ([Company::class, Certificate::class, ProjectMedia::class, JobOpening::class] as $model) {
            $this->assertTrue($model::query()->firstOrFail()->is_active);
        }
    }

    public function test_collection_lists_show_the_image_from_the_form(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $item = CollectionItem::factory()->create(['collection' => 'services', 'image' => '/storage/services/example.jpg']);
        $this->get('/admin/collections/services')->assertOk()->assertSee('src="'.$item->image.'"', false);
        $this->get('/admin/collections/faqs')->assertOk()->assertDontSee('<th>Image</th>', false);
    }

    public function test_review_slugs_use_the_client_name_and_manual_fields_are_absent(): void
    {
        Storage::fake('public');
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $this->post('/admin/collections/testimonials', [
            'client_name' => 'Happy Client', 'description' => 'Great work', 'designation' => 'Director', 'status' => 'published',
            'image_upload' => UploadedFile::fake()->image('client.jpg'),
        ])->assertRedirect();
        $this->assertDatabaseHas('collection_items', ['collection' => 'testimonials', 'slug' => 'happy-client', 'title' => 'Happy Client']);
        foreach (array_keys(config('cms.collections')) as $collection) {
            $this->get('/admin/collections/'.$collection.'/create')->assertOk()->assertDontSee('name="slug"', false)->assertDontSee('name="sort_order"', false);
        }
        foreach (['companies', 'certificates', 'project-media', 'job-openings'] as $kind) {
            $this->get('/admin/'.$kind.'/create')->assertOk()->assertDontSee('name="sort_order"', false)->assertDontSee('name="slug"', false);
        }
    }
}
