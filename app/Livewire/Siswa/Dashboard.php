<?php

namespace App\Livewire\Siswa;

use Livewire\Component;
use Livewire\Attributes\Layout; // Import Layout Attribute
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Kategori;

class Dashboard extends Component
{
    // --- PENTING: GUNAKAN LAYOUT SISWA ---
    #[Layout('components.layouts.siswa')] 
    public function render()
    {
        $siswa = Auth::user()->siswa;
        
        $sedangDipinjam = 0;
        if($siswa) {
            $sedangDipinjam = Peminjaman::where('siswa_id', $siswa->siswa_id)
                ->where('status_peminjaman', 'Dipinjam')
                ->count();
        }

        $bukuTerbaru = Buku::with('kategori')
            ->latest()
            ->take(10)
            ->get();

        $kategoris = Kategori::withCount('bukus')->orderByDesc('bukus_count')->take(6)->get();

        return view('livewire.siswa.dashboard', [
            'siswa' => $siswa,
            'sedangDipinjam' => $sedangDipinjam,
            'bukuTerbaru' => $bukuTerbaru,
            'kategoris' => $kategoris
        ]);
    }
}