<?php
namespace App\Livewire\Admin\Jurusan;

use App\Models\Jurusan;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;

class JurusanEdit extends Component
{
    public $jurusanId;
    #[Validate('required|min:3')] public $nama_jurusan;
    public $kode_jurusan;

    public function mount(Jurusan $jurusan)
    {
        $this->jurusanId = $jurusan->jurusan_id;
        $this->nama_jurusan = $jurusan->nama_jurusan;
        $this->kode_jurusan = $jurusan->kode_jurusan;
    }

    public function update()
    {
        $this->validate([
            'nama_jurusan' => 'required|min:3',
            'kode_jurusan' => ['required', Rule::unique('jurusans', 'kode_jurusan')->ignore($this->jurusanId, 'jurusan_id')],
        ]);

        $jurusan = Jurusan::find($this->jurusanId);
        $jurusan->update([
            'nama_jurusan' => $this->nama_jurusan,
            'kode_jurusan' => strtoupper($this->kode_jurusan),
        ]);

        session()->flash('message', 'Jurusan berhasil diperbarui.');
        return redirect()->route('jurusan.index');
    }

    public function render() { return view('livewire.admin.jurusan.jurusan-edit'); }
}