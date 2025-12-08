<?php

namespace App\Livewire\Admin\Guru;

use App\Models\Guru;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class GuruEdit extends Component
{
    use WithFileUploads;

    public $guruId;
    public $userId;

    // Properti Form
    public $nama_lengkap;
    public $nip;
    public $jenis_kelamin; 
    public $mata_pelajaran;
    public $nomor_telepon;
    public $email;
    
    #[Validate('nullable|image|max:2048', as: 'Foto Profil')]
    public $new_foto;
    public $old_foto;

    public $status;

    public function mount(Guru $guru)
    {
        // Isi form dengan data awal dari Database
        $this->guruId = $guru->guru_id;
        $this->userId = $guru->user_id;
        
        $this->nama_lengkap = $guru->nama_lengkap;
        $this->nip = $guru->nip;
        $this->jenis_kelamin = $guru->jenis_kelamin;
        $this->mata_pelajaran = $guru->mata_pelajaran;
        $this->nomor_telepon = $guru->nomor_telepon;
        $this->email = $guru->email;
        $this->old_foto = $guru->foto_profil;
        $this->status = $guru->status;
    }

    public function update()
    {
        // Validasi Manual agar bisa ignore ID sendiri (untuk unique check)
        $this->validate([
            'nama_lengkap' => 'required|min:3',
            'jenis_kelamin' => 'required|in:L,P',
            'nip' => ['required', Rule::unique('gurus', 'nip')->ignore($this->guruId, 'guru_id')],
            'email' => ['required', 'email', Rule::unique('gurus', 'email')->ignore($this->guruId, 'guru_id')],
            'nomor_telepon' => 'nullable|numeric',
        ], [
            'jenis_kelamin.required' => 'Silakan pilih jenis kelamin.',
        ]);

        DB::transaction(function () {
            // 1. Update User Login (Sync Email & Username/NIP)
            $user = User::find($this->userId);
            if ($user) {
                $user->update([
                    'email' => $this->email,
                    'username' => $this->nip,
                    'is_active' => $this->status === 'Aktif',
                ]);
            }

            // 2. Handle Ganti Foto
            $fotoPath = $this->old_foto;
            if ($this->new_foto) {
                // Hapus foto lama jika ada
                if ($this->old_foto && Storage::disk('public')->exists($this->old_foto)) {
                    Storage::disk('public')->delete($this->old_foto);
                }
                $fotoPath = $this->new_foto->store('profil-guru', 'public');
            }

            // 3. Update Data Guru
            $guru = Guru::find($this->guruId);
            $guru->update([
                'nama_lengkap' => $this->nama_lengkap,
                'nip' => $this->nip,
                'jenis_kelamin' => $this->jenis_kelamin,
                'mata_pelajaran' => $this->mata_pelajaran,
                'nomor_telepon' => $this->nomor_telepon,
                'email' => $this->email,
                'foto_profil' => $fotoPath,
                'status' => $this->status,
            ]);
        });

        session()->flash('message', 'Data guru berhasil diperbarui.');
        return redirect()->route('guru.index');
    }

    public function render()
    {
        return view('livewire.admin.guru.guru-edit');
    }
}