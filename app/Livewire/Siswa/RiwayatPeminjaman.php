<?php

namespace App\Livewire\Siswa;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;

class RiwayatPeminjaman extends Component
{
    use WithPagination;

    #[Layout('components.layouts.siswa')]

    // State untuk Modal
    public $returnModalOpen = false;
    public $selectedId = null;

    // 1. Fungsi Buka Modal
    public function confirmReturn($id)
    {
        $this->selectedId = $id;
        $this->returnModalOpen = true;
    }

    // 2. Fungsi Tutup Modal
    public function cancelReturn()
    {
        $this->returnModalOpen = false;
        $this->selectedId = null;
    }

    // 3. Eksekusi Pengajuan (Dipanggil saat klik 'Ya' di modal)
    public function ajukanPengembalian()
    {
        if (!$this->selectedId) return;

        $peminjaman = Peminjaman::where('siswa_id', Auth::user()->siswa->siswa_id)
            ->find($this->selectedId);

        if ($peminjaman && in_array($peminjaman->status_peminjaman, ['Dipinjam', 'Terlambat'])) {
            $peminjaman->update([
                'status_peminjaman' => 'Menunggu Pengembalian'
            ]);
            
            session()->flash('message', 'Permintaan pengembalian berhasil dikirim. Silakan serahkan buku ke perpustakaan untuk verifikasi.');
        }

        // Tutup modal setelah proses
        $this->cancelReturn();
    }

    public function render()
    {
        $siswa = Auth::user()->siswa;

        if (!$siswa) { abort(403, 'Profil siswa tidak ditemukan.'); }

        $riwayat = Peminjaman::with(['detailPeminjaman.buku', 'pengembalian.denda'])
            ->where('siswa_id', $siswa->siswa_id)
            ->latest()
            ->paginate(10);

        return view('livewire.siswa.riwayat-peminjaman', [
            'riwayat' => $riwayat
        ]);
    }
}