<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Sirkulasi</h1>
            <p class="text-sm text-gray-500">Kelola peminjaman dan pengembalian buku.</p>
        </div>
        {{-- Arahkan ke Create yang sama dengan Admin, atau buat khusus Pustakawan --}}
        <a href="{{ route('pustakawan.transaksi.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 flex items-center gap-2">
            <x-heroicon-o-plus class="w-5 h-5" /> Transaksi Baru
        </a>
    </div>

    {{-- Search Bar --}}
    <div class="bg-white p-2 rounded-xl border border-gray-100 mb-6 shadow-sm">
        <input wire:model.live="search" type="text" placeholder="Cari Kode Transaksi atau Nama Siswa..." class="w-full border-none focus:ring-0 text-sm">
    </div>

    {{-- Tabel Transaksi --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 border-b border-gray-100 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-4">Kode & Tanggal</th>
                    <th class="px-6 py-4">Siswa</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($transaksi as $item)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $item->kode_transaksi }}</div>
                            <div class="text-xs text-gray-500">{{ date('d M Y', strtotime($item->tanggal_peminjaman)) }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium">{{ $item->siswa->nama_lengkap }}</div>
                            <div class="text-xs text-gray-500">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4">
                            @if($item->status_peminjaman == 'Dipinjam')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-lg text-xs font-bold">Dipinjam</span>
                            @elseif($item->status_peminjaman == 'Dikembalikan')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs font-bold">Selesai</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-bold">Terlambat</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{-- Gunakan route admin peminjaman show karena fungsinya sama (Read Only) --}}
                            <a href="{{ route('peminjaman.show', $item->peminjaman_id) }}" class="text-indigo-600 hover:underline">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-8 text-gray-400">Tidak ada data transaksi.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $transaksi->links() }}</div>
    </div>
</div>