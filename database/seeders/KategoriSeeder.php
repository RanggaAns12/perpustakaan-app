<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Fiksi & Sastra',
                'deskripsi' => 'Novel, cerpen, puisi, dan karya sastra imajinatif lainnya.',
                'kode_warna' => '#F87171', // Red 400
            ],
            [
                'nama_kategori' => 'Sains & Teknologi',
                'deskripsi' => 'Buku pengetahuan alam, komputer, teknik, dan teknologi terbaru.',
                'kode_warna' => '#60A5FA', // Blue 400
            ],
            [
                'nama_kategori' => 'Sejarah & Budaya',
                'deskripsi' => 'Buku tentang peristiwa masa lalu, biografi tokoh, dan kebudayaan.',
                'kode_warna' => '#FBBF24', // Amber 400
            ],
            [
                'nama_kategori' => 'Pendidikan & Pelajaran',
                'deskripsi' => 'Buku teks sekolah, panduan belajar, dan referensi akademik.',
                'kode_warna' => '#34D399', // Emerald 400
            ],
            [
                'nama_kategori' => 'Agama & Filsafat',
                'deskripsi' => 'Buku keagamaan, spiritualitas, dan pemikiran filosofis.',
                'kode_warna' => '#A78BFA', // Violet 400
            ],
            [
                'nama_kategori' => 'Bisnis & Ekonomi',
                'deskripsi' => 'Manajemen, investasi, kewirausahaan, dan ekonomi makro/mikro.',
                'kode_warna' => '#FB923C', // Orange 400
            ],
            [
                'nama_kategori' => 'Pengembangan Diri',
                'deskripsi' => 'Motivasi, psikologi populer, dan peningkatan soft skill.',
                'kode_warna' => '#EC4899', // Pink 400
            ],
            [
                'nama_kategori' => 'Anak & Remaja',
                'deskripsi' => 'Buku cerita anak, dongeng, komik edukasi, dan novel remaja.',
                'kode_warna' => '#F472B6', // Pink 400
            ],
        ];

        foreach ($kategoris as $data) {
            Kategori::create($data);
        }
    }
}