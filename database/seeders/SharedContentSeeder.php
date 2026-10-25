<?php

namespace Database\Seeders;

use App\Models\SiteContent;
use Illuminate\Database\Seeder;

class SharedContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (config('cms.founder') as $field => $default) {
            SiteContent::query()->firstOrCreate(
                ['page' => 'global', 'key' => 'global/founder/'.$field],
                ['type' => $field === 'image' ? 'image' : 'text', 'value' => $default],
            );
        }
    }
}
