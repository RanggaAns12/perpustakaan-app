<?php

namespace App\Livewire\Guru;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class Profile extends Component
{
    use WithFileUploads;

    // Property untuk menyimpan ID agar tidak hilang saat validasi
    public $guru_id;
    public $user_id;

    public $nama_lengkap;
    public $email;
    public $nip;
    public $nomor_telepon;
    
    public $password;
    public $password_confirmation;

    public $foto_profil;
    public $foto_lama;

    public function mount()
    {
        $user = Auth::user();
        $guru = $user->guru;

        // Simpan ID ke property
        $this->user_id = $user->user_id; 
        
        if ($guru) {
            $this->guru_id = $guru->guru_id;
            $this->nama_lengkap = $guru->nama_lengkap;
            $this->nip = $guru->nip;
            $this->nomor_telepon = $guru->nomor_telepon;
            $this->foto_lama = $guru->foto_profil;
        }

        $this->email = $user->email;
    }

    public function update()
    {
        // Debugging: Uncomment baris di bawah jika tombol masih tidak respon
        // dd('Tombol ditekan', $this->all());

        // Validasi
        $this->validate([
            'nama_lengkap' => 'required|min:3',
            // Perbaikan Rule Unique menggunakan ID yang disimpan di property
            'nip' => ['required', Rule::unique('gurus', 'nip')->ignore($this->guru_id, 'guru_id')],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->user_id, 'user_id')],
            'nomor_telepon' => 'nullable|numeric',
            'password' => 'nullable|min:6|confirmed', // Pastikan input name="password_confirmation" ada di view
            'foto_profil' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        $guru = $user->guru;

        DB::transaction(function () use ($user, $guru) {
            // 1. Update Akun User
            $userData = [
                'email' => $this->email,
                'username' => $this->nip // Sync username dengan NIP
            ];
            
            if ($this->password) {
                $userData['password'] = Hash::make($this->password);
            }
            
            $user->update($userData);

            // 2. Handle Foto
            $fotoPath = $this->foto_lama;
            if ($this->foto_profil) {
                // Hapus foto lama fisik jika ada
                if ($this->foto_lama && Storage::disk('public')->exists($this->foto_lama)) {
                    Storage::disk('public')->delete($this->foto_lama);
                }
                $fotoPath = $this->foto_profil->store('profil-guru', 'public');
            }

            // 3. Update Data Guru
            if ($guru) {
                $guru->update([
                    'nama_lengkap' => $this->nama_lengkap,
                    'nip' => $this->nip,
                    'nomor_telepon' => $this->nomor_telepon,
                    'foto_profil' => $fotoPath,
                ]);
            }
        });

        // Reset input password & foto preview
        $this->reset(['password', 'password_confirmation', 'foto_profil']);
        
        // Refresh foto lama
        $this->foto_lama = Auth::user()->guru->foto_profil;

       $this->dispatch('show-success', message: 'Profil Anda berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.guru.profile');
    }
}