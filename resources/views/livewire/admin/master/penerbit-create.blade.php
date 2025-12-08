<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Tambah Penerbit</h2>
            <p class="text-sm text-gray-500 mt-1">Lengkapi data penerbit untuk relasi buku.</p>
        </div>
        <a href="{{ route('penerbit.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition shadow-sm">
            <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
            Kembali
        </a>
    </div>

    <div class="max-w-4xl mx-auto">
        <form wire:submit="save">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Kolom Kiri: Informasi Utama --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600">
                                <x-heroicon-o-building-office-2 class="w-5 h-5" />
                            </div>
                            Informasi Utama
                        </h3>
                        
                        <div class="space-y-6">
                            {{-- Nama Penerbit --}}
                            <div class="relative group">
                                <input type="text" id="nama_penerbit" wire:model="nama_penerbit" class="input-field peer" placeholder=" " />
                                <label for="nama_penerbit" class="input-label">Nama Penerbit</label>
                                @error('nama_penerbit') <span class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Grid Kota & Telepon --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="relative group">
                                    <input type="text" id="kota" wire:model="kota" class="input-field peer" placeholder=" " />
                                    <label for="kota" class="input-label">Kota</label>
                                    @error('kota') <span class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</span> @enderror
                                </div>
                                <div class="relative group">
                                    <input type="text" id="telepon_penerbit" wire:model="telepon_penerbit" class="input-field peer" placeholder=" " />
                                    <label for="telepon_penerbit" class="input-label">Telepon</label>
                                    @error('telepon_penerbit') <span class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="relative group">
                                <input type="email" id="email_penerbit" wire:model="email_penerbit" class="input-field peer" placeholder=" " />
                                <label for="email_penerbit" class="input-label">Email Resmi</label>
                                @error('email_penerbit') <span class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Lokasi & Tombol --}}
                <div class="space-y-6">
                    
                    {{-- Card Alamat --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                            <x-heroicon-o-map-pin class="w-5 h-5 text-gray-400" />
                            Lokasi
                        </h3>
                        <div class="relative group">
                            <textarea id="alamat_penerbit" wire:model="alamat_penerbit" rows="5" class="input-field peer h-auto py-4 min-h-[140px]" placeholder=" "></textarea>
                            <label for="alamat_penerbit" class="input-label">Alamat Lengkap</label>
                            @error('alamat_penerbit') <span class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col gap-3">
                        <button type="submit" 
                                class="w-full px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed" 
                                wire:loading.attr="disabled">
                            <x-heroicon-o-check class="w-5 h-5" wire:loading.remove />
                            <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Simpan Data
                        </button>
                        <a href="{{ route('penerbit.index') }}" class="w-full px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition text-center shadow-sm">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>