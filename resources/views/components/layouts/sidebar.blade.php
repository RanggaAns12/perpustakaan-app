<aside 
    class="fixed inset-y-0 left-0 z-50 bg-white/80 backdrop-blur-xl border-r border-white/50 shadow-xl lg:shadow-indigo-100/50 transition-all duration-300 ease-in-out overflow-hidden"
    :class="{ 
        'translate-x-0': sidebarOpen, 
        '-translate-x-full': !sidebarOpen,
        'lg:translate-x-0': true, 
        'w-64': !sidebarCollapsed, 
        'lg:w-20': sidebarCollapsed
    }"
    x-cloak>
    
    {{-- Sidebar Header (Logo) --}}
    <div class="h-16 flex items-center justify-center border-b border-gray-100/50 bg-white/50 whitespace-nowrap">
        <div class="flex items-center gap-3 transition-opacity duration-300" x-show="!sidebarCollapsed">
            <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="Logo" class="h-8 w-auto">
            <span class="font-bold text-xl tracking-tight text-gray-800">SMA<span class="text-indigo-600">NSATARA</span></span>
        </div>
        <div class="hidden lg:block" x-show="sidebarCollapsed" x-transition>
            <img src="{{ Vite::asset('resources/images/logo.png') }}" alt="Logo" class="h-9 w-9">
        </div>
    </div>

    {{-- Sidebar Navigation --}}
    <nav class="p-4 space-y-1.5 overflow-y-auto h-[calc(100vh-4rem)] custom-scrollbar">
        
        {{-- LOGIKA PEMANGGILAN MENU BERDASARKAN ROLE --}}
        @if(Auth::user()->isAdmin())
            @include('components.layouts.sidebar.admin-menu')
        
        @elseif(Auth::user()->isPustakawan())
            @include('components.layouts.sidebar.pustakawan-menu')
        
        @elseif(Auth::user()->isGuru())
            @include('components.layouts.sidebar.guru-menu')
        @endif

        {{-- Tombol Logout (Global) --}}
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