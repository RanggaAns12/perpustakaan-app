<div class="space-y-8">
    
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Dashboard Ringkasan</h1>
            <p class="text-gray-500 mt-1">Halo <span class="text-indigo-600 font-semibold">{{ Auth::user()->username }}</span>, berikut laporan hari ini.</p>
        </div>
        <div class="flex gap-3">
            {{-- Tombol Transaksi Baru dengan wire:navigate --}}
            <a href="{{ route('peminjaman.create') }}" wire:navigate
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-xl text-sm font-semibold text-white hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition transform hover:-translate-y-0.5">
                <x-heroicon-o-plus class="w-4 h-4 mr-2" /> 
                Transaksi Baru
            </a>
        </div>
    </div>

    {{-- --- BAGIAN ADMIN / PUSTAKAWAN --- --}}
    @if(Auth::user()->isAdmin() || Auth::user()->isPustakawan())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        {{-- Card 1: Total Buku --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Koleksi</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1 group-hover:text-indigo-600 transition">{{ number_format($stats['total_buku']) }}</h3>
                </div>
                <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition duration-300">
                    <x-heroicon-o-book-open class="w-8 h-8" />
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-gray-400">
                <span class="text-xs">Total judul buku terdaftar</span>
            </div>
        </div>

        {{-- Card 2: Siswa Aktif --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Siswa Aktif</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1 group-hover:text-purple-600 transition">{{ number_format($stats['total_siswa']) }}</h3>
                </div>
                <div class="p-3 bg-purple-50 rounded-xl text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition duration-300">
                    <x-heroicon-o-users class="w-8 h-8" />
                </div>
            </div>
            <div class="mt-4 flex items-center text-sm text-gray-400">
                <span class="text-xs">Total siswa status aktif</span>
            </div>
        </div>

        {{-- Card 3: Sedang Dipinjam --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Sedang Dipinjam</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1 group-hover:text-orange-600 transition">{{ number_format($stats['peminjaman_aktif']) }}</h3>
                </div>
                <div class="p-3 bg-orange-50 rounded-xl text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition duration-300">
                    <x-heroicon-o-clock class="w-8 h-8" />
                </div>
            </div>
             <div class="mt-4 flex items-center text-sm text-orange-600 font-medium">
                <span class="text-xs">Transaksi belum kembali</span>
            </div>
        </div>

        {{-- Card 4: Total Denda --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Tunggakan Denda</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1 group-hover:text-red-600 transition">Rp {{ number_format($stats['total_denda'], 0, ',', '.') }}</h3>
                </div>
                <div class="p-3 bg-red-50 rounded-xl text-red-600 group-hover:bg-red-600 group-hover:text-white transition duration-300">
                    <x-heroicon-o-banknotes class="w-8 h-8" />
                </div>
            </div>
             <div class="mt-4 flex items-center text-sm text-red-600 font-medium">
                <span class="text-xs">Belum lunas</span>
            </div>
        </div>
    </div>
    @endif

    {{-- --- BAGIAN SISWA (Jika Login sebagai Siswa) --- --}}
    @if(Auth::user()->isSiswa())
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        {{-- Dipinjam --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Buku Dipinjam</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1 group-hover:text-indigo-600 transition">{{ $stats['dipinjam'] }}</h3>
                </div>
                <div class="p-3 bg-indigo-50 rounded-xl text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition duration-300">
                    <x-heroicon-o-book-open class="w-8 h-8" />
                </div>
            </div>
        </div>

        {{-- Dikembalikan --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Dikembalikan</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1 group-hover:text-green-600 transition">{{ $stats['dikembalikan'] }}</h3>
                </div>
                <div class="p-3 bg-green-50 rounded-xl text-green-600 group-hover:bg-green-600 group-hover:text-white transition duration-300">
                    <x-heroicon-o-check-circle class="w-8 h-8" />
                </div>
            </div>
        </div>

        {{-- Denda --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Denda Saya</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-1 group-hover:text-red-600 transition">Rp {{ number_format($stats['denda_saya'], 0, ',', '.') }}</h3>
                </div>
                <div class="p-3 bg-red-50 rounded-xl text-red-600 group-hover:bg-red-600 group-hover:text-white transition duration-300">
                    <x-heroicon-o-banknotes class="w-8 h-8" />
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- --- CONTENT GRID --- --}}
    <div class="grid lg:grid-cols-3 gap-8">
        
        {{-- Chart Section (Statistik Mingguan - Visual CSS) --}}
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="font-bold text-gray-800 flex items-center gap-2">
                    <x-heroicon-o-presentation-chart-bar class="w-5 h-5 text-indigo-500" />
                    Statistik Peminjaman
                </h3>
                <div class="px-3 py-1 bg-gray-50 rounded-lg text-xs font-medium text-gray-500 border border-gray-200">
                    7 Hari Terakhir
                </div>
            </div>
            
            {{-- CSS Bar Chart (Visual) --}}
            <div class="h-64 flex items-end justify-between gap-3 px-2 pt-8 pb-2 border-b border-gray-100">
                {{-- Data Dummy untuk Visualisasi --}}
                @foreach([40, 65, 30, 80, 55, 90, 45] as $height)
                    <div class="w-full bg-gray-50 rounded-t-lg hover:bg-indigo-50 transition-colors relative group cursor-pointer h-full flex items-end">
                        <div style="height: {{ $height }}%" class="bg-indigo-500 rounded-t-lg relative w-full transition-all duration-500 ease-out group-hover:bg-indigo-600 group-hover:shadow-lg group-hover:shadow-indigo-200">
                            {{-- Tooltip Angka --}}
                            <div class="absolute -top-10 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded shadow-xl opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0 z-10 whitespace-nowrap after:content-[''] after:absolute after:top-full after:left-1/2 after:-translate-x-1/2 after:border-4 after:border-transparent after:border-t-gray-800">
                                {{ $height }} Buku
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="flex justify-between text-xs font-bold text-gray-400 mt-4 px-2 font-mono">
                <span>SEN</span><span>SEL</span><span>RAB</span><span>KAM</span><span>JUM</span><span>SAB</span><span>MIN</span>
            </div>
        </div>

        {{-- Recent Activity List --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col h-full">
            <h3 class="font-bold text-gray-800 mb-6 flex items-center justify-between">
                <span>Aktivitas Terbaru</span>
                <span class="text-xs font-normal text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full border border-indigo-100">{{ count($recentActivities) }} Item</span>
            </h3>
            
            <div class="space-y-6 flex-1 overflow-y-auto custom-scrollbar pr-2 max-h-[300px]">
                @forelse($recentActivities as $log)
                    <div class="flex gap-4 group relative">
                        {{-- Vertical Line Connector --}}
                        <div class="absolute left-5 top-10 bottom-0 w-px bg-gray-100 group-last:hidden"></div>

                        {{-- Icon Status --}}
                        <div class="h-10 w-10 rounded-full flex items-center justify-center shrink-0 border transition-all duration-300 z-10 bg-white
                            {{ $log->status_peminjaman == 'Dipinjam' ? 'border-blue-100 text-blue-600 shadow-sm group-hover:bg-blue-50' : 'border-green-100 text-green-600 shadow-sm group-hover:bg-green-50' }}">
                            @if($log->status_peminjaman == 'Dipinjam')
                                <x-heroicon-o-arrow-up-tray class="w-5 h-5" />
                            @else
                                <x-heroicon-o-check class="w-5 h-5" />
                            @endif
                        </div>
                        
                        <div>
                            <p class="text-sm text-gray-600">
                                @if(Auth::user()->isSiswa())
                                    <span class="text-gray-900 font-bold block">Anda</span>
                                @else
                                    <span class="text-gray-900 font-bold block">{{ $log->siswa->nama_lengkap ?? 'Siswa' }}</span>
                                @endif
                                
                                <span class="text-xs">
                                    {{ $log->status_peminjaman == 'Dipinjam' ? 'meminjam buku' : 'mengembalikan buku' }}
                                </span>
                                <span class="text-indigo-600 font-medium block mt-0.5 text-xs bg-indigo-50 w-fit px-2 py-0.5 rounded">
                                    {{ $log->detailPeminjaman->first()->buku->judul_buku ?? 'Judul Buku' }}
                                </span>
                            </p>
                            <p class="text-[10px] text-gray-400 mt-1 flex items-center gap-1">
                                <x-heroicon-o-clock class="w-3 h-3" />
                                {{ $log->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 text-gray-400 flex flex-col items-center justify-center h-full">
                        <div class="bg-gray-50 p-3 rounded-full mb-3">
                            <x-heroicon-o-inbox class="w-8 h-8 text-gray-300" />
                        </div>
                        <p class="text-sm">Belum ada aktivitas hari ini.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-6 pt-4 border-t border-gray-50">
                <a href="{{ route('peminjaman.index') }}" wire:navigate class="block w-full py-2.5 text-center text-sm text-indigo-600 font-semibold bg-indigo-50 hover:bg-indigo-100 rounded-xl transition-colors">
                    Lihat Semua Aktivitas
                </a>
            </div>
        </div>
    </div>
</div>