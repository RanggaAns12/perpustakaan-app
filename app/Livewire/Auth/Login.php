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
        // 1. Validasi Input
        $this->validate();

        // 2. Coba Login
        // Kita cek 'is_active' juga sesuai struktur database Anda
        if (Auth::attempt(['username' => $this->username, 'password' => $this->password, 'is_active' => true])) {
            
            // Regenerasi session untuk keamanan (Fixation attack protection)
            session()->regenerate();

            // Update last_login di database
            $user = Auth::user();
            $user->update(['last_login' => now()]);

            // Redirect ke dashboard atau halaman yang diminta sebelumnya
            return redirect()->intended(route('dashboard'));
        }

        // 3. Jika Gagal
        $this->addError('username', 'Username atau password salah, atau akun tidak aktif.');
        
        // Reset password field
        $this->password = '';
    }
}