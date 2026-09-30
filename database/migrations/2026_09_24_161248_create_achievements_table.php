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
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();      
            $table->text('description');
            $table->string('icon')->nullable();
            $table->string('metric_label');              
            $table->unsignedSmallInteger('order')->default(0);
            $table->timestamps();
        });

        Schema::create('achievement_tags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('achievement_id')->constrained()->cascadeOnDelete();
            $table->string('tag');
        });

        Schema::create('achievement_gallery_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('achievement_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('icon')->nullable();
            $table->string('media_path')->nullable();
            $table->unsignedSmallInteger('order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('achievement_gallery_items');
        Schema::dropIfExists('achievement_tags');
        Schema::dropIfExists('achievements');
    }
};
