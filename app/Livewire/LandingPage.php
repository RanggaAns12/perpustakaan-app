<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\LandingSetting;
use App\Models\Buku; // Tambahkan Model Buku
use App\Models\Siswa; // Tambahkan Model Siswa
use Livewire\Attributes\Layout;

class LandingPage extends Component
{
    #[Layout('components.layouts.guest')] 
    public function render()
    {
        // 1. Ambil data setting (Baris Pertama)
        $setting = LandingSetting::first();

        // 2. Konversi ke array (jika ada datanya)
        $data = $setting ? $setting->toArray() : [];

        // 3. Tambahkan Statistik Real-time (Opsional, agar angka di landing page hidup)
        $data['stats_buku'] = Buku::count();
        $data['stats_siswa'] = Siswa::where('status_siswa', 'Aktif')->count();

        // Kirim ke view
        return view('livewire.landing-page', [
            'data' => $data
        ]);
    }
}