<?php

namespace App\Livewire\Admin\Master;

use App\Models\Kelas;
use Livewire\Component;
use Livewire\WithPagination;

class KelasIndex extends Component
{
    use WithPagination;
    public $search = '';

    public function updatingSearch() { $this->resetPage(); }

    public function delete($id)
    {
        $kelas = Kelas::find($id);
        if ($kelas->siswa()->exists()) {
            session()->flash('error', 'Kelas tidak bisa dihapus karena memiliki siswa.');
            return;
        }
        $kelas->delete();
        session()->flash('message', 'Kelas berhasil dihapus.');
    }

    public function render()
    {
        $kelases = Kelas::with(['jurusan', 'tahunAjaran', 'waliKelas'])
            ->where('nama_kelas', 'like', '%' . $this->search . '%')
            ->orWhereHas('jurusan', function($q){ $q->where('nama_jurusan', 'like', '%'.$this->search.'%'); })
            ->latest()
            ->paginate(10);
        return view('livewire.admin.master.kelas-index', ['kelases' => $kelases]);
    }
}