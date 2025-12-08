<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'PerpusSekolah - Siswa' }}</title>
    
    {{-- Load Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Font Modern (Plus Jakarta Sans) --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        /* Glass Effect Class */
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5);
        }
        
        /* Custom Scrollbar yang Tipis & Halus */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 antialiased relative min-h-screen flex flex-col" x-data="{ mobileMenuOpen: false, scrolled: false }" @scroll.window="scrolled = (window.pageYOffset > 20)">

    {{-- 1. BACKGROUND DEKORATIF (BLOBS) --}}
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-indigo-200/30 rounded-full mix-blend-multiply filter blur-[80px] opacity-70 animate-blob"></div>
        <div class="absolute top-0 right-1/4 w-[500px] h-[500px] bg-purple-200/30 rounded-full mix-blend-multiply filter blur-[80px] opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-1/3 w-[600px] h-[600px] bg-pink-200/30 rounded-full mix-blend-multiply filter blur-[80px] opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    {{-- 2. NAVBAR (Tanpa Sidebar) --}}
    <nav class="fixed w-full z-50 transition-all duration-300" 
         :class="{ 'glass-nav shadow-sm py-3': scrolled, 'bg-transparent py-5': !scrolled }">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                
                {{-- Logo Section --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('siswa.dashboard') }}" wire:navigate class="flex items-center gap-2 group">
                        <div class="relative w-10 h-10 transition-transform duration-300 group-hover:scale-110">
                            {{-- Mengambil Logo dari Public --}}
                            <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="Logo" class="w-full h-full object-contain drop-shadow-md">
                        </div>
                        <span class="font-bold text-xl tracking-tight text-slate-900 group-hover:text-indigo-600 transition-colors">
                            Perpus<span class="text-indigo-600">Sekolah</span>
                        </span>
                    </a>
                </div>

                {{-- Desktop Menu (Center) --}}
                <div class="hidden md:flex items-center space-x-1 bg-white/50 backdrop-blur-md px-2 py-1.5 rounded-full border border-white/50 shadow-sm">
                    <a href="{{ route('siswa.dashboard') }}" wire:navigate 
                       class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('siswa.dashboard') ? 'bg-indigo-600 text-white shadow-md' : 'text-slate-600 hover:text-indigo-600 hover:bg-white' }}">
                        Beranda
                    </a>
                    <a href="#" class="px-5 py-2 rounded-full text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-white transition-all duration-200">
                        Katalog
                    </a>
                    <a href="#" class="px-5 py-2 rounded-full text-sm font-medium text-slate-600 hover:text-indigo-600 hover:bg-white transition-all duration-200">
                        Riwayat
                    </a>
                </div>

                {{-- User Profile (Right) --}}
                <div class="hidden md:flex items-center gap-4">
                    {{-- Notif --}}
                    <button class="relative p-2 rounded-full bg-white/60 hover:bg-white text-slate-500 hover:text-indigo-600 transition shadow-sm border border-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                    </button>

                    {{-- Dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 pl-1 pr-2 py-1 rounded-full bg-white/60 hover:bg-white border border-white transition shadow-sm group">
                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 p-[2px]">
                                @if(Auth::user()->siswa && Auth::user()->siswa->foto_profil)
                                    <img src="{{ asset('storage/' . Auth::user()->siswa->foto_profil) }}" class="h-full w-full rounded-full object-cover border border-white">
                                @else
                                    <div class="h-full w-full bg-white rounded-full flex items-center justify-center">
                                        <span class="text-indigo-600 font-bold text-xs">{{ substr(Auth::user()->siswa->nama_lengkap ?? Auth::user()->username, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <span class="text-sm font-semibold text-slate-700 max-w-[100px] truncate group-hover:text-indigo-600 transition">
                                {{ explode(' ', Auth::user()->siswa->nama_lengkap ?? 'Siswa')[0] }}
                            </span>
                            <svg class="w-4 h-4 text-slate-400 group-hover:text-indigo-500 transition" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        {{-- Menu Dropdown --}}
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-2xl shadow-xl border border-slate-100 py-1 z-50 origin-top-right overflow-hidden" 
                             style="display: none;">
                            
                            <div class="px-4 py-3 border-b border-slate-50 bg-slate-50/50">
                                <p class="text-xs text-slate-500">Masuk sebagai</p>
                                <p class="text-sm font-bold text-slate-900 truncate">{{ Auth::user()->siswa->nama_lengkap ?? 'Siswa' }}</p>
                            </div>

                            <a href="#" class="block px-4 py-2.5 text-sm text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Profil Saya
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Mobile Menu Button --}}
                <div class="md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-slate-600 hover:text-indigo-600 focus:outline-none bg-white/50 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Mobile Menu Overlay --}}
        <div x-show="mobileMenuOpen" 
             x-transition 
             class="md:hidden fixed inset-0 z-50 bg-white/95 backdrop-blur-xl flex flex-col p-6"
             style="display: none;">
            
            <div class="flex justify-between items-center mb-8">
                <span class="font-bold text-xl text-indigo-600">Menu</span>
                <button @click="mobileMenuOpen = false" class="p-2 bg-slate-100 rounded-full">
                    <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="space-y-4 text-center">
                <a href="{{ route('siswa.dashboard') }}" class="block py-3 text-lg font-medium text-indigo-600 bg-indigo-50 rounded-xl">Beranda</a>
                <a href="#" class="block py-3 text-lg font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-xl">Katalog Buku</a>
                <a href="#" class="block py-3 text-lg font-medium text-slate-600 hover:text-indigo-600 hover:bg-slate-50 rounded-xl">Riwayat Peminjaman</a>
                
                <div class="border-t border-slate-100 my-6"></div>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-3 text-lg font-bold text-red-500 bg-red-50 rounded-xl">Keluar Aplikasi</button>
                </form>
            </div>
        </div>
    </nav>

    {{-- 3. MAIN CONTENT (Padding Top agar tidak tertutup Navbar) --}}
    <main class="flex-grow pt-28 pb-12 w-full">
        {{ $slot }}
    </main>

    {{-- 4. FOOTER --}}
    <footer class="bg-white/40 backdrop-blur-md border-t border-white/60 mt-auto">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-slate-500 text-sm">
                &copy; {{ date('Y') }} <span class="font-bold text-indigo-600">PerpusSekolah</span>. 
                Belajar Tanpa Batas.
            </p>
        </div>
    </footer>

</body>
</html>