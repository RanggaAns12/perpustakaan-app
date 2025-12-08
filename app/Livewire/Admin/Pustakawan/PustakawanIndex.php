<?php

namespace App\Livewire\Admin\Pustakawan;

use App\Models\Pustakawan;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class PustakawanIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $deleteModalOpen = false;
    public $deleteId = null;

    public function updatingSearch() { $this->resetPage(); }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->deleteModalOpen = true;
    }

    public function delete($id)
    {
        $pustakawan = Pustakawan::find($id);
        
        if (!$pustakawan) {
            $this->deleteModalOpen = false;
            return;
        }

        // Cek Relasi Transaksi Sebelum Hapus
        if ($pustakawan->peminjamans()->exists() || $pustakawan->pengembalians()->exists()) {
            session()->flash('error', 'Gagal: Pustakawan ini sudah melayani transaksi. Data tidak bisa dihapus.');
            $this->deleteModalOpen = false;
            return;
        }

        // Hapus Foto
        if ($pustakawan->foto_profil && Storage::disk('public')->exists($pustakawan->foto_profil)) {
            Storage::disk('public')->delete($pustakawan->foto_profil);
        }

        $user = $pustakawan->user; // Simpan referensi user

        $pustakawan->delete(); // Hapus Pustakawan
        
        if ($user) {
            $user->delete(); // Hapus Akun Login
        }

        session()->flash('message', 'Data pustakawan dan akun berhasil dihapus.');
        $this->deleteModalOpen = false;
    }

    public function render()
    {
        $pustakawans = Pustakawan::where('nama_lengkap', 'like', '%' . $this->search . '%')
            ->orWhere('nip', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.pustakawan.pustakawan-index', ['pustakawans' => $pustakawans]);
    }
}