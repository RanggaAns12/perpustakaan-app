<div>
    {{-- 1. HERO SECTION --}}
    <div class="relative rounded-3xl overflow-hidden bg-gradient-to-r from-indigo-600 to-purple-600 shadow-2xl shadow-indigo-200 mb-12 animate-fade-in-up">
        
        {{-- Dekorasi Latar --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-black/10 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

        <div class="relative z-10 p-8 md:p-12 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="text-white text-center md:text-left">
                <h1 class="text-3xl md:text-5xl font-extrabold mb-4 leading-tight">
                    Halo, {{ explode(' ', $siswa->nama_lengkap ?? 'Siswa')[0] }}! 👋
                </h1>
                <p class="text-indigo-100 text-lg mb-8 max-w-lg">
                    Dunia pengetahuan menunggumu. Jangan lupa kembalikan buku tepat waktu ya!
                </p>
                
                {{-- Search Bar Mewah --}}
                <div class="relative max-w-md w-full">
                    <input type="text" placeholder="Cari judul buku, penulis..." 
                           class="w-full pl-12 pr-4 py-4 rounded-2xl border-none focus:ring-4 focus:ring-indigo-400/50 shadow-lg text-slate-800 placeholder-slate-400 transition-all">
                    <svg class="w-6 h-6 text-indigo-500 absolute left-4 top-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </div>

            {{-- Info Card Transparan --}}
            <div class="bg-white/20 backdrop-blur-md border border-white/30 p-6 rounded-2xl text-white w-full md:w-auto min-w-[200px] text-center transform hover:scale-105 transition duration-300">
                <div class="text-indigo-100 text-sm font-medium uppercase tracking-wider mb-1">Sedang Dipinjam</div>
                <div class="text-5xl font-extrabold">{{ $sedangDipinjam }}</div>
                <div class="text-xs mt-2 bg-white/20 px-2 py-1 rounded-full inline-block">Buku</div>
            </div>
        </div>
    </div>

    {{-- 2. KATEGORI PILLS --}}
    <div class="mb-10 overflow-x-auto pb-4 hide-scrollbar animate-fade-in-up delay-100">
        <div class="flex gap-4">
            @foreach($kategoris as $kategori)
                <a href="#" class="flex-shrink-0 px-6 py-3 bg-white border border-slate-100 rounded-full shadow-sm text-slate-600 font-medium hover:bg-indigo-600 hover:text-white hover:shadow-indigo-300 hover:shadow-lg transition-all duration-300">
                    {{ $kategori->nama_kategori }}
                </a>
            @endforeach
            <a href="#" class="flex-shrink-0 px-6 py-3 bg-slate-100 rounded-full text-slate-500 font-medium hover:bg-slate-200 transition">
                Lihat Semua
            </a>
        </div>
    </div>

    {{-- 3. BUKU TERBARU GRID --}}
    <div class="animate-fade-in-up delay-200">
        <div class="flex justify-between items-end mb-6">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Buku Terbaru</h2>
                <p class="text-slate-500 text-sm mt-1">Koleksi yang baru saja mendarat di rak.</p>
            </div>
            <a href="#" class="text-indigo-600 font-semibold hover:text-indigo-800 transition flex items-center gap-1">
                Lihat Semua <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6">
            @foreach($bukuTerbaru as $buku)
                <div class="group relative bg-white rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-2 transition-all duration-300 border border-slate-100 overflow-hidden h-full flex flex-col">
                    {{-- Cover Image --}}
                    <div class="aspect-[2/3] w-full bg-slate-200 relative overflow-hidden">
                        @if($buku->cover_buku)
                            <img src="{{ asset('storage/' . $buku->cover_buku) }}" alt="{{ $buku->judul_buku }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-slate-400 bg-slate-100">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            </div>
                        @endif
                        
                        {{-- Badge Kategori --}}
                        <div class="absolute top-3 left-3">
                            <span class="bg-white/90 backdrop-blur-sm text-indigo-600 text-[10px] font-bold px-2 py-1 rounded-lg shadow-sm">
                                {{ $buku->kategori->nama_kategori ?? 'Umum' }}
                            </span>
                        </div>

                        {{-- Overlay Hover --}}
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                            <button class="bg-white text-indigo-600 px-4 py-2 rounded-full font-bold text-sm shadow-lg transform translate-y-4 group-hover:translate-y-0 transition duration-300">
                                Lihat Detail
                            </button>
                        </div>
                    </div>

                    {{-- Info Buku --}}
                    <div class="p-4 flex flex-col flex-grow">
                        <h3 class="font-bold text-slate-800 text-base leading-snug line-clamp-2 mb-1 group-hover:text-indigo-600 transition-colors">
                            {{ $buku->judul_buku }}
                        </h3>
                        <p class="text-xs text-slate-500 mb-3">{{ $buku->penulis->first()->nama_penulis ?? 'Penulis tidak diketahui' }}</p>
                        
                        <div class="mt-auto flex items-center justify-between pt-3 border-t border-slate-50">
                            <div class="flex items-center gap-1 text-xs font-medium {{ $buku->jumlah_eksemplar_tersedia > 0 ? 'text-green-600' : 'text-red-500' }}">
                                <span class="w-2 h-2 rounded-full {{ $buku->jumlah_eksemplar_tersedia > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                {{ $buku->jumlah_eksemplar_tersedia > 0 ? 'Tersedia' : 'Habis' }}
                            </div>
                            <span class="text-xs text-slate-400">{{ $buku->tahun_terbit }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- 4. SECTION PROMOSI / QUOTE --}}
    <div class="mt-16 bg-slate-900 rounded-3xl p-8 md:p-12 text-center text-white relative overflow-hidden animate-fade-in-up delay-300">
        <div class="relative z-10 max-w-2xl mx-auto">
            <h2 class="text-2xl md:text-3xl font-bold mb-4">"Buku adalah liburan paling murah yang bisa kau beli."</h2>
            <p class="text-slate-400 italic">- Arturo Pérez-Reverte</p>
        </div>
        {{-- Abstract circles --}}
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="w-full h-full text-indigo-500 fill-current">
                <circle cx="0" cy="100" r="50" />
                <circle cx="100" cy="0" r="30" />
            </svg>
        </div>
    </div>
</div>