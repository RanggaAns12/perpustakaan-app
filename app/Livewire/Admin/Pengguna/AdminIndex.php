<?php

namespace App\Livewire\Admin\Pengguna;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Admin;
use App\Models\User;

class AdminIndex extends Component
{
    use WithPagination;

    public $search = '';

    // Reset pagination saat melakukan pencarian
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        // Cegah menghapus diri sendiri (Opsional, tapi disarankan)
        $admin = Admin::find($id);
        
        if ($admin) {
            // Hapus User terkait juga
            $user = User::find($admin->user_id);
            
            $admin->delete();
            if ($user) $user->delete();

            session()->flash('success', 'Data admin berhasil dihapus.');
        }
    }

    public function render()
    {
        $admins = Admin::with('user')
            ->where('nama_lengkap', 'like', '%' . $this->search . '%')
            ->orWhere('nip', 'like', '%' . $this->search . '%')
            ->orWhereHas('user', function ($q) {
                $q->where('username', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.pengguna.admin-index', [
            'admins' => $admins
        ]);
    }
}