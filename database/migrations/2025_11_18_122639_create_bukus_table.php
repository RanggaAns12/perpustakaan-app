<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bukus', function (Blueprint $table) {
            $table->id('buku_id');
            $table->foreignId('kategori_id')->constrained('kategoris', 'kategori_id');
            $table->foreignId('penerbit_id')->constrained('penerbits', 'penerbit_id');
            $table->string('isbn', 20)->nullable();
            $table->string('judul_buku', 200);
            $table->integer('tahun_terbit');
            $table->integer('jumlah_halaman')->nullable();
            $table->string('bahasa', 20)->default('Indonesia');
            $table->text('sinopsis')->nullable();
            $table->string('cover_buku')->nullable();
            $table->integer('jumlah_eksemplar_total');
            $table->integer('jumlah_eksemplar_tersedia');
            $table->string('lokasi_rak', 20);
            $table->enum('status_buku', ['Tersedia', 'Dipinjam', 'Rusak', 'Hilang'])->default('Tersedia');
            $table->foreignId('created_by')->constrained('users', 'user_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bukus');
    }
};