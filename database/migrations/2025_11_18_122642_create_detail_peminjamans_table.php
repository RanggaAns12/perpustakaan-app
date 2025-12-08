<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_peminjamans', function (Blueprint $table) {
            $table->id('detail_id');
            $table->foreignId('peminjaman_id')->constrained('peminjamans', 'peminjaman_id');
            $table->foreignId('buku_id')->constrained('bukus', 'buku_id');
            $table->enum('kondisi_buku_saat_pinjam', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->decimal('denda_per_buku', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_peminjamans');
    }
};