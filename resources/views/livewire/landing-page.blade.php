<div class="font-sans text-gray-900 antialiased">
    
    <nav x-data="navbar" 
         :class="{ 'glass-nav shadow-sm': scrolled, 'bg-transparent': !scrolled }"
         class="fixed w-full z-50 transition-all duration-300 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="shrink-0 flex items-center gap-2 cursor-pointer">
                    <div class="bg-indigo-600 p-2 rounded-lg text-white">
                        <x-heroicon-o-book-open class="w-6 h-6" />
                    </div>
                    <span class="font-bold text-xl tracking-tight text-indigo-900">Perpus<span class="text-indigo-600">Sekolah</span></span>
                </div>

                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#home" class="text-gray-600 hover:text-indigo-600 font-medium transition">Beranda</a>
                    <a href="#fitur" class="text-gray-600 hover:text-indigo-600 font-medium transition">Fitur</a>
                    <a href="#koleksi" class="text-gray-600 hover:text-indigo-600 font-medium transition">Koleksi</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-full font-semibold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-full font-semibold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">
                            Masuk Sekarang
                        </a>
                    @endauth
                </div>

                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-indigo-600 focus:outline-none">
                        <x-heroicon-o-bars-3 class="w-8 h-8" />
                    </button>
                </div>
            </div>
        </div>

        <div x-show="mobileMenuOpen" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="md:hidden bg-white border-t border-gray-100 absolute w-full shadow-lg">
            <div class="px-4 pt-2 pb-4 space-y-1">
                <a href="#home" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50">Beranda</a>
                <a href="#koleksi" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50">Koleksi</a>
                <a href="{{ route('login') }}" class="block px-3 py-2 mt-4 text-center rounded-md text-base font-bold bg-indigo-600 text-white">Masuk Aplikasi</a>
            </div>
        </div>
    </nav>

    <section id="home" class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden bg-linear-to-b from-indigo-50 to-white">
        <div class="absolute top-0 left-0 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-purple-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute top-0 right-0 translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-indigo-200 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div x-data="animateOnScroll" :class="shown ? 'animate-fade-in-up' : 'opacity-0'" class="text-center lg:text-left">
                    <div class="inline-block px-4 py-1.5 mb-6 rounded-full bg-indigo-100 text-indigo-700 font-semibold text-sm uppercase tracking-wide">
                        {{ $setting->tagline ?? 'Sistem Perpustakaan Digital' }}
                    </div>
                    <h1 class="text-4xl lg:text-6xl font-extrabold text-gray-900 leading-tight mb-6 text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">
                        {{ $setting->judul_hero ?? 'Selamat Datang di Perpustakaan' }}
                    </h1>
                    <p class="text-lg text-gray-600 mb-8 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        {{ $setting->deskripsi_hero ?? 'Platform perpustakaan digital untuk memudahkan akses buku dan literasi.' }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                        <a href="{{ route('login') }}" class="px-8 py-4 bg-indigo-600 text-white rounded-xl font-bold text-lg shadow-xl shadow-indigo-200 hover:bg-indigo-700 hover:scale-105 transition transform duration-200">
                            {{ $setting->text_cta ?? 'Mulai Sekarang' }}
                        </a>
                        <a href="#fitur" class="px-8 py-4 bg-white text-gray-700 border border-gray-200 rounded-xl font-bold text-lg hover:bg-gray-50 hover:border-gray-300 transition duration-200 flex items-center justify-center gap-2">
                            <x-heroicon-o-play-circle class="w-6 h-6 text-indigo-600" />
                            Pelajari Fitur
                        </a>
                    </div>
                </div>

                <div class="relative lg:block">
                    @if(isset($setting->gambar_hero) && $setting->gambar_hero)
                        <img src="{{ asset('storage/' . $setting->gambar_hero) }}" 
                             alt="Hero Illustration" 
                             class="relative z-10 w-full max-w-lg mx-auto animate-float drop-shadow-2xl rounded-2xl object-cover">
                    @else
                        {{-- Gambar Default jika Admin belum upload --}}
                        <img src="https://img.freepik.com/free-vector/library-concept-illustration_114360-2675.jpg" 
                             alt="Default Illustration" 
                             class="relative z-10 w-full max-w-lg mx-auto animate-float drop-shadow-2xl rounded-2xl">
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="bg-indigo-900 py-12 -mt-10 relative z-20 mx-4 rounded-3xl shadow-2xl max-w-7xl lg:mx-auto">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-white px-6">
            <div class="space-y-2">
                <h3 class="text-4xl font-bold">{{ number_format($totalBuku) }}+</h3>
                <p class="text-indigo-200 text-sm uppercase tracking-wider">Koleksi Buku</p>
            </div>
            <div class="space-y-2">
                <h3 class="text-4xl font-bold">500+</h3>
                <p class="text-indigo-200 text-sm uppercase tracking-wider">Siswa Aktif</p>
            </div>
            <div class="space-y-2">
                <h3 class="text-4xl font-bold">24/7</h3>
                <p class="text-indigo-200 text-sm uppercase tracking-wider">Akses Digital</p>
            </div>
            <div class="space-y-2">
                <h3 class="text-4xl font-bold">Gratis</h3>
                <p class="text-indigo-200 text-sm uppercase tracking-wider">Akses Penuh</p>
            </div>
        </div>
    </div>

    <section id="fitur" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Kenapa Memilih Kami?</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Platform perpustakaan modern yang dirancang untuk memudahkan siswa dan guru dalam kegiatan literasi.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div x-data="animateOnScroll" :class="shown ? 'animate-fade-in-up' : 'opacity-0'" class="p-8 bg-gray-50 rounded-2xl hover:bg-white hover:shadow-xl transition duration-300 border border-transparent hover:border-indigo-100 group">
                    <div class="w-14 h-14 bg-indigo-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 transition duration-300">
                        <x-heroicon-o-magnifying-glass class="w-7 h-7 text-indigo-600 group-hover:text-white transition" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pencarian Cepat</h3>
                    <p class="text-gray-500 leading-relaxed">Cari buku berdasarkan judul, penulis, atau kategori dalam hitungan detik dengan sistem indeks pintar.</p>
                </div>

                <div x-data="animateOnScroll" :class="shown ? 'animate-fade-in-up delay-100' : 'opacity-0'" class="p-8 bg-gray-50 rounded-2xl hover:bg-white hover:shadow-xl transition duration-300 border border-transparent hover:border-indigo-100 group">
                    <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-purple-600 transition duration-300">
                        <x-heroicon-o-clock class="w-7 h-7 text-purple-600 group-hover:text-white transition" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Riwayat Peminjaman</h3>
                    <p class="text-gray-500 leading-relaxed">Pantau status peminjaman, tanggal kembali, dan riwayat bacaan Anda secara realtime.</p>
                </div>

                <div x-data="animateOnScroll" :class="shown ? 'animate-fade-in-up delay-200' : 'opacity-0'" class="p-8 bg-gray-50 rounded-2xl hover:bg-white hover:shadow-xl transition duration-300 border border-transparent hover:border-indigo-100 group">
                    <div class="w-14 h-14 bg-pink-100 rounded-xl flex items-center justify-center mb-6 group-hover:bg-pink-600 transition duration-300">
                        <x-heroicon-o-device-phone-mobile class="w-7 h-7 text-pink-600 group-hover:text-white transition" />
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Responsif Mobile</h3>
                    <p class="text-gray-500 leading-relaxed">Akses perpustakaan dari smartphone, tablet, atau laptop dengan tampilan yang menyesuaikan layar.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="koleksi" class="py-24 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Koleksi Terbaru</h2>
                    <p class="text-gray-500">Buku-buku yang baru saja ditambahkan ke perpustakaan.</p>
                </div>
                <a href="{{ route('login') }}" class="hidden md:flex items-center text-indigo-600 font-semibold hover:text-indigo-700">
                    Lihat Semua <x-heroicon-o-arrow-right class="w-4 h-4 ml-2" />
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($bukuTerbaru as $buku)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition duration-300 overflow-hidden group">
                        <div class="h-64 bg-gray-200 relative overflow-hidden">
                            @if($buku->cover_buku)
                                <img src="{{ asset('storage/' . $buku->cover_buku) }}" alt="{{ $buku->judul_buku }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300">
                                    <x-heroicon-o-book-open class="w-16 h-16" />
                                </div>
                            @endif
                            <div class="absolute top-2 right-2 bg-white/90 backdrop-blur px-2 py-1 rounded text-xs font-bold text-indigo-600">
                                {{ $buku->kategori->nama_kategori ?? 'Umum' }}
                            </div>
                        </div>
                        <div class="p-5">
                            <h3 class="font-bold text-gray-900 line-clamp-1 mb-1" title="{{ $buku->judul_buku }}">{{ $buku->judul_buku }}</h3>
                            <p class="text-sm text-gray-500 mb-4">{{ $buku->penulis->first()->nama_penulis ?? 'Penulis Tidak Diketahui' }}</p>
                            <button wire:navigate href="{{ route('login') }}" class="w-full py-2 border border-indigo-600 text-indigo-600 rounded-lg font-semibold text-sm hover:bg-indigo-600 hover:text-white transition">
                                Login untuk Detail
                            </button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-4 text-center py-10 text-gray-500">Belum ada buku yang ditambahkan.</div>
                @endforelse
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center gap-2 mb-4">
                        <x-heroicon-o-book-open class="w-6 h-6 text-indigo-400" />
                        <span class="font-bold text-xl">PerpusSekolah</span>
                    </div>
                    <p class="text-gray-400 max-w-sm text-sm leading-relaxed">
                        Membangun generasi literasi yang cerdas dan berwawasan luas melalui akses buku digital yang mudah dan modern.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Navigasi</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li><a href="#home" class="hover:text-white transition">Beranda</a></li>
                        <li><a href="#fitur" class="hover:text-white transition">Fitur</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Login Guru</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-white transition">Login Siswa</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-sm text-gray-400">
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-map-pin class="w-4 h-4" /> 
                            {{ $setting->alamat ?? 'Alamat Sekolah Belum Diatur' }}
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-phone class="w-4 h-4" /> 
                            {{ $setting->telepon ?? '-' }}
                        </li>
                        <li class="flex items-center gap-2">
                            <x-heroicon-o-envelope class="w-4 h-4" /> 
                            {{ $setting->email ?? '-' }}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} PerpusSekolah App. All rights reserved. Built with Laravel 12 & TALL.
            </div>
        </div>
    </footer>
</div>