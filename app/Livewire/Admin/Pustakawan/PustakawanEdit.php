<?php

namespace App\Livewire\Admin\Pustakawan;

use App\Models\Pustakawan;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PustakawanEdit extends Component
{
    use WithFileUploads;

    public $pustakawanId;
    public $userId;

    public $nama_lengkap;
    public $nip;
    public $nomor_telepon;
    public $email;
    public $shift_kerja;
    public $tanggal_bergabung;
    
    public $new_foto;
    public $old_foto;

    public function mount(Pustakawan $pustakawan)
    {
        $this->pustakawanId = $pustakawan->pustakawan_id;
        $this->userId = $pustakawan->user_id;
        
        $this->nama_lengkap = $pustakawan->nama_lengkap;
        $this->nip = $pustakawan->nip;
        $this->nomor_telepon = $pustakawan->nomor_telepon;
        $this->shift_kerja = $pustakawan->shift_kerja;
        $this->tanggal_bergabung = $pustakawan->tanggal_bergabung ? $pustakawan->tanggal_bergabung->format('Y-m-d') : null;
        $this->old_foto = $pustakawan->foto_profil;
        
        $this->email = $pustakawan->user->email ?? '';
    }

    public function update()
    {
        $this->validate([
            'nama_lengkap' => 'required|min:3',
            'nip' => ['required', Rule::unique('pustakawans', 'nip')->ignore($this->pustakawanId, 'pustakawan_id')],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($this->userId, 'user_id')],
            'tanggal_bergabung' => 'required|date',
        ]);

        DB::transaction(function () {
            // Update User (Sync Email & Username)
            $user = User::find($this->userId);
            if ($user) {
                $user->update([
                    'email' => $this->email,
                    'username' => $this->nip,
                ]);
            }

            // Handle Foto
            $fotoPath = $this->old_foto;
            if ($this->new_foto) {
                if ($this->old_foto && Storage::disk('public')->exists($this->old_foto)) {
                    Storage::disk('public')->delete($this->old_foto);
                }
                $fotoPath = $this->new_foto->store('profil-pustakawan', 'public');
            }

            // Update Pustakawan
            $pustakawan = Pustakawan::find($this->pustakawanId);
            $pustakawan->update([
                'nip' => $this->nip,
                'nama_lengkap' => $this->nama_lengkap,
                'nomor_telepon' => $this->nomor_telepon,
                'shift_kerja' => $this->shift_kerja,
                'tanggal_bergabung' => $this->tanggal_bergabung,
                'foto_profil' => $fotoPath,
            ]);
        });

        $this->dispatch('show-success', message: 'Pustakawan berhasil diperbarui.');
        return redirect()->route('pustakawan.index');
    }

    public function render()
    {
        return view('livewire.admin.pustakawan.pustakawan-edit');
    }
}