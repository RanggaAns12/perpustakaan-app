<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard - PerpusSekolah' }}</title>
    
    {{-- Load Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900" 
    x-data="{ 
        sidebarOpen: false, 
        sidebarCollapsed: $persist(false),
        toggleSidebar() {
            if (window.innerWidth < 1024) {
                this.sidebarOpen = !this.sidebarOpen;
            } else {
                this.sidebarCollapsed = !this.sidebarCollapsed;
            }
        }
    }">

    {{-- 1. OVERLAY MOBILE --}}
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-40 lg:hidden"
         x-cloak>
    </div>

    {{-- 2. SIDEBAR --}}
    <aside 
        class="fixed inset-y-0 left-0 z-50 bg-white border-r border-gray-200 transition-all duration-300 ease-in-out shadow-xl lg:shadow-none overflow-hidden"
        :class="{ 
            'translate-x-0': sidebarOpen, 
            '-translate-x-full': !sidebarOpen,
            'lg:translate-x-0': true, 
            'w-64': !sidebarCollapsed, 
            'lg:w-20': sidebarCollapsed
        }"
        x-cloak>
        
        {{-- Sidebar Header --}}
        <div class="h-16 flex items-center justify-center border-b border-gray-100 bg-white whitespace-nowrap">
            <div class="flex items-center gap-3 transition-opacity duration-300"
                 x-show="!sidebarCollapsed">
                <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="Logo" class="h-8 w-auto">
                <span class="font-bold text-xl tracking-tight text-gray-800">SMA<span class="text-indigo-600">NSATARA</span></span>
            </div>

            <div class="hidden lg:block" x-show="sidebarCollapsed" x-transition>
                <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="Logo" class="h-9 w-9">
            </div>
        </div>

        {{-- Sidebar Navigation --}}
        <nav class="p-4 space-y-1.5 overflow-y-auto h-[calc(100vh-4rem)] custom-scrollbar">
            
            {{-- Menu Dashboard --}}
            <a href="{{ route('dashboard') }}" wire:navigate
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <x-heroicon-o-home class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Dashboard</span>
                
                {{-- Tooltip saat collapsed --}}
                <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">
                    Dashboard
                </div>
            </a>

            <div class="border-t border-gray-100 my-3 mx-2" x-show="!sidebarCollapsed"></div>

            {{-- LABEL: MASTER DATA --}}
            <div x-show="!sidebarCollapsed" class="px-3 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider transition-all">
                Master Data
            </div>

            {{-- Menu Data Buku --}}
            <a href="{{ route('buku.index') }}" wire:navigate
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('buku.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <x-heroicon-o-book-open class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Data Buku</span>
                <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Data Buku</div>
            </a>

            {{-- Menu Kategori --}}
            <a href="{{ route('kategori.index') }}" wire:navigate
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('kategori.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <x-heroicon-o-tag class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Kategori</span>
                <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Kategori</div>
            </a>

            {{-- Menu Penerbit --}}
            <a href="{{ route('penerbit.index') }}" wire:navigate
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('penerbit.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <x-heroicon-o-building-office-2 class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Penerbit</span>
                <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Penerbit</div>
            </a>

            {{-- Menu Penulis --}}
            <a href="{{ route('penulis.index') }}" wire:navigate
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('penulis.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <x-heroicon-o-pencil-square class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Penulis</span>
                <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Penulis</div>
            </a>
            
            {{-- LABEL: DATA SEKOLAH --}}
            <div x-show="!sidebarCollapsed" class="px-3 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider mt-4">
                Data Sekolah
            </div>

            {{-- Menu Data Kelas --}}
            <a href="{{ route('kelas.index') }}" wire:navigate
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('kelas.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <x-heroicon-o-academic-cap class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Data Kelas</span>
                <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Data Kelas</div>
            </a>

            {{-- Menu Tahun Ajaran --}}
            <a href="{{ route('tahun-ajaran.index') }}" wire:navigate
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('tahun-ajaran.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <x-heroicon-o-calendar-days class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Tahun Ajaran</span>
                <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Tahun Ajaran</div>
            </a>

            {{-- Menu Jurusan --}}
            <a href="{{ route('jurusan.index') }}" wire:navigate
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('jurusan.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <x-heroicon-o-briefcase class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Jurusan</span>
                <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Jurusan</div>
            </a>

            {{-- Menu Data Guru --}}
            <a href="{{ route('guru.index') }}" wire:navigate
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('guru.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <x-heroicon-o-user-group class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Data Guru</span>
                <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Data Guru</div>
            </a>

            {{-- Menu Pustakawan --}}
            <a href="{{ route('pustakawan.index') }}" wire:navigate
            class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('pustakawan.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <x-heroicon-o-user-circle class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Pustakawan</span>
                <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Pustakawan</div>
            </a>

            {{-- Menu Siswa --}}
            <a href="{{ route('siswa.index') }}" wire:navigate
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('siswa.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <x-heroicon-o-users class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Data Siswa</span>
                <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Data Siswa</div>
            </a>

            <div class="border-t border-gray-100 my-3 mx-2" x-show="!sidebarCollapsed"></div>

            {{-- LABEL: SIRKULASI --}}
            <div x-show="!sidebarCollapsed" class="px-3 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">
                Sirkulasi
            </div>

            {{-- Menu Peminjaman --}}
            <a href="{{ route('peminjaman.index') }}" wire:navigate
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('peminjaman.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <x-heroicon-o-clipboard-document-check class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Peminjaman</span>
                <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Peminjaman</div>
            </a>

            {{-- Menu Laporan --}}
            <a href="{{ route('laporan.aktivitas') }}" wire:navigate
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('laporan.*') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                <x-heroicon-o-chart-bar class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Laporan</span>
                <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Laporan</div>
            </a>

            {{-- --- BAGIAN BARU: PENGATURAN LANDING PAGE (KHUSUS ADMIN) --- --}}
            @if(Auth::user()->isAdmin())
                <div class="border-t border-gray-100 my-3 mx-2" x-show="!sidebarCollapsed"></div>

                {{-- LABEL: PENGATURAN --}}
                <div x-show="!sidebarCollapsed" class="px-3 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider">
                    Pengaturan
                </div>

                <a href="{{ route('setting.landing-page') }}" wire:navigate
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('setting.landing-page') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <x-heroicon-o-cog-6-tooth class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                    <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Landing Page</span>
                    <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Landing Page</div>
                </a>
            @endif
            {{-- --- AKHIR BAGIAN BARU --- --}}

            {{-- Tombol Keluar --}}
            <div class="mt-auto pt-8 pb-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-red-600 hover:bg-red-50 transition-all duration-200 group relative">
                        <x-heroicon-o-arrow-left-on-rectangle class="w-6 h-6 shrink-0" />
                        <span x-show="!sidebarCollapsed" class="whitespace-nowrap font-medium">Keluar Aplikasi</span>
                        <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Keluar</div>
                    </button>
                </form>
            </div>
        </nav>
    </aside>

    {{-- 3. MAIN CONTENT WRAPPER --}}
    <div 
        class="transition-all duration-300 ease-in-out min-h-screen flex flex-col"
        :class="{ 
            'lg:ml-64': !sidebarCollapsed, 
            'lg:ml-20': sidebarCollapsed 
        }">

        {{-- Top Navbar --}}
        <header class="bg-white/80 backdrop-blur-md sticky top-0 z-40 border-b border-gray-200 h-16 px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            
            {{-- Left: Toggle Button --}}
            <div class="flex items-center gap-4">
                <button @click="toggleSidebar()" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-indigo-600 transition-colors focus:outline-none">
                    <x-heroicon-o-bars-3-bottom-left class="w-6 h-6" />
                </button>
                <h2 class="text-lg font-semibold text-gray-800 hidden sm:block">{{ $title ?? 'Dashboard' }}</h2>
            </div>

            {{-- Right: Profile Dropdown --}}
            <div class="flex items-center gap-4" x-data="{ open: false }">
                
                {{-- Notifikasi --}}
                <button class="relative p-2 rounded-full text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition">
                    <x-heroicon-o-bell class="w-6 h-6" />
                    <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
                </button>

                {{-- User Profile Trigger --}}
                <div class="relative">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 focus:outline-none group">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-700 group-hover:text-indigo-600 transition">{{ Auth::user()->username }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->getRoleName() }}</p>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 p-0.5 shadow-md group-hover:shadow-lg transition duration-300">
                            <div class="h-full w-full bg-white rounded-full flex items-center justify-center">
                                <span class="text-indigo-600 font-bold text-sm">{{ substr(Auth::user()->username, 0, 2) }}</span>
                            </div>
                        </div>
                        <x-heroicon-o-chevron-down class="w-4 h-4 text-gray-400 group-hover:text-indigo-600 transition duration-200" x-bind:class="{'rotate-180': open}" />
                    </button>

                    {{-- Dropdown Menu --}}
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                         class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-xl border border-gray-100 ring-1 ring-black/5 focus:outline-none z-50 overflow-hidden"
                         style="display: none;">
                        
                        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                            <p class="text-sm font-medium text-gray-500">Masuk sebagai</p>
                            <p class="text-sm font-bold text-gray-900 truncate">{{ Auth::user()->username }}</p>
                        </div>

                        <div class="py-2">
                            <a href="#" class="flex items-center gap-3 px-6 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors group">
                                <div class="p-1.5 bg-gray-100 rounded-lg text-gray-500 group-hover:bg-white group-hover:text-indigo-600 group-hover:shadow-sm transition">
                                    <x-heroicon-o-user class="w-4 h-4" />
                                </div>
                                Profil Saya
                            </a>
                        </div>

                        <div class="border-t border-gray-100"></div>

                        <div class="py-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-3 px-6 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors group">
                                    <div class="p-1.5 bg-red-50 rounded-lg text-red-500 group-hover:bg-white group-hover:shadow-sm transition">
                                        <x-heroicon-o-arrow-left-on-rectangle class="w-4 h-4" />
                                    </div>
                                    Keluar Aplikasi
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Main Content Area --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-x-hidden">
            {{ $slot }}
        </main>

        {{-- Footer --}}
        <footer class="bg-white border-t border-gray-200 py-4 px-6 text-center md:text-left text-sm text-gray-500">
            &copy; {{ date('Y') }} Sistem Informasi Perpustakaan. All rights reserved.
        </footer>
    </div>

</body>
</html>