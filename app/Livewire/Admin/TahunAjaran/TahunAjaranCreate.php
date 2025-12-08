<?php

namespace App\Livewire\Admin\TahunAjaran;

use App\Models\TahunAjaran;
use Livewire\Component;
use Livewire\Attributes\Validate;

class TahunAjaranCreate extends Component
{
    #[Validate('required', message: 'Tahun ajaran wajib diisi')] 
    public $tahun_ajaran;

    // Inisialisasi string kosong agar select option default terpilih
    #[Validate('required', message: 'Semester wajib dipilih')] 
    public $semester = '';
    
    #[Validate('required|date')] 
    public $tanggal_mulai;
    
    #[Validate('required|date|after:tanggal_mulai')] 
    public $tanggal_selesai;
    
    public $is_aktif = false;

    public function save()
    {
        $this->validate();

        // Jika diset aktif, nonaktifkan tahun ajaran lain
        if ($this->is_aktif) {
            TahunAjaran::query()->update(['is_aktif' => false]);
        }

        TahunAjaran::create([
            'tahun_ajaran' => $this->tahun_ajaran,
            'semester' => $this->semester,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'is_aktif' => $this->is_aktif,
        ]);

        session()->flash('message', 'Periode akademik berhasil ditambahkan.');
        return redirect()->route('tahun-ajaran.index');
    }

    public function render() 
    { 
        // Pastikan path view sudah mengarah ke folder admin
        return view('livewire.admin.tahun-ajaran.tahun-ajaran-create'); 
    }
}