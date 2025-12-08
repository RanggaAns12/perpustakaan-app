<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pustakawans', function (Blueprint $table) {
            $table->id('pustakawan_id');
            $table->foreignId('user_id')->constrained('users', 'user_id');
            $table->string('nip', 20)->unique();
            $table->string('nama_lengkap', 100);
            $table->string('nomor_telepon', 15)->nullable();
            $table->string('foto_profil')->nullable();
            $table->string('shift_kerja', 50)->nullable();
            $table->date('tanggal_bergabung');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pustakawans');
    }
};