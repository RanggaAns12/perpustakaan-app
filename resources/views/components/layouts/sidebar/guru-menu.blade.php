<div class="space-y-1 px-3 py-3">
    <a href="{{ route('guru.dashboard') }}" wire:navigate
       class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs('guru.dashboard') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-100' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
       :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
        <x-heroicon-o-home class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">Beranda</span>
        <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Beranda</div>
    </a>

    <div class="border-t border-slate-100 my-4 mx-2" x-show="!sidebarCollapsed"></div>
    <div x-show="!sidebarCollapsed" class="px-3 mb-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider transition-opacity duration-300">Akademik</div>

    <a href="{{ route('guru.buku') }}" wire:navigate
       class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs('guru.buku') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-100' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
       :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
        <x-heroicon-o-book-open class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">Katalog Buku</span>
        <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Katalog Buku</div>
    </a>

    <div class="border-t border-slate-100 my-4 mx-2" x-show="!sidebarCollapsed"></div>

    <a href="{{ route('guru.profile') }}" wire:navigate
       class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs('guru.profile') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-100' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
       :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
        <x-heroicon-o-user class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">Profil Saya</span>
        <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Profil Saya</div>
    </a>
</div>