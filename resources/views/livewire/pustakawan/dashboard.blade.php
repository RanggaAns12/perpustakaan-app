<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 animate-fade-in-up">
        <h1 class="text-3xl font-bold text-gray-900">Halo, Pustakawan!</h1>
        <p class="text-gray-500 mt-2">Selamat bekerja, berikut aktivitas perpustakaan hari ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        {{-- Card 1 --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium uppercase">Pinjam Hari Ini</div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-indigo-600">{{ $stats['peminjaman_hari_ini'] }}</span>
                <span class="text-xs text-gray-400">Transaksi</span>
            </div>
        </div>
        
        {{-- Card 2 --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium uppercase">Kembali Hari Ini</div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-green-600">{{ $stats['pengembalian_hari_ini'] }}</span>
                <span class="text-xs text-gray-400">Transaksi</span>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium uppercase">Sedang Dipinjam</div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-blue-600">{{ $stats['sedang_dipinjam'] }}</span>
                <span class="text-xs text-gray-400">Buku</span>
            </div>
        </div>

        {{-- Card 4 --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-gray-500 text-sm font-medium uppercase">Terlambat</div>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-red-600">{{ $stats['terlambat'] }}</span>
                <span class="text-xs text-gray-400">Siswa</span>
            </div>
        </div>
    </div>
</div>