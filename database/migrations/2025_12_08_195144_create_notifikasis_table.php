<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notifikasis', function (Blueprint $table) {
            $table->id('notifikasi_id');
            // Pengirim (Bisa Null jika sistem)
            $table->unsignedBigInteger('sender_id')->nullable();
            // Penerima
            $table->unsignedBigInteger('user_id');
            
            $table->string('judul');
            $table->text('pesan');
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            // Foreign Keys (Sesuaikan dengan nama tabel user Anda, di sini 'users' dan PK 'user_id')
            $table->foreign('sender_id')->references('user_id')->on('users')->onDelete('set null');
            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifikasis');
    }
};