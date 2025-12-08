<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in-up">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Sirkulasi Perpustakaan</h1>
            <p class="text-slate-500 mt-1">Kelola peminjaman, pengembalian, dan verifikasi status buku.</p>
        </div>
        <a href="{{ route('peminjaman.create') }}" 
           class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-semibold rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-0.5 transition-all group gap-2">
            <x-heroicon-o-plus class="w-5 h-5 group-hover:rotate-90 transition-transform" /> 
            Transaksi Manual
        </a>
    </div>

    {{-- Filter & Search --}}
    <div class="bg-white p-2 rounded-2xl border border-slate-200 mb-6 shadow-sm flex flex-col md:flex-row gap-2">
        <div class="relative flex-grow">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                <x-heroicon-o-magnifying-glass class="h-5 w-5" />
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" 
                   class="block w-full pl-10 pr-4 py-2.5 bg-transparent border-none rounded-xl text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-indigo-100" 
                   placeholder="Cari Kode, Nama Siswa..." />
        </div>

        <div class="flex bg-slate-100 p-1 rounded-xl overflow-x-auto hide-scrollbar">
            @foreach(['' => 'Semua', 'Pending' => 'Baru', 'Menunggu Pengembalian' => 'Kembali', 'Dipinjam' => 'Aktif'] as $key => $label)
                <button wire:click="$set('filterStatus', '{{ $key }}')" 
                        class="px-4 py-1.5 text-xs font-bold rounded-lg transition-all whitespace-nowrap {{ $filterStatus === $key ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-black/5' : 'text-slate-500 hover:text-slate-700' }}">
                    {{ $label }}
                </button>
            @endforeach
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
            <x-heroicon-o-check-circle class="w-5 h-5" />
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
            <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase text-xs font-bold tracking-wide">
                    <tr>
                        <th class="px-6 py-4">Transaksi</th>
                        <th class="px-6 py-4">Peminjam</th>
                        <th class="px-6 py-4">Buku</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transaksi as $item)
                        <tr class="group hover:bg-slate-50/50 transition duration-150">
                            {{-- Kolom Transaksi --}}
                            <td class="px-6 py-4 align-top">
                                <span class="bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded font-mono font-bold text-xs border border-indigo-100">
                                    {{ $item->kode_transaksi }}
                                </span>
                                <div class="text-xs text-slate-400 mt-1 flex items-center gap-1">
                                    <x-heroicon-o-calendar class="w-3 h-3"/>
                                    {{ date('d/m/y', strtotime($item->tanggal_peminjaman)) }}
                                </div>
                            </td>

                            {{-- Kolom Peminjam --}}
                            <td class="px-6 py-4 align-top">
                                <div class="font-bold text-slate-800">{{ $item->siswa->nama_lengkap ?? 'Dihapus' }}</div>
                                <div class="text-xs text-slate-500">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</div>
                            </td>

                            {{-- Kolom Buku --}}
                            <td class="px-6 py-4 align-top">
                                <ul class="space-y-1">
                                    @foreach($item->detailPeminjaman as $detail)
                                        <li class="flex items-start gap-1.5 text-xs text-slate-600 max-w-[200px]">
                                            <x-heroicon-o-book-open class="w-3 h-3 mt-0.5 shrink-0 text-slate-400"/>
                                            <span class="truncate">{{ $detail->buku->judul_buku ?? 'Buku Dihapus' }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>

                            {{-- Kolom Status --}}
                            <td class="px-6 py-4 align-top text-center">
                                @php
                                    $statusClasses = match($item->status_peminjaman) {
                                        'Pending' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                        'Dipinjam' => 'bg-indigo-50 text-indigo-700 border-indigo-100',
                                        'Dikembalikan' => 'bg-green-50 text-green-700 border-green-100',
                                        'Menunggu Pengembalian' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'Terlambat' => 'bg-rose-50 text-rose-700 border-rose-100',
                                        default => 'bg-slate-50 text-slate-600 border-slate-200',
                                    };
                                @endphp
                                <span class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wide border {{ $statusClasses }}">
                                    {{ $item->status_peminjaman }}
                                </span>
                            </td>

                            {{-- Kolom Aksi --}}
                            <td class="px-6 py-4 align-top text-center">
                                <button wire:click="showDetail({{ $item->peminjaman_id }})" 
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-white border border-slate-200 text-slate-600 text-xs font-bold rounded-lg shadow-sm hover:bg-indigo-600 hover:text-white hover:border-indigo-600 transition-all duration-200 group-hover:border-slate-300">
                                    <span>Detail</span>
                                    <x-heroicon-o-chevron-right class="w-3 h-3"/>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                <div class="flex flex-col items-center">
                                    <x-heroicon-o-inbox class="w-8 h-8 text-slate-300 mb-2"/>
                                    <p>Data tidak ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $transaksi->links() }}
        </div>
    </div>

    {{-- MODAL DETAIL & KONFIRMASI --}}
    @if($selectedPeminjaman)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" x-data x-transition>
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" wire:click="closeDetail"></div>
            
            {{-- Modal Panel --}}
            <div class="relative w-full max-w-lg bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh] transform transition-all">
                
                {{-- Modal Header --}}
                <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
                    <div>
                        <h3 class="font-bold text-slate-800 text-lg">Proses Transaksi</h3>
                        <p class="text-xs text-slate-500 font-mono mt-0.5">{{ $selectedPeminjaman->kode_transaksi }}</p>
                    </div>
                    <button wire:click="closeDetail" class="text-slate-400 hover:text-rose-500 transition-colors p-1 rounded-full hover:bg-rose-50">
                        <x-heroicon-o-x-mark class="w-6 h-6" />
                    </button>
                </div>

                {{-- Modal Content --}}
                <div class="p-6 overflow-y-auto">
                    {{-- Info Siswa --}}
                    <div class="mb-5 flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold shrink-0">
                            {{ substr($selectedPeminjaman->siswa->nama_lengkap ?? 'X', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-bold uppercase tracking-wider mb-0.5">Peminjam</p>
                            <p class="font-bold text-slate-900 text-base">{{ $selectedPeminjaman->siswa->nama_lengkap }}</p>
                            <p class="text-sm text-slate-500">{{ $selectedPeminjaman->siswa->kelas->nama_kelas ?? '-' }} • {{ $selectedPeminjaman->siswa->nis }}</p>
                        </div>
                    </div>

                    {{-- Info Buku --}}
                    <div class="mb-5 bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase mb-3">Buku yang dipinjam</p>
                        <div class="space-y-3">
                            @foreach($selectedPeminjaman->detailPeminjaman as $detail)
                                <div class="flex items-start gap-3">
                                    <x-heroicon-o-book-open class="w-5 h-5 text-indigo-500 shrink-0 mt-0.5" />
                                    <div>
                                        <p class="text-sm text-slate-800 font-semibold leading-snug">{{ $detail->buku->judul_buku }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">
                                            {{ $detail->buku->penulis->pluck('nama_penulis')->implode(', ') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Info Tanggal --}}
                    <div class="grid grid-cols-2 gap-4 text-sm bg-white border border-slate-100 rounded-xl p-3">
                        <div>
                            <span class="block text-xs text-slate-400 mb-1">Tanggal Pinjam</span>
                            <p class="font-semibold text-slate-700">{{ date('d M Y', strtotime($selectedPeminjaman->tanggal_peminjaman)) }}</p>
                        </div>
                        <div>
                            <span class="block text-xs text-slate-400 mb-1">Jatuh Tempo</span>
                            <p class="font-semibold text-rose-600">{{ date('d M Y', strtotime($selectedPeminjaman->tanggal_jatuh_tempo)) }}</p>
                        </div>
                    </div>
                </div>

                {{-- Modal Footer (Tombol Aksi dengan Warna Solid) --}}
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                    @if($selectedPeminjaman->status_peminjaman == 'Pending')
                        <div class="flex gap-3">
                            <button wire:click="tolakPeminjaman({{ $selectedPeminjaman->peminjaman_id }})" 
                                    class="flex-1 py-2.5 px-4 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 shadow-md shadow-red-200 transition-colors">
                                Tolak
                            </button>
                            <button wire:click="setujuiPeminjaman({{ $selectedPeminjaman->peminjaman_id }})" 
                                    class="flex-1 py-2.5 px-4 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow-md shadow-indigo-200 transition-colors">
                                Setujui Peminjaman
                            </button>
                        </div>
                    @elseif($selectedPeminjaman->status_peminjaman == 'Menunggu Pengembalian')
                        <button wire:click="verifikasiPengembalian({{ $selectedPeminjaman->peminjaman_id }})" 
                                class="w-full py-3 px-4 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 shadow-md shadow-emerald-200 transition-colors flex items-center justify-center gap-2">
                            <x-heroicon-o-check-badge class="w-5 h-5"/>
                            Verifikasi Pengembalian
                        </button>
                    @else
                        {{-- Tombol Tutup Default berwarna Abu-abu (Bukan Putih Polos) --}}
                        <button wire:click="closeDetail" class="w-full py-2.5 bg-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-300 transition-colors">
                            Tutup
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>