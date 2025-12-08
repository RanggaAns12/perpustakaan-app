<?php
namespace App\Livewire\Admin\Jurusan;

use App\Models\Jurusan;
use Livewire\Component;
use Livewire\WithPagination;

class JurusanIndex extends Component
{
    use WithPagination;
    public $search = '';

    public function updatingSearch() { $this->resetPage(); }

    public function delete($id)
    {
        $jurusan = Jurusan::find($id);
        if ($jurusan->kelas()->exists()) {
            session()->flash('error', 'Jurusan tidak dapat dihapus karena sedang digunakan oleh data Kelas.');
            return;
        }
        $jurusan->delete();
        session()->flash('message', 'Jurusan berhasil dihapus.');
    }

    public function render()
    {
        $jurusans = Jurusan::where('nama_jurusan', 'like', '%' . $this->search . '%')
            ->orWhere('kode_jurusan', 'like', '%' . $this->search . '%')
            ->latest()->paginate(10);
        return view('livewire.admin.jurusan.jurusan-index', ['jurusans' => $jurusans]);
    }
}