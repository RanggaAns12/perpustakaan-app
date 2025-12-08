<div class="min-h-screen bg-gray-50/50 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 animate-fade-in-up">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Laporan Perpustakaan</h1>
                <p class="text-gray-500 mt-2">Analisis dan rekapitulasi data sirkulasi buku.</p>
            </div>
            
            {{-- Tombol Cetak PDF (Floating Style) --}}
            <button wire:click="cetakPdf" 
                    wire:loading.attr="disabled"
                    class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-red-600 to-rose-600 text-white font-semibold rounded-xl shadow-lg shadow-red-200 hover:shadow-red-300 hover:-translate-y-0.5 transition-all duration-200 disabled:opacity-70 disabled:cursor-not-allowed group">
                
                {{-- Loading Icon --}}
                <svg wire:loading wire:target="cetakPdf" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

                {{-- Printer Icon --}}
                <x-heroicon-o-printer class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" wire:loading.remove wire:target="cetakPdf" />
                
                <span wire:loading.remove wire:target="cetakPdf">Export PDF</span>
                <span wire:loading wire:target="cetakPdf">Memproses...</span>
            </button>
        </div>

        {{-- Filter Section (Sticky & Glass Effect) --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-1 mb-8 sticky top-20 z-20 backdrop-blur-xl bg-white/90 transition-all hover:shadow-md">
            <form wire:submit.prevent="filter" class="grid grid-cols-1 md:grid-cols-12 gap-2 p-2">
                
                {{-- Tanggal Mulai --}}
                <div class="md:col-span-3 relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <x-heroicon-o-calendar class="h-5 w-5" />
                    </div>
                    <input type="date" wire:model="tanggal_mulai" class="block w-full pl-10 pr-3 py-2.5 bg-gray-50 border-transparent focus:bg-white border focus:border-indigo-500 rounded-xl text-sm transition-all" title="Dari Tanggal" />
                </div>

                {{-- Tanggal Selesai --}}
                <div class="md:col-span-3 relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <x-heroicon-o-arrow-right class="h-4 w-4" />
                    </div>
                    <input type="date" wire:model="tanggal_selesai" class="block w-full pl-10 pr-3 py-2.5 bg-gray-50 border-transparent focus:bg-white border focus:border-indigo-500 rounded-xl text-sm transition-all" title="Sampai Tanggal" />
                </div>

                {{-- Status Filter --}}
                <div class="md:col-span-3 relative group">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <x-heroicon-o-funnel class="h-5 w-5" />
                    </div>
                    <select wire:model="status_filter" class="block w-full pl-10 pr-10 py-2.5 bg-gray-50 border-transparent focus:bg-white border focus:border-indigo-500 rounded-xl text-sm appearance-none cursor-pointer transition-all">
                        <option value="">Semua Status</option>
                        <option value="Dipinjam">Sedang Dipinjam</option>
                        <option value="Dikembalikan">Sudah Kembali</option>
                        <option value="Terlambat">Terlambat</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                        <x-heroicon-o-chevron-down class="h-4 w-4" />
                    </div>
                </div>

                {{-- Tombol Terapkan --}}
                <div class="md:col-span-3">
                    <button type="submit" class="w-full h-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl shadow-md shadow-indigo-200 transition-all flex items-center justify-center gap-2">
                        <x-heroicon-o-magnifying-glass class="w-5 h-5" />
                        Filter Data
                    </button>
                </div>
            </form>
        </div>

        {{-- Summary Cards (Dashboard Style) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            {{-- Total Transaksi --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group relative overflow-hidden">
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Total Transaksi</p>
                        <h3 class="text-3xl font-bold text-gray-900 mt-1 group-hover:text-indigo-600 transition-colors">{{ number_format($summary['total']) }}</h3>
                    </div>
                    <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                        <x-heroicon-o-clipboard-document-list class="w-8 h-8" />
                    </div>
                </div>
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-indigo-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
            </div>

            {{-- Buku Dipinjam --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group relative overflow-hidden">
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Sedang Dipinjam</p>
                        <h3 class="text-3xl font-bold text-yellow-600 mt-1">{{ number_format($summary['dipinjam']) }}</h3>
                    </div>
                    <div class="p-3 bg-yellow-50 rounded-xl text-yellow-600 group-hover:bg-yellow-500 group-hover:text-white transition-colors duration-300">
                        <x-heroicon-o-clock class="w-8 h-8" />
                    </div>
                </div>
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-yellow-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
            </div>

            {{-- Buku Kembali --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group relative overflow-hidden">
                <div class="flex justify-between items-start relative z-10">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Berhasil Kembali</p>
                        <h3 class="text-3xl font-bold text-green-600 mt-1">{{ number_format($summary['dikembalikan']) }}</h3>
                    </div>
                    <div class="p-3 bg-green-50 rounded-xl text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                        <x-heroicon-o-check-circle class="w-8 h-8" />
                    </div>
                </div>
                <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-green-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
            </div>
        </div>

        {{-- Data Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex items-center gap-2">
                <div class="w-2 h-6 bg-indigo-500 rounded-full"></div>
                <h3 class="font-bold text-gray-800">Rincian Data</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/30 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                            <th class="px-6 py-4 rounded-tl-2xl">Tanggal & Kode</th>
                            <th class="px-6 py-4">Siswa</th>
                            <th class="px-6 py-4">Buku</th>
                            <th class="px-6 py-4 text-center rounded-tr-2xl">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($laporans as $row)
                            <tr class="group hover:bg-indigo-50/30 transition-colors duration-200">
                                {{-- Tanggal & Kode --}}
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-medium text-gray-900">
                                            {{ date('d M Y', strtotime($row->tanggal_peminjaman)) }}
                                        </span>
                                        <span class="text-xs font-mono font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded w-fit mt-1 group-hover:bg-indigo-100 transition-colors">
                                            {{ $row->kode_transaksi }}
                                        </span>
                                    </div>
                                </td>

                                {{-- Siswa --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-9 w-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 text-xs font-bold shrink-0 border border-gray-200">
                                            {{ substr($row->siswa->nama_lengkap ?? 'X', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900 line-clamp-1">{{ $row->siswa->nama_lengkap ?? 'Siswa Dihapus' }}</div>
                                            <div class="text-xs text-gray-500">{{ $row->siswa->kelas->nama_kelas ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Detail Buku --}}
                                <td class="px-6 py-4">
                                    <div class="space-y-1.5">
                                        @foreach($row->detailPeminjaman as $det)
                                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                                <x-heroicon-o-book-open class="w-4 h-4 text-gray-400" />
                                                <span class="truncate max-w-[220px]" title="{{ $det->buku->judul_buku ?? '-' }}">
                                                    {{ $det->buku->judul_buku ?? 'Buku Dihapus' }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-4 text-center">
                                    @php
                                        $statusClass = match($row->status_peminjaman) {
                                            'Dipinjam' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'Dikembalikan' => 'bg-green-100 text-green-800 border-green-200',
                                            'Terlambat' => 'bg-red-100 text-red-800 border-red-200',
                                            default => 'bg-gray-100 text-gray-800 border-gray-200'
                                        };
                                    @endphp
                                    <div class="inline-flex flex-col items-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $statusClass }}">
                                            {{ $row->status_peminjaman }}
                                        </span>
                                        @if($row->status_peminjaman == 'Dipinjam')
                                            <span class="text-[10px] text-gray-400 mt-1">
                                                Jatuh Tempo: {{ date('d/m', strtotime($row->tanggal_jatuh_tempo)) }}
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <div class="p-4 bg-gray-50 rounded-full mb-3">
                                            <x-heroicon-o-inbox class="w-8 h-8 opacity-50" />
                                        </div>
                                        <p class="text-sm font-medium">Tidak ada data transaksi pada periode ini.</p>
                                        <p class="text-xs text-gray-400 mt-1">Coba ubah filter tanggal.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $laporans->links() }}
            </div>
        </div>

    </div>
</div>