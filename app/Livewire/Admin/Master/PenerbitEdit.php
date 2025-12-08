<?php

namespace App\Livewire\Admin\Master;

use App\Models\Penerbit;
use Livewire\Component;
use Livewire\Attributes\Validate;

class PenerbitEdit extends Component
{
    public $penerbitId;

    #[Validate('required|min:3')]
    public $nama_penerbit;
    
    public $alamat_penerbit;
    public $kota;
    public $telepon_penerbit;
    
    #[Validate('nullable|email')]
    public $email_penerbit;

    public function mount(Penerbit $penerbit)
    {
        $this->penerbitId = $penerbit->penerbit_id;
        $this->nama_penerbit = $penerbit->nama_penerbit;
        $this->alamat_penerbit = $penerbit->alamat_penerbit;
        $this->kota = $penerbit->kota;
        $this->telepon_penerbit = $penerbit->telepon_penerbit;
        $this->email_penerbit = $penerbit->email_penerbit;
    }

    public function update()
    {
        $this->validate();
        
        $penerbit = Penerbit::find($this->penerbitId);
        $penerbit->update([
            'nama_penerbit' => $this->nama_penerbit,
            'alamat_penerbit' => $this->alamat_penerbit,
            'kota' => $this->kota,
            'telepon_penerbit' => $this->telepon_penerbit,
            'email_penerbit' => $this->email_penerbit,
        ]);

        $this->dispatch('show-success', message: 'Penerbit berhasil diperbarui.');
        return redirect()->route('penerbit.index');
    }

    public function render()
    {
        return view('livewire.admin.master.penerbit-edit');
    }
}