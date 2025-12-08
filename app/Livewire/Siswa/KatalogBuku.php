<?php

namespace App\Livewire\Siswa;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Buku;
use App\Models\Kategori;

class KatalogBuku extends Component
{
    use WithPagination;

    #[Layout('components.layouts.siswa')]

    public $search = '';
    public $kategoriId = '';
    
    // --- TAMBAHAN BARU: VARIABEL UNTUK MODAL ---
    public $selectedBook = null;

    public function updatedSearch() { $this->resetPage(); }
    public function updatedKategoriId() { $this->resetPage(); }

    // Fungsi Buka Modal Detail
    public function showBook($id)
    {
        $this->selectedBook = Buku::with(['kategori', 'penulis', 'penerbit'])->find($id);
    }

    // Fungsi Tutup Modal
    public function closeBook()
    {
        $this->selectedBook = null;
    }

    public function render()
    {
        $kategoris = Kategori::withCount('bukus')->get();

        $bukus = Buku::with(['kategori', 'penulis'])
            ->when($this->search, function ($query) {
                $query->where('judul_buku', 'like', '%' . $this->search . '%')
                      ->orWhereHas('penulis', function ($q) {
                          $q->where('nama_penulis', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->kategoriId, function ($query) {
                $query->where('kategori_id', $this->kategoriId);
            })
            ->latest()
            ->paginate(12);

        return view('livewire.siswa.katalog-buku', [
            'bukus' => $bukus,
            'kategoris' => $kategoris
        ]);
    }
}