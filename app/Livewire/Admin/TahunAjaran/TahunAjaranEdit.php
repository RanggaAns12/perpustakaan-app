<?php
namespace App\Livewire\Admin\TahunAjaran;

use App\Models\TahunAjaran;
use Livewire\Component;
use Livewire\Attributes\Validate;

class TahunAjaranEdit extends Component
{
    public $tahunId;
    #[Validate('required')] public $tahun_ajaran;
    #[Validate('required')] public $semester;
    #[Validate('required|date')] public $tanggal_mulai;
    #[Validate('required|date|after:tanggal_mulai')] public $tanggal_selesai;
    public $is_aktif;

    public function mount(TahunAjaran $tahun)
    {
        $this->tahunId = $tahun->tahun_id;
        $this->tahun_ajaran = $tahun->tahun_ajaran;
        $this->semester = $tahun->semester;
        $this->tanggal_mulai = $tahun->tanggal_mulai;
        $this->tanggal_selesai = $tahun->tanggal_selesai;
        $this->is_aktif = (bool) $tahun->is_aktif;
    }

    public function update()
    {
        $this->validate();

        if ($this->is_aktif) {
            TahunAjaran::where('tahun_id', '!=', $this->tahunId)->update(['is_aktif' => false]);
        }

        $tahun = TahunAjaran::find($this->tahunId);
        $tahun->update([
            'tahun_ajaran' => $this->tahun_ajaran,
            'semester' => $this->semester,
            'tanggal_mulai' => $this->tanggal_mulai,
            'tanggal_selesai' => $this->tanggal_selesai,
            'is_aktif' => $this->is_aktif,
        ]);

        session()->flash('message', 'Data tahun ajaran diperbarui.');
        return redirect()->route('tahun-ajaran.index');
    }

    public function render() { return view('livewire.admin.tahun-ajaran.tahun-ajaran-edit'); }
}