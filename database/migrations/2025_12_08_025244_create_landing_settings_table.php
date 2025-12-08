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
        Schema::create('landing_settings', function (Blueprint $table) {
            $table->id();
            // Hero Section
            $table->string('tagline')->default('Sistem Perpustakaan Digital 2.0');
            $table->string('judul_hero')->default('Jelajahi Jendela Dunia Pengetahuan');
            $table->text('deskripsi_hero')->nullable();
            $table->string('text_cta')->default('Mulai Membaca');
            $table->string('gambar_hero')->nullable(); // Path gambar
            
            // Kontak Info (Footer)
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->string('email')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_settings');
    }
};
