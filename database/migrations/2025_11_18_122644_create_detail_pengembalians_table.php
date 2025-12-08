<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pengembalians', function (Blueprint $table) {
            $table->id('detail_pengembalian_id');
            $table->foreignId('pengembalian_id')->constrained('pengembalians', 'pengembalian_id');
            $table->foreignId('buku_id')->constrained('bukus', 'buku_id');
            $table->enum('kondisi_buku_saat_kembali', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik');
            $table->text('keterangan_kerusakan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pengembalians');
    }
};