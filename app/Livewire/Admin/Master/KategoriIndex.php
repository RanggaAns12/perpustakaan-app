<?php

namespace App\Livewire\Admin\Master;

use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;

class KategoriIndex extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $kategori = Kategori::find($id);
        if ($kategori->bukus()->exists()) {
            session()->flash('error', 'Kategori tidak bisa dihapus karena masih digunakan oleh buku.');
            return;
        }
        $kategori->delete();
        session()->flash('message', 'Kategori berhasil dihapus.');
    }

    public function render()
    {
        $kategoris = Kategori::where('nama_kategori', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.master.kategori-index', ['kategoris' => $kategoris]);
    }
}