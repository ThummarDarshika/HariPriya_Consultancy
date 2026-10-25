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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_opening_id')->constrained()->restrictOnDelete();
            $table->string('role_title');
            $table->string('full_name', 160);
            $table->string('email');
            $table->string('phone', 64);
            $table->string('location', 160);
            $table->string('qualification', 160);
            $table->unsignedSmallInteger('experience_years');
            $table->string('current_company', 160)->nullable();
            $table->string('notice_period', 80)->nullable();
            $table->text('cover_letter');
            $table->string('resume_path');
            $table->timestamps();
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
