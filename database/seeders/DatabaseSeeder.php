<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;
use App\Models\Admin;
use App\Models\Siswa;
use App\Models\Jurusan;
use App\Models\TahunAjaran;
use App\Models\Kelas;
use App\Models\Penulis;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon; // Jangan lupa import Carbon

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

        // --- MASTER DATA PENDUKUNG ---
        
        // Buat Jurusan
        $jurusan = Jurusan::firstOrCreate(
            ['kode_jurusan' => 'RPL'],
            ['nama_jurusan' => 'Rekayasa Perangkat Lunak']
        );

        // Buat Tahun Ajaran (Fix: is_aktif)
        $tahunAjaran = TahunAjaran::firstOrCreate(
            ['tahun_ajaran' => '2024/2025', 'semester' => 'Ganjil'], 
            [
                'is_aktif' => true,
                'tanggal_mulai' => '2024-07-15',
                'tanggal_selesai' => '2024-12-20',
            ]
        );

        // Buat Kelas (Fix: kode_kelas & tingkat)
        $kelas = Kelas::firstOrCreate(
            ['nama_kelas' => 'X RPL 1'], 
            [
                'jurusan_id' => $jurusan->jurusan_id,
                'tahun_id' => $tahunAjaran->tahun_id,
                'kode_kelas' => 'X-RPL-1', // Wajib unik
                'tingkat' => 'X',          // Wajib diisi (Enum: X, XI, XII)
                'kapasitas' => 36
            ]
        );

        // -------------------------------------------------------------

        // 2. Buat User Admin
        $userAdmin = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'role_id' => 1,
                'password' => Hash::make('password123'),
                'email' => 'admin@sekolah.sch.id',
                'is_active' => true,
            ]
        );
        
        if (!$userAdmin->admin) {
            Admin::create([
                'user_id' => $userAdmin->user_id,
                'nip' => '199001012024011001',
                'nama_lengkap' => 'Administrator Utama',
                'nomor_telepon' => '081234567890',
            ]);
        }

        // 3. Buat User Siswa (Agar bisa Login)
        $userSiswa = User::firstOrCreate(
            ['username' => 'siswa'],
            [
                'role_id' => 3,
                'password' => Hash::make('password123'),
                'email' => 'siswa@sekolah.sch.id',
                'is_active' => true,
            ]
        );

        // Buat Profil Siswa
        if (!$userSiswa->siswa) {
            Siswa::create([
                'user_id' => $userSiswa->user_id,
                'kelas_id' => $kelas->kelas_id,
                'nis' => '10001',
                // 'nisn' => '0012345678', // DIBUANG: Karena di Migration tabel siswas TIDAK ADA kolom nisn
                'nama_lengkap' => 'Siswa Percobaan',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '2008-01-01',
                'agama' => 'Islam',
                'alamat' => 'Jl. Pendidikan No. 10',
                'nomor_telepon' => '085712345678',
                'nama_orangtua' => 'Budi Santoso',
                'telepon_orangtua' => '081298765432',
                'tanggal_daftar' => Carbon::now(), // Wajib diisi
                'status_siswa' => 'Aktif',
            ]);
        }

        // 4. Seeder Lainnya
        $this->call([
            PenerbitSeeder::class,
            KategoriSeeder::class,
        ]);

        // 5. Penulis Dummy
        $penulisNames = ['Andrea Hirata', 'Tere Liye', 'J.K. Rowling'];
        foreach ($penulisNames as $nama) {
            Penulis::firstOrCreate(['nama_penulis' => $nama], [
                'biografi' => 'Penulis dummy.',
                'kebangsaan' => 'Indonesia'
            ]);
        }

        $this->command->info('Database berhasil di-seed (Lengkap & Fix)!');
    }
}