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
        $this->get('/about')->assertDontSee('alt="Acme Updated"', false);

        $this->delete(route('admin.certificates.destroy', $certificate))
            ->assertRedirect(route('admin.certificates.index'));
        $this->assertSoftDeleted($certificate);
        $this->get('/about')->assertDontSee('alt="ISO 9001"', false);
    }

    public function test_site_media_and_brochure_uploads_are_saved_and_rendered_immediately(): void
    {
        Storage::fake('public');
        $this->seed(SiteAssetSeeder::class);
        $this->actingAs($this->administrator());
        $this->get('/admin/site-assets')->assertOk();
        $this->get('/admin/brochure')->assertOk()->assertSee('Upload PDF');

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

    public function test_shared_cta_background_is_saved_in_site_assets_and_rendered_on_its_pages(): void
    {
        Storage::fake('public');
        $this->seed(SiteAssetSeeder::class);
        $this->actingAs($this->administrator());
        $this->get('/admin/site-assets')->assertOk()
            ->assertSee('Shared CTA background (Home, Products & Services)')
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

    private function administrator(): User
    {
        $administrator = User::factory()->create();
        $administrator->is_admin = true;
        $administrator->save();

        return $administrator;
    }
}
