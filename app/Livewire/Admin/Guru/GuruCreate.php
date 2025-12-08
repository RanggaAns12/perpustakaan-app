<?php

namespace App\Livewire\Admin\Guru;

use App\Models\Guru;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GuruCreate extends Component
{
    use WithFileUploads;

    // --- DATA PRIBADI ---
    #[Validate('required|min:3', as: 'Nama Lengkap')]
    public $nama_lengkap;

    #[Validate('required|unique:gurus,nip', as: 'NIP')]
    public $nip;

    // PERBAIKAN PENTING: Inisialisasi dengan string kosong agar validasi 'required' berjalan normal
    #[Validate('required|in:L,P', as: 'Jenis Kelamin')]
    public $jenis_kelamin = ''; 

    public $mata_pelajaran;
    
    // --- KONTAK ---
    #[Validate('nullable|numeric', as: 'No. Telepon')]
    public $nomor_telepon;
    
    #[Validate('required|email|unique:gurus,email', as: 'Email')]
    public $email;

    // --- FILE & STATUS ---
    #[Validate('nullable|image|max:2048', as: 'Foto Profil')]
    public $foto_profil;

    public $status = 'Aktif'; // Default value

    /**
     * Custom Error Messages (Opsional, agar pesan lebih jelas)
     */
    public function messages() 
    {
        return [
            'jenis_kelamin.required' => 'Silakan pilih jenis kelamin.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
        ];
    }

    public function save()
    {
        $this->validate();

        // Gunakan Transaction agar jika salah satu gagal, tidak ada data sampah tersisa
        DB::transaction(function () {
            
            // 1. Buat Akun User Login Terlebih Dahulu
            // Username default = NIP, Password default = guru123
            $user = User::create([
                'username' => $this->nip, 
                'email' => $this->email,
                'password' => Hash::make('guru123'),
                'role_id' => 4, // Pastikan ID 4 adalah Role untuk Guru di database Anda
                'is_active' => true,
            ]);

            // 2. Upload Foto jika ada
            $fotoPath = null;
            if ($this->foto_profil) {
                $fotoPath = $this->foto_profil->store('profil-guru', 'public');
            }

            // 3. Buat Data Guru yang terhubung ke User
            Guru::create([
                'user_id' => $user->user_id,
                'nip' => $this->nip,
                'nama_lengkap' => $this->nama_lengkap,
                'jenis_kelamin' => $this->jenis_kelamin,
                'mata_pelajaran' => $this->mata_pelajaran,
                'nomor_telepon' => $this->nomor_telepon,
                'email' => $this->email,
                'foto_profil' => $fotoPath,
                'status' => $this->status,
            ]);
        });

       $this->dispatch('show-success', message: 'Data guru berhasil ditambahkan. Login default menggunakan NIP.');
        return redirect()->route('guru.index');
    }

    public function render()
    {
        return view('livewire.admin.guru.guru-create');
    }
}