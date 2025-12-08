<?php

namespace App\Livewire\Admin\Peminjaman;

use App\Models\Peminjaman;
use Livewire\Component;
use Livewire\Attributes\Layout;

class PeminjamanShow extends Component
{
    public Peminjaman $peminjaman;

    public function mount($peminjaman)
    {
        // Load relasi lengkap: Siswa, Pustakawan, Detail Peminjaman (Buku), Pengembalian (Detail, Denda)
        $this->peminjaman = Peminjaman::with([
            'siswa.kelas', 
            'pustakawan', 
            'detailPeminjaman.buku', 
            'pengembalian.denda',
            'pengembalian.detailPengembalian'
        ])->findOrFail($peminjaman);
    }

    #[Layout('components.layouts.app', ['title' => 'Detail Transaksi'])]
    public function render()
    {
        return view('livewire.admin.peminjaman.peminjaman-show');
    }
}