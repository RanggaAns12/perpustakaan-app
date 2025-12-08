<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    {{-- NOTIFIKASI KETERLAMBATAN --}}
    @if($bukuTerlambat->count() > 0)
        <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-6 rounded-r-xl shadow-sm animate-pulse flex items-start gap-4">
            <div class="bg-red-100 p-2 rounded-full text-red-600">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-red-800">Peringatan Jatuh Tempo!</h3>
                <div class="mt-2 text-sm text-red-700">
                    <p class="mb-2">Anda memiliki {{ $bukuTerlambat->count() }} buku yang melewati batas waktu pengembalian:</p>
                    <ul class="list-disc list-inside space-y-1 font-medium bg-red-100/50 p-3 rounded-lg">
                        @foreach($bukuTerlambat as $item)
                            <li>{{ $item->detailPeminjaman->first()->buku->judul_buku ?? 'Judul Buku' }} (Tempo: {{ $item->tanggal_jatuh_tempo->format('d M Y') }})</li>
                        @endforeach
                    </ul>
                    <p class="mt-3 font-semibold">Segera lakukan pengembalian ke perpustakaan untuk menghindari denda lebih lanjut.</p>
                </div>
            </div>
        </div>
    @endif

    {{-- HERO SECTION --}}
    <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-indigo-600 via-purple-600 to-indigo-800 shadow-2xl shadow-indigo-200 mb-10 animate-fade-in-up group">
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2 group-hover:bg-white/20 transition duration-700"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-black/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>

        <div class="relative z-10 p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="text-white text-center md:text-left space-y-4 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-xs font-medium text-indigo-100 border border-white/20">
                    <span>✨ Perpustakaan Digital</span>
                </div>
                <h1 class="text-3xl md:text-5xl font-bold leading-tight tracking-tight">
                    {{ $greeting }}, <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-200 to-amber-400">
                        {{ explode(' ', $siswa->nama_lengkap ?? 'Siswa')[0] }}!
                    </span> 👋
                </h1>
                <p class="text-indigo-100 text-lg md:text-xl font-light leading-relaxed opacity-90">
                    "Buku adalah jendela dunia. Apa yang ingin kamu jelajahi hari ini?"
                </p>
                
                <div class="pt-4 relative w-full md:max-w-md group-focus-within:scale-105 transition-transform duration-300">
                    <input type="text" placeholder="Cari judul buku, penulis, atau kategori..." 
                           class="w-full pl-12 pr-4 py-4 rounded-2xl bg-white/95 border-none focus:ring-4 focus:ring-indigo-400/50 shadow-xl text-slate-800 placeholder-slate-400 transition-all font-medium">
                    <svg class="w-6 h-6 text-indigo-500 absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 w-full md:w-auto">
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-5 rounded-2xl text-center hover:bg-white/20 transition duration-300">
                    <div class="text-indigo-200 text-xs font-bold uppercase tracking-wider mb-1">Dipinjam</div>
                    <div class="text-3xl md:text-4xl font-extrabold text-white">{{ $sedangDipinjam }}</div>
                    <div class="text-[10px] text-white/70 mt-1">Buku Aktif</div>
                </div>
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-5 rounded-2xl text-center hover:bg-white/20 transition duration-300">
                    <div class="text-pink-200 text-xs font-bold uppercase tracking-wider mb-1">Denda</div>
                    <div class="text-xl md:text-2xl font-extrabold text-white truncate">
                        {{ $totalDenda > 0 ? 'Rp ' . number_format($totalDenda, 0, ',', '.') : 'Rp 0' }}
                    </div>
                    <div class="text-[10px] {{ $totalDenda > 0 ? 'text-pink-300 animate-pulse' : 'text-green-300' }} mt-1">
                        {{ $totalDenda > 0 ? 'Belum Lunas' : 'Aman' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- KATEGORI --}}
    <div class="mb-10 animate-fade-in-up delay-100">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                Kategori Populer
            </h3>
        </div>
        
        <div class="flex gap-3 overflow-x-auto pb-4 hide-scrollbar snap-x">
            @foreach($kategoris as $kategori)
                <a href="#" class="snap-start flex-shrink-0 group relative overflow-hidden px-6 py-3 rounded-xl bg-white border border-slate-100 shadow-sm hover:shadow-md transition-all duration-300">
                    <div class="absolute inset-0 bg-indigo-50 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-300"></div>
                    <div class="relative flex items-center gap-2">
                        <span class="font-semibold text-slate-600 group-hover:text-indigo-700 transition-colors">{{ $kategori->nama_kategori }}</span>
                        <span class="bg-slate-100 text-slate-500 text-[10px] px-2 py-0.5 rounded-full group-hover:bg-indigo-200 group-hover:text-indigo-700 transition-colors">
                            {{ $kategori->bukus_count }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    {{-- BUKU TERBARU --}}
    <div class="animate-fade-in-up delay-200 mb-16">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Koleksi Terbaru</h2>
                <p class="text-slate-500 text-sm mt-1">Buku-buku segar yang baru mendarat di rak.</p>
            </div>
            <a href="{{ route('siswa.katalog') }}" class="group flex items-center gap-1 text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">
                Lihat Semua
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @forelse($bukuTerbaru as $buku)
                <div class="group relative flex flex-col bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 overflow-hidden h-full">
                    <div class="relative aspect-[2/3] overflow-hidden bg-slate-100">
                        @if($buku->cover_buku)
                            <img src="{{ asset('storage/' . $buku->cover_buku) }}" alt="{{ $buku->judul_buku }}" 
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 p-4 text-center">
                                <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <span class="text-xs font-medium">No Cover</span>
                            </div>
                        @endif
                        <div class="absolute top-3 left-3 z-10">
                            <span class="bg-white/90 backdrop-blur-md text-indigo-700 text-[10px] font-bold px-2.5 py-1 rounded-lg shadow-sm">
                                {{ $buku->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </div>
                    </div>

                    <div class="p-4 flex flex-col flex-grow">
                        <h4 class="font-bold text-slate-800 text-sm leading-snug line-clamp-2 mb-1 group-hover:text-indigo-600 transition-colors" title="{{ $buku->judul_buku }}">
                            {{ $buku->judul_buku }}
                        </h4>
                        <p class="text-xs text-slate-500 mb-3 line-clamp-1">
                            {{ $buku->penulis->pluck('nama_penulis')->implode(', ') ?: 'Penulis tidak diketahui' }}
                        </p>
                        
                        <div class="mt-auto pt-3 border-t border-slate-50 flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="relative flex h-2 w-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $buku->jumlah_eksemplar_tersedia > 0 ? 'bg-green-400' : 'bg-red-400' }} opacity-75"></span>
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
                <div class="col-span-full py-12 flex flex-col items-center justify-center text-center bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                    <div class="bg-white p-4 rounded-full shadow-sm mb-3">
                        <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <p class="text-slate-500 font-medium">Belum ada buku yang ditambahkan.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>