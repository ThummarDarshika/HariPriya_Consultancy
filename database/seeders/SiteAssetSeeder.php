<?php

namespace Database\Seeders;

use App\Models\SiteAsset;
use Illuminate\Database\Seeder;

class SiteAssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $legacySharedCtaValue = SiteAsset::query()
            ->whereIn('key', ['home.cta_background', 'services.cta_background', 'products.inquiry_background'])
            ->orderByDesc('updated_at')
            ->value('value');

        foreach (config('cms.managed_assets') as $key => $asset) {
            SiteAsset::query()->firstOrCreate(
                ['key' => $key],
                [
                    'page' => $asset['page'],
                    'label' => $asset['label'],
                    'kind' => $asset['kind'],
                    'value' => $key === 'cta.background' ? ($legacySharedCtaValue ?? $asset['default']) : $asset['default'],
                ],
            );
        }
    }
}
