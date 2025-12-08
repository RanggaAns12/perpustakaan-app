<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buku_penulis', function (Blueprint $table) {
            $table->id('buku_penulis_id');
            $table->foreignId('buku_id')->constrained('bukus', 'buku_id');
            $table->foreignId('penulis_id')->constrained('penulis', 'penulis_id');
            $table->timestamps();
            
            $table->unique(['buku_id', 'penulis_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buku_penulis');
    }
};