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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->references('id')->on('artists')->onDelete('cascade');
            $table->string('title');
            $table->text('lyrics');
            $table->text('notes')->nullable();
            $table->string('spotify_url')->nullable();
            $table->string('mp3_audio')->nullable();
            $table->boolean('privacy')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
