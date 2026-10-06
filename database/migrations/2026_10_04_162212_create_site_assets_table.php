<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_assets', function (Blueprint $table) {
            $table->id();
            $table->string('key', 100)->unique();
            $table->string('page', 30)->index();
            $table->string('label', 160);
            $table->string('kind', 20);
            $table->text('value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_assets');
    }
};
