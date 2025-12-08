<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LandingSetting;

class LandingSettingSeeder extends Seeder
{
    public function run(): void
    {
        LandingSetting::create([
            'tagline' => 'Sistem Perpustakaan Digital 2.0',
            'judul_hero' => 'Jelajahi Jendela Dunia Pengetahuan',
            'deskripsi_hero' => 'Akses ribuan koleksi buku secara mudah dan cepat. Pinjam, baca, dan kembalikan buku hanya dalam genggaman tangan Anda.',
            'text_cta' => 'Mulai Membaca',
            'alamat' => 'Jl. Pendidikan No. 1, Medan',
            'telepon' => '(061) 1234-5678',
            'email' => 'info@sekolah.sch.id',
        ]);
    }
}