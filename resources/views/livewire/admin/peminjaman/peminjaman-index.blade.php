<div class="min-h-screen bg-gray-50/50 pb-12" x-data="{ returnModalOpen: @entangle('returnModalOpen') }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 animate-fade-in-up">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Sirkulasi Peminjaman</h1>
                <p class="text-gray-500 mt-2">Kelola transaksi peminjaman dan pengembalian buku.</p>
            </div>
            <a href="{{ route('peminjaman.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:-translate-y-0.5 transition-all group">
                <x-heroicon-o-plus class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform" /> 
                Transaksi Baru
            </a>
        </div>

        {{-- Flash Message --}}
        @if (session()->has('message'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
                <x-heroicon-o-check-circle class="w-6 h-6" />
                <span class="font-medium">{{ session('message') }}</span>
            </div>
        @endif

        {{-- Search --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 mb-8 sticky top-20 z-20">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <x-heroicon-o-magnifying-glass class="h-5 w-5" />
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-11 pr-4 py-2.5 border-none rounded-xl bg-transparent focus:ring-2 focus:ring-indigo-500/20" placeholder="Cari kode transaksi, siswa, atau NIS..." />
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                            <th class="px-6 py-4">Transaksi & Siswa</th>
                            <th class="px-6 py-4">Detail Buku</th>
                            <th class="px-6 py-4">Tanggal</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($peminjamans as $item)
                            <tr class="group hover:bg-indigo-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="font-mono font-bold text-gray-900 text-sm">{{ $item->kode_transaksi }}</div>
                                    <div class="text-sm text-indigo-600 font-semibold mt-1">{{ $item->siswa->nama_lengkap ?? 'Siswa Dihapus' }}</div>
                                    <div class="text-xs text-gray-400">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        @foreach($item->detailPeminjaman as $detail)
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200 truncate max-w-[200px]">
                                                <x-heroicon-o-book-open class="w-3 h-3 mr-1.5" />
                                                {{ $detail->buku->judul_buku ?? 'Buku Dihapus' }}
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <div class="text-xs text-gray-500 space-y-1">
                                        <div class="flex items-center gap-1"><x-heroicon-m-calendar class="w-3 h-3" /> Pinjam: <span class="text-gray-900 font-medium">{{ $item->tanggal_peminjaman ? date('d/m/y', strtotime($item->tanggal_peminjaman)) : '-' }}</span></div>
                                        <div class="flex items-center gap-1"><x-heroicon-m-clock class="w-3 h-3" /> Tempo: <span class="text-red-600 font-medium">{{ $item->tanggal_jatuh_tempo ? date('d/m/y', strtotime($item->tanggal_jatuh_tempo)) : '-' }}</span></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $color = match($item->status_peminjaman) {
                                            'Dipinjam' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'Dikembalikan' => 'bg-green-100 text-green-800 border-green-200',
                                            'Terlambat' => 'bg-red-100 text-red-800 border-red-200',
                                            default => 'bg-gray-100 text-gray-800'
                                        };
                                    @endphp
                                    <span class="px-2.5 py-1 rounded-full text-xs font-bold border {{ $color }}">
                                        {{ $item->status_peminjaman }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('peminjaman.show', $item->peminjaman_id) }}" class="p-1.5 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Detail">
                                            <x-heroicon-o-eye class="w-5 h-5" />
                                        </a>
                                        @if($item->status_peminjaman == 'Dipinjam' || $item->status_peminjaman == 'Terlambat')
                                            <button wire:click="openReturnModal({{ $item->peminjaman_id }})" class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 shadow-sm transition">
                                                <x-heroicon-o-arrow-uturn-left class="w-3.5 h-3.5 mr-1" /> Kembali
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-12 text-center text-gray-400 italic">Tidak ada data transaksi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">{{ $peminjamans->links() }}</div>
        </div>

        {{-- Modal Pengembalian (CENTERED) --}}
        <div x-show="returnModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex min-h-screen items-center justify-center p-4 text-center">
                <div x-show="returnModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm" @click="returnModalOpen = false"></div>

                <div x-show="returnModalOpen" x-transition class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">
                    <div class="bg-white px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-lg font-bold text-gray-900">Konfirmasi Pengembalian</h3>
                        <button @click="returnModalOpen = false" class="text-gray-400 hover:text-gray-600"><x-heroicon-o-x-mark class="w-6 h-6" /></button>
                    </div>
                    
                    <div class="p-6 space-y-5">
                        <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100">
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600">Jatuh Tempo:</span>
                                <span class="font-semibold text-gray-900">{{ $selectedPeminjaman ? date('d M Y', strtotime($selectedPeminjaman->tanggal_jatuh_tempo)) : '-' }}</span>
                            </div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-gray-600">Tgl Kembali:</span>
                                <span class="font-semibold text-gray-900">{{ date('d M Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm pt-2 border-t border-indigo-200/50">
                                <span class="text-gray-600">Keterlambatan:</span>
                                <span class="font-bold {{ $terlambatHari > 0 ? 'text-red-600' : 'text-green-600' }}">
                                    {{ $terlambatHari > 0 ? $terlambatHari . ' Hari' : 'Tepat Waktu' }}
                                </span>
                            </div>
                        </div>

                        @if($dendaEstimasi > 0)
                            <div class="bg-red-50 p-4 rounded-xl border border-red-100 flex justify-between items-center">
                                <div class="flex items-center gap-2 text-red-800 text-sm font-medium">
                                    <x-heroicon-o-banknotes class="w-5 h-5" /> Total Denda:
                                </div>
                                <span class="text-xl font-extrabold text-red-600">Rp {{ number_format($dendaEstimasi, 0, ',', '.') }}</span>
                            </div>
                            <p class="text-xs text-gray-500 text-center">Denda akan dicatat otomatis ke akun siswa sebagai "Belum Lunas".</p>
                        @else
                            <div class="text-center text-green-600 font-medium text-sm flex items-center justify-center gap-1">
                                <x-heroicon-o-check-badge class="w-5 h-5" /> Tidak ada denda.
                            </div>
                        @endif
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex justify-end gap-3">
                        <button wire:click="processReturn" class="px-5 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition w-full">
                            Proses Pengembalian
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>