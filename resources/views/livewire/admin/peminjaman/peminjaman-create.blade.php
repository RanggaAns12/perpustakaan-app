<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Buat Transaksi Baru</h2>
            <p class="text-sm text-gray-500 mt-1">Formulir peminjaman buku perpustakaan.</p>
        </div>
        <a href="{{ route('peminjaman.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
            <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" /> Kembali
        </a>
    </div>

    <div class="max-w-3xl mx-auto">
        
        {{-- PERBAIKAN: Tambahkan Blok Alert Error di Sini --}}
        @if (session()->has('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-start gap-3 shadow-sm animate-fade-in-up">
                <x-heroicon-o-x-circle class="w-6 h-6 shrink-0 mt-0.5" />
                <div>
                    <h4 class="font-bold">Gagal Menyimpan!</h4>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            </div>
        @endif
        {{-- Akhir Blok Alert --}}

        <form wire:submit="save">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                
                {{-- Data Peminjam --}}
                <div class="mb-8 pb-8 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600">
                            <x-heroicon-o-user-group class="w-5 h-5" />
                        </div>
                        Pilih Peminjam
                    </h3>
                    
                    <div class="space-y-6">
                        <div class="relative group">
                            {{-- Tambahkan wire:model.live agar update realtime --}}
                            <select wire:model.live="siswa_id" required class="input-field peer appearance-none cursor-pointer">
                                <option value="" disabled selected>Pilih Siswa...</option>
                                @foreach($siswas as $siswa)
                                    <option value="{{ $siswa->siswa_id }}">{{ $siswa->nis }} - {{ $siswa->nama_lengkap }}</option>
                                @endforeach
                            </select>
                            <label class="input-label">Nama Siswa</label>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <x-heroicon-o-chevron-down class="w-4 h-4" />
                            </div>
                            @error('siswa_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                {{-- Detail Peminjaman --}}
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600">
                            <x-heroicon-o-book-open class="w-5 h-5" />
                        </div>
                        Detail Peminjaman
                    </h3>
                    
                    <div class="space-y-6">
                        <div class="relative group">
                            {{-- Tambahkan wire:model.live --}}
                            <select wire:model.live="buku_id" required class="input-field peer appearance-none cursor-pointer">
                                <option value="" disabled selected>Pilih Buku...</option>
                                @foreach($bukus as $buku)
                                    <option value="{{ $buku->buku_id }}">{{ $buku->judul_buku }} (Sisa Stok: {{ $buku->jumlah_eksemplar_tersedia }})</option>
                                @endforeach
                            </select>
                            <label class="input-label">Judul Buku</label>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <x-heroicon-o-chevron-down class="w-4 h-4" />
                            </div>
                            @error('buku_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative group">
                                <input type="date" wire:model="tanggal_peminjaman" class="input-field peer" placeholder=" " required />
                                <label class="input-label">Tanggal Pinjam</label>
                                @error('tanggal_peminjaman') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div class="relative group">
                                <input type="date" wire:model="tanggal_jatuh_tempo" class="input-field peer" placeholder=" " required />
                                <label class="input-label">Jatuh Tempo</label>
                                @error('tanggal_jatuh_tempo') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Tombol Simpan --}}
                <div class="pt-8 mt-8 border-t border-gray-100 flex justify-end">
                    <button type="submit" 
                            class="w-full md:w-auto px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold rounded-xl hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-200 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                            wire:loading.attr="disabled">
                        
                        {{-- Loading Spinner --}}
                        <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>

                        <span wire:loading.remove><x-heroicon-o-check class="w-5 h-5 inline mr-1" /> Simpan Transaksi</span>
                        <span wire:loading>Memproses...</span>
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>