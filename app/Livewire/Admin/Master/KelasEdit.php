<?php

namespace App\Livewire\Admin\Master;

use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\TahunAjaran;
use App\Models\Guru;
use Livewire\Component;
use Livewire\Attributes\Validate;

class KelasEdit extends Component
{
    public $kelasId;
    #[Validate('required')] public $nama_kelas;
    #[Validate('required')] public $kode_kelas;
    #[Validate('required')] public $tingkat;
    #[Validate('required')] public $jurusan_id;
    #[Validate('required')] public $tahun_id;
    public $wali_kelas;
    #[Validate('numeric')] public $kapasitas;
    public $ruangan;

    public function mount(Kelas $kelas)
    {
        $this->kelasId = $kelas->kelas_id;
        $this->nama_kelas = $kelas->nama_kelas;
        $this->kode_kelas = $kelas->kode_kelas;
        $this->tingkat = $kelas->tingkat;
        $this->jurusan_id = $kelas->jurusan_id;
        $this->tahun_id = $kelas->tahun_id;
        $this->wali_kelas = $kelas->wali_kelas;
        $this->kapasitas = $kelas->kapasitas;
        $this->ruangan = $kelas->ruangan;
    }

    public function update()
    {
        $this->validate();
        $kelas = Kelas::find($this->kelasId);
        $kelas->update([
            'nama_kelas' => $this->nama_kelas,
            'kode_kelas' => $this->kode_kelas,
            'tingkat' => $this->tingkat,
            'jurusan_id' => $this->jurusan_id,
            'tahun_id' => $this->tahun_id,
            'wali_kelas' => $this->wali_kelas,
            'kapasitas' => $this->kapasitas,
            'ruangan' => $this->ruangan,
        ]);
        session()->flash('message', 'Kelas berhasil diperbarui.');
        return redirect()->route('kelas.index');
    }

    public function render()
    {
        return view('livewire.admin.master.kelas-edit', [
            'jurusans' => Jurusan::all(),
            'tahuns' => TahunAjaran::all(), // Tampilkan semua tahun untuk edit
            'gurus' => Guru::all()
        ]);
    }
}