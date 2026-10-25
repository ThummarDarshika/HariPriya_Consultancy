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
        foreach (config('cms.managed_assets') as $key => $asset) {
            SiteAsset::query()->firstOrCreate(
                ['key' => $key],
                [
                    'page' => $asset['page'],
                    'label' => $asset['label'],
                    'kind' => $asset['kind'],
                    'value' => $asset['default'],
                ],
            );
        }
    }
}
