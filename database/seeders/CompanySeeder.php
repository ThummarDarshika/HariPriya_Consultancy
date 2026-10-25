<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $logos = [
            '1-BK1k9eNG.svg', '2-B-fi7rK7.svg', 'client-logo-03.svg',
            '4-BXsuW1ly.svg', '5-Btx3uSlX.svg', '6-CUpVjbFW.svg',
            'client-logo-07.svg', '8-CnKgKRq1.svg', 'client-logo-09.svg',
            'client-logo-10.svg', '11-CAPVb5z7.svg', 'client-logo-12.svg',
        ];

        foreach ($logos as $index => $logo) {
            Company::withTrashed()->firstOrCreate(
                ['seed_key' => sprintf('legacy-%02d', $index + 1)],
                [
                    'name' => sprintf('Company %02d', $index + 1),
                    'image_path' => '/assets/'.$logo,
                    'sort_order' => $index,
                    'is_active' => true,
                ],
            );
        }
    }
}
