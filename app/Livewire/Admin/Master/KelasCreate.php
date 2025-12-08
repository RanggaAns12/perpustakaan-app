<?php

namespace App\Livewire\Admin\Master;

use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\TahunAjaran;
use App\Models\Guru;
use Livewire\Component;
use Livewire\Attributes\Validate;

class KelasCreate extends Component
{
    #[Validate('required', as: 'Nama Kelas')] 
    public $nama_kelas;

    #[Validate('required|unique:kelas,kode_kelas', as: 'Kode Kelas')] 
    public $kode_kelas;

    // PERBAIKAN: Inisialisasi dengan string kosong
    #[Validate('required', as: 'Tingkat')] 
    public $tingkat = '';

    // PERBAIKAN: Inisialisasi dengan string kosong
    #[Validate('required', as: 'Jurusan')] 
    public $jurusan_id = '';

    // PERBAIKAN: Inisialisasi dengan string kosong
    #[Validate('required', as: 'Tahun Ajaran')] 
    public $tahun_id = '';

    // Wali kelas opsional, tapi sebaiknya di-init kosong juga
    public $wali_kelas = '';
    
    #[Validate('numeric', as: 'Kapasitas')] 
    public $kapasitas = 36;
    
    public $ruangan;

    public function save()
    {
        $this->validate();
        
        Kelas::create([
            'nama_kelas' => $this->nama_kelas,
            'kode_kelas' => $this->kode_kelas,
            'tingkat' => $this->tingkat,
            'jurusan_id' => $this->jurusan_id,
            'tahun_id' => $this->tahun_id,
            // Jika kosong (''), ubah jadi null agar tidak error di database (jika kolom nullable)
            'wali_kelas' => $this->wali_kelas === '' ? null : $this->wali_kelas,
            'kapasitas' => $this->kapasitas,
            'ruangan' => $this->ruangan,
        ]);
        
        $this->dispatch('show-success', message: 'Kelas berhasil dibuat.');
        return redirect()->route('kelas.index');
    }

    public function render()
    {
        return view('livewire.admin.master.kelas-create', [
            'jurusans' => Jurusan::all(),
            'tahuns' => TahunAjaran::where('is_aktif', true)->latest()->get(), // Saran: Ambil tahun aktif saja atau urutkan terbaru
            'gurus' => Guru::where('status', 'Aktif')->get() // Saran: Ambil guru aktif saja
        ]);
    }
}