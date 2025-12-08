<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Katalog Buku</h1>
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari Judul atau ISBN..." class="mt-4 w-full md:w-1/3 border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500">
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-6">
        @foreach($bukus as $buku)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                <div class="aspect-[3/4] bg-gray-100 relative">
                    @if($buku->cover_buku)
                        <img src="{{ asset('storage/'.$buku->cover_buku) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400"><x-heroicon-o-book-open class="w-8 h-8"/></div>
                    @endif
                    <div class="absolute top-2 right-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded text-xs font-bold text-indigo-600">
                        {{ $buku->jumlah_eksemplar_tersedia }} Stok
                    </div>
                </div>
                <div class="p-3">
                    <h3 class="font-bold text-gray-900 text-sm line-clamp-2" title="{{ $buku->judul_buku }}">{{ $buku->judul_buku }}</h3>
                    <p class="text-xs text-gray-500 mt-1">{{ $buku->rak_penyimpanan }}</p>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-6">{{ $bukus->links() }}</div>
</div>