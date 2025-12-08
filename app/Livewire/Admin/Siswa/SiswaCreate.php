<?php

namespace App\Livewire\Admin\Siswa;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SiswaCreate extends Component
{
    use WithFileUploads;

    #[Validate('required', as: 'Nama Lengkap')] 
    public $nama_lengkap;

    #[Validate('required|unique:siswas,nis', as: 'NIS')] 
    public $nis;
    
    // PERBAIKAN: Inisialisasi dengan string kosong
    #[Validate('required', as: 'Kelas')] 
    public $kelas_id = '';

    // PERBAIKAN: Inisialisasi dengan string kosong
    #[Validate('required', as: 'Jenis Kelamin')] 
    public $jenis_kelamin = '';

    public $tempat_lahir;
    public $tanggal_lahir;
    public $alamat;
    public $nomor_telepon;
    public $email;
    
    #[Validate('nullable|image|max:2048', as: 'Foto Profil')] 
    public $foto_profil;
    
    public $nama_orangtua;
    public $telepon_orangtua;

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            // 1. Buat User Login (Username = NIS, Password Default = siswa123)
            $user = User::create([
                'username' => $this->nis,
                'password' => Hash::make('siswa123'),
                'email' => $this->email,
                'role_id' => 3, // ID 3 = Siswa
                'is_active' => true
            ]);

            $fotoPath = null;
            if ($this->foto_profil) {
                $fotoPath = $this->foto_profil->store('profil', 'public');
            }

            // 2. Buat Data Siswa
            Siswa::create([
                'user_id' => $user->user_id,
                'kelas_id' => $this->kelas_id,
                'nis' => $this->nis,
                'nama_lengkap' => $this->nama_lengkap,
                'jenis_kelamin' => $this->jenis_kelamin,
                'tempat_lahir' => $this->tempat_lahir,
                'tanggal_lahir' => $this->tanggal_lahir,
                'alamat' => $this->alamat,
                'nomor_telepon' => $this->nomor_telepon,
                'foto_profil' => $fotoPath,
                'nama_orangtua' => $this->nama_orangtua,
                'telepon_orangtua' => $this->telepon_orangtua,
                'tanggal_daftar' => now(),
                'status_siswa' => 'Aktif'
            ]);
        });

       $this->dispatch('show-success', message: 'Siswa berhasil ditambahkan. Login: NIS / siswa123');
        return redirect()->route('siswa.index');
    }

    public function render()
    {
        // Menambahkan 'with' jurusan agar nama kelas lebih jelas (opsional)
        return view('livewire.admin.siswa.siswa-create', [
            'kelases' => Kelas::with('jurusan')->get() 
        ]);
    }
}