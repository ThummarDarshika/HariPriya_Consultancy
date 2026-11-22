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
        foreach (['companies', 'certificates', 'project_media', 'job_openings'] as $table) {
            DB::table($table)->where('is_active', false)->update(['is_active' => true]);
        }
    }

    /**
     * Previous visibility choices cannot be reconstructed after publishing.
     */
    public function down(): void {}
};
