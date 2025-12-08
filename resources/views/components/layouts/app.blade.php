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
        
        /* Animasi Bounce untuk Icon Sukses */
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(-5%); animation-timing-function: cubic-bezier(0.8, 0, 1, 1); }
            50% { transform: translateY(0); animation-timing-function: cubic-bezier(0, 0, 0.2, 1); }
        }
        .animate-bounce-slow { animation: bounce-slow 2s infinite; }
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

    {{-- LOGIKA PENENTUAN NAMA TAMPILAN --}}
    @php
        $user = Auth::user();
        $displayName = $user->username; // Default (Misal Admin)

        if ($user->isPustakawan() && $user->pustakawan) {
            $displayName = $user->pustakawan->nama_lengkap;
        } elseif ($user->isGuru() && $user->guru) {
            $displayName = $user->guru->nama_lengkap;
        } elseif ($user->isSiswa() && $user->siswa) {
            $displayName = $user->siswa->nama_lengkap;
        }
        
        // Ambil inisial 2 huruf pertama dari nama
        $initials = collect(explode(' ', $displayName))->map(fn($segment) => $segment[0] ?? '')->take(2)->join('');
    @endphp

    {{-- 1. BACKGROUND DEKORATIF --}}
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
        <div class="absolute top-0 -left-10 w-96 h-96 bg-purple-200/40 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob"></div>
        <div class="absolute top-0 -right-10 w-96 h-96 bg-indigo-200/40 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-20 left-20 w-96 h-96 bg-pink-200/40 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    {{-- 2. OVERLAY MOBILE --}}
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         x-transition.opacity
         class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-40 lg:hidden"
         x-cloak>
    </div>

    {{-- 3. SIDEBAR COMPONENT --}}
    <x-layouts.sidebar />

    {{-- 4. MAIN CONTENT WRAPPER --}}
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
                {{-- Notifikasi Component --}}
                <livewire:partial.navbar-notifikasi />

                {{-- User Profile --}}
                <div class="relative">
                    <button @click="open = !open" @click.away="open = false" class="flex items-center gap-3 focus:outline-none group">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-700 group-hover:text-indigo-600 transition truncate max-w-[150px] text-right">{{ $displayName }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->getRoleName() }}</p>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 p-0.5 shadow-md group-hover:shadow-lg transition duration-300">
                            <div class="h-full w-full bg-white rounded-full flex items-center justify-center">
                                <span class="text-indigo-600 font-bold text-sm uppercase">{{ $initials }}</span>
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
                            <p class="text-sm font-bold text-gray-900 truncate">{{ $displayName }}</p>
                        </div>

                        {{-- Dynamic Profile Link based on Role --}}
                        <div class="py-2">
                            @php
                                $profileRoute = '#';
                                if(Auth::user()->isPustakawan()) $profileRoute = route('pustakawan.profile');
                                elseif(Auth::user()->isGuru()) $profileRoute = route('guru.profile');
                            @endphp
                            
                            <a href="{{ $profileRoute }}" class="flex items-center gap-3 px-6 py-2.5 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600 transition-colors group">
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

    {{-- ================================================= --}}
    {{--              GLOBAL SUCCESS MODAL                 --}}
    {{-- ================================================= --}}
    <div x-data="{ 
            show: false, 
            message: '',
            init() {
                // 1. Cek jika ada Flash Message dari Session (saat redirect/reload)
                @if(session()->has('message'))
                    this.message = '{{ session('message') }}';
                    this.show = true;
                    setTimeout(() => this.show = false, 3000); // Auto close 3 detik
                @endif

                // 2. Dengarkan Event Livewire (saat update tanpa reload)
                Livewire.on('show-success', (data) => {
                    // Data bisa berupa object atau string langsung
                    this.message = (typeof data === 'string') ? data : data.message; 
                    this.show = true;
                    setTimeout(() => this.show = false, 3000);
                });
            }
         }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-90"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-90"
         class="fixed inset-0 z-[100] flex items-center justify-center px-4 py-6 pointer-events-none"
         style="display: none;">
        
        {{-- Modal Card --}}
        <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 p-6 max-w-sm w-full pointer-events-auto flex flex-col items-center text-center relative overflow-hidden">
            
            {{-- Hiasan Background Card --}}
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-green-400 to-emerald-500"></div>
            
            {{-- Icon Check Animated --}}
            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4 text-green-600 animate-bounce-slow">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>

            {{-- Text --}}
            <h3 class="text-xl font-bold text-gray-900">Berhasil!</h3>
            <p class="text-gray-500 mt-2 text-sm" x-text="message"></p>

            {{-- Tombol Tutup --}}
            <button @click="show = false" class="mt-6 px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold rounded-xl text-sm transition w-full">
                Tutup
            </button>
        </div>
    </div>

</body>
</html>