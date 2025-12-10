<div class="font-sans text-slate-900 antialiased selection:bg-indigo-500 selection:text-white">
    
    @push('styles')
        <style>
            .glass-nav { 
                background: rgba(255, 255, 255, 0.85); 
                backdrop-filter: blur(16px); 
                border-bottom: 1px solid rgba(255,255,255,0.5); 
                box-shadow: 0 4px 30px rgba(0, 0, 0, 0.03);
            }
            /* Efek hover pada kartu buku */
            .book-card-hover:hover {
                transform: translateY(-5px);
                box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            }
        </style>
    @endpush

    {{-- NAVBAR --}}
    <nav class="fixed w-full z-50 top-0 transition-all duration-300 glass-nav" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                {{-- Logo & Identitas Sekolah --}}
                <div class="flex items-center gap-3" data-aos="fade-down">
                    <div class="relative w-10 h-10 group cursor-pointer">
                        <img src="{{ Vite::asset('resources/images/logo.png') }}" 
                             alt="Logo SMAN 1" 
                             class="w-full h-full object-contain drop-shadow-md transition-transform group-hover:scale-110 group-hover:rotate-3">
                    </div>
                    <div class="flex flex-col leading-none">
                        <span class="font-extrabold text-lg text-slate-900 tracking-tight">Perpustakaan</span>
                        <span class="text-[0.65rem] font-bold text-indigo-600 uppercase tracking-widest">SMA Negeri 1 Tanjung Morawa</span>
                    </div>
                </div>

                {{-- Menu Desktop --}}
                <div class="hidden md:flex items-center gap-8 font-medium text-sm text-slate-600" data-aos="fade-down" data-aos-delay="100">
                    <a href="#beranda" class="hover:text-indigo-600 transition relative group py-2">
                        Beranda
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 transition-all group-hover:w-full"></span>
                    </a>
                    <a href="#koleksi" class="hover:text-indigo-600 transition relative group py-2">
                        Koleksi
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 transition-all group-hover:w-full"></span>
                    </a>
                    <a href="#galeri" class="hover:text-indigo-600 transition relative group py-2">
                        Galeri
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-indigo-600 transition-all group-hover:w-full"></span>
                    </a>
                </div>

                {{-- Auth Buttons --}}
                <div class="flex items-center gap-3" data-aos="fade-down" data-aos-delay="200">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-full hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-0.5 transition-all text-sm">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2.5 bg-slate-900 text-white font-bold rounded-full hover:bg-slate-800 hover:shadow-lg hover:-translate-y-0.5 transition-all text-sm flex items-center gap-2">
                            <x-heroicon-o-arrow-right-end-on-rectangle class="w-4 h-4" /> Masuk
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- HERO SECTION --}}
    <section id="beranda" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                {{-- Text Content --}}
                <div class="order-2 lg:order-1">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-indigo-100 shadow-sm mb-6" data-aos="fade-up">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-500"></span>
                        </span>
                        <span class="text-xs font-bold text-indigo-900 uppercase tracking-wider">Official Digital Library</span>
                    </div>
                    
                    <h1 class="text-5xl lg:text-7xl font-extrabold text-slate-900 leading-tight mb-6" data-aos="fade-up" data-aos-delay="100">
                        {{ $data['judul_hero'] ?? 'Jelajahi Jendela Dunia.' }}
                    </h1>
                    
                    <p class="text-lg text-slate-600 mb-8 max-w-lg leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                        {{ $data['deskripsi_hero'] ?? 'Akses ribuan koleksi buku fisik dan digital untuk menunjang prestasi siswa SMA Negeri 1 Tanjung Morawa.' }}
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4" data-aos="fade-up" data-aos-delay="300">
                        <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-8 py-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-full hover:shadow-xl hover:shadow-indigo-200 hover:-translate-y-1 transition-all duration-300">
                            {{ $data['text_cta'] ?? 'Mulai Membaca' }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 ml-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- Hero Image --}}
                <div class="relative lg:ml-auto order-1 lg:order-2" data-aos="fade-left" data-aos-delay="200">
                    <div class="relative z-10 animate-float">
                        @if(isset($data['gambar_hero']) && $data['gambar_hero'])
                            <img src="{{ asset('storage/' . $data['gambar_hero']) }}" alt="Library" class="rounded-[2.5rem] shadow-2xl border-8 border-white object-cover h-[400px] lg:h-[500px] w-full transform rotate-3 hover:rotate-0 transition duration-500">
                        @else
                            <div class="h-[400px] lg:h-[500px] w-full bg-gradient-to-br from-indigo-100 to-purple-100 rounded-[2.5rem] border-8 border-white shadow-2xl flex flex-col items-center justify-center text-indigo-300">
                                <x-heroicon-o-book-open class="w-32 h-32 mb-4" />
                                <span class="font-bold text-lg">Ilustrasi Perpustakaan</span>
                            </div>
                        @endif
                    </div>
                    {{-- Decorative Elements --}}
                    <div class="absolute -bottom-10 -left-10 w-24 h-24 bg-yellow-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                    <div class="absolute -top-10 -right-10 w-24 h-24 bg-pink-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- STATISTIK SECTION --}}
    <section class="py-12 bg-white border-y border-slate-100 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-slate-100">
                <div data-aos="zoom-in" data-aos-delay="0">
                    <p class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-1">{{ $data['stats_buku'] ?? '0' }}</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Judul Buku</p>
                </div>
                <div data-aos="zoom-in" data-aos-delay="100">
                    <p class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-1">{{ $data['stats_siswa'] ?? '0' }}</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Siswa Aktif</p>
                </div>
                <div data-aos="zoom-in" data-aos-delay="200">
                    <p class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-1">A</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Akreditasi</p>
                </div>
                <div data-aos="zoom-in" data-aos-delay="300">
                    <p class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-1">24/7</p>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Layanan</p>
                </div>
            </div>
        </div>
    </section>

    {{-- KOLEKSI BUKU (RANDOM 6) --}}
    <section id="koleksi" class="py-24 bg-slate-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">Koleksi <span class="text-indigo-600">Terbaru</span></h2>
                <p class="text-slate-500 text-lg">Temukan buku-buku menarik yang baru saja mendarat di rak kami.</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                @foreach($bukuPilihan as $buku)
                    <div class="group relative bg-white rounded-2xl shadow-sm border border-slate-100 book-card-hover transition-all duration-300 overflow-hidden h-full flex flex-col" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        
                        {{-- Cover Image --}}
                        <div class="aspect-[2/3] bg-slate-100 relative overflow-hidden">
                            @if($buku->cover_buku)
                                <img src="{{ asset('storage/' . $buku->cover_buku) }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" 
                                     alt="{{ $buku->judul_buku }}">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-slate-300 p-4 text-center">
                                    <x-heroicon-o-book-open class="w-8 h-8 mb-2" />
                                    <span class="text-[10px]">No Cover</span>
                                </div>
                            @endif
                            
                            {{-- Category Badge --}}
                            <div class="absolute top-2 left-2">
                                <span class="bg-white/90 backdrop-blur-sm text-indigo-700 text-[10px] font-bold px-2 py-1 rounded shadow-sm">
                                    {{ $buku->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                            </div>
                        </div>
                        
                        {{-- Info --}}
                        <div class="p-4 flex flex-col flex-grow">
                            <h3 class="font-bold text-slate-900 text-sm line-clamp-2 leading-snug mb-1 group-hover:text-indigo-600 transition-colors" title="{{ $buku->judul_buku }}">
                                {{ $buku->judul_buku }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-1 mb-2">
                                {{ $buku->penulis->first()->nama_penulis ?? 'Penulis tidak diketahui' }}
                            </p>
                            
                            {{-- Stok Indicator --}}
                            <div class="mt-auto flex items-center gap-1.5 pt-2 border-t border-slate-50">
                                <span class="w-1.5 h-1.5 rounded-full {{ $buku->jumlah_eksemplar_tersedia > 0 ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                <span class="text-[10px] font-medium text-slate-400">
                                    {{ $buku->jumlah_eksemplar_tersedia > 0 ? 'Tersedia' : 'Habis' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-12 text-center" data-aos="fade-up">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-indigo-600 font-bold hover:text-indigo-800 transition hover:underline underline-offset-4">
                    Lihat Semua Koleksi <x-heroicon-o-arrow-long-right class="w-5 h-5 ml-2" />
                </a>
            </div>
        </div>
    </section>

   {{-- GALERI KEGIATAN --}}
    <section id="galeri" class="py-24 bg-white relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-indigo-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-pink-50 rounded-full mix-blend-multiply filter blur-3xl opacity-50"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4" data-aos="fade-right">
                <div class="max-w-2xl">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">Galeri <span class="text-indigo-600">Literasi</span></h2>
                    <p class="text-slate-500 text-lg">Dokumentasi kegiatan membaca, diskusi, dan aktivitas seru siswa di perpustakaan kami.</p>
                </div>
            </div>

            @if($galeri->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4 auto-rows-[200px]">
                    @foreach($galeri as $index => $item)
                        {{-- Logika Layout Grid Bento (Besar/Kecil acak berdasarkan index) --}}
                        @php
                            $classes = match($index % 6) {
                                0 => 'md:col-span-2 md:row-span-2', // Besar
                                3 => 'md:col-span-2', // Lebar
                                default => '', // Kotak Biasa
                            };
                        @endphp

                        <div class="relative rounded-3xl overflow-hidden group shadow-lg {{ $classes }}" data-aos="zoom-in" data-aos-delay="{{ $index * 50 }}">
                            <img src="{{ asset('storage/' . $item->foto) }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110" alt="{{ $item->judul }}">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end p-6">
                                <h3 class="text-white font-bold text-lg translate-y-4 group-hover:translate-y-0 transition duration-300">{{ $item->judul }}</h3>
                                @if($item->deskripsi)
                                    <p class="text-slate-200 text-xs mt-1 opacity-0 group-hover:opacity-100 transition duration-300 delay-100 line-clamp-2">{{ $item->deskripsi }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Tampilan Kosong --}}
                <div class="text-center py-16 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                    <p class="text-slate-400">Belum ada foto kegiatan yang diupload.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-white border-t border-slate-200 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <div class="flex items-center gap-3">
                    <img src="{{ Vite::asset('resources/images/logo.png') }}" class="w-12 h-12 object-contain filter grayscale hover:grayscale-0 transition duration-300" alt="Logo">
                    <div class="flex flex-col">
                        <span class="font-bold text-lg text-slate-900">Perpustakaan Digital</span>
                        <span class="text-xs text-slate-500 uppercase tracking-widest">SMA Negeri 1 Tanjung Morawa</span>
                    </div>
                </div>
                
                <div class="text-slate-500 text-sm text-center md:text-right">
                    <p>{{ $data['alamat'] ?? 'Jl. Sultan Serdang Psr. VIII, Tanjung Morawa' }}</p>
                    <p class="mt-1">&copy; {{ date('Y') }} Hak Cipta Dilindungi Undang-undang.</p>
                </div>
            </div>
        </div>
    </footer>
</div>