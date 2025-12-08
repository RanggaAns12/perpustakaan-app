<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penulis', function (Blueprint $table) {
            $table->id('penulis_id');
            $table->string('nama_penulis', 100);
            $table->text('biografi')->nullable();
            $table->string('kebangsaan', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penulis');
    }
};