<?php

namespace App\Livewire\Admin\Pengguna;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Validation\Rule;

class AdminEdit extends Component
{
    #[Layout('components.layouts.app')]

    public $adminId;
    public $userId;

    // Data Akun
    public $username;
    public $email;
    public $password; // Opsional (diisi hanya jika ingin ganti)

    // Data Profil
    public $nama_lengkap;
    public $nip;
    public $nomor_telepon;

    public function mount($id)
    {
        $admin = Admin::with('user')->findOrFail($id);

        $this->adminId = $admin->admin_id;
        $this->userId = $admin->user_id;

        // Isi Form dengan Data Lama
        $this->username      = $admin->user->username;
        $this->email         = $admin->user->email;
        $this->nama_lengkap  = $admin->nama_lengkap;
        $this->nip           = $admin->nip;
        $this->nomor_telepon = $admin->nomor_telepon;
    }

    public function update()
    {
        $this->validate([
            'email'         => ['required', 'email', Rule::unique('users', 'email')->ignore($this->userId, 'user_id')],
            // Password boleh kosong saat edit
            'password'      => 'nullable|min:6', 
            'nama_lengkap'  => 'required|string|max:100',
            'nip'           => ['required', 'numeric', Rule::unique('admins', 'nip')->ignore($this->adminId, 'admin_id')],
            'nomor_telepon' => 'nullable|numeric|digits_between:10,15',
        ]);

        DB::beginTransaction();
        try {
            // 1. Update User (Login)
            $user = User::find($this->userId);
            $userData = [
                'email' => $this->email,
            ];
            
            // Hanya update password jika diisi
            if (!empty($this->password)) {
                $userData['password'] = Hash::make($this->password);
            }
            
            $user->update($userData);

            // 2. Update Profil Admin
            $admin = Admin::find($this->adminId);
            $admin->update([
                'nip'           => $this->nip,
                'nama_lengkap'  => $this->nama_lengkap,
                'nomor_telepon' => $this->nomor_telepon,
            ]);

            DB::commit();

            session()->flash('success', 'Data admin berhasil diperbarui!');
            return redirect()->route('admin.index');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Gagal update: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.pengguna.admin-edit');
    }
}