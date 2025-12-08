<?php

namespace App\Livewire\Pustakawan;

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

    public $nama_lengkap;
    public $email;
    public $nomor_telepon;
    public $nip; // Read Only
    
    // Password (Optional)
    public $password;
    public $password_confirmation;

    // Foto
    public $foto_profil;
    public $foto_lama;

    public function mount()
    {
        $user = Auth::user();
        $pustakawan = $user->pustakawan;

        if ($pustakawan) {
            $this->nama_lengkap = $pustakawan->nama_lengkap;
            $this->nip = $pustakawan->nip;
            $this->nomor_telepon = $pustakawan->nomor_telepon;
            $this->foto_lama = $pustakawan->foto_profil;
        }

        $this->email = $user->email;
    }

    public function update()
    {
        $user = Auth::user();
        $pustakawan = $user->pustakawan;

        $this->validate([
            'nama_lengkap' => 'required|min:3',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->user_id, 'user_id')],
            'nomor_telepon' => 'nullable|numeric',
            'password' => 'nullable|min:6|confirmed', // Confirmed butuh input name="password_confirmation"
            'foto_profil' => 'nullable|image|max:2048',
        ]);

        DB::transaction(function () use ($user, $pustakawan) {
            // 1. Update Tabel Users (Email & Password)
            $userData = ['email' => $this->email];
            
            if ($this->password) {
                $userData['password'] = Hash::make($this->password);
            }
            
            $user->update($userData);

            // 2. Handle Upload Foto
            $fotoPath = $this->foto_lama;
            if ($this->foto_profil) {
                // Hapus foto lama jika ada
                if ($this->foto_lama && Storage::disk('public')->exists($this->foto_lama)) {
                    Storage::disk('public')->delete($this->foto_lama);
                }
                $fotoPath = $this->foto_profil->store('profil-pustakawan', 'public');
            }

            // 3. Update Tabel Pustakawan
            if ($pustakawan) {
                $pustakawan->update([
                    'nama_lengkap' => $this->nama_lengkap,
                    'nomor_telepon' => $this->nomor_telepon,
                    'foto_profil' => $fotoPath,
                ]);
            }
        });

        // Reset input password agar aman
        $this->reset(['password', 'password_confirmation', 'foto_profil']);
        
        // Refresh foto lama untuk preview
        $this->foto_lama = Auth::user()->pustakawan->foto_profil;

        $this->dispatch('show-success', message: 'Profil Anda berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.pustakawan.profile');
    }
}