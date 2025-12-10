<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LandingSetting;
use App\Models\Buku;
use App\Models\Siswa;
use App\Models\Galeri; // Tambahkan ini
use Livewire\Attributes\Layout;

class LandingPage extends Component
{
    #[Layout('components.layouts.guest')] 
    public function render()
    {
        $setting = LandingSetting::first();
        $data = $setting ? $setting->toArray() : [];

        $data['stats_buku'] = Buku::count();
        $data['stats_siswa'] = Siswa::where('status_siswa', 'Aktif')->count();

        $bukuPilihan = Buku::with(['penulis', 'kategori'])
            ->where('jumlah_eksemplar_tersedia', '>', 0)
            ->inRandomOrder()
            ->take(6)
            ->get();

        // TAMBAHAN: Ambil data Galeri
        $galeri = Galeri::latest()->take(8)->get();

        return view('livewire.landing-page', [
            'data' => $data,
            'bukuPilihan' => $bukuPilihan,
            'galeri' => $galeri // Kirim ke view
        ]);
    }
}