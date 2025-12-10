<div class="space-y-1">
    {{-- DASHBOARD --}}
    <a href="{{ route('dashboard') }}" wire:navigate
       class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white font-semibold shadow-lg shadow-indigo-200' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}"
       :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
       
        <x-heroicon-o-home class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap font-medium text-sm">Dashboard</span>
        
        <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Dashboard</div>
    </a>

    {{-- MASTER DATA --}}
    <div class="border-t border-slate-100 my-4 mx-2" x-show="!sidebarCollapsed"></div>
    <div x-show="!sidebarCollapsed" class="px-3 mb-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider transition-opacity duration-300">Master Data</div>

    @php
        $menus = [
            ['route' => 'buku.index', 'label' => 'Data Buku', 'icon' => 'book-open', 'active' => 'buku.*'],
            ['route' => 'kategori.index', 'label' => 'Kategori', 'icon' => 'tag', 'active' => 'kategori.*'],
            ['route' => 'penerbit.index', 'label' => 'Penerbit', 'icon' => 'building-office-2', 'active' => 'penerbit.*'],
            ['route' => 'penulis.index', 'label' => 'Penulis', 'icon' => 'pencil-square', 'active' => 'penulis.*'],
        ];
    @endphp

    @foreach($menus as $menu)
        <a href="{{ route($menu['route']) }}" wire:navigate
           class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs($menu['active']) ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-100' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
           :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
            
            @if($menu['icon'] == 'book-open') <x-heroicon-o-book-open class="w-5 h-5 shrink-0" />
            @elseif($menu['icon'] == 'tag') <x-heroicon-o-tag class="w-5 h-5 shrink-0" />
            @elseif($menu['icon'] == 'building-office-2') <x-heroicon-o-building-office-2 class="w-5 h-5 shrink-0" />
            @elseif($menu['icon'] == 'pencil-square') <x-heroicon-o-pencil-square class="w-5 h-5 shrink-0" />
            @endif

            <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">{{ $menu['label'] }}</span>
            <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">{{ $menu['label'] }}</div>
        </a>
    @endforeach

    {{-- ADMINISTRASI --}}
    <div class="border-t border-slate-100 my-4 mx-2" x-show="!sidebarCollapsed"></div>
    <div x-show="!sidebarCollapsed" class="px-3 mb-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider transition-opacity duration-300">Data Sekolah</div>

    @foreach([
        ['route' => 'kelas.index', 'label' => 'Data Kelas', 'icon' => 'academic-cap', 'active' => 'kelas.*'],
        ['route' => 'tahun-ajaran.index', 'label' => 'Tahun Ajaran', 'icon' => 'calendar-days', 'active' => 'tahun-ajaran.*'],
        ['route' => 'jurusan.index', 'label' => 'Jurusan', 'icon' => 'briefcase', 'active' => 'jurusan.*'],
        ['route' => 'guru.index', 'label' => 'Data Guru', 'icon' => 'user-group', 'active' => 'guru.*'],
        ['route' => 'siswa.index', 'label' => 'Data Siswa', 'icon' => 'users', 'active' => 'siswa.*'],
        ['route' => 'pustakawan.index', 'label' => 'Pustakawan', 'icon' => 'user-circle', 'active' => 'pustakawan.index'],
    ] as $menu)
        <a href="{{ route($menu['route']) }}" wire:navigate
           class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs($menu['active']) ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-100' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
           :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
            
            @if($menu['icon'] == 'academic-cap') <x-heroicon-o-academic-cap class="w-5 h-5 shrink-0" />
            @elseif($menu['icon'] == 'calendar-days') <x-heroicon-o-calendar-days class="w-5 h-5 shrink-0" />
            @elseif($menu['icon'] == 'briefcase') <x-heroicon-o-briefcase class="w-5 h-5 shrink-0" />
            @elseif($menu['icon'] == 'user-group') <x-heroicon-o-user-group class="w-5 h-5 shrink-0" />
            @elseif($menu['icon'] == 'users') <x-heroicon-o-users class="w-5 h-5 shrink-0" />
            @elseif($menu['icon'] == 'user-circle') <x-heroicon-o-user-circle class="w-5 h-5 shrink-0" />
            @endif

            <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">{{ $menu['label'] }}</span>
            <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">{{ $menu['label'] }}</div>
        </a>
    @endforeach

    {{-- SIRKULASI --}}
    <div class="border-t border-slate-100 my-4 mx-2" x-show="!sidebarCollapsed"></div>
    <div x-show="!sidebarCollapsed" class="px-3 mb-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider transition-opacity duration-300">Sirkulasi</div>

    <a href="{{ route('peminjaman.index') }}" wire:navigate
       class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs('peminjaman.*') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-100' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
       :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
        <x-heroicon-o-clipboard-document-check class="w-5 h-5 shrink-0" />
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">Peminjaman</span>
        <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Peminjaman</div>
    </a>

    <a href="{{ route('laporan.aktivitas') }}" wire:navigate
       class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs('laporan.*') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-100' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
       :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
        <x-heroicon-o-chart-bar class="w-5 h-5 shrink-0" />
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">Laporan</span>
        <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Laporan</div>
    </a>

    {{-- PENGATURAN --}}
    <div class="border-t border-slate-100 my-4 mx-2" x-show="!sidebarCollapsed"></div>
    <div x-show="!sidebarCollapsed" class="px-3 mb-2 text-[10px] font-bold text-slate-400 uppercase tracking-wider transition-opacity duration-300">Pengaturan</div>

    <a href="{{ route('admin.index') }}" wire:navigate
       class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs('admin.*') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-100' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
       :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
        <x-heroicon-o-users class="w-5 h-5 shrink-0" />
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">Manajemen Admin</span>
        <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Admin</div>
    </a>

    <a href="{{ route('notifikasi.index') }}" wire:navigate
    class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs('notifikasi.*') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-100' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
    :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
        <x-heroicon-o-bell class="w-5 h-5 shrink-0" />
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">Notifikasi</span>
        <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Notifikasi</div>
    </a>

    <a href="{{ route('chat.index') }}" wire:navigate
    class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs('chat.index') ? 'bg-indigo-600 text-white font-semibold shadow-md' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
    :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
        <x-heroicon-o-chat-bubble-left-right class="w-5 h-5 shrink-0" />
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">Live Chat</span>
        <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Live Chat</div>
    </a>

    <a href="{{ route('setting.landing-page') }}" wire:navigate
       class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs('setting.landing-page') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-100' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
       :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
        <x-heroicon-o-cog-6-tooth class="w-5 h-5 shrink-0" />
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">Landing Page</span>
        <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Landing Page</div>
    </a>

    {{-- LINK GALERI BARU --}}
    <a href="{{ route('setting.galeri') }}" wire:navigate
       class="flex items-center rounded-xl transition-all duration-200 group relative py-2.5 min-h-[44px] {{ request()->routeIs('setting.galeri') ? 'bg-indigo-600 text-white font-semibold shadow-md shadow-indigo-100' : 'text-slate-600 hover:bg-indigo-50 hover:text-indigo-600' }}"
       :class="sidebarCollapsed ? 'justify-center px-0' : 'gap-3 px-3'">
        <x-heroicon-o-photo class="w-5 h-5 shrink-0" />
        <span x-show="!sidebarCollapsed" class="whitespace-nowrap text-sm">Kelola Galeri</span>
        <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Kelola Galeri</div>
    </a>
</div>