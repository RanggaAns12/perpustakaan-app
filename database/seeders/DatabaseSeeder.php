<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Admin;
use App\Models\Penulis; // Import Penulis
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Roles
        $roles = [
            ['role_id' => 1, 'role_name' => 'Admin'],
            ['role_id' => 2, 'role_name' => 'Pustakawan'],
            ['role_id' => 3, 'role_name' => 'Siswa'],
            ['role_id' => 4, 'role_name' => 'Guru'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['role_id' => $role['role_id']], $role);
        }

        // 2. Buat User Admin Default
        $userAdmin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'role_id' => 1,
                'password' => Hash::make('password123'),
                'email' => 'admin@sekolah.sch.id',
                'is_active' => true,
            ]
        );

        // 3. Buat Profil Admin
        if (!$userAdmin->admin) {
            Admin::create([
                'user_id' => $userAdmin->user_id,
                'nip' => '199001012024011001',
                'nama_lengkap' => 'Administrator Utama',
                'nomor_telepon' => '081234567890',
            ]);
        }

        // 4. Panggil Seeder Master Data (Penerbit & Kategori)
        $this->call([
            PenerbitSeeder::class,
            KategoriSeeder::class,
        ]);

        // 5. Buat Data Dummy Penulis (Opsional, agar dropdown penulis tidak kosong)
        $penulisNames = [
            'Andrea Hirata', 'Tere Liye', 'Dee Lestari', 'Pramoedya Ananta Toer', 
            'Raditya Dika', 'Eka Kurniawan', 'Leila S. Chudori', 'Ika Natassa',
            'J.K. Rowling', 'Agatha Christie'
        ];

        foreach ($penulisNames as $nama) {
            Penulis::firstOrCreate(['nama_penulis' => $nama], [
                'biografi' => 'Penulis terkenal dengan karya best seller.',
                'kebangsaan' => 'Indonesia'
            ]);
        }

        $this->command->info('Database berhasil di-seed dengan lengkap!');
    }
}