{{-- Dashboard Guru --}}
<a href="{{ route('guru.dashboard') }}" wire:navigate
   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('guru.dashboard') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
    <x-heroicon-o-home class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
    <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Beranda</span>
    <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Beranda</div>
</a>

<div class="px-3 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider mt-4" x-show="!sidebarCollapsed">
    Akademik
</div>

{{-- Katalog Buku --}}
<a href="{{ route('guru.buku') }}" wire:navigate
   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('guru.buku') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
    <x-heroicon-o-book-open class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
    <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Katalog Buku</span>
    <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Katalog</div>
</a>

<div class="border-t border-gray-100 my-3 mx-2" x-show="!sidebarCollapsed"></div>

{{-- Profil Guru --}}
<a href="{{ route('guru.profile') }}" wire:navigate
   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('guru.profile') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
    <x-heroicon-o-user class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
    <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Profil Saya</span>
    <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Profil</div>
</a>