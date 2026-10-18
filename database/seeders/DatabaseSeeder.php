<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(LegacyCollectionSeeder::class);
        $this->call([SiteAssetSeeder::class, CompanySeeder::class, CertificateSeeder::class, SharedContentSeeder::class]);

        if (config('cms.admin.email') && config('cms.admin.password')) {
            $administrator = User::query()->firstOrNew(['email' => config('cms.admin.email')]);
            $administrator->name = config('cms.admin.name');
            $administrator->password = config('cms.admin.password');
            $administrator->is_admin = true;
            $administrator->save();
        }
    }
}
