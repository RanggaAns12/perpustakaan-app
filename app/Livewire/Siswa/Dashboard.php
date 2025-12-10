<?php

namespace App\Livewire\Siswa;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\Denda;
use App\Models\Kategori;
use Carbon\Carbon;

class Dashboard extends Component
{
    #[Layout('components.layouts.siswa')] 
    public function render()
    {
        $user = Auth::user();
        $siswa = $user->siswa;

        if (!$siswa) {
            session()->flash('error', 'Profil Siswa tidak ditemukan.');
            return view('livewire.siswa.dashboard', [
                'siswa' => null, 'sedangDipinjam' => 0, 'totalDenda' => 0,
                'bukuTerbaru' => [], 'kategoris' => [], 'greeting' => 'Halo',
                'bukuTerlambat' => collect([])
            ]);
        }

        $sedangDipinjam = Peminjaman::where('siswa_id', $siswa->siswa_id)
            ->where('status_peminjaman', 'Dipinjam')
            ->count();

        $totalDenda = Denda::where('siswa_id', $siswa->siswa_id)
            ->where('status_denda', 'Belum Lunas')
            ->sum('total_denda');

        $bukuTerbaru = Buku::with(['kategori', 'penulis'])
            ->latest()
            ->take(6)
            ->get();

        $kategoris = Kategori::withCount('bukus')
            ->orderByDesc('bukus_count')
            ->take(6)
            ->get();

        $bukuTerlambat = Peminjaman::with(['detailPeminjaman.buku'])
            ->where('siswa_id', $siswa->siswa_id)
            ->whereIn('status_peminjaman', ['Dipinjam', 'Terlambat'])
            ->whereDate('tanggal_jatuh_tempo', '<', Carbon::now())
            ->get();

        $hour = now()->hour;
        $greeting = match(true) {
            $hour < 12 => 'Selamat Pagi',
            $hour < 15 => 'Selamat Siang',
            $hour < 18 => 'Selamat Sore',
            default => 'Selamat Malam',
        };

        return view('livewire.siswa.dashboard', [
            'siswa' => $siswa,
            'sedangDipinjam' => $sedangDipinjam,
            'totalDenda' => $totalDenda,
            'bukuTerbaru' => $bukuTerbaru,
            'kategoris' => $kategoris,
            'greeting' => $greeting,
            'bukuTerlambat' => $bukuTerlambat
        ]);
    }
}