<?php

namespace App\Livewire\Admin\Master;

use App\Models\Kategori;
use Livewire\Component;
use Livewire\Attributes\Validate;

class KategoriEdit extends Component
{
    public $kategoriId;

    #[Validate('required|min:3')]
    public $nama_kategori;

    #[Validate('required')]
    public $kode_warna;

    public $deskripsi;

    public function mount(Kategori $kategori)
    {
        $this->kategoriId = $kategori->kategori_id;
        $this->nama_kategori = $kategori->nama_kategori;
        $this->kode_warna = $kategori->kode_warna;
        $this->deskripsi = $kategori->deskripsi;
    }

    public function update()
    {
        $this->validate();

        $kategori = Kategori::find($this->kategoriId);
        $kategori->update([
            'nama_kategori' => $this->nama_kategori,
            'kode_warna' => $this->kode_warna,
            'deskripsi' => $this->deskripsi,
        ]);

        session()->flash('message', 'Kategori berhasil diperbarui.');
        return redirect()->route('kategori.index');
    }

    public function render()
    {
        return view('livewire.admin.master.kategori-edit');
    }
}