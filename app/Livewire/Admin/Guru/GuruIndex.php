<?php

namespace App\Livewire\Admin\Guru;

use App\Models\Guru;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class GuruIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $guru = Guru::find($id);

        if (!$guru) {
            session()->flash('error', 'Data guru tidak ditemukan.');
            return;
        }

        // Cek relasi sebelum hapus (misal: Wali Kelas)
        if ($guru->kelas()->exists()) {
            session()->flash('error', 'Guru tidak bisa dihapus karena terdaftar sebagai Wali Kelas.');
            return;
        }

        // Hapus Foto Profil jika ada
        if ($guru->foto_profil && Storage::disk('public')->exists($guru->foto_profil)) {
            Storage::disk('public')->delete($guru->foto_profil);
        }

        // Simpan referensi User terkait ke variabel sementara
        $user = $guru->user;

        // --- PERBAIKAN UTAMA DI SINI ---
        
        // 1. Hapus Data Guru TERLEBIH DAHULU
        // Kita harus menghapus 'anak' (Guru) dulu sebelum menghapus 'induk' (User)
        $guru->delete();

        // 2. Baru Hapus Akun User Login
        if ($user) {
            $user->delete();
        }

        session()->flash('message', 'Data guru dan akun login berhasil dihapus.');
    }

    public function render()
    {
        $gurus = Guru::where('nama_lengkap', 'like', '%' . $this->search . '%')
            ->orWhere('nip', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.guru.guru-index', ['gurus' => $gurus]);
    }
}