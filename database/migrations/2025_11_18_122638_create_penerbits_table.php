<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penerbits', function (Blueprint $table) {
            $table->id('penerbit_id');
            $table->string('nama_penerbit', 100);
            $table->text('alamat_penerbit')->nullable();
            $table->string('kota', 50)->nullable();
            $table->string('telepon_penerbit', 15)->nullable();
            $table->string('email_penerbit')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penerbits');
    }
};