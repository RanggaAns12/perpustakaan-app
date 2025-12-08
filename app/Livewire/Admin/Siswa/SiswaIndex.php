<?php

namespace App\Livewire\Admin\Siswa;

use App\Models\Siswa;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class SiswaIndex extends Component
{
    use WithPagination;
    public $search = '';

    public function delete($id)
    {
        $siswa = Siswa::find($id);
        if ($siswa) {
            // Hapus user login terkait
            $siswa->user()->delete();
            if ($siswa->foto_profil) Storage::disk('public')->delete($siswa->foto_profil);
            $siswa->delete();
            session()->flash('message', 'Siswa berhasil dihapus.');
        }
    }

    public function render()
    {
        $siswas = Siswa::with(['kelas', 'user'])
            ->where('nama_lengkap', 'like', '%' . $this->search . '%')
            ->orWhere('nis', 'like', '%' . $this->search . '%')
            // Menghapus pencarian NISN karena kolom sudah dihapus
            ->latest()
            ->paginate(10);
        return view('livewire.admin.siswa.siswa-index', ['siswas' => $siswas]);
    }
}