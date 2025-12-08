<?php

namespace App\Livewire\Pustakawan;

use Livewire\Component;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;

class Dashboard extends Component
{
    public function render()
    {
        $today = Carbon::today();

        $stats = [
            'peminjaman_hari_ini' => Peminjaman::whereDate('tanggal_peminjaman', $today)->count(),
            'pengembalian_hari_ini' => Pengembalian::whereDate('tanggal_pengembalian', $today)->count(),
            'sedang_dipinjam' => Peminjaman::where('status_peminjaman', 'Dipinjam')->count(),
            'terlambat' => Peminjaman::where('status_peminjaman', 'Terlambat')->count(),
        ];

        return view('livewire.pustakawan.dashboard', ['stats' => $stats]);
    }
}