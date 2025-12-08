<?php

namespace App\Livewire\Notifikasi;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;
use App\Models\User;
use App\Models\Role;

class NotifikasiIndex extends Component
{
    use WithPagination;

    public $activeTab = 'masuk'; // 'masuk' atau 'kirim'
    
    // Form Kirim
    public $target_audience; // 'semua_siswa', 'semua_guru', 'user_spesifik'
    public $specific_user_id;
    public $judul;
    public $pesan;

    // Search untuk user spesifik
    public $searchUser = '';

    public function render()
    {
        $user = Auth::user();

        // 1. Ambil Notifikasi Masuk
        $masuk = Notifikasi::with('sender')
            ->where('user_id', $user->user_id)
            ->latest()
            ->paginate(10);

        // 2. Data untuk Form Kirim (Hanya jika Admin/Pustakawan)
        $usersList = [];
        if ($this->activeTab == 'kirim' && ($user->isAdmin() || $user->isPustakawan())) {
            if ($this->target_audience == 'user_spesifik') {
                $usersList = User::where('username', 'like', '%' . $this->searchUser . '%')
                    ->orWhere('email', 'like', '%' . $this->searchUser . '%')
                    ->where('user_id', '!=', $user->user_id) // Jangan kirim ke diri sendiri
                    ->take(10)
                    ->get();
            }
        }

        return view('livewire.notifikasi.notifikasi-index', [
            'notifikasiMasuk' => $masuk,
            'usersList' => $usersList
        ]);
    }

    public function kirim()
    {
        // Validasi Akses
        if (!Auth::user()->isAdmin() && !Auth::user()->isPustakawan()) {
            abort(403);
        }

        $this->validate([
            'target_audience' => 'required',
            'judul' => 'required|min:3',
            'pesan' => 'required|min:5',
            'specific_user_id' => 'required_if:target_audience,user_spesifik'
        ]);

        $targets = [];

        // Tentukan Target Penerima
        switch ($this->target_audience) {
            case 'semua_siswa':
                $targets = User::where('role_id', 3)->pluck('user_id'); // ID 3 = Siswa
                break;
            case 'semua_guru':
                $targets = User::where('role_id', 4)->pluck('user_id'); // ID 4 = Guru
                break;
            case 'semua_pustakawan':
                $targets = User::where('role_id', 2)->pluck('user_id'); // ID 2 = Pustakawan
                break;
            case 'user_spesifik':
                $targets = [$this->specific_user_id];
                break;
        }

        // Buat Notifikasi (Batch Insert)
        $data = [];
        $now = now();
        $senderId = Auth::id();

        foreach ($targets as $receiverId) {
            $data[] = [
                'sender_id' => $senderId,
                'user_id' => $receiverId,
                'judul' => $this->judul,
                'pesan' => $this->pesan,
                'is_read' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        if (count($data) > 0) {
            Notifikasi::insert($data);
            session()->flash('message', 'Notifikasi berhasil dikirim ke ' . count($data) . ' pengguna.');
        } else {
            session()->flash('error', 'Tidak ada penerima yang ditemukan.');
        }

        // Reset Form
        $this->reset(['judul', 'pesan', 'target_audience', 'specific_user_id', 'searchUser']);
        $this->activeTab = 'masuk'; // Kembali ke inbox
    }

    public function delete($id)
    {
        $notif = Notifikasi::find($id);
        if ($notif && $notif->user_id == Auth::id()) {
            $notif->delete();
            session()->flash('message', 'Notifikasi dihapus.');
        }
    }

    public function markAllRead()
    {
        Notifikasi::where('user_id', Auth::id())->update(['is_read' => true]);
        session()->flash('message', 'Semua notifikasi ditandai sudah dibaca.');
    }
}