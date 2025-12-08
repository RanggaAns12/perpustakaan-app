<?php

namespace App\Livewire\Admin\Master;

use App\Models\Kategori;
use Livewire\Component;
use Livewire\Attributes\Validate;

class KategoriCreate extends Component
{
    #[Validate('required|min:3')]
    public $nama_kategori;

    #[Validate('required')]
    public $kode_warna = '#4F46E5';

    public $deskripsi;

    public function save()
    {
        $this->validate();

        Kategori::create([
            'nama_kategori' => $this->nama_kategori,
            'kode_warna' => $this->kode_warna,
            'deskripsi' => $this->deskripsi,
        ]);

        session()->flash('message', 'Kategori berhasil ditambahkan.');
        return redirect()->route('kategori.index');
    }

    public function render()
    {
        return view('livewire.admin.master.kategori-create');
    }
}