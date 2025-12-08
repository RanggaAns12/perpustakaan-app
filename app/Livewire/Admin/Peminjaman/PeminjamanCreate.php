<?php

namespace App\Livewire\Admin\Peminjaman;

use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Buku;
use App\Models\Siswa;
use App\Models\Pengaturan;
use App\Models\Pustakawan; // Tambahkan Model ini
use Livewire\Component;
use Livewire\Attributes\Validate;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeminjamanCreate extends Component
{
    #[Validate('required', as: 'Siswa')]
    public $siswa_id = '';

    #[Validate('required', as: 'Buku')]
    public $buku_id = ''; 

    #[Validate('required|date')]
    public $tanggal_peminjaman;

    #[Validate('required|date|after_or_equal:tanggal_peminjaman')]
    public $tanggal_jatuh_tempo;

    public function mount()
    {
        $pengaturan = Pengaturan::first();
        $maxHari = $pengaturan->max_peminjaman_hari ?? 7;

        $this->tanggal_peminjaman = date('Y-m-d');
        $this->tanggal_jatuh_tempo = Carbon::now()->addDays($maxHari)->format('Y-m-d');
    }

    public function save()
    {
        $this->validate();

        $buku = Buku::find($this->buku_id);
        if ($buku->jumlah_eksemplar_tersedia < 1) {
            $this->addError('buku_id', 'Stok buku ini habis.');
            return;
        }

        // --- LOGIKA MENCARI PETUGAS (PUSTAKAWAN) ---
        $pustakawanId = null;
        
        // 1. Cek apakah user login punya data pustakawan
        if (Auth::user()->pustakawan) {
            $pustakawanId = Auth::user()->pustakawan->pustakawan_id;
        } 
        // 2. Jika tidak (misal Admin), ambil pustakawan pertama di DB sebagai perwakilan
        else {
            $petugasDefault = Pustakawan::first();
            if ($petugasDefault) {
                $pustakawanId = $petugasDefault->pustakawan_id;
            } else {
                // Jika tabel pustakawan benar-benar kosong
                session()->flash('error', 'Gagal: Tidak ada data Pustakawan di database. Tambahkan data Pustakawan di menu Master terlebih dahulu.');
                return;
            }
        }

        DB::transaction(function () use ($buku, $pustakawanId) {
            // 1. Buat Header
            $peminjaman = Peminjaman::create([
                'kode_transaksi' => 'PMJ-' . time(),
                'siswa_id' => $this->siswa_id,
                'pustakawan_id' => $pustakawanId, // Gunakan ID yang sudah dipastikan ada
                'tanggal_peminjaman' => $this->tanggal_peminjaman,
                'tanggal_jatuh_tempo' => $this->tanggal_jatuh_tempo,
                'status_peminjaman' => 'Dipinjam',
            ]);

            // 2. Buat Detail
            DetailPeminjaman::create([
                'peminjaman_id' => $peminjaman->peminjaman_id,
                'buku_id' => $this->buku_id,
                'kondisi_buku_saat_pinjam' => 'Baik',
            ]);

            // 3. Kurangi Stok
            $buku->decrement('jumlah_eksemplar_tersedia');
        });

        $this->dispatch('show-success', message: 'Transaksi berhasil dibuat.');
        return redirect()->route('peminjaman.index');
    }

    public function render()
    {
        return view('livewire.admin.peminjaman.peminjaman-create', [
            'siswas' => Siswa::where('status_siswa', 'Aktif')->get(),
            'bukus' => Buku::where('jumlah_eksemplar_tersedia', '>', 0)->latest()->take(50)->get()
        ]);
    }
}