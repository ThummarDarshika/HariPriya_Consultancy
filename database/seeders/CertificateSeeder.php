<?php

namespace Database\Seeders;

use App\Models\Certificate;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['4-cTO0dgU6.svg', '2-w-olEE16.svg', '1-B0uK0s1S.svg', '3-sIx_wNan.svg'] as $index => $image) {
            Certificate::withTrashed()->firstOrCreate(
                ['seed_key' => sprintf('legacy-%02d', $index + 1)],
                [
                    'name' => sprintf('Certificate %02d', $index + 1),
                    'image_path' => '/assets/'.$image,
                    'sort_order' => $index,
                    'is_active' => true,
                ],
            );
        }
    }
}
