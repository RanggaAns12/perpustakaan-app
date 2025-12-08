<?php

namespace App\Livewire\Admin\Buku;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Penerbit;
use App\Models\Penulis;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;

class BukuEdit extends Component
{
    use WithFileUploads;

    public $bukuId;
    
    #[Validate('required')]
    public $judul_buku;
    public $isbn;
    public $kategori_id;
    public $penerbit_id;
    public $selected_penulis = [];
    public $tahun_terbit;
    public $jumlah_halaman;
    public $jumlah_eksemplar_total;
    public $lokasi_rak;
    public $sinopsis;
    public $bahasa;
    
    #[Validate('nullable|image|max:2048')]
    public $new_cover_image; // Untuk upload baru
    public $old_cover_image; // Untuk display lama

    public function mount($buku)
    {
        // Livewire otomatis meng-bind model jika route pakai {buku}
        // Tapi karena kita menerima $buku dari Controller/Route binding, kita init manual
        $bukuData = Buku::findOrFail($buku); // $buku disini adalah ID jika binding route standar

        $this->bukuId = $bukuData->buku_id;
        $this->judul_buku = $bukuData->judul_buku;
        $this->isbn = $bukuData->isbn;
        $this->kategori_id = $bukuData->kategori_id;
        $this->penerbit_id = $bukuData->penerbit_id;
        $this->tahun_terbit = $bukuData->tahun_terbit;
        $this->jumlah_halaman = $bukuData->jumlah_halaman;
        $this->jumlah_eksemplar_total = $bukuData->jumlah_eksemplar_total;
        $this->lokasi_rak = $bukuData->lokasi_rak;
        $this->sinopsis = $bukuData->sinopsis;
        $this->bahasa = $bukuData->bahasa;
        $this->old_cover_image = $bukuData->cover_buku;
        
        // Ambil ID penulis yang sudah terhubung
        $this->selected_penulis = $bukuData->penulis->pluck('penulis_id')->toArray();
    }

    public function update()
    {
        $this->validate([
            'judul_buku' => 'required',
            'isbn' => 'required|unique:bukus,isbn,' . $this->bukuId . ',buku_id', // Ignore current ID
            'kategori_id' => 'required',
            'penerbit_id' => 'required',
            'tahun_terbit' => 'required|numeric',
            'jumlah_eksemplar_total' => 'required|numeric',
        ]);

        $buku = Buku::find($this->bukuId);

        // Handle Cover Update
        $coverPath = $buku->cover_buku;
        if ($this->new_cover_image) {
            // Hapus cover lama jika ada
            if ($buku->cover_buku) {
                Storage::disk('public')->delete($buku->cover_buku);
            }
            $coverPath = $this->new_cover_image->store('covers', 'public');
        }

        // Hitung selisih stok untuk update 'tersedia'
        $selisihStok = $this->jumlah_eksemplar_total - $buku->jumlah_eksemplar_total;
        $stokTersediaBaru = $buku->jumlah_eksemplar_tersedia + $selisihStok;

        // Cegah stok tersedia jadi minus
        if ($stokTersediaBaru < 0) $stokTersediaBaru = 0;

        $buku->update([
            'judul_buku' => $this->judul_buku,
            'isbn' => $this->isbn,
            'kategori_id' => $this->kategori_id,
            'penerbit_id' => $this->penerbit_id,
            'tahun_terbit' => $this->tahun_terbit,
            'jumlah_halaman' => $this->jumlah_halaman,
            'jumlah_eksemplar_total' => $this->jumlah_eksemplar_total,
            'jumlah_eksemplar_tersedia' => $stokTersediaBaru,
            'lokasi_rak' => $this->lokasi_rak,
            'sinopsis' => $this->sinopsis,
            'bahasa' => $this->bahasa,
            'cover_buku' => $coverPath,
        ]);

        // Sync Penulis (Update relasi Many-to-Many)
        $buku->penulis()->sync($this->selected_penulis);

        $this->dispatch('show-success', message: 'Data buku berhasil diperbarui.');
        return redirect()->route('buku.index');
    }

    public function render()
    {
        return view('livewire.admin.buku.buku-edit', [
            'kategoris' => Kategori::all(),
            'penerbits' => Penerbit::all(),
            'semua_penulis' => Penulis::all(),
        ]);
    }
}