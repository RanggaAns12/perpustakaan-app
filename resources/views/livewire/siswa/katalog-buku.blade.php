<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    {{-- Header Section --}}
    <div class="mb-8 animate-fade-in-up">
        <h1 class="text-3xl font-bold text-slate-800">Katalog Buku</h1>
        <p class="text-slate-500 mt-2 text-lg">Jelajahi koleksi ilmu pengetahuan tanpa batas.</p>
    </div>

    {{-- Search & Filter Bar --}}
    <div class="bg-white/60 backdrop-blur-xl border border-white/50 rounded-2xl p-6 shadow-sm mb-8 animate-fade-in-up delay-100">
        <div class="flex flex-col md:flex-row gap-4">
            {{-- Search Input --}}
            <div class="flex-grow relative group">
                <input wire:model.live.debounce.300ms="search" 
                       type="text" 
                       placeholder="Cari judul buku atau penulis..." 
                       class="w-full pl-12 pr-4 py-3.5 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all text-sm shadow-sm group-hover:border-indigo-300">
                <svg class="w-5 h-5 text-slate-400 absolute left-4 top-3.5 group-focus-within:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            {{-- Filter Kategori --}}
            <div class="w-full md:w-72 relative">
                <select wire:model.live="kategoriId" 
                        class="w-full pl-4 pr-10 py-3.5 bg-white border border-slate-200 rounded-xl focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all text-sm text-slate-600 shadow-sm appearance-none cursor-pointer">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->kategori_id }}">{{ $kategori->nama_kategori }} ({{ $kategori->bukus_count }})</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Grid Buku --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6 mb-8 animate-fade-in-up delay-200">
        @forelse($bukus as $buku)
            <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-100 overflow-hidden flex flex-col h-full">
                
                {{-- Cover Image --}}
                <div class="relative aspect-[2/3] overflow-hidden bg-slate-100 cursor-pointer" wire:click="showBook({{ $buku->buku_id }})">
                    @if($buku->cover_buku)
                        <img src="{{ asset('storage/' . $buku->cover_buku) }}" alt="{{ $buku->judul_buku }}" 
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 p-4 text-center">
                            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <span class="text-xs font-medium">No Cover</span>
                        </div>
                    @endif

                    <div class="absolute top-3 left-3">
                        <span class="bg-white/95 backdrop-blur-md text-indigo-700 text-[10px] font-bold px-2.5 py-1 rounded-lg shadow-sm">
                            {{ $buku->kategori->nama_kategori ?? 'Umum' }}
                        </span>
                    </div>

                    {{-- Hover Button --}}
                    <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <button class="bg-white text-slate-900 px-5 py-2 rounded-full font-bold text-xs shadow-lg transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300 hover:bg-indigo-50">
                            Lihat Detail
                        </button>
                    </div>
                </div>

                {{-- Book Info --}}
                <div class="p-4 flex flex-col flex-grow">
                    <h4 class="font-bold text-slate-800 text-sm leading-snug line-clamp-2 mb-1 group-hover:text-indigo-600 transition-colors cursor-pointer" 
                        wire:click="showBook({{ $buku->buku_id }})" title="{{ $buku->judul_buku }}">
                        {{ $buku->judul_buku }}
                    </h4>
                    
                    <p class="text-xs text-slate-500 mb-3 line-clamp-1">
                        {{ $buku->penulis->pluck('nama_penulis')->implode(', ') ?: 'Penulis tidak diketahui' }}
                    </p>
                    
                    <div class="mt-auto pt-3 border-t border-slate-50 flex items-center justify-between">
                        <div class="flex items-center gap-1.5">
                            <span class="relative flex h-2 w-2">
                              <span class="absolute inline-flex h-full w-full rounded-full {{ $buku->jumlah_eksemplar_tersedia > 0 ? 'bg-green-400' : 'bg-red-400' }} opacity-75 {{ $buku->jumlah_eksemplar_tersedia > 0 ? 'animate-ping' : '' }}"></span>
                              <span class="relative inline-flex rounded-full h-2 w-2 {{ $buku->jumlah_eksemplar_tersedia > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            </span>
                            <span class="text-[10px] font-medium {{ $buku->jumlah_eksemplar_tersedia > 0 ? 'text-green-600' : 'text-red-500' }}">
                                {{ $buku->jumlah_eksemplar_tersedia > 0 ? 'Tersedia' : 'Habis' }}
                            </span>
                        </div>
                        <span class="text-[10px] text-slate-400 font-medium">Stok: {{ $buku->jumlah_eksemplar_tersedia }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-16 flex flex-col items-center justify-center text-center bg-white rounded-3xl border border-dashed border-slate-200 shadow-sm">
                <div class="bg-indigo-50 p-4 rounded-full mb-4">
                    <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <h3 class="text-slate-900 font-medium text-lg">Tidak ada buku ditemukan</h3>
                <p class="text-slate-500 text-sm mt-1 max-w-xs mx-auto">Kami tidak dapat menemukan buku dengan kata kunci tersebut.</p>
            </div>
        @endforelse
    </div>

    <div class="mb-12">
        {{ $bukus->links() }} 
    </div>

    {{-- MODAL DETAIL BUKU --}}
    @if($selectedBook)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6" x-data x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" wire:click="closeBook"></div>

            {{-- Modal Content --}}
            <div class="relative w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden transform transition-all flex flex-col md:flex-row max-h-[90vh]">
                
                {{-- Close Button (Mobile) --}}
                <button wire:click="closeBook" class="absolute top-4 right-4 z-10 p-2 bg-white/20 backdrop-blur-md rounded-full text-slate-600 hover:bg-white hover:text-red-500 transition md:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                {{-- Left Side: Image --}}
                <div class="w-full md:w-2/5 bg-slate-100 relative h-64 md:h-auto flex-shrink-0">
                    @if($selectedBook->cover_buku)
                        <img src="{{ asset('storage/' . $selectedBook->cover_buku) }}" alt="Cover" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                            <svg class="w-16 h-16 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <span>No Cover Available</span>
                        </div>
                    @endif
                    
                    {{-- Status Overlay --}}
                    <div class="absolute bottom-0 left-0 right-0 p-4 bg-gradient-to-t from-black/70 to-transparent text-white">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full {{ $selectedBook->jumlah_eksemplar_tersedia > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                            <span class="font-medium text-sm">
                                {{ $selectedBook->jumlah_eksemplar_tersedia > 0 ? 'Tersedia: ' . $selectedBook->jumlah_eksemplar_tersedia : 'Stok Habis' }}
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Right Side: Details --}}
                <div class="w-full md:w-3/5 p-6 md:p-8 overflow-y-auto bg-white flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <span class="inline-block py-1 px-3 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold uppercase tracking-wider mb-2">
                                {{ $selectedBook->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                            <h2 class="text-2xl font-bold text-slate-800 leading-tight">{{ $selectedBook->judul_buku }}</h2>
                        </div>
                        <button wire:click="closeBook" class="hidden md:block p-2 rounded-full hover:bg-slate-100 text-slate-400 hover:text-red-500 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    {{-- Metadata Grid --}}
                    <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="block text-xs text-slate-400 uppercase font-bold tracking-wider mb-1">Penulis</span>
                            <span class="font-semibold text-slate-700 block truncate" title="{{ $selectedBook->penulis->pluck('nama_penulis')->implode(', ') }}">
                                {{ $selectedBook->penulis->pluck('nama_penulis')->implode(', ') ?: '-' }}
                            </span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="block text-xs text-slate-400 uppercase font-bold tracking-wider mb-1">Penerbit</span>
                            <span class="font-semibold text-slate-700 block truncate">
                                {{ $selectedBook->penerbit->nama_penerbit ?? '-' }}
                            </span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="block text-xs text-slate-400 uppercase font-bold tracking-wider mb-1">Tahun Terbit</span>
                            <span class="font-semibold text-slate-700">
                                {{ $selectedBook->tahun_terbit }}
                            </span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="block text-xs text-slate-400 uppercase font-bold tracking-wider mb-1">ISBN</span>
                            <span class="font-semibold text-slate-700 font-mono">
                                {{ $selectedBook->isbn ?? '-' }}
                            </span>
                        </div>
                    </div>

                    {{-- Sinopsis --}}
                    <div class="prose prose-sm text-slate-600 mb-6 flex-grow overflow-y-auto max-h-48 pr-2 custom-scrollbar">
                        <h4 class="font-bold text-slate-800 mb-2">Sinopsis</h4>
                        <p class="leading-relaxed">
                            {{ $selectedBook->sinopsis ?? 'Tidak ada sinopsis untuk buku ini.' }}
                        </p>
                    </div>

                    {{-- Action Footer --}}
                <div class="pt-4 border-t border-slate-100 mt-auto flex items-center justify-between">
                    <div class="text-xs text-slate-400">
                        Lokasi Rak: <span class="font-semibold text-slate-600">{{ $selectedBook->lokasi_rak ?? 'Belum diatur' }}</span>
                    </div>
                    
                    @if($selectedBook->jumlah_eksemplar_tersedia > 0)
                        <a href="{{ route('siswa.peminjaman.create', $selectedBook->buku_id) }}" wire:navigate
                        class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 hover:shadow-lg hover:shadow-indigo-200 transition-all duration-300 transform active:scale-95 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Pinjam Buku Ini
                        </a>
                    @else
                        <button disabled class="px-6 py-2.5 bg-slate-200 text-slate-400 font-medium rounded-xl cursor-not-allowed">
                            Stok Habis
                        </button>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>