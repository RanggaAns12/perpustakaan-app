<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 animate-fade-in-up">
        <h1 class="text-3xl font-bold text-gray-900">Selamat Datang, Bapak/Ibu Guru!</h1>
        <p class="text-gray-500 mt-2">Silakan cari referensi buku untuk bahan ajar di sini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Card 1 --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-indigo-100 rounded-xl text-indigo-600">
                    <x-heroicon-o-book-open class="w-8 h-8" />
                </div>
                <div>
                    <div class="text-gray-500 text-sm font-medium uppercase">Total Koleksi</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $stats['total_buku'] }} <span class="text-sm font-normal text-gray-400">Judul</span></div>
                </div>
            </div>
        </div>
        
        {{-- Card 2 --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-green-100 rounded-xl text-green-600">
                    <x-heroicon-o-sparkles class="w-8 h-8" />
                </div>
                <div>
                    <div class="text-gray-500 text-sm font-medium uppercase">Buku Baru</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $stats['buku_baru'] }} <span class="text-sm font-normal text-gray-400">Bulan Ini</span></div>
                </div>
            </div>
        </div>

        {{-- Card 3 --}}
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-purple-100 rounded-xl text-purple-600">
                    <x-heroicon-o-tag class="w-8 h-8" />
                </div>
                <div>
                    <div class="text-gray-500 text-sm font-medium uppercase">Kategori</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $stats['total_kategori'] }} <span class="text-sm font-normal text-gray-400">Topik</span></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Shortcut ke Katalog --}}
    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-3xl p-8 text-white flex flex-col md:flex-row items-center justify-between shadow-xl shadow-indigo-200">
        <div>
            <h2 class="text-2xl font-bold mb-2">Cari Buku Referensi?</h2>
            <p class="text-indigo-100">Akses katalog lengkap perpustakaan untuk mendukung kegiatan belajar mengajar.</p>
        </div>
        <a href="{{ route('guru.buku') }}" class="mt-4 md:mt-0 px-6 py-3 bg-white text-indigo-600 font-bold rounded-xl shadow-lg hover:bg-gray-50 transition transform hover:-translate-y-1">
            Lihat Katalog Buku
        </a>
    </div>
</div>