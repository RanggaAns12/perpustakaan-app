<?php

namespace App\Livewire\Admin\Peminjaman;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\DetailPengembalian;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\Pengaturan;
use App\Models\Pustakawan; // Tambahkan Model ini
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PeminjamanIndex extends Component
{
    use WithPagination;

    public $search = '';
    
    public $returnModalOpen = false;
    public $selectedPeminjaman;
    public $dendaEstimasi = 0;
    public $terlambatHari = 0;
    public $tarifDenda = 2000;

    public function updatingSearch() { $this->resetPage(); }

    public function openReturnModal($id)
    {
        $this->selectedPeminjaman = Peminjaman::with('detailPeminjaman')->find($id);
        
        if ($this->selectedPeminjaman) {
            $pengaturan = Pengaturan::first();
            $this->tarifDenda = $pengaturan->denda_per_hari ?? 2000;

            $jatuhTempo = Carbon::parse($this->selectedPeminjaman->tanggal_jatuh_tempo);
            $hariIni = Carbon::now();

            if ($hariIni->gt($jatuhTempo)) {
                $this->terlambatHari = $hariIni->diffInDays($jatuhTempo);
                $jumlahBuku = $this->selectedPeminjaman->detailPeminjaman->count();
                $this->dendaEstimasi = $this->terlambatHari * $this->tarifDenda * $jumlahBuku;
            } else {
                $this->terlambatHari = 0;
                $this->dendaEstimasi = 0;
            }
            
            $this->returnModalOpen = true;
        }
    }

    public function processReturn()
    {
        if (!$this->selectedPeminjaman) return;

        // --- LOGIKA MENCARI PETUGAS (PUSTAKAWAN) ---
        $pustakawanId = null;
        if (Auth::user()->pustakawan) {
            $pustakawanId = Auth::user()->pustakawan->pustakawan_id;
        } else {
            $petugasDefault = Pustakawan::first();
            if ($petugasDefault) {
                $pustakawanId = $petugasDefault->pustakawan_id;
            } else {
                session()->flash('error', 'Gagal: Data Pustakawan tidak ditemukan untuk memproses pengembalian.');
                return;
            }
        }

        DB::transaction(function () use ($pustakawanId) {
            $peminjaman = $this->selectedPeminjaman;

            // 1. Buat Header Pengembalian
            $pengembalian = Pengembalian::create([
                'kode_transaksi' => 'KMB-' . time(),
                'peminjaman_id' => $peminjaman->peminjaman_id,
                'siswa_id' => $peminjaman->siswa_id,
                'pustakawan_id' => $pustakawanId, // Gunakan ID yang valid
                'tanggal_pengembalian' => now(),
                'status_pengembalian' => $this->terlambatHari > 0 ? 'Terlambat' : 'Tepat Waktu',
            ]);

            // 2. Proses Detail Buku
            foreach ($peminjaman->detailPeminjaman as $detail) {
                $buku = Buku::find($detail->buku_id);
                $buku->increment('jumlah_eksemplar_tersedia');

                DetailPengembalian::create([
                    'pengembalian_id' => $pengembalian->pengembalian_id,
                    'buku_id' => $detail->buku_id,
                    'kondisi_buku_saat_kembali' => 'Baik',
                ]);
            }

            // 3. Buat Denda
            if ($this->dendaEstimasi > 0) {
                Denda::create([
                    'pengembalian_id' => $pengembalian->pengembalian_id,
                    'siswa_id' => $peminjaman->siswa_id,
                    'jumlah_hari_terlambat' => $this->terlambatHari,
                    'tarif_denda_per_hari' => $this->tarifDenda,
                    'total_denda' => $this->dendaEstimasi,
                    'status_denda' => 'Belum Lunas'
                ]);
            }

            $peminjaman->update(['status_peminjaman' => 'Dikembalikan']);
        });

        $this->returnModalOpen = false;
        session()->flash('message', 'Buku berhasil dikembalikan dan stok diperbarui.');
    }

    public function render()
    {
        $peminjamans = Peminjaman::with(['siswa', 'detailPeminjaman.buku'])
            ->where('kode_transaksi', 'like', '%' . $this->search . '%')
            ->orWhereHas('siswa', fn($q) => $q->where('nama_lengkap', 'like', '%' . $this->search . '%'))
            ->latest()
            ->paginate(10);

        return view('livewire.admin.peminjaman.peminjaman-index', ['peminjamans' => $peminjamans]);
    }
}