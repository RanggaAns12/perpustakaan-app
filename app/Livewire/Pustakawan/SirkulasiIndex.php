<?php

namespace App\Livewire\Pustakawan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Peminjaman;

class SirkulasiIndex extends Component
{
    use WithPagination;
    
    public $search = '';

    public function render()
    {
        // Pustakawan bisa melihat semua transaksi
        $transaksi = Peminjaman::with(['siswa', 'detailPeminjaman.buku'])
            ->where('kode_transaksi', 'like', '%' . $this->search . '%')
            ->orWhereHas('siswa', fn($q) => $q->where('nama_lengkap', 'like', '%' . $this->search . '%'))
            ->latest()
            ->paginate(10);

        return view('livewire.pustakawan.sirkulasi-index', [
            'transaksi' => $transaksi
        ]);
    }
}