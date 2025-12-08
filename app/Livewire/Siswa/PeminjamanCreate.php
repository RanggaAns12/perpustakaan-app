<?php

namespace App\Livewire\Siswa;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\DetailPeminjaman;
use Carbon\Carbon;

class PeminjamanCreate extends Component
{
    #[Layout('components.layouts.siswa')]

    public Buku $buku;
    public $tanggal_pinjam;
    public $tanggal_kembali;
    public $durasi = 7; // Default 7 hari

    public function mount(Buku $buku)
    {
        $this->buku = $buku;
        
        // 1. Cek Stok (Keamanan Ekstra)
        if ($this->buku->jumlah_eksemplar_tersedia < 1) {
            session()->flash('error', 'Maaf, stok buku ini sedang habis.');
            return redirect()->route('siswa.katalog');
        }

        // 2. Set Tanggal Default
        $this->tanggal_pinjam = Carbon::now()->format('Y-m-d');
        // Casting (int) penting agar Carbon tidak error membaca string dari select option
        $this->tanggal_kembali = Carbon::now()->addDays((int) $this->durasi)->format('Y-m-d');
    }

    // Update tanggal kembali otomatis saat durasi diganti
    public function updatedDurasi()
    {
        $this->tanggal_kembali = Carbon::parse($this->tanggal_pinjam)
            ->addDays((int) $this->durasi)
            ->format('Y-m-d');
    }

    public function prosesPeminjaman()
    {
        $siswa = Auth::user()->siswa;

        if (!$siswa) {
            return redirect()->route('siswa.dashboard')->with('error', 'Data profil siswa tidak ditemukan.');
        }

        DB::beginTransaction();
        try {
            // A. Buat Header Peminjaman
            $peminjaman = Peminjaman::create([
                'kode_transaksi'      => 'TRX-' . time() . '-' . $siswa->siswa_id, // Unik
                'siswa_id'            => $siswa->siswa_id,
                'pustakawan_id'       => null, // Kosong karena menunggu konfirmasi
                'tanggal_peminjaman'  => $this->tanggal_pinjam,
                'tanggal_jatuh_tempo' => $this->tanggal_kembali,
                'status_peminjaman'   => 'Pending', // Status Awal
            ]);

            // B. Buat Detail Peminjaman (Relasi Buku)
            DetailPeminjaman::create([
                'peminjaman_id' => $peminjaman->peminjaman_id,
                'buku_id'       => $this->buku->buku_id,
            ]);

            // C. Kurangi Stok Buku (Booking Stok)
            $this->buku->decrement('jumlah_eksemplar_tersedia');

            DB::commit();

            // Redirect ke Riwayat dengan Pesan Sukses
            return redirect()->route('siswa.riwayat')
                ->with('success', 'Permintaan peminjaman berhasil dikirim! Silakan tunggu konfirmasi pustakawan.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Log error untuk developer, tampilkan pesan umum untuk user
            session()->flash('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.siswa.peminjaman-create');
    }
}