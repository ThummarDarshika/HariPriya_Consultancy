<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('site_contents')
            ->where('page', 'home')
            ->whereIn('value', ['Based in: Los Angeles, India', 'Based in: Los Angeles, USA'])
            ->update(['value' => 'Based in: India', 'updated_at' => now()]);
    }

    /** Replaced template content should not be restored. */
    public function down(): void {}
};
