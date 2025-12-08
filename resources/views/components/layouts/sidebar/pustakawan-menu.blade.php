{{-- Dashboard Pustakawan --}}
                <a href="{{ route('pustakawan.dashboard') }}" wire:navigate
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('pustakawan.dashboard') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <x-heroicon-o-home class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                    <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Beranda</span>
                    <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Beranda</div>
                </a>

                <div class="px-3 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider mt-4" x-show="!sidebarCollapsed">
                    Layanan
                </div>

                {{-- Sirkulasi --}}
                <a href="{{ route('pustakawan.sirkulasi') }}" wire:navigate
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('pustakawan.sirkulasi') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <x-heroicon-o-arrows-right-left class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                    <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Sirkulasi</span>
                    <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Sirkulasi</div>
                </a>

                {{-- Transaksi Baru --}}
                <a href="{{ route('pustakawan.transaksi.create') }}" wire:navigate
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('pustakawan.transaksi.create') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <x-heroicon-o-plus-circle class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                    <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Transaksi Baru</span>
                    <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Transaksi Baru</div>
                </a>

                <div class="px-3 mb-2 text-xs font-bold text-gray-400 uppercase tracking-wider mt-4" x-show="!sidebarCollapsed">
                    Data
                </div>

                {{-- Cek Buku --}}
                <a href="{{ route('pustakawan.buku') }}" wire:navigate
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('pustakawan.buku') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <x-heroicon-o-book-open class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                    <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Cek Stok Buku</span>
                    <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Stok Buku</div>
                </a>

                {{-- Menu Profil --}}
                <a href="{{ route('pustakawan.profile') }}" wire:navigate
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('pustakawan.profile') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <x-heroicon-o-user-circle class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                    <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Profil Saya</span>
                    <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Profil</div>
                </a>