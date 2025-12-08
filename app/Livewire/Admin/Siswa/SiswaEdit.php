<?php

namespace App\Livewire\Admin\Siswa;

use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SiswaEdit extends Component
{
    use WithFileUploads;

    public $siswaId;
    public $userId;

    #[Validate('required')] 
    public $nama_lengkap;
    
    public $nis; 
    // BARIS NISN DIHAPUS DARI SINI
    
    #[Validate('required')] 
    public $kelas_id;
    
    #[Validate('required')] 
    public $jenis_kelamin;
    
    public $tempat_lahir;
    public $tanggal_lahir;
    public $alamat;
    public $nomor_telepon;
    
    public $email; 
    
    #[Validate('nullable|image|max:2048')] 
    public $new_foto; 
    public $old_foto; 
    
    public $nama_orangtua;
    public $telepon_orangtua;

    public function mount(Siswa $siswa)
    {
        $this->siswaId = $siswa->siswa_id;
        $this->userId = $siswa->user_id;
        
        $this->nama_lengkap = $siswa->nama_lengkap;
        $this->nis = $siswa->nis;
        // BARIS $this->nisn = $siswa->nisn; DIHAPUS DARI SINI
        $this->kelas_id = $siswa->kelas_id;
        $this->jenis_kelamin = $siswa->jenis_kelamin;
        $this->tempat_lahir = $siswa->tempat_lahir;
        $this->tanggal_lahir = $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('Y-m-d') : null;
        $this->alamat = $siswa->alamat;
        $this->nomor_telepon = $siswa->nomor_telepon;
        $this->nama_orangtua = $siswa->nama_orangtua;
        $this->telepon_orangtua = $siswa->telepon_orangtua;
        $this->old_foto = $siswa->foto_profil;
        
        $this->email = $siswa->user->email ?? '';
    }

    public function update()
    {
        $this->validate([
            'nis' => ['required', Rule::unique('siswas', 'nis')->ignore($this->siswaId, 'siswa_id')],
            'email' => ['nullable', 'email', Rule::unique('users', 'email')->ignore($this->userId, 'user_id')],
            'nama_lengkap' => 'required',
            'kelas_id' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        $siswa = Siswa::find($this->siswaId);
        $user = User::find($this->userId);

        if ($user) {
            $user->update([
                'email' => $this->email,
                'username' => $this->nis,
            ]);
        }

        $fotoPath = $siswa->foto_profil;
        if ($this->new_foto) {
            if ($siswa->foto_profil && Storage::disk('public')->exists($siswa->foto_profil)) {
                Storage::disk('public')->delete($siswa->foto_profil);
            }
            $fotoPath = $this->new_foto->store('profil', 'public');
        }

        $siswa->update([
            'kelas_id' => $this->kelas_id,
            'nis' => $this->nis,
            // BARIS 'nisn' => $this->nisn, DIHAPUS DARI SINI
            'nama_lengkap' => $this->nama_lengkap,
            'jenis_kelamin' => $this->jenis_kelamin,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'alamat' => $this->alamat,
            'nomor_telepon' => $this->nomor_telepon,
            'foto_profil' => $fotoPath,
            'nama_orangtua' => $this->nama_orangtua,
            'telepon_orangtua' => $this->telepon_orangtua,
        ]);

        session()->flash('message', 'Data siswa berhasil diperbarui.');
        return redirect()->route('siswa.index');
    }

    public function render()
    {
        return view('livewire.admin.siswa.siswa-edit', [
            'kelases' => Kelas::all()
        ]);
    }
}