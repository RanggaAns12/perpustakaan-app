<?php

namespace App\Livewire\Admin\Master;

use App\Models\Penerbit;
use Livewire\Component;
use Livewire\Attributes\Validate;

class PenerbitCreate extends Component
{
    #[Validate('required|min:3')]
    public $nama_penerbit;
    
    public $alamat_penerbit;
    public $kota;
    public $telepon_penerbit;
    
    #[Validate('nullable|email')]
    public $email_penerbit;

    public function save()
    {
        $this->validate();

        Penerbit::create([
            'nama_penerbit' => $this->nama_penerbit,
            'alamat_penerbit' => $this->alamat_penerbit,
            'kota' => $this->kota,
            'telepon_penerbit' => $this->telepon_penerbit,
            'email_penerbit' => $this->email_penerbit,
        ]);

        $this->dispatch('show-success', message: 'Penerbit berhasil ditambahkan.');
        return redirect()->route('penerbit.index');
    }

    public function render()
    {
        return view('livewire.admin.master.penerbit-create');
    }
}