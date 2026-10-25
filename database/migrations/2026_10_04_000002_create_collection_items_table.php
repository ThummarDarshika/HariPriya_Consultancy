<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('collection_items', function (Blueprint $table): void {
            $table->id();
            $table->string('collection', 32);
            $table->string('title');
            $table->string('slug');
            $table->string('category')->nullable();
            $table->longText('description')->nullable();
            $table->text('summary')->nullable();
            $table->string('article_subheading')->nullable();
            $table->string('video_url', 2048)->nullable();
            $table->decimal('price', 12, 2)->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable();
            $table->json('gallery')->nullable();
            $table->json('features')->nullable();
            $table->string('status', 16)->default('draft');
            $table->string('client_name')->nullable();
            $table->string('designation')->nullable();
            $table->string('company')->nullable();
            $table->unsignedTinyInteger('rating')->nullable();
            $table->string('role')->nullable();
            $table->string('material')->nullable();
            $table->string('capability')->nullable();
            $table->string('size_range')->nullable();
            $table->string('metric')->nullable();
            $table->string('display_date')->nullable();
            $table->json('social_links')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['collection', 'slug']);
            $table->index(['collection', 'status', 'sort_order']);
        });

        Schema::create('contact_submissions', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('subject')->nullable();
            $table->text('message');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_submissions');
        Schema::dropIfExists('collection_items');
    }
};
