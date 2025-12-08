<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\User;

class StudentChatWidget extends Component
{
    public $isOpen = false;
    public $message = '';
    
    // Tentukan ID Admin/Pustakawan utama sebagai penerima default (Misal ID 1)
    // Atau bisa dibuat sistem round-robin, tapi untuk simpel kita set ke Admin/Petugas ID 1 dulu
    public $adminId; 

    public function mount()
    {
        // Cari satu petugas (Admin/Pustakawan) untuk menerima pesan
        // Idealnya ini bisa dinamis, tapi untuk V1 kita ambil Admin pertama
        $admin = User::whereIn('role_id', [1, 2])->first();
        $this->adminId = $admin ? $admin->user_id : 1; 
    }

    public function toggleChat()
    {
        $this->isOpen = !$this->isOpen;
        if($this->isOpen) {
            $this->markAsRead();
        }
    }

    public function sendMessage()
    {
        $this->validate(['message' => 'required']);

        Chat::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->adminId,
            'message' => $this->message,
        ]);

        $this->message = '';
    }

    public function markAsRead()
    {
        Chat::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    public function render()
    {
        // Ambil percakapan antara Siswa Login dan Petugas
        $chats = collect();
        
        if ($this->isOpen) {
            $chats = Chat::where(function($q) {
                    $q->where('sender_id', Auth::id())
                      ->orWhere('receiver_id', Auth::id());
                })
                ->orderBy('created_at', 'asc')
                ->get();
        }

        // Cek pesan belum dibaca untuk badge notifikasi
        $unreadCount = Chat::where('receiver_id', Auth::id())
            ->where('is_read', false)
            ->count();

        return view('livewire.chat.student-chat-widget', [
            'chats' => $chats,
            'unreadCount' => $unreadCount
        ]);
    }
}