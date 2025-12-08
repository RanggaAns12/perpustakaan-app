<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Detail Transaksi</h2>
            <p class="text-sm text-gray-500 mt-1">Kode: <span class="font-mono font-bold text-indigo-600">{{ $peminjaman->kode_transaksi }}</span></p>
        </div>
        <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
            <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" /> Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Kolom Kiri: Status & Info Siswa --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-4">Status Transaksi</h3>
                
                <div class="flex justify-center py-4">
                    @php
                        $statusColor = match($peminjaman->status_peminjaman) {
                            'Dipinjam' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                            'Dikembalikan' => 'bg-green-100 text-green-800 border-green-200',
                            'Terlambat' => 'bg-red-100 text-red-800 border-red-200',
                            default => 'bg-gray-100 text-gray-800'
                        };
                    @endphp
                    <span class="px-4 py-1.5 rounded-full font-bold border {{ $statusColor }}">
                        {{ $peminjaman->status_peminjaman }}
                    </span>
                </div>

                <div class="border-t border-gray-100 pt-4 space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Tanggal Pinjam</span>
                        <span class="font-medium">{{ date('d M Y', strtotime($peminjaman->tanggal_peminjaman)) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Jatuh Tempo</span>
                        <span class="font-medium text-red-600">{{ date('d M Y', strtotime($peminjaman->tanggal_jatuh_tempo)) }}</span>
                    </div>
                    @if($peminjaman->pengembalian)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Dikembalikan</span>
                            <span class="font-medium text-green-600">{{ date('d M Y', strtotime($peminjaman->pengembalian->tanggal_pengembalian)) }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wide mb-4">Peminjam</h3>
                <div class="flex items-center gap-4">
                    <div class="h-12 w-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-lg">
                        {{ substr($peminjaman->siswa->nama_lengkap, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-bold text-gray-900">{{ $peminjaman->siswa->nama_lengkap }}</p>
                        <p class="text-xs text-gray-500">{{ $peminjaman->siswa->nis }} • {{ $peminjaman->siswa->kelas->nama_kelas ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Daftar Buku & Info Denda --}}
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-gray-900">Buku yang Dipinjam</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($peminjaman->detailPeminjaman as $detail)
                        <div class="p-4 flex items-start gap-4 hover:bg-gray-50 transition">
                            <div class="h-16 w-12 bg-gray-200 rounded flex-shrink-0 overflow-hidden">
                                @if($detail->buku->cover_buku)
                                    <img src="{{ asset('storage/'.$detail->buku->cover_buku) }}" class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full flex items-center justify-center text-gray-400"><x-heroicon-o-book-open class="w-6 h-6" /></div>
                                @endif
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 text-sm">{{ $detail->buku->judul_buku }}</h4>
                                <p class="text-xs text-gray-500 mt-1">Kondisi Awal: {{ $detail->kondisi_buku_saat_pinjam }}</p>
                                @if($peminjaman->pengembalian)
                                    @php
                                        $detailKembali = $peminjaman->pengembalian->detailPengembalian->where('buku_id', $detail->buku_id)->first();
                                    @endphp
                                    <p class="text-xs text-green-600 mt-0.5">
                                        Kondisi Kembali: {{ $detailKembali->kondisi_buku_saat_kembali ?? '-' }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if($peminjaman->pengembalian && $peminjaman->pengembalian->denda)
                <div class="bg-red-50 rounded-2xl border border-red-100 p-6">
                    <h3 class="font-bold text-red-800 flex items-center gap-2 mb-4">
                        <x-heroicon-o-exclamation-triangle class="w-5 h-5" /> Info Denda
                    </h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="text-gray-600 block">Terlambat</span>
                            <span class="font-bold text-gray-900">{{ $peminjaman->pengembalian->denda->jumlah_hari_terlambat }} Hari</span>
                        </div>
                        <div>
                            <span class="text-gray-600 block">Total Denda</span>
                            <span class="font-bold text-red-600 text-lg">Rp {{ number_format($peminjaman->pengembalian->denda->total_denda, 0, ',', '.') }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 block">Status Pembayaran</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded text-xs font-bold {{ $peminjaman->pengembalian->denda->status_denda == 'Lunas' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                {{ $peminjaman->pengembalian->denda->status_denda }}
                            </span>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>