<?php

namespace App\Livewire\Partial;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class NavbarNotifikasi extends Component
{
    // Cek notifikasi baru setiap 10 detik
    public function render()
    {
        $user = Auth::user();
        
        // Ambil 5 notifikasi terbaru
        $notifikasis = Notifikasi::where('user_id', $user->user_id)
            ->latest()
            ->take(5)
            ->get();

        // Hitung yang belum dibaca
        $unreadCount = Notifikasi::where('user_id', $user->user_id)
            ->where('is_read', false)
            ->count();

        return view('livewire.partial.navbar-notifikasi', [
            'notifikasis' => $notifikasis,
            'unreadCount' => $unreadCount
        ]);
    }

    public function markAsRead($id)
    {
        $notif = Notifikasi::find($id);
        if ($notif && $notif->user_id == Auth::id()) {
            $notif->update(['is_read' => true]);
            
            // Redirect ke halaman detail/index notifikasi
            return redirect()->route('notifikasi.index');
        }
    }
}