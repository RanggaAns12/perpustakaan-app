<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dendas', function (Blueprint $table) {
            $table->id('denda_id');
            $table->foreignId('pengembalian_id')->constrained('pengembalians', 'pengembalian_id');
            $table->foreignId('siswa_id')->constrained('siswas', 'siswa_id');
            $table->integer('jumlah_hari_terlambat');
            $table->decimal('tarif_denda_per_hari', 10, 2);
            $table->decimal('total_denda', 10, 2);
            $table->enum('status_denda', ['Belum Lunas', 'Lunas'])->default('Belum Lunas');
            $table->date('tanggal_bayar')->nullable();
            $table->enum('metode_pembayaran', ['Tunai', 'Transfer'])->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dendas');
    }
};