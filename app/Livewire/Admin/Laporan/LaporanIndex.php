<?php

namespace App\Livewire\Admin\Laporan;

use App\Models\Peminjaman;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanIndex extends Component
{
    use WithPagination;

    public $tanggal_mulai;
    public $tanggal_selesai;
    public $status_filter = ''; // Filter Status: '', 'Dipinjam', 'Dikembalikan', 'Terlambat'

    public function mount()
    {
        // Default: Menampilkan data bulan ini
        $this->tanggal_mulai = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->tanggal_selesai = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function filter()
    {
        $this->resetPage(); // Reset pagination saat filter diterapkan
    }

    public function cetakPdf()
    {
        // 1. Ambil Data (Tanpa Pagination) untuk PDF
        $query = Peminjaman::with(['siswa.kelas', 'detailPeminjaman.buku'])
            ->whereBetween('tanggal_peminjaman', [$this->tanggal_mulai, $this->tanggal_selesai]);

        if ($this->status_filter) {
            $query->where('status_peminjaman', $this->status_filter);
        }

        $dataLaporan = $query->oldest('tanggal_peminjaman')->get();

        // 2. Load View PDF (Pastikan file resources/views/pdf/laporan-peminjaman.blade.php sudah dibuat)
        // Jika belum ada, gunakan view sederhana atau buat file tersebut.
        $pdf = Pdf::loadView('pdf.laporan-peminjaman', [
            'data' => $dataLaporan,
            'tglAwal' => $this->tanggal_mulai,
            'tglAkhir' => $this->tanggal_selesai
        ]);

        // 3. Set Kertas A4 Portrait
        $pdf->setPaper('a4', 'portrait');

        // 4. Download Langsung
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Laporan_Perpustakaan_' . date('Ymd_His') . '.pdf');
    }

    public function render()
    {
        // Query Dasar
        $query = Peminjaman::with(['siswa.kelas', 'detailPeminjaman.buku'])
            ->whereBetween('tanggal_peminjaman', [$this->tanggal_mulai, $this->tanggal_selesai]);

        // Terapkan Filter Status
        if ($this->status_filter) {
            $query->where('status_peminjaman', $this->status_filter);
        }

        // Hitung Ringkasan (Cloning query agar tidak merusak query utama)
        $summary = [
            'total' => (clone $query)->count(),
            'dipinjam' => (clone $query)->whereIn('status_peminjaman', ['Dipinjam', 'Terlambat'])->count(),
            'dikembalikan' => (clone $query)->where('status_peminjaman', 'Dikembalikan')->count()
        ];

        // Data Tabel (Dengan Pagination)
        $laporans = $query->latest('tanggal_peminjaman')->paginate(10);

        return view('livewire.admin.laporan.laporan-index', [
            'laporans' => $laporans,
            'summary' => $summary
        ]);
    }
}