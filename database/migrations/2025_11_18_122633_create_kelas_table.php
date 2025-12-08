<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id('kelas_id');
            $table->foreignId('jurusan_id')->constrained('jurusans', 'jurusan_id');
            $table->foreignId('tahun_id')->constrained('tahun_ajarans', 'tahun_id');
            $table->foreignId('wali_kelas')->nullable()->constrained('gurus', 'guru_id');
            $table->enum('tingkat', ['X', 'XI', 'XII']);
            $table->string('nama_kelas', 50); // X-MIPA-1
            $table->string('kode_kelas', 10)->unique(); // XM1
            $table->integer('kapasitas')->default(40);
            $table->string('ruangan', 20)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};