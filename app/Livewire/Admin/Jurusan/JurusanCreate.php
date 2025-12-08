<?php
namespace App\Livewire\Admin\Jurusan;

use App\Models\Jurusan;
use Livewire\Component;
use Livewire\Attributes\Validate;

class JurusanCreate extends Component
{
    #[Validate('required|min:3')] public $nama_jurusan;
    #[Validate('required|unique:jurusans,kode_jurusan')] public $kode_jurusan;

    public function save()
    {
        $this->validate();
        Jurusan::create([
            'nama_jurusan' => $this->nama_jurusan,
            'kode_jurusan' => strtoupper($this->kode_jurusan),
        ]);
        $this->dispatch('show-success', message: 'Jurusan berhasil ditambahkan.');
        return redirect()->route('jurusan.index');
    }

    public function render() { return view('livewire.admin.jurusan.jurusan-create'); }
}