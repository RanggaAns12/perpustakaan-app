<?php

namespace App\Livewire\Pustakawan;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\DetailPengembalian;
use App\Models\Buku;
use App\Models\Denda;
use App\Models\Pengaturan;

class SirkulasiIndex extends Component
{
    use WithPagination;
    
    public $search = '';
    public $filterStatus = '';
    public $selectedPeminjaman = null;

    // Reset pagination saat searching/filtering
    public function updatedSearch() { $this->resetPage(); }
    public function updatedFilterStatus() { $this->resetPage(); }

    public function showDetail($id)
    {
        $this->selectedPeminjaman = Peminjaman::with([
            'siswa.kelas', 
            'detailPeminjaman.buku.penulis'
        ])->find($id);
    }

    public function closeDetail()
    {
        $this->selectedPeminjaman = null;
    }

    // --- LOGIKA APPROVAL ---

    public function setujuiPeminjaman($id)
    {
        $peminjaman = Peminjaman::find($id);
        
        // Pastikan User punya relasi pustakawan
        $petugasId = Auth::user()->pustakawan->pustakawan_id ?? null;

        if (!$petugasId) {
            session()->flash('error', 'Akun Anda tidak terhubung dengan data Pustakawan.');
            return;
        }
        
        if($peminjaman && $peminjaman->status_peminjaman == 'Pending') {
            $peminjaman->update([
                'status_peminjaman' => 'Dipinjam',
                'pustakawan_id' => $petugasId,
            ]);

            $this->closeDetail();
            session()->flash('success', 'Peminjaman disetujui. Silakan serahkan buku.');
        }
    }

    public function tolakPeminjaman($id)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman')->find($id);
        $petugasId = Auth::user()->pustakawan->pustakawan_id ?? null;

        if($peminjaman && $peminjaman->status_peminjaman == 'Pending') {
            
            // Kembalikan Stok karena saat Pending stok sudah dibooking (dikurangi)
            foreach($peminjaman->detailPeminjaman as $detail) {
                // Gunakan find agar aman jika relasi bermasalah
                $buku = Buku::find($detail->buku_id);
                if($buku) {
                    $buku->increment('jumlah_eksemplar_tersedia');
                }
            }

            $peminjaman->update([
                'status_peminjaman' => 'Ditolak',
                'pustakawan_id' => $petugasId,
                'catatan' => 'Ditolak oleh pustakawan.'
            ]);

            $this->closeDetail();
            session()->flash('error', 'Peminjaman ditolak. Stok buku telah dikembalikan.');
        }
    }

    public function verifikasiPengembalian($id)
    {
        $peminjaman = Peminjaman::with('detailPeminjaman')->find($id);
        $petugasId = Auth::user()->pustakawan->pustakawan_id ?? null;
        
        if(!$peminjaman || $peminjaman->status_peminjaman != 'Menunggu Pengembalian') return;

        DB::transaction(function () use ($peminjaman, $petugasId) {
            $pengaturan = Pengaturan::first();
            $tarifDenda = $pengaturan->denda_per_hari ?? 2000;
            $jatuhTempo = Carbon::parse($peminjaman->tanggal_jatuh_tempo);
            $hariIni = Carbon::now();
            
            $terlambatHari = 0;
            $totalDenda = 0;

            if ($hariIni->gt($jatuhTempo)) {
                $terlambatHari = $hariIni->diffInDays($jatuhTempo);
                $jumlahBuku = $peminjaman->detailPeminjaman->count();
                $totalDenda = $terlambatHari * $tarifDenda * $jumlahBuku;
            }

            $pengembalian = Pengembalian::create([
                'kode_transaksi' => 'KMB-' . time(),
                'peminjaman_id' => $peminjaman->peminjaman_id,
                'siswa_id' => $peminjaman->siswa_id,
                'pustakawan_id' => $petugasId,
                'tanggal_pengembalian' => now(),
                'status_pengembalian' => $terlambatHari > 0 ? 'Terlambat' : 'Tepat Waktu',
            ]);

            foreach ($peminjaman->detailPeminjaman as $detail) {
                $buku = Buku::find($detail->buku_id);
                if($buku) {
                    $buku->increment('jumlah_eksemplar_tersedia');
                }

                DetailPengembalian::create([
                    'pengembalian_id' => $pengembalian->pengembalian_id,
                    'buku_id' => $detail->buku_id,
                    'kondisi_buku_saat_kembali' => 'Baik',
                ]);
            }

            if ($totalDenda > 0) {
                Denda::create([
                    'pengembalian_id' => $pengembalian->pengembalian_id,
                    'siswa_id' => $peminjaman->siswa_id,
                    'jumlah_hari_terlambat' => $terlambatHari,
                    'tarif_denda_per_hari' => $tarifDenda,
                    'total_denda' => $totalDenda,
                    'status_denda' => 'Belum Lunas'
                ]);
            }

            $peminjaman->update(['status_peminjaman' => 'Dikembalikan']);
        });

        $this->closeDetail();
        session()->flash('success', 'Pengembalian diverifikasi. Stok diperbarui.');
    }

    public function render()
    {
        // PERBAIKAN QUERY GROUPING
        $query = Peminjaman::with(['siswa.kelas', 'detailPeminjaman.buku'])
            ->where(function($q) {
                $q->where('kode_transaksi', 'like', '%' . $this->search . '%')
                  ->orWhereHas('siswa', fn($sub) => $sub->where('nama_lengkap', 'like', '%' . $this->search . '%'));
            });

        if($this->filterStatus) {
            $query->where('status_peminjaman', $this->filterStatus);
        } else {
            // Prioritaskan yang butuh tindakan
            $query->orderByRaw("FIELD(status_peminjaman, 'Menunggu Pengembalian', 'Pending') DESC")
                  ->latest();
        }

        $counts = [
            'verifikasi' => Peminjaman::whereIn('status_peminjaman', ['Pending', 'Menunggu Pengembalian'])->count(),
            'aktif' => Peminjaman::where('status_peminjaman', 'Dipinjam')->count(),
            'terlambat' => Peminjaman::where('status_peminjaman', 'Terlambat')->count(),
            'selesai' => Peminjaman::where('status_peminjaman', 'Dikembalikan')->count(),
        ];

        return view('livewire.pustakawan.sirkulasi-index', [
            'transaksi' => $query->paginate(10),
            'counts' => $counts
        ]);
    }
}