 {{-- Menu Dashboard --}}
                <a href="{{ route('dashboard') }}" wire:navigate
                   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                    <x-heroicon-o-home class="w-6 h-6 shrink-0 transition-transform group-hover:scale-110" />
                    <span x-show="!sidebarCollapsed" class="whitespace-nowrap">Dashboard</span>
                    <div x-show="sidebarCollapsed" class="hidden lg:block absolute left-14 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity z-50 whitespace-nowrap pointer-events-none shadow-lg">Dashboard</div>
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
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('pustakawan.index') ? 'bg-indigo-50 text-indigo-600 font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
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