<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('peminjamans', function (Blueprint $table) {
            $table->id('peminjaman_id');
            $table->string('kode_transaksi', 20)->unique(); // PMJ-2024-001
            $table->foreignId('siswa_id')->constrained('siswas', 'siswa_id');
            $table->foreignId('pustakawan_id')->nullable()->constrained('pustakawans', 'pustakawan_id');
            $table->date('tanggal_peminjaman');
            $table->date('tanggal_jatuh_tempo');
            $table->enum('status_peminjaman', ['Pending', 'Dipinjam', 'Dikembalikan', 'Terlambat', 'Hilang', 'Ditolak'])
                  ->default('Pending'); // Set default jadi Pending
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('peminjamans');
    }
};