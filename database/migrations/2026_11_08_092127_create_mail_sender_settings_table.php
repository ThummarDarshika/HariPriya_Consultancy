<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mail_sender_settings', function (Blueprint $table): void {
            $table->id();
            $table->string('email');
            $table->string('name', 160);
            $table->string('smtp_host');
            $table->unsignedSmallInteger('smtp_port');
            $table->string('smtp_scheme', 10);
            $table->string('smtp_username');
            $table->text('smtp_password');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mail_sender_settings');
    }
};
