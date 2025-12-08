<div class="min-h-screen bg-gray-50/50 pb-12" x-data="{ deleteModalOpen: false, deleteId: null }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 animate-fade-in-up">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Koleksi Buku</h1>
                <p class="text-gray-500 mt-2">Kelola semua data buku, stok, dan kategori di perpustakaan.</p>
            </div>
            <a href="{{ route('buku.create') }}" 
               class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:-translate-y-0.5 transition-all duration-200 group">
                <x-heroicon-o-plus class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" />
                Tambah Buku
            </a>
        </div>

        {{-- Flash Message --}}
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                 class="fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-white border border-green-100 px-4 py-3 rounded-xl shadow-xl shadow-green-50 transition">
                <div class="bg-green-100 text-green-600 p-2 rounded-full"><x-heroicon-o-check class="w-5 h-5" /></div>
                <div><p class="font-semibold text-gray-900">Berhasil!</p><p class="text-sm text-gray-500">{{ session('message') }}</p></div>
            </div>
        @endif

        {{-- Filters Bar --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 mb-8 sticky top-20 z-30 backdrop-blur-xl bg-white/80 transition-all duration-300 hover:shadow-md flex flex-col md:flex-row gap-2">
            <div class="flex-1 relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" />
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-11 pr-4 py-2.5 bg-transparent border-none rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500/20 transition-all" placeholder="Cari judul buku, ISBN, atau penulis..." />
            </div>
            <div class="hidden md:block w-px bg-gray-200 my-1"></div>
            <div class="md:w-64 relative">
                <select wire:model.live="kategori_id" class="block w-full pl-4 pr-10 py-2.5 bg-transparent border-none rounded-xl text-gray-700 focus:ring-2 focus:ring-indigo-500/20 cursor-pointer hover:bg-gray-50 transition-colors appearance-none">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->kategori_id }}">{{ $kategori->nama_kategori }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-gray-400"><x-heroicon-o-funnel class="h-5 w-5" /></div>
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative min-h-[400px]">
             <div wire:loading.flex wire:target="kategori_id, delete" class="absolute inset-0 bg-white/60 backdrop-blur-[1px] z-20 flex items-center justify-center">
                <div class="flex flex-col items-center"><svg class="animate-spin h-8 w-8 text-indigo-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span class="text-sm font-medium text-indigo-600">Memproses...</span></div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                            <th class="px-6 py-4 rounded-tl-2xl">Buku</th>
                            <th class="px-6 py-4">Detail</th>
                            <th class="px-6 py-4 text-center">Stok</th>
                            <th class="px-6 py-4 text-center rounded-tr-2xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($bukus as $buku)
                            <tr class="group hover:bg-indigo-50/30 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="relative h-20 w-14 shrink-0 rounded shadow-sm overflow-hidden group-hover:shadow-md transition-all duration-300 group-hover:scale-105">
                                            @if($buku->cover_buku)
                                                <img src="{{ asset('storage/' . $buku->cover_buku) }}" class="h-full w-full object-cover" onerror="this.onerror=null; this.src=''; this.parentElement.innerHTML='<div class=\'h-full w-full bg-gray-200 flex items-center justify-center text-gray-400\'><svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\'></path></svg></div>';">
                                            @else
                                                <div class="h-full w-full bg-gray-200 flex items-center justify-center text-gray-400"><x-heroicon-o-photo class="w-6 h-6" /></div>
                                            @endif
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-900 line-clamp-2 group-hover:text-indigo-600 transition-colors">{{ $buku->judul_buku }}</h3>
                                            <p class="text-xs text-gray-500 mt-1 font-mono">{{ $buku->isbn }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="space-y-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 border border-indigo-200">{{ $buku->kategori->nama_kategori ?? 'Umum' }}</span>
                                        <div class="text-sm text-gray-600 flex flex-wrap gap-1">
                                            @foreach($buku->penulis->take(2) as $penulis)
                                                <span class="bg-gray-100 px-1.5 py-0.5 rounded text-xs text-gray-700">{{ $penulis->nama_penulis }}</span>
                                            @endforeach
                                        </div>
                                        <p class="text-xs text-gray-400">{{ $buku->penerbit->nama_penerbit ?? '-' }} • {{ $buku->tahun_terbit }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-flex flex-col items-center">
                                        <span class="text-lg font-bold {{ $buku->jumlah_eksemplar_tersedia > 0 ? 'text-gray-800' : 'text-red-500' }}">{{ $buku->jumlah_eksemplar_tersedia }}</span>
                                        <span class="text-[10px] uppercase tracking-wide font-semibold mt-0.5 px-2 py-0.5 rounded-full {{ $buku->jumlah_eksemplar_tersedia > 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $buku->jumlah_eksemplar_tersedia > 0 ? 'Tersedia' : 'Habis' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('buku.show', $buku->buku_id) }}" class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Detail"><x-heroicon-o-eye class="w-5 h-5" /></a>
                                        <a href="{{ route('buku.edit', $buku->buku_id) }}" class="p-2 text-gray-500 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-all" title="Edit"><x-heroicon-o-pencil-square class="w-5 h-5" /></a>
                                        
                                        {{-- Tombol Trigger Modal --}}
                                        <button @click="deleteModalOpen = true; deleteId = {{ $buku->buku_id }}" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                            <x-heroicon-o-trash class="w-5 h-5" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-16 text-center text-gray-500">Data tidak ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">{{ $bukus->links() }}</div>
        </div>

        {{-- MODAL DELETE --}}
        <div x-show="deleteModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                {{-- Overlay Gelap --}}
                <div x-show="deleteModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="deleteModalOpen = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                {{-- Modal Panel --}}
                <div x-show="deleteModalOpen" 
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-100">
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-red-600" />
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Buku</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus buku ini? Data yang dihapus tidak dapat dikembalikan.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="button" wire:click="delete(deleteId)" @click="deleteModalOpen = false" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition">
                            Ya, Hapus
                        </button>
                        <button type="button" @click="deleteModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>