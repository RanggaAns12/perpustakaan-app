<?php

namespace App\Livewire\Admin\Buku;

use App\Models\Buku;
use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class BukuIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $kategori_id = '';
    public $perPage = 10;

    // Reset pagination saat melakukan pencarian
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // Fungsi Hapus Buku
    public function delete($id)
    {
        $buku = Buku::find($id);
        
        if ($buku) {
            // Hapus gambar cover jika ada
            if ($buku->cover_buku) {
                Storage::disk('public')->delete($buku->cover_buku);
            }
            
            // Hapus relasi penulis (detach)
            $buku->penulis()->detach();
            
            $buku->delete();
            session()->flash('message', 'Buku berhasil dihapus.');
        }
    }

    public function render()
    {
        $bukus = Buku::with(['kategori', 'penulis', 'penerbit'])
            ->when($this->search, function ($query) {
                $query->where('judul_buku', 'like', '%' . $this->search . '%')
                      ->orWhere('isbn', 'like', '%' . $this->search . '%');
            })
            ->when($this->kategori_id, function ($query) {
                $query->where('kategori_id', $this->kategori_id);
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.buku.buku-index', [
            'bukus' => $bukus,
            'kategoris' => Kategori::all(),
        ]);
    }
}