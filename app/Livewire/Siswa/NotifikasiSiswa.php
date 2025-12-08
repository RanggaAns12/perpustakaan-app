<?php

namespace App\Livewire\Siswa;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;

class NotifikasiSiswa extends Component
{
    use WithPagination;

    #[Layout('components.layouts.siswa')] // Menggunakan layout khusus siswa

    public function markAsRead($id)
    {
        $notif = Notifikasi::find($id);
        if ($notif && $notif->user_id == Auth::id()) {
            $notif->update(['is_read' => true]);
        }
    }

    public function markAllRead()
    {
        Notifikasi::where('user_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
            
        session()->flash('message', 'Semua notifikasi ditandai sudah dibaca.');
    }

    public function delete($id)
    {
        $notif = Notifikasi::find($id);
        if ($notif && $notif->user_id == Auth::id()) {
            $notif->delete();
            session()->flash('message', 'Pesan berhasil dihapus.');
        }
    }

    public function render()
    {
        $notifikasis = Notifikasi::with('sender')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('livewire.siswa.notifikasi-siswa', [
            'notifikasis' => $notifikasis
        ]);
    }
}