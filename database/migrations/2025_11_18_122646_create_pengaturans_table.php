<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaturans', function (Blueprint $table) {
            $table->id('pengaturan_id');
            $table->integer('max_peminjaman_hari')->default(7);
            $table->integer('max_buku_dipinjam')->default(3);
            $table->decimal('denda_per_hari', 10, 2)->default(2000);
            $table->integer('masa_tenggang')->default(3);
            $table->foreignId('updated_by')->constrained('users', 'user_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengaturans');
    }
};