<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Buku;
use App\Models\LandingSetting; // Import Model

class LandingPage extends Component
{
    #[Layout('components.layouts.guest', ['title' => 'Selamat Datang di PerpusApp'])] 
    public function render()
    {
        // Ambil pengaturan (jika kosong, buat instance baru agar tidak error)
        $setting = LandingSetting::first() ?? new LandingSetting();

        return view('livewire.landing-page', [
            'bukuTerbaru' => Buku::latest()->take(4)->get(),
            'totalBuku' => Buku::count(),
            'setting' => $setting, // Kirim variabel $setting ke view
        ]);
    }
}