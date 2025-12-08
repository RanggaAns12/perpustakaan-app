<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;

class Login extends Component
{
    #[Validate('required', message: 'Username wajib diisi')]
    public $username = '';

    #[Validate('required', message: 'Password wajib diisi')]
    public $password = '';

    // Kita gunakan layout 'app' yang sudah dibuat, tapi title-nya kita set custom
    #[Layout('components.layouts.guest', ['title' => 'Login - Perpustakaan'])]
    public function render()
    {
        return view('livewire.auth.login');
    }

    // Method ini yang dipanggil saat form di-submit (wire:submit="login")
    public function login()
    {
        $this->validate();

        if (Auth::attempt(['username' => $this->username, 'password' => $this->password, 'is_active' => true])) {
            
            session()->regenerate();
            
            $user = Auth::user();
            $user->update(['last_login' => now()]);

            // --- PERBAIKAN LOGIKA REDIRECT ---
            if ($user->isSiswa()) {
                return redirect()->route('siswa.dashboard'); // Arahkan ke Dashboard Khusus Siswa
            } elseif ($user->isPustakawan()) {
                return redirect()->route('pustakawan.dashboard');
            } elseif ($user->isGuru()) {
                return redirect()->route('guru.dashboard');
            }

            // Default untuk Admin
            return redirect()->intended(route('dashboard'));
        }

        $this->addError('username', 'Username atau password salah, atau akun tidak aktif.');
        $this->password = '';
    }
}