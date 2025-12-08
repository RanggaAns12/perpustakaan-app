<?php

namespace App\Livewire\Admin\Master;

use App\Models\Penulis;
use Livewire\Component;
use Livewire\Attributes\Validate;

class PenulisCreate extends Component
{
    #[Validate('required|min:3')]
    public $nama_penulis;

    public $biografi;
    
    public $kebangsaan = 'Indonesia'; // Default

    public function save()
    {
        $this->validate();

        Penulis::create([
            'nama_penulis' => $this->nama_penulis,
            'biografi' => $this->biografi,
            'kebangsaan' => $this->kebangsaan,
        ]);

        $this->dispatch('show-success', message: 'Penulis berhasil ditambahkan.');
        return redirect()->route('penulis.index');
    }

    public function render()
    {
        return view('livewire.admin.master.penulis-create');
    }
}