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
         Schema::create('expertise_principles', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('title');
            $table->text('description');
            $table->unsignedSmallInteger('order')->default(0);
        });

        Schema::create('expertise_categories', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable();
            $table->string('title');
            $table->unsignedSmallInteger('order')->default(0);
        });

        Schema::create('expertise_category_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('expertise_category_id')->constrained()->cascadeOnDelete();
            $table->string('label');   
            $table->unsignedSmallInteger('order')->default(0);
        });

        Schema::create('expertise_stats', function (Blueprint $table) {
            $table->id();
            $table->string('value');  
            $table->string('label');   
            $table->unsignedSmallInteger('order')->default(0);
        });

        Schema::create('capability_highlights', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->string('icon')->nullable();   
            $table->string('media_path')->nullable();
            $table->string('link')->nullable();
            $table->unsignedSmallInteger('order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capability_highlights');
        Schema::dropIfExists('expertise_stats');
        Schema::dropIfExists('expertise_category_items');
        Schema::dropIfExists('expertise_categories');
        Schema::dropIfExists('expertise_principles');
    }
};
