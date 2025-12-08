<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Penerbit;

class PenerbitSeeder extends Seeder
{
    public function run(): void
    {
        $penerbits = [
            [
                'nama_penerbit' => 'Gramedia Pustaka Utama',
                'alamat_penerbit' => 'Jl. Palmerah Barat 29-37, Gelora, Tanah Abang',
                'kota' => 'Jakarta Pusat',
                'telepon_penerbit' => '021-53650110',
                'email_penerbit' => 'redaksi@gramediapustakautama.id',
            ],
            [
                'nama_penerbit' => 'Erlangga',
                'alamat_penerbit' => 'Jl. H. Baping Raya No. 100, Ciracas',
                'kota' => 'Jakarta Timur',
                'telepon_penerbit' => '021-8717006',
                'email_penerbit' => 'redaksi@erlangga.co.id',
            ],
            [
                'nama_penerbit' => 'Mizan Pustaka',
                'alamat_penerbit' => 'Jl. Cinambo No. 135, Cisaranten Wetan',
                'kota' => 'Bandung',
                'telepon_penerbit' => '022-7834310',
                'email_penerbit' => 'redaksi@mizan.com',
            ],
            [
                'nama_penerbit' => 'Republika Penerbit',
                'alamat_penerbit' => 'Jl. Warung Buncit Raya No. 37',
                'kota' => 'Jakarta Selatan',
                'telepon_penerbit' => '021-7803747',
                'email_penerbit' => 'sekretariat@republikapenerbit.id',
            ],
            [
                'nama_penerbit' => 'Bentang Pustaka',
                'alamat_penerbit' => 'Jl. Palagan Tentara Pelajar No. 101',
                'kota' => 'Yogyakarta',
                'telepon_penerbit' => '0274-869066',
                'email_penerbit' => 'bentang.pustaka@mizan.com',
            ],
            [
                'nama_penerbit' => 'Gagas Media',
                'alamat_penerbit' => 'Jl. H. Montong No. 57, Ciganjur',
                'kota' => 'Jakarta Selatan',
                'telepon_penerbit' => '021-78883030',
                'email_penerbit' => 'redaksi@gagasmedia.net',
            ],
        ];

        foreach ($penerbits as $data) {
            Penerbit::create($data);
        }
    }
}