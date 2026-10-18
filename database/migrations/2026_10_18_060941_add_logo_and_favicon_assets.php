<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach (['site.logo', 'site.favicon'] as $key) {
            $asset = config('cms.managed_assets')[$key];
            DB::table('site_assets')->updateOrInsert(['key' => $key], [
                'page' => $asset['page'], 'label' => $asset['label'], 'kind' => $asset['kind'],
                'value' => $asset['default'], 'created_at' => now(), 'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('site_assets')->whereIn('key', ['site.logo', 'site.favicon'])->delete();
    }
};
