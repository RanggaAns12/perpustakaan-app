<?php

namespace App\Livewire\Admin\Buku;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Penulis;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class BukuCreate extends Component
{
    use WithFileUploads;

    #[Validate('required', message: 'Judul buku wajib diisi')]
    public $judul_buku;

    #[Validate('required|unique:bukus,isbn', message: 'ISBN wajib diisi & unik')]
    public $isbn;

    #[Validate('required', message: 'Kategori wajib dipilih')]
    public $kategori_id;

    #[Validate('required', message: 'Penerbit wajib dipilih')]
    public $penerbit_id;

    #[Validate('required|array|min:1', message: 'Pilih minimal satu penulis')]
    public $selected_penulis = [];

    #[Validate('required|numeric', message: 'Tahun terbit wajib angka')]
    public $tahun_terbit;

    #[Validate('required|numeric', message: 'Jumlah halaman wajib angka')]
    public $jumlah_halaman;

    #[Validate('required|numeric|min:1', message: 'Stok minimal 1')]
    public $jumlah_eksemplar_total;

    public $lokasi_rak;
    public $sinopsis;
    public $bahasa = 'Indonesia';
    
    #[Validate('nullable|image|max:2048', message: 'Format gambar salah atau terlalu besar (Max 2MB)')]
    public $cover_image;

    public function save()
    {
        $this->validate();

        // Handle File Upload
        $coverPath = null;
        if ($this->cover_image) {
            $coverPath = $this->cover_image->store('covers', 'public');
        }

        // Create Buku
        $buku = Buku::create([
            'judul_buku' => $this->judul_buku,
            'isbn' => $this->isbn,
            'kategori_id' => $this->kategori_id,
            'penerbit_id' => $this->penerbit_id,
            'tahun_terbit' => $this->tahun_terbit,
            'jumlah_halaman' => $this->jumlah_halaman,
            'jumlah_eksemplar_total' => $this->jumlah_eksemplar_total,
            'jumlah_eksemplar_tersedia' => $this->jumlah_eksemplar_total, // Awalnya sama dengan total
            'lokasi_rak' => $this->lokasi_rak,
            'sinopsis' => $this->sinopsis,
            'bahasa' => $this->bahasa,
            'cover_buku' => $coverPath,
            'created_by' => Auth::id() ?? 1, // Fallback ke admin ID 1 jika null
        ]);

        // Attach Penulis (Many-to-Many)
        $buku->penulis()->attach($this->selected_penulis);

        session()->flash('message', 'Buku berhasil ditambahkan!');
        return redirect()->route('buku.index');
    }

    public function render()
    {
        return view('livewire.admin.buku.buku-create', [
            'kategoris' => Kategori::all(),
            'penerbits' => Penerbit::all(),
            'semua_penulis' => Penulis::all(),
        ]);
    }
}