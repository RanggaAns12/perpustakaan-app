<?php

namespace App\Livewire\Guru;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Buku;
use App\Models\Kategori;

class BukuList extends Component
{
    use WithPagination;
    
    public $search = '';
    public $kategori_id = '';

    public function render()
    {
        $bukus = Buku::with(['kategori', 'penulis'])
            ->when($this->search, function ($q) {
                $q->where('judul_buku', 'like', '%' . $this->search . '%')
                  ->orWhere('isbn', 'like', '%' . $this->search . '%');
            })
            ->when($this->kategori_id, function ($q) {
                $q->where('kategori_id', $this->kategori_id);
            })
            ->latest()
            ->paginate(12);

        return view('livewire.guru.buku-list', [
            'bukus' => $bukus,
            'kategoris' => Kategori::all()
        ]);
    }
}