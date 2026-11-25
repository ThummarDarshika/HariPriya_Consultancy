<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Company;
use App\Models\SiteAsset;
use App\Models\User;
use Database\Seeders\CertificateSeeder;
use Database\Seeders\CompanySeeder;
use Database\Seeders\SiteAssetSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ManagedContentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_reorder_companies_and_incomplete_orders_are_rejected(): void
    {
        $first = Company::factory()->create(['sort_order' => 0]);
        $second = Company::factory()->create(['sort_order' => 1]);
        $this->postJson('/admin/companies/reorder', ['ids' => [$second->id, $first->id]])->assertUnauthorized();
        $this->actingAs(User::factory()->create());
        $this->postJson('/admin/companies/reorder', ['ids' => [$second->id, $first->id]])->assertForbidden();
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $this->postJson('/admin/companies/reorder', ['ids' => [$second->id, $first->id]])->assertOk();
        $this->assertSame(0, $second->fresh()->sort_order);
        $this->assertSame(1, $first->fresh()->sort_order);
        $this->get('/admin/companies')->assertOk()->assertSeeInOrder([$second->name, $first->name]);
        $this->postJson('/admin/companies/reorder', ['ids' => [$first->id]])->assertUnprocessable();
        $this->postJson('/admin/companies/reorder', ['ids' => [$first->id, $first->id]])->assertUnprocessable();
        $this->assertSame(0, $second->fresh()->sort_order);
    }

    public function test_only_administrators_can_manage_company_certificate_and_site_media(): void
    {
        $this->get('/admin/companies')->assertRedirect('/admin/login');
        $this->get('/admin/certificates')->assertRedirect('/admin/login');
        $this->get('/admin/site-assets')->assertRedirect('/admin/login');

        $this->actingAs(User::factory()->create());

        $this->get('/admin/companies')->assertForbidden();
        $this->post('/admin/companies', [])->assertForbidden();
        $this->get('/admin/certificates')->assertForbidden();
        $this->get('/admin/site-assets')->assertForbidden();
    }

    public function test_seeded_companies_and_certificates_render_from_database(): void
    {
        $this->seed([CompanySeeder::class, CertificateSeeder::class]);

        $this->get('/')->assertOk()->assertSee('alt="Company 01"', false);
        $this->get('/contact')->assertOk()->assertSee('alt="Company 01"', false);
        $this->get('/about')->assertOk()
            ->assertSee('alt="Company 01"', false)
            ->assertSee('alt="Certificate 01"', false);

        Company::query()->where('seed_key', 'legacy-01')->update(['name' => 'Renamed client']);
        Certificate::query()->where('seed_key', 'legacy-01')->update(['is_active' => false]);
        $this->seed([CompanySeeder::class, CertificateSeeder::class]);

        $this->get('/about')->assertSee('alt="Renamed client"', false)
            ->assertDontSee('alt="Certificate 01"', false);
    }

    public function test_administrator_can_create_update_hide_and_delete_managed_images(): void
    {
        Storage::fake('public');
        $this->actingAs($this->administrator());

        $this->get('/admin/companies/create')->assertOk();
        $this->get('/admin/certificates/create')->assertOk();
        $this->get('/admin/companies')->assertOk();
        $this->get('/admin/certificates')->assertOk();

        $this->post('/admin/companies', [
            'name' => 'Acme Manufacturing',
            'image_upload' => UploadedFile::fake()->image('acme.png'),
            'sort_order' => 2,
            'is_active' => 1,
        ])->assertRedirect(route('admin.companies.index'));
        $company = Company::query()->firstOrFail();
        Storage::disk('public')->assertExists(substr($company->image_path, strlen('/storage/')));
        $this->get('/about')->assertSee('alt="Acme Manufacturing"', false);
        $this->get('/contact')->assertSee('alt="Acme Manufacturing"', false);

        $this->post('/admin/certificates', [
            'name' => 'ISO 9001',
            'image_upload' => UploadedFile::fake()->image('iso.png'),
            'sort_order' => 1,
            'is_active' => 1,
        ])->assertRedirect(route('admin.certificates.index'));
        $certificate = Certificate::query()->firstOrFail();
        $this->get('/about')->assertSee('alt="ISO 9001"', false);

        $this->put(route('admin.companies.update', $company), [
            'name' => 'Acme Updated',
            'sort_order' => 3,
            'is_active' => 0,
        ])->assertRedirect(route('admin.companies.index'));
        $this->get('/about')->assertSee('alt="Acme Updated"', false);

        $this->delete(route('admin.certificates.destroy', $certificate))
            ->assertRedirect(route('admin.certificates.index'));
        $this->assertSoftDeleted($certificate);
        $this->get('/about')->assertDontSee('alt="ISO 9001"', false);
    }

    public function test_company_and_certificate_tables_search_by_name_and_keep_search_when_paginating(): void
    {
        foreach (range(1, 31) as $position) {
            Company::factory()->create(['name' => 'Target company '.str_pad((string) $position, 2, '0', STR_PAD_LEFT), 'sort_order' => $position]);
            Certificate::factory()->create(['name' => 'Target certificate '.str_pad((string) $position, 2, '0', STR_PAD_LEFT), 'sort_order' => $position]);
        }

        Company::factory()->create(['name' => 'Unrelated company']);
        Certificate::factory()->create(['name' => 'Unrelated certificate']);
        $this->actingAs($this->administrator());

        foreach (['companies' => 'company', 'certificates' => 'certificate'] as $route => $label) {
            $this->get('/admin/'.$route.'?search=Target')->assertOk()
                ->assertSee('Target '.$label.' 30')
                ->assertDontSee('Target '.$label.' 31')
                ->assertDontSee('Unrelated '.$label)
                ->assertSee('search=Target', false);

            $this->get('/admin/'.$route.'?search=Target&page=2')->assertOk()
                ->assertSee('Target '.$label.' 31')
                ->assertDontSee('Target '.$label.' 30')
                ->assertDontSee('Unrelated '.$label);
        }
    }

    public function test_site_media_and_brochure_uploads_are_saved_and_rendered_immediately(): void
    {
        Storage::fake('public');
        $this->seed(SiteAssetSeeder::class);
        $this->actingAs($this->administrator());
        $this->get('/admin/site-assets')->assertOk();
        $this->get('/admin/brochure')->assertOk()->assertSee('Upload brochure');

        $background = SiteAsset::query()->where('key', 'cta.background')->firstOrFail();
        $this->put(route('admin.site-assets.update', $background), [
            'upload' => UploadedFile::fake()->image('new-cta.png'),
        ])->assertRedirect(route('admin.site-assets.index'));
        $background->refresh();
        Storage::disk('public')->assertExists(substr($background->value, strlen('/storage/')));
        $previousBackground = $background->value;
        $this->get('/')->assertOk()->assertSee($previousBackground);

        $this->put(route('admin.site-assets.update', $background), [
            'upload' => UploadedFile::fake()->image('replacement-cta.png'),
        ])->assertRedirect(route('admin.site-assets.index'));
        $background->refresh();
        $this->assertNotSame($previousBackground, $background->value);
        Storage::disk('public')->assertMissing(substr($previousBackground, strlen('/storage/')));
        $this->get('/')->assertSee($background->value)->assertDontSee($previousBackground);

        $brochure = SiteAsset::query()->where('key', 'brochure')->firstOrFail();
        $this->put(route('admin.site-assets.update', $brochure), [
            'upload' => UploadedFile::fake()->create('brochure.pdf', 100, 'application/pdf'),
        ])->assertRedirect(route('admin.brochure'));
        $brochure->refresh();
        $this->assertStringStartsWith('/storage/brochures/', $brochure->value);
        $this->seed(SiteAssetSeeder::class);
        $this->assertSame($brochure->value, $brochure->fresh()->value);
        Storage::disk('public')->assertExists(substr($brochure->value, strlen('/storage/')));
        $this->get('/')->assertSee($brochure->value);
        $this->get('/about')->assertSee($brochure->value);

        $since = SiteAsset::query()->where('key', 'about.since_label')->firstOrFail();
        $this->put(route('admin.site-assets.update', $since), [
            'value' => 'Since - 2010',
        ])->assertRedirect(route('admin.site-assets.index'));
        $this->get('/about')->assertSee('Since - 2010');
    }

    public function test_brochure_accepts_a_50_mb_pdf_and_rejects_a_larger_file(): void
    {
        Storage::fake('public');
        $this->seed(SiteAssetSeeder::class);
        $this->actingAs($this->administrator());
        $brochure = SiteAsset::query()->where('key', 'brochure')->firstOrFail();

        $this->put(route('admin.site-assets.update', $brochure), [
            'upload' => UploadedFile::fake()->create('brochure.pdf', 51200, 'application/pdf'),
        ])->assertRedirect(route('admin.brochure'));

        $brochure->refresh();
        Storage::disk('public')->assertExists(substr($brochure->value, strlen('/storage/')));
        $savedValue = $brochure->value;
        $this->get('/')->assertSee($savedValue);

        $this->put(route('admin.site-assets.update', $brochure), [
            'upload' => UploadedFile::fake()->create('too-large.pdf', 51201, 'application/pdf'),
        ])->assertSessionHasErrors('upload');

        $this->assertSame($savedValue, $brochure->fresh()->value);
        Storage::disk('public')->assertExists(substr($savedValue, strlen('/storage/')));
    }

    public function test_shared_cta_background_is_saved_in_site_assets_and_rendered_on_its_pages(): void
    {
        Storage::fake('public');
        $this->seed(SiteAssetSeeder::class);
        $this->actingAs($this->administrator());
        $this->get('/admin/site-assets')->assertOk()
            ->assertDontSee('Shared CTA background (Home, Products & Services)')
            ->assertDontSee('About Us heading background')
            ->assertDontSee('Custom Order Inquiry background');

        $asset = SiteAsset::query()->where('key', 'cta.background')->firstOrFail();
        $this->put(route('admin.site-assets.update', $asset), [
            'upload' => UploadedFile::fake()->image('shared-background.png'),
        ])->assertRedirect(route('admin.site-assets.index'));

        $asset->refresh();
        $this->assertStringStartsWith('/storage/site-assets/', $asset->value);
        Storage::disk('public')->assertExists(substr($asset->value, strlen('/storage/')));

        foreach (['/', '/products', '/services'] as $page) {
            $this->get($page)->assertOk()->assertSee($asset->value);
        }
    }

    public function test_company_dialog_uses_the_existing_upload_and_validation_flow(): void
    {
        Storage::fake('public');
        $this->actingAs($this->administrator());
        $this->get('/admin/companies')->assertOk()->assertSee('data-company-dialog', false)->assertSee('company-dialog.js');
        $this->get('/admin/certificates')->assertOk()->assertSee('data-company-dialog', false)->assertSee('data-crop-width="900" data-crop-height="1200"', false);
        $this->postJson('/admin/companies', ['name' => 'New company'])->assertUnprocessable()->assertJsonValidationErrors('image_upload');
        $this->post('/admin/companies', [
            'name' => 'New company', 'image_upload' => UploadedFile::fake()->image('logo.jpg'),
        ], ['Accept' => 'application/json'])->assertCreated()->assertJsonPath('message', 'Company added.');
        $company = Company::query()->firstOrFail();
        $image = $company->image_path;
        $position = $company->sort_order;
        Storage::disk('public')->assertExists(substr($image, strlen('/storage/')));
        $this->post('/admin/companies/'.$company->id, [
            '_method' => 'PUT', 'name' => '',
        ], ['Accept' => 'application/json'])->assertUnprocessable()->assertJsonValidationErrors('name');
        $this->assertSame('New company', $company->fresh()->name);
        $this->post('/admin/companies/'.$company->id, [
            '_method' => 'PUT', 'name' => 'Changed company',
        ], ['Accept' => 'application/json'])->assertOk()->assertJsonPath('message', 'Company saved.');
        $this->assertSame($image, $company->fresh()->image_path);
        $this->assertSame($position, $company->fresh()->sort_order);
        $this->post('/admin/companies/'.$company->id, [
            '_method' => 'PUT', 'name' => 'Changed company', 'image_upload' => UploadedFile::fake()->image('replacement.png'),
        ], ['Accept' => 'application/json'])->assertOk();
        $this->assertNotSame($image, $company->fresh()->image_path);
        Storage::disk('public')->assertMissing(substr($image, strlen('/storage/')));
        Storage::disk('public')->assertExists(substr($company->fresh()->image_path, strlen('/storage/')));
        $this->get('/admin/companies')->assertOk()->assertSee('data-company-name="Changed company"', false)->assertSee('data-company-image="'.$company->fresh()->image_path.'"', false);
        $this->get('/')->assertOk()->assertSee($company->fresh()->image_path);
    }

    public function test_certificate_dialog_creates_and_updates_images_without_losing_the_existing_file_or_order(): void
    {
        Storage::fake('public');
        $this->actingAs($this->administrator());
        $this->postJson('/admin/certificates', ['name' => 'Certificate'])->assertUnprocessable()->assertJsonValidationErrors('image_upload');
        $this->post('/admin/certificates', [
            'name' => 'ISO certificate', 'image_upload' => UploadedFile::fake()->image('certificate.jpg'),
        ], ['Accept' => 'application/json'])->assertCreated()->assertJsonPath('message', 'Certificate added.');
        $item = Certificate::query()->firstOrFail();
        $image = $item->image_path;
        $position = $item->sort_order;
        $this->get('/admin/certificates')->assertOk()->assertSee('data-item-label="certificate"', false)->assertSee('data-company-name="ISO certificate"', false)->assertSee('data-company-image="'.$image.'"', false);
        $this->post('/admin/certificates/'.$item->id, ['_method' => 'PUT', 'name' => ''], ['Accept' => 'application/json'])->assertUnprocessable()->assertJsonValidationErrors('name');
        $this->assertSame('ISO certificate', $item->fresh()->name);
        $this->post('/admin/certificates/'.$item->id, ['_method' => 'PUT', 'name' => 'Changed certificate'], ['Accept' => 'application/json'])->assertOk()->assertJsonPath('message', 'Certificate saved.');
        $this->assertSame($image, $item->fresh()->image_path);
        $this->assertSame($position, $item->fresh()->sort_order);
        Storage::disk('public')->assertExists(substr($image, strlen('/storage/')));
        $this->post('/admin/certificates/'.$item->id, [
            '_method' => 'PUT', 'name' => 'Changed certificate', 'image_upload' => UploadedFile::fake()->image('replacement.png'),
        ], ['Accept' => 'application/json'])->assertOk();
        $this->assertNotSame($image, $item->fresh()->image_path);
        Storage::disk('public')->assertMissing(substr($image, strlen('/storage/')));
        Storage::disk('public')->assertExists(substr($item->fresh()->image_path, strlen('/storage/')));
        $this->get('/about')->assertOk()->assertSee($item->fresh()->image_path);
    }

    public function test_administrator_can_bulk_delete_selected_companies_and_certificates(): void
    {
        Storage::fake('public');
        Storage::disk('public')->put('companies/alpha.png', 'alpha');
        Storage::disk('public')->put('companies/beta.png', 'beta');
        Storage::disk('public')->put('companies/gamma.png', 'gamma');
        Storage::disk('public')->put('certificates/iso-9001.png', 'iso9001');
        Storage::disk('public')->put('certificates/iso-14001.png', 'iso14001');

        $first = Company::factory()->create(['name' => 'Alpha Corp', 'image_path' => '/storage/companies/alpha.png']);
        $second = Company::factory()->create(['name' => 'Beta Corp', 'image_path' => '/storage/companies/beta.png']);
        $third = Company::factory()->create(['name' => 'Gamma Corp', 'image_path' => '/storage/companies/gamma.png']);
        $seeded = Company::factory()->create(['name' => 'Seeded Corp', 'image_path' => '/assets/1-BK1k9eNG.svg']);

        $certFirst = Certificate::factory()->create(['name' => 'ISO 9001', 'image_path' => '/storage/certificates/iso-9001.png']);
        $certSecond = Certificate::factory()->create(['name' => 'ISO 14001', 'image_path' => '/storage/certificates/iso-14001.png']);
        $certSeeded = Certificate::factory()->create(['name' => 'Seeded Cert', 'image_path' => '/assets/4-cTO0dgU6.svg']);

        $this->delete(route('admin.companies.bulk-destroy'), ['ids' => [$first->id]])
            ->assertRedirect(route('login'));
        $this->delete(route('admin.certificates.bulk-destroy'), ['ids' => [$certFirst->id]])
            ->assertRedirect(route('login'));

        $this->actingAs(User::factory()->create());
        $this->delete(route('admin.companies.bulk-destroy'), ['ids' => [$first->id]])
            ->assertForbidden();
        $this->delete(route('admin.certificates.bulk-destroy'), ['ids' => [$certFirst->id]])
            ->assertForbidden();
        $this->assertNotSoftDeleted($first);
        $this->assertNotSoftDeleted($certFirst);
        Storage::disk('public')->assertExists('companies/alpha.png');
        Storage::disk('public')->assertExists('certificates/iso-9001.png');

        $this->actingAs($this->administrator());

        $this->get(route('admin.companies.index'))
            ->assertOk()
            ->assertSee('data-bulk-select-all', false)
            ->assertSee('data-bulk-select-item', false)
            ->assertSee('form="bulk-delete-companies-form"', false)
            ->assertSee('company-bulk-delete.js', false)
            ->assertSee('Delete selected');

        $this->get(route('admin.certificates.index'))
            ->assertOk()
            ->assertSee('data-bulk-select-all', false)
            ->assertSee('data-bulk-select-item', false)
            ->assertSee('form="bulk-delete-certificates-form"', false)
            ->assertSee('company-bulk-delete.js', false)
            ->assertSee('Delete selected');

        $this->from(route('admin.companies.index'))
            ->delete(route('admin.companies.bulk-destroy'), ['ids' => []])
            ->assertRedirect(route('admin.companies.index'))
            ->assertSessionHasErrors('ids');

        $this->from(route('admin.companies.index'))
            ->delete(route('admin.companies.bulk-destroy'), ['ids' => [$first->id, $third->id, $seeded->id]])
            ->assertRedirect(route('admin.companies.index'))
            ->assertSessionHas('status', '3 companies deleted.');

        $this->assertSoftDeleted($first);
        $this->assertNotSoftDeleted($second);
        $this->assertSoftDeleted($third);
        $this->assertSoftDeleted($seeded);
        Storage::disk('public')->assertMissing('companies/alpha.png');
        Storage::disk('public')->assertMissing('companies/gamma.png');
        Storage::disk('public')->assertExists('companies/beta.png');
        $this->assertFileExists(public_path('assets/1-BK1k9eNG.svg'));

        $this->from(route('admin.certificates.index'))
            ->delete(route('admin.certificates.bulk-destroy'), ['ids' => [$certFirst->id, $certSeeded->id]])
            ->assertRedirect(route('admin.certificates.index'))
            ->assertSessionHas('status', '2 certificates deleted.');

        $this->assertSoftDeleted($certFirst);
        $this->assertNotSoftDeleted($certSecond);
        $this->assertSoftDeleted($certSeeded);
        Storage::disk('public')->assertMissing('certificates/iso-9001.png');
        Storage::disk('public')->assertExists('certificates/iso-14001.png');
        $this->assertFileExists(public_path('assets/4-cTO0dgU6.svg'));

        $this->from(route('admin.companies.index'))
            ->delete(route('admin.companies.bulk-destroy'), ['ids' => [$first->id]])
            ->assertRedirect(route('admin.companies.index'))
            ->assertSessionHasErrors('ids.0');

        $this->delete(route('admin.companies.destroy', $second))
            ->assertRedirect(route('admin.companies.index'))
            ->assertSessionHas('status', 'Company deleted.');
        $this->assertSoftDeleted($second);
    }

    private function administrator(): User
    {
        $administrator = User::factory()->create();
        $administrator->is_admin = true;
        $administrator->save();

        return $administrator;
    }
}
