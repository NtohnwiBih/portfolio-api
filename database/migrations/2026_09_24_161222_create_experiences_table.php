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
       Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->string('role_title');       
            $table->string('company');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);
            $table->unsignedSmallInteger('order')->default(0);
            $table->timestamps();
        });

        Schema::create('experience_highlights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('experience_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->unsignedSmallInteger('order')->default(0);
        });

        Schema::create('experience_snapshots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('experience_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('subtitle')->nullable();  
            $table->string('icon')->nullable();    
            $table->string('image_path')->nullable();
            $table->unsignedSmallInteger('order')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experience_snapshots');
        Schema::dropIfExists('experience_highlights');
        Schema::dropIfExists('experiences');
    }
};
