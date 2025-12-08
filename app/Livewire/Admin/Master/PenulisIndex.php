<?php

namespace App\Livewire\Admin\Master;

use App\Models\Penulis;
use Livewire\Component;
use Livewire\WithPagination;

class PenulisIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $penulis = Penulis::find($id);
        
        // Cek relasi sebelum hapus
        if ($penulis->bukus()->exists()) {
            session()->flash('error', 'Penulis tidak bisa dihapus karena masih terhubung dengan buku.');
            return;
        }

        $penulis->delete();
        session()->flash('message', 'Penulis berhasil dihapus.');
    }

    public function render()
    {
        $penulis = Penulis::where('nama_penulis', 'like', '%' . $this->search . '%')
            ->orWhere('kebangsaan', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.master.penulis-index', ['penulis_list' => $penulis]);
    }
}