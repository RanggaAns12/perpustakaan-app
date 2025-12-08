<?php

namespace App\Livewire\Pustakawan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Buku;

class BukuList extends Component
{
    use WithPagination;
    public $search = '';

    public function render()
    {
        $bukus = Buku::with(['kategori', 'penulis'])
            ->where('judul_buku', 'like', '%' . $this->search . '%')
            ->orWhere('isbn', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(12);

        return view('livewire.pustakawan.buku-list', ['bukus' => $bukus]);
    }
}