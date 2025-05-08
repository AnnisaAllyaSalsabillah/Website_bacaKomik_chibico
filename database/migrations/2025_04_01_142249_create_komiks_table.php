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
        Schema::create('komiks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('sinopsis')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('rank')->nullable();
            $table->string('alternative')->nullable();
            $table->string('author')->nullable();
            $table->string('artist')->nullable();
            $table->enum('type', ['manhwa', 'manhua', 'manga'])->default('manhua');
            $table->string('release_year')->nullable();
            $table->enum('status', ['ongoing', 'completed'])->default('ongoing');
            $table->timestamps();
        });
        //
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komiks');
    }
};
