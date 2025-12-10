<?php

namespace App\Livewire\Admin\Setting;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use App\Models\Galeri;
use Illuminate\Support\Facades\Storage;

class GaleriManager extends Component
{
    use WithFileUploads;

    #[Validate('required|min:3')]
    public $judul;

    public $deskripsi;

    #[Validate('required|image|max:5120')] // Max 5MB
    public $foto;

    public function save()
    {
        $this->validate();

        $path = $this->foto->store('galeri-sekolah', 'public');

        Galeri::create([
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'foto' => $path,
        ]);

        $this->reset(['judul', 'deskripsi', 'foto']);
        session()->flash('message', 'Foto berhasil ditambahkan ke galeri.');
    }

    public function delete($id)
    {
        $item = Galeri::find($id);
        
        if ($item) {
            if ($item->foto && Storage::disk('public')->exists($item->foto)) {
                Storage::disk('public')->delete($item->foto);
            }
            $item->delete();
            session()->flash('message', 'Foto dihapus dari galeri.');
        }
    }

    public function render()
    {
        return view('livewire.admin.setting.galeri-manager', [
            'galeris' => Galeri::latest()->get()
        ]);
    }
}