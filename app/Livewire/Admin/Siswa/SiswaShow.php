<?php

namespace App\Livewire\Admin\Siswa;

use App\Models\Siswa;
use Livewire\Component;
use Livewire\Attributes\Layout;

class SiswaShow extends Component
{
    public Siswa $siswa;

    public function mount(Siswa $siswa)
    {
        // Eager load relasi yang dibutuhkan untuk tampilan detail
        // Kita memuat kelas beserta detailnya (jurusan, tahun, wali kelas) dan user login
        $this->siswa = $siswa->load([
            'user', 
            'kelas.jurusan', 
            'kelas.tahunAjaran', 
            'kelas.waliKelas'
        ]);
    }

    #[Layout('components.layouts.app', ['title' => 'Detail Siswa'])]
    public function render()
    {
        return view('livewire.admin.siswa.siswa-show');
    }
}