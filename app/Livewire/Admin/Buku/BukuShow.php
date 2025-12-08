<?php

namespace App\Livewire\Admin\Buku;

use App\Models\Buku;
use Livewire\Component;
use Livewire\Attributes\Layout;

class BukuShow extends Component
{
    // Properti public untuk menampung data buku
    public Buku $buku;

    // PERBAIKAN: Gunakan Type Hint 'Buku' di sini.
    // Laravel otomatis mencari buku berdasarkan ID di URL (Route Model Binding).
    public function mount(Buku $buku)
    {
        // Kita load relasi agar efisien (Eager Loading)
        // Tidak perlu query 'where' manual lagi karena $buku sudah ketemu datanya.
        $this->buku = $buku->load(['kategori', 'penerbit', 'penulis', 'createdBy']);
    }

    #[Layout('components.layouts.app', ['title' => 'Detail Buku'])]
    public function render()
    {
        return view('livewire.admin.buku.buku-show');
    }
}