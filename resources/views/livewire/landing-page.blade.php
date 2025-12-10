<div class="font-sans text-slate-900 antialiased selection:bg-indigo-500 selection:text-white">
    
    {{-- STYLE KHUSUS HALAMAN INI --}}
    {{-- Kita push style ini ke stack 'styles' yang ada di layout guest --}}
    @push('styles')
        <style>
            .glass-nav { 
                background: rgba(255, 255, 255, 0.8); 
                backdrop-filter: blur(12px); 
                border-bottom: 1px solid rgba(255,255,255,0.3); 
            }
        </style>
    @endpush

    {{-- NAVBAR --}}
    <nav class="fixed w-full z-50 top-0 transition-all duration-300 glass-nav" x-data="{ scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                {{-- Logo --}}
                <div class="flex items-center gap-2" data-aos="fade-down">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-white">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <span class="font-extrabold text-xl tracking-tight">Perpus<span class="text-indigo-600">Digital</span></span>
                </div>

                {{-- Menu Desktop --}}
                <div class="hidden md:flex items-center gap-8 font-medium text-sm text-slate-600" data-aos="fade-down" data-aos-delay="100">
                    <a href="#beranda" class="hover:text-indigo-600 transition">Beranda</a>
                    <a href="#fitur" class="hover:text-indigo-600 transition">Layanan</a>
                    <a href="#statistik" class="hover:text-indigo-600 transition">Statistik</a>
                </div>

                {{-- Auth Buttons --}}
                <div class="hidden md:flex items-center gap-3" data-aos="fade-down" data-aos-delay="200">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 bg-indigo-600 text-white font-bold rounded-full hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-0.5 transition-all">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2.5 bg-slate-900 text-white font-bold rounded-full hover:bg-slate-800 hover:shadow-lg hover:-translate-y-0.5 transition-all">Masuk</a>
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
                <div>
                    <span class="inline-block py-1 px-3 rounded-full bg-indigo-50 text-indigo-600 text-xs font-bold uppercase tracking-wider mb-5 border border-indigo-100" data-aos="fade-up">
                        Perpustakaan Masa Depan
                    </span>
                    
                    <h1 class="text-5xl lg:text-7xl font-extrabold text-slate-900 leading-tight mb-6" data-aos="fade-up" data-aos-delay="100">
                        {{ $data['judul_hero'] ?? 'Jelajahi Dunia Pengetahuan.' }}
                    </h1>
                    
                    <p class="text-lg text-slate-600 mb-8 max-w-lg leading-relaxed" data-aos="fade-up" data-aos-delay="200">
                        {{ $data['deskripsi_hero'] ?? 'Akses ribuan koleksi buku fisik dan digital kapan saja. Platform modern untuk generasi cerdas.' }}
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4" data-aos="fade-up" data-aos-delay="300">
                        <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-8 py-4 bg-indigo-600 text-white font-bold rounded-full hover:bg-indigo-700 transition-all hover:shadow-xl hover:shadow-indigo-200 hover:-translate-y-1">
                            Mulai Sekarang
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 ml-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                            </svg>
                        </a>
                        <a href="#fitur" class="inline-flex justify-center items-center px-8 py-4 bg-white text-slate-700 font-bold rounded-full border border-slate-200 hover:border-indigo-600 hover:text-indigo-600 transition-all">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>

                {{-- Hero Image --}}
                <div class="relative lg:ml-auto" data-aos="fade-left" data-aos-delay="200">
                    <div class="relative z-10 animate-float">
                        @if(isset($data['gambar_hero']) && $data['gambar_hero'])
                            <img src="{{ asset('storage/' . $data['gambar_hero']) }}" alt="Library" class="rounded-[2.5rem] shadow-2xl border-8 border-white object-cover h-[500px] w-full">
                        @else
                            {{-- Placeholder Image jika admin belum upload gambar --}}
                            <div class="h-[500px] w-full bg-indigo-50 rounded-[2.5rem] border-8 border-white shadow-2xl flex items-center justify-center text-indigo-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-32 h-32">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- STATISTIK SECTION --}}
    <section id="statistik" class="py-10 bg-white border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-slate-100">
                <div data-aos="zoom-in" data-aos-delay="0">
                    <p class="text-4xl font-extrabold text-indigo-600 mb-1">{{ $data['stats_buku'] ?? '0' }}</p>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-wide">Koleksi Buku</p>
                </div>
                <div data-aos="zoom-in" data-aos-delay="100">
                    <p class="text-4xl font-extrabold text-indigo-600 mb-1">{{ $data['stats_siswa'] ?? '0' }}</p>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-wide">Anggota Aktif</p>
                </div>
                <div data-aos="zoom-in" data-aos-delay="200">
                    <p class="text-4xl font-extrabold text-indigo-600 mb-1">24/7</p>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-wide">Akses Online</p>
                </div>
                <div data-aos="zoom-in" data-aos-delay="300">
                    <p class="text-4xl font-extrabold text-indigo-600 mb-1">100%</p>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-wide">Gratis</p>
                </div>
            </div>
        </div>
    </section>

    {{-- FITUR SECTION --}}
    <section id="fitur" class="py-24 relative bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
             <div class="text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">Fasilitas <span class="text-indigo-600">Unggulan</span> Kami</h2>
                <p class="text-slate-500 text-lg">Kami menyediakan berbagai layanan modern untuk mendukung kegiatan belajar mengajar yang lebih efektif.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                {{-- Card 1 --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 transition-colors">
                        <svg class="w-7 h-7 text-indigo-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Katalog Digital</h3>
                    <p class="text-slate-600">Cari buku favoritmu dengan mudah melalui sistem katalog online kami yang canggih dan cepat.</p>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-14 h-14 bg-purple-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-purple-600 transition-colors">
                        <svg class="w-7 h-7 text-purple-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Peminjaman Cepat</h3>
                    <p class="text-slate-600">Proses sirkulasi buku yang efisien tanpa antrian panjang. Pinjam dan kembali dalam hitungan detik.</p>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-200 hover:shadow-xl hover:-translate-y-2 transition-all duration-300 group" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-14 h-14 bg-pink-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-pink-600 transition-colors">
                         <svg class="w-7 h-7 text-pink-600 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">E-Library</h3>
                    <p class="text-slate-600">Baca buku elektronik di mana saja dan kapan saja. Mendukung pembelajaran jarak jauh.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA SECTION --}}
    <section class="py-24 px-4">
        <div class="max-w-6xl mx-auto bg-slate-900 rounded-[3rem] p-12 md:p-20 text-center relative overflow-hidden shadow-2xl" data-aos="zoom-in">
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-30 pointer-events-none">
                 <div class="absolute top-[-50%] left-[-20%] w-[600px] h-[600px] bg-indigo-600 rounded-full blur-[100px] animate-blob"></div>
            </div>
            
            <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-6 relative z-10">Mulai Petualangan Membacamu</h2>
            <p class="text-slate-400 text-lg mb-10 max-w-xl mx-auto relative z-10">Bergabunglah dengan ribuan siswa lainnya dan tingkatkan wawasanmu melalui koleksi terbaik kami.</p>
            
            <a href="{{ route('login') }}" class="relative z-10 inline-block bg-white text-slate-900 font-bold text-lg px-10 py-4 rounded-full hover:bg-indigo-50 hover:scale-105 transition-all duration-300 shadow-lg">
                Masuk Sekarang
            </a>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-white border-t border-slate-200 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center mb-8">
                <div class="flex items-center gap-2 mb-4 md:mb-0">
                    <div class="w-8 h-8 bg-indigo-600 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                    </div>
                    <span class="font-bold text-xl text-slate-900">PerpusDigital</span>
                </div>
                <div class="text-slate-500 text-sm">
                    &copy; {{ date('Y') }} Hak Cipta Dilindungi Undang-undang.
                </div>
            </div>
        </div>
    </footer>
</div>