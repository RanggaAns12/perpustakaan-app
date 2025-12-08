<?php

namespace App\Livewire\Admin\Pengguna;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Admin;

class AdminCreate extends Component
{
    #[Layout('components.layouts.app')] // Menggunakan layout Admin utama

    // Data Akun (User)
    public $username;
    public $email;
    public $password;

    // Data Profil (Admin)
    public $nama_lengkap;
    public $nip;
    public $nomor_telepon;

    // Rules Validasi
    protected $rules = [
        'username'      => 'required|unique:users,username|min:4',
        'email'         => 'required|email|unique:users,email',
        'password'      => 'required|min:6',
        'nama_lengkap'  => 'required|string|max:100',
        'nip'           => 'required|unique:admins,nip|numeric',
        'nomor_telepon' => 'nullable|numeric|digits_between:10,15',
    ];

    public function simpan()
    {
        $this->validate();

        DB::beginTransaction();
        try {
            // 1. Buat Akun User (Login)
            $user = User::create([
                'username'  => $this->username,
                'email'     => $this->email,
                'password'  => Hash::make($this->password),
                'role_id'   => 1, // Role ID 1 = Admin
                'is_active' => true,
            ]);

            // 2. Buat Profil Admin
            Admin::create([
                'user_id'       => $user->user_id,
                'nip'           => $this->nip,
                'nama_lengkap'  => $this->nama_lengkap,
                'nomor_telepon' => $this->nomor_telepon,
            ]);

            DB::commit();

            // Reset Form & Beri Notifikasi
            $this->reset();
            session()->flash('success', 'Admin baru berhasil ditambahkan!');
            
            // Opsional: Redirect ke dashboard atau list admin jika ada
            // return redirect()->route('admin.dashboard'); 

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal menambah admin: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.pengguna.admin-create');
    }
}