<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalians', function (Blueprint $table) {
            $table->id('pengembalian_id');
            $table->string('kode_transaksi', 20)->unique(); // KMB-2024-001
            $table->foreignId('peminjaman_id')->constrained('peminjamans', 'peminjaman_id');
            $table->foreignId('siswa_id')->constrained('siswas', 'siswa_id');
            $table->foreignId('pustakawan_id')->constrained('pustakawans', 'pustakawan_id');
            $table->date('tanggal_pengembalian');
            $table->enum('status_pengembalian', ['Tepat Waktu', 'Terlambat'])->default('Tepat Waktu');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalians');
    }
};