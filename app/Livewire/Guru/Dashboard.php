<?php

namespace App\Livewire\Guru;

use Livewire\Component;
use App\Models\Buku;
use App\Models\Kategori;

class Dashboard extends Component
{
    public function render()
    {
        // Statistik sederhana untuk Guru
        $stats = [
            'total_buku' => Buku::count(),
            'buku_baru' => Buku::where('created_at', '>=', now()->subDays(30))->count(),
            'total_kategori' => Kategori::count(),
        ];

        return view('livewire.guru.dashboard', ['stats' => $stats]);
    }
}