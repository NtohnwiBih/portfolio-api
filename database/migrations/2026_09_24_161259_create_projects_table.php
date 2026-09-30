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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->enum('type', ['frontend', 'backend', 'fullstack'])->default('frontend');
            $table->string('short_description');
            $table->longText('description')->nullable();
            $table->json('tech_stack')->nullable();      
            $table->string('cover_image_path')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->unsignedSmallInteger('order')->default(0);
            $table->timestamps();
        });

        Schema::create('project_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('image_path');
            $table->string('caption')->nullable();
            $table->unsignedSmallInteger('order')->default(0);
        });

        Schema::create('project_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('label');   
            $table->string('type');   
            $table->string('url');
            $table->unsignedSmallInteger('order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_links');
        Schema::dropIfExists('project_images');
        Schema::dropIfExists('projects');
    }
};
