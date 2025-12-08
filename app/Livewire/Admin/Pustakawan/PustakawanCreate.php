<?php

namespace App\Livewire\Admin\Pustakawan;

use App\Models\Pustakawan;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class PustakawanCreate extends Component
{
    use WithFileUploads;

    #[Validate('required|min:3')]
    public $nama_lengkap;

    #[Validate('required|unique:pustakawans,nip', as: 'NIP')]
    public $nip;

    public $nomor_telepon;
    
    #[Validate('required|email|unique:users,email', as: 'Email')]
    public $email;

    public $shift_kerja = 'Pagi'; // Default
    
    #[Validate('required|date')]
    public $tanggal_bergabung;

    #[Validate('nullable|image|max:2048')]
    public $foto_profil;

    public function mount()
    {
        $this->tanggal_bergabung = date('Y-m-d');
    }

    public function save()
    {
        $this->validate();

        DB::transaction(function () {
            // 1. Buat User Login (Role ID 2 = Pustakawan)
            // Username = NIP, Password = pustakawan123
            $user = User::create([
                'username' => $this->nip,
                'email' => $this->email,
                'password' => Hash::make('pustakawan123'),
                'role_id' => 2, 
                'is_active' => true,
            ]);

            $fotoPath = null;
            if ($this->foto_profil) {
                $fotoPath = $this->foto_profil->store('profil-pustakawan', 'public');
            }

            // 2. Buat Data Pustakawan
            Pustakawan::create([
                'user_id' => $user->user_id,
                'nip' => $this->nip,
                'nama_lengkap' => $this->nama_lengkap,
                'nomor_telepon' => $this->nomor_telepon,
                'shift_kerja' => $this->shift_kerja,
                'tanggal_bergabung' => $this->tanggal_bergabung,
                'foto_profil' => $fotoPath,
            ]);
        });

       $this->dispatch('show-success', message: 'Pustakawan berhasil ditambahkan. Login default: NIP / pustakawan123');
    }

    public function render()
    {
        return view('livewire.admin.pustakawan.pustakawan-create');
    }
}