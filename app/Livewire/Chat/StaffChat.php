<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class StaffChat extends Component
{
    public $selectedUserId = null;
    public $message = '';
    public $search = '';

    public function selectUser($userId)
    {
        $this->selectedUserId = $userId;
        $this->markAsRead($userId);
    }

    public function sendMessage()
    {
        $this->validate(['message' => 'required']);

        if (!$this->selectedUserId) return;

        Chat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->selectedUserId,
            'message' => $this->message,
        ]);

        $this->message = '';
    }

    public function markAsRead($senderId)
    {
        Chat::where('sender_id', $senderId)
            ->where('receiver_id', Auth::id())
            ->update(['is_read' => true]);
    }

    public function render()
    {
        $users = User::whereHas('siswa') // Pastikan hanya ambil user yang punya data siswa
            ->where(function($q) {
                // FILTER PENCARIAN (DIPERBAIKI)
                // Cari berdasarkan username di tabel users
                $q->where('username', 'like', '%' . $this->search . '%')
                  // ATAU cari berdasarkan nama_lengkap di tabel relasi siswas
                  ->orWhereHas('siswa', function($subQ) {
                      $subQ->where('nama_lengkap', 'like', '%' . $this->search . '%');
                  });
            })
            // Hanya tampilkan siswa yang pernah chat (kirim atau terima)
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                      ->from('chats')
                      ->whereRaw('chats.sender_id = users.user_id OR chats.receiver_id = users.user_id');
            })
            ->get()
            ->map(function($user) {
                // Hitung pesan belum dibaca
                $user->unread = Chat::where('sender_id', $user->user_id)
                                    ->where('receiver_id', Auth::id())
                                    ->where('is_read', false)
                                    ->count();
                
                // Ambil pesan terakhir untuk preview
                $lastMsg = Chat::where(function($q) use ($user) {
                        $q->where('sender_id', $user->user_id)->where('receiver_id', Auth::id());
                    })
                    ->orWhere(function($q) use ($user) {
                        $q->where('sender_id', Auth::id())->where('receiver_id', $user->user_id);
                    })
                    ->latest()
                    ->first();
                
                $user->last_message = $lastMsg ? $lastMsg->message : '';
                $user->last_time = $lastMsg ? $lastMsg->created_at : null;
                
                // Ambil nama lengkap dari relasi siswa
                $user->display_name = $user->siswa->nama_lengkap ?? $user->username;
                
                return $user;
            })
            ->sortByDesc('last_time'); // Urutkan dari yang terbaru chat-nya

        // Ambil isi chat jika ada user yang dipilih
        $activeChats = collect();
        if ($this->selectedUserId) {
            $activeChats = Chat::where(function($q) {
                    $q->where('sender_id', Auth::id())->where('receiver_id', $this->selectedUserId);
                })
                ->orWhere(function($q) {
                    $q->where('sender_id', $this->selectedUserId)->where('receiver_id', Auth::id());
                })
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('livewire.chat.staff-chat', [
            'usersList' => $users,
            'activeChats' => $activeChats
        ]);
    }
}