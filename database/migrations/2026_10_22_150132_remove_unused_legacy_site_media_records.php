<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('site_assets')->whereIn('key', [
            'about.hero_background',
            'blog.hero_background',
            'case-studies.hero_background',
            'home.cta_background',
            'products.inquiry_background',
            'services.cta_background',
        ])->delete();

        DB::table('site_contents')->whereIn('key', [
            'global/header/div:0/div:0/div:0/a:0/img:0/image',
            'home/main/section:1/div:1/div:0/div:0/img:0/image',
            'global/footer/div:2/div:0/div:0/div:0/form:0/input:0/placeholder',
        ])->delete();
    }

    /** Deleted user content cannot be recreated reliably. */
    public function down(): void {}
};
