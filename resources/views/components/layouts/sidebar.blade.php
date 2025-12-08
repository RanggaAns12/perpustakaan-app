<aside 
    class="fixed inset-y-0 left-0 z-50 bg-white/80 backdrop-blur-xl border-r border-slate-200 shadow-2xl lg:shadow-indigo-50/50 transition-all duration-300 ease-in-out overflow-hidden flex flex-col"
    :class="{ 
        'translate-x-0': sidebarOpen, 
        '-translate-x-full': !sidebarOpen,
        'lg:translate-x-0': true, 
        'w-72': !sidebarCollapsed, 
        'lg:w-24': sidebarCollapsed 
    }"
    x-cloak>
    
    {{-- SIDEBAR HEADER (Fixed Height & Shrink-0 agar tidak gepeng) --}}
    <div class="h-24 shrink-0 flex items-center bg-white/50 border-b border-slate-100/80 transition-all duration-300"
         :class="sidebarCollapsed ? 'justify-center px-0' : 'px-6'">
        
        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3.5 group w-full overflow-hidden whitespace-nowrap">
            
            {{-- LOGO --}}
            <div class="relative shrink-0 transition-all duration-300 ease-out"
                 :class="sidebarCollapsed ? 'mx-auto w-10 h-10 hover:scale-110' : 'w-10 h-10 group-hover:scale-105'">
                <img src="{{ Vite::asset('resources/images/logo.png') }}" 
                     alt="Logo" 
                     class="w-full h-full object-contain drop-shadow-sm">
            </div>

            {{-- TEXT (Nama Sekolah) --}}
            <div class="flex flex-col justify-center -space-y-0.5 transition-opacity duration-200"
                 x-show="!sidebarCollapsed"
                 x-transition:enter="delay-100 opacity-0"
                 x-transition:enter-end="opacity-100">
                <span class="font-extrabold text-lg leading-none text-slate-800 tracking-tight group-hover:text-indigo-600 transition-colors">
                    Perpustakaan
                </span>
                <span class="text-[0.65rem] font-bold text-slate-500 uppercase tracking-widest group-hover:text-indigo-500 transition-colors">
                    SMAN 1 TJ. MORAWA
                </span>
            </div>
        </a>
    </div>

    {{-- NAVIGATION MENU (Scrollable Area) --}}
    <nav class="flex-1 overflow-y-auto p-4 space-y-2 custom-scrollbar flex flex-col">
        
        @if(Auth::user()->isAdmin())
            @include('components.layouts.sidebar.admin-menu')
        
        @elseif(Auth::user()->isPustakawan())
            @include('components.layouts.sidebar.pustakawan-menu')
        
        @elseif(Auth::user()->isGuru())
            @include('components.layouts.sidebar.guru-menu')
        @endif

        {{-- TOMBOL LOGOUT GLOBAL --}}
        <div class="mt-auto pt-6 pb-2">
            <div class="border-t border-slate-100 mb-4 mx-2" x-show="!sidebarCollapsed"></div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full flex items-center rounded-xl transition-all duration-200 group relative min-h-[48px]"
                        :class="sidebarCollapsed ? 'justify-center px-0 text-red-500 hover:bg-red-50' : 'px-4 gap-3 text-slate-500 hover:bg-red-50 hover:text-red-600'">
                    
                    <x-heroicon-o-arrow-left-on-rectangle class="w-6 h-6 shrink-0 transition-transform group-hover:-translate-x-1" />

                    <span class="font-medium text-sm whitespace-nowrap origin-left transition-all duration-200"
                          x-show="!sidebarCollapsed">
                        Keluar Aplikasi
                    </span>

                    {{-- Tooltip Logout --}}
                    <div x-show="sidebarCollapsed" 
                         class="hidden lg:block absolute left-16 bg-slate-800 text-white text-xs px-2.5 py-1.5 rounded-md opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">
                        Keluar
                    </div>
                </button>
            </form>
        </div>
    </nav>
</aside>