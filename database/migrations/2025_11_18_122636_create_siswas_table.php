<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id('siswa_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->foreignId('kelas_id')->constrained('kelas', 'kelas_id');
            $table->string('nis', 10)->unique()->nullable();
            $table->string('nama_lengkap', 100);
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama', 20)->nullable();
            $table->text('alamat')->nullable();
            $table->string('nomor_telepon', 15)->nullable();
            $table->string('foto_profil')->nullable();
            $table->string('nama_orangtua', 100)->nullable();
            $table->string('telepon_orangtua', 15)->nullable();
            $table->date('tanggal_daftar');
            $table->enum('status_siswa', ['Aktif', 'Lulus', 'Pindah', 'Drop Out'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};