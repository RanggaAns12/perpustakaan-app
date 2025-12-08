<div class="space-y-1 px-3 py-3">
    <div x-show="!sidebarCollapsed" class="px-3 mb-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider transition-opacity duration-300">Menu Utama</div>

    <a href="{{ route('pustakawan.dashboard') }}" wire:navigate
       class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs('pustakawan.dashboard') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-100' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
       :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
        <x-heroicon-o-home class="w-5 h-5 shrink-0" />
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">Dashboard</span>
    </a>

    {{-- Route ke Sirkulasi Index --}}
    <a href="{{ route('pustakawan.sirkulasi') }}" wire:navigate
       class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs('pustakawan.sirkulasi') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-100' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
       :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
        <x-heroicon-o-clipboard-document-check class="w-5 h-5 shrink-0" />
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">Sirkulasi</span>
    </a>

    {{-- Menggunakan Route PeminjamanCreate milik Admin karena logikanya sudah support Pustakawan --}}
    <a href="{{ route('peminjaman.create') }}" wire:navigate
       class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs('peminjaman.create') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-100' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
       :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
        <x-heroicon-o-plus-circle class="w-5 h-5 shrink-0" />
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">Buat Peminjaman</span>
    </a>

    <div class="border-t border-slate-100 my-4 mx-2" x-show="!sidebarCollapsed"></div>
    <div x-show="!sidebarCollapsed" class="px-3 mb-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider transition-opacity duration-300">Koleksi</div>

    <a href="{{ route('pustakawan.buku') }}" wire:navigate
       class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs('pustakawan.buku') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-100' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
       :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
        <x-heroicon-o-book-open class="w-5 h-5 shrink-0" />
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">Katalog Buku</span>
    </a>

    <div class="border-t border-slate-100 my-4 mx-2" x-show="!sidebarCollapsed"></div>
    <div x-show="!sidebarCollapsed" class="px-3 mb-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider transition-opacity duration-300">Pengaturan</div>

    <a href="{{ route('notifikasi.index') }}" wire:navigate
    class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs('notifikasi.*') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-100' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
    :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
        <x-heroicon-o-bell class="w-5 h-5 shrink-0" />
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">Notifikasi</span>
    </a>

    <a href="{{ route('chat.index') }}" wire:navigate
    class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs('chat.index') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
    :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
        <x-heroicon-o-chat-bubble-left-right class="w-5 h-5 shrink-0" />
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">Live Chat</span>
    </a>

    <a href="{{ route('pustakawan.profile') }}" wire:navigate
       class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs('pustakawan.profile') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-100' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
       :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
        <x-heroicon-o-user class="w-5 h-5 shrink-0" />
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">Profil Saya</span>
    </a>
</div>