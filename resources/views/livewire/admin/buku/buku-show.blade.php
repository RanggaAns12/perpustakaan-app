<div class="max-w-5xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('buku.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-1">
            <x-heroicon-o-arrow-left class="w-4 h-4" /> Kembali ke Daftar
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-3">
            {{-- Kolom Kiri: Cover --}}
            <div class="bg-gray-50 p-8 flex items-start justify-center border-r border-gray-100">
                <div class="relative group">
                    @if($buku->cover_buku)
                        <img src="{{ asset('storage/' . $buku->cover_buku) }}" alt="{{ $buku->judul_buku }}" class="w-64 rounded-lg shadow-2xl rotate-2 group-hover:rotate-0 transition duration-500">
                    @else
                        <div class="w-64 h-96 bg-gray-200 rounded-lg shadow-inner flex items-center justify-center text-gray-400">
                            <div class="text-center">
                                <x-heroicon-o-book-open class="w-16 h-16 mx-auto mb-2" />
                                <span>No Cover</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Kolom Kanan: Detail Info --}}
            <div class="col-span-2 p-8">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm font-semibold tracking-wide">
                            {{ $buku->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                        </span>
                        <h1 class="text-3xl font-extrabold text-gray-900 mt-3 leading-tight">{{ $buku->judul_buku }}</h1>
                        <p class="text-gray-500 mt-1">ISBN: <span class="font-mono text-gray-700">{{ $buku->isbn }}</span></p>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('buku.edit', $buku->buku_id) }}" class="p-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition">
                            <x-heroicon-o-pencil-square class="w-5 h-5" />
                        </a>
                    </div>
                </div>

                {{-- Penulis & Penerbit --}}
                <div class="grid grid-cols-2 gap-6 mb-8">
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Penulis</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($buku->penulis as $penulis)
                                <span class="text-gray-800 font-medium bg-gray-100 px-2 py-1 rounded">{{ $penulis->nama_penulis }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Penerbit</h3>
                        <p class="text-gray-800 font-medium">{{ $buku->penerbit->nama_penerbit ?? '-' }}</p>
                        <p class="text-xs text-gray-500">{{ $buku->tahun_terbit }}</p>
                    </div>
                </div>

                {{-- Statistik --}}
                <div class="grid grid-cols-3 gap-4 mb-8 bg-gray-50 p-4 rounded-xl border border-gray-100">
                    <div class="text-center">
                        <p class="text-xs text-gray-500">Stok Tersedia</p>
                        <p class="text-xl font-bold {{ $buku->jumlah_eksemplar_tersedia > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $buku->jumlah_eksemplar_tersedia }}
                        </p>
                    </div>
                    <div class="text-center border-l border-gray-200">
                        <p class="text-xs text-gray-500">Total Stok</p>
                        <p class="text-xl font-bold text-gray-800">{{ $buku->jumlah_eksemplar_total }}</p>
                    </div>
                    <div class="text-center border-l border-gray-200">
                        <p class="text-xs text-gray-500">Lokasi Rak</p>
                        <p class="text-xl font-bold text-indigo-600">{{ $buku->lokasi_rak }}</p>
                    </div>
                </div>

                {{-- Sinopsis --}}
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Sinopsis</h3>
                    <p class="text-gray-600 leading-relaxed text-justify">
                        {{ $buku->sinopsis ?? 'Tidak ada sinopsis.' }}
                    </p>
                </div>

                {{-- Info Tambahan --}}
                <div class="border-t border-gray-100 pt-6 grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">Jumlah Halaman:</span>
                        <span class="text-gray-800 font-medium ml-2">{{ $buku->jumlah_halaman }} Hal</span>
                    </div>
                    <div>
                        <span class="text-gray-500">Bahasa:</span>
                        <span class="text-gray-800 font-medium ml-2">{{ $buku->bahasa }}</span>
                    </div>
                    <div class="col-span-2">
                        <span class="text-gray-500">Ditambahkan Oleh:</span>
                        <span class="text-gray-800 font-medium ml-2">{{ $buku->createdBy->username ?? 'System' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>