<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in-up">
    <div class="mb-6 flex flex-col md:flex-row justify-between items-end gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Katalog Buku</h1>
            <p class="text-sm text-gray-500">Cari buku untuk dicek ketersediaannya.</p>
        </div>
        <div class="w-full md:w-1/3 relative">
            <x-heroicon-o-magnifying-glass class="w-5 h-5 absolute left-3 top-3 text-gray-400" />
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari Judul atau ISBN..." class="pl-10 w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 shadow-sm">
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @forelse($bukus as $buku)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                <div class="aspect-[3/4] bg-gray-100 relative overflow-hidden">
                    @if($buku->cover_buku)
                        <img src="{{ asset('storage/'.$buku->cover_buku) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300"><x-heroicon-o-book-open class="w-10 h-10"/></div>
                    @endif
                    <div class="absolute top-2 right-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-[10px] font-bold {{ $buku->jumlah_eksemplar_tersedia > 0 ? 'text-green-600' : 'text-red-500' }}">
                        {{ $buku->jumlah_eksemplar_tersedia }} Stok
                    </div>
                </div>
                <div class="p-3">
                    <h3 class="font-bold text-gray-900 text-sm line-clamp-2 leading-tight" title="{{ $buku->judul_buku }}">{{ $buku->judul_buku }}</h3>
                    
                    {{-- PERBAIKAN: Menggunakan lokasi_rak --}}
                    <div class="flex items-center gap-1 mt-2 text-xs text-gray-500">
                        <x-heroicon-o-map-pin class="w-3 h-3" /> 
                        {{ $buku->lokasi_rak ?? 'Rak -' }}
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-gray-400">
                <p>Tidak ada buku ditemukan.</p>
            </div>
        @endforelse
    </div>
    <div class="mt-6">{{ $bukus->links() }}</div>
</div>