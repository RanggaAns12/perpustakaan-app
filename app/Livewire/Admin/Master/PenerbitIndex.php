<?php

namespace App\Livewire\Admin\Master;

use App\Models\Penerbit;
use Livewire\Component;
use Livewire\WithPagination;

class PenerbitIndex extends Component
{
    use WithPagination;
    public $search = '';

    public function updatingSearch() { $this->resetPage(); }

    public function delete($id)
    {
        $penerbit = Penerbit::find($id);
        if ($penerbit->bukus()->exists()) {
            session()->flash('error', 'Penerbit ini memiliki buku terdaftar, tidak bisa dihapus.');
            return;
        }
        $penerbit->delete();
        session()->flash('message', 'Penerbit berhasil dihapus.');
    }

    public function render()
    {
        $penerbits = Penerbit::where('nama_penerbit', 'like', '%' . $this->search . '%')
            ->latest()->paginate(10);
        return view('livewire.admin.master.penerbit-index', ['penerbits' => $penerbits]);
    }
}