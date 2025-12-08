<?php

namespace App\Livewire\Admin; // Namespace Baru

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Buku;
use App\Models\Siswa;
use App\Models\Peminjaman;
use App\Models\Denda;

class Dashboard extends Component
{
    public function render()
    {
        $user = Auth::user();
        
        $stats = [
            'total_buku' => 0,
            'total_siswa' => 0,
            'peminjaman_aktif' => 0,
            'total_denda' => 0,
            'dipinjam' => 0,
            'dikembalikan' => 0,
            'denda_saya' => 0,
        ];
        
        $recentActivities = [];

        if ($user->isAdmin() || $user->isPustakawan()) {
            $stats['total_buku'] = Buku::count();
            $stats['total_siswa'] = Siswa::where('status_siswa', 'Aktif')->count();
            $stats['peminjaman_aktif'] = Peminjaman::where('status_peminjaman', 'Dipinjam')->count();
            $stats['total_denda'] = Denda::where('status_denda', 'Belum Lunas')->sum('total_denda');

            $recentActivities = Peminjaman::with(['siswa', 'detailPeminjaman.buku'])
                ->latest()
                ->take(5)
                ->get();
        } elseif ($user->isSiswa()) {
            $siswaId = $user->siswa->siswa_id ?? 0;

            $stats['dipinjam'] = Peminjaman::where('siswa_id', $siswaId)->where('status_peminjaman', 'Dipinjam')->count();
            $stats['dikembalikan'] = Peminjaman::where('siswa_id', $siswaId)->where('status_peminjaman', 'Dikembalikan')->count();
            $stats['denda_saya'] = Denda::where('siswa_id', $siswaId)->where('status_denda', 'Belum Lunas')->sum('total_denda');
            
            $recentActivities = Peminjaman::with(['detailPeminjaman.buku'])
                ->where('siswa_id', $siswaId)
                ->latest()
                ->take(5)
                ->get();
        }

        // Update View Path ke folder 'admin'
        return view('livewire.admin.dashboard', [
            'stats' => $stats,
            'recentActivities' => $recentActivities
        ]);
    }
}