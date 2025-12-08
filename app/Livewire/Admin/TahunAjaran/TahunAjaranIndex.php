<?php
namespace App\Livewire\Admin\TahunAjaran;

use App\Models\TahunAjaran;
use Livewire\Component;
use Livewire\WithPagination;

class TahunAjaranIndex extends Component
{
    use WithPagination;

    public function delete($id)
    {
        $tahun = TahunAjaran::find($id);
        if ($tahun->kelas()->exists()) {
            session()->flash('error', 'Tahun ajaran tidak bisa dihapus karena ada kelas yang terkait.');
            return;
        }
        $tahun->delete();
        session()->flash('message', 'Tahun ajaran berhasil dihapus.');
    }

    public function aktifkan($id)
    {
        TahunAjaran::query()->update(['is_aktif' => false]);
        $tahun = TahunAjaran::find($id);
        $tahun->update(['is_aktif' => true]);
        session()->flash('message', 'Tahun ajaran berhasil diaktifkan.');
    }

    public function render()
    {
        return view('livewire.admin.tahun-ajaran.tahun-ajaran-index', [
            'tahunAjarans' => TahunAjaran::latest()->paginate(10)
        ]);
    }
}