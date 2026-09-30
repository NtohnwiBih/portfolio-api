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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role_title');                 
            $table->string('hero_title');                  
            $table->string('hero_highlight')->nullable();  
            $table->text('hero_description');
            $table->string('photo_path')->nullable();
            $table->string('photo_caption')->nullable();   
            $table->text('quote')->nullable();
            $table->string('quote_author')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->text('contact_intro')->nullable();     
            $table->string('resume_path')->nullable();
            $table->string('footer_text')->nullable();     
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
