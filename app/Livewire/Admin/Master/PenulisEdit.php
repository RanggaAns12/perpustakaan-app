<?php

namespace App\Livewire\Admin\Master;

use App\Models\Penulis;
use Livewire\Component;
use Livewire\Attributes\Validate;

class PenulisEdit extends Component
{
    public $penulisId;

    #[Validate('required|min:3')]
    public $nama_penulis;

    public $biografi;
    public $kebangsaan;

    public function mount(Penulis $penulis)
    {
        $this->penulisId = $penulis->penulis_id;
        $this->nama_penulis = $penulis->nama_penulis;
        $this->biografi = $penulis->biografi;
        $this->kebangsaan = $penulis->kebangsaan;
    }

    public function update()
    {
        $this->validate();

        $penulis = Penulis::find($this->penulisId);
        $penulis->update([
            'nama_penulis' => $this->nama_penulis,
            'biografi' => $this->biografi,
            'kebangsaan' => $this->kebangsaan,
        ]);

        session()->flash('message', 'Data penulis berhasil diperbarui.');
        return redirect()->route('penulis.index');
    }

    public function render()
    {
        return view('livewire.admin.master.penulis-edit');
    }
}