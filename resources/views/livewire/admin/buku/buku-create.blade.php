<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Tambah Buku Baru</h2>
            <p class="text-sm text-gray-500 mt-1">Lengkapi formulir di bawah untuk menambahkan koleksi baru.</p>
        </div>
        <a href="{{ route('buku.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition shadow-sm">
            <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
            Kembali ke Daftar
        </a>
    </div>

    <form wire:submit="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Kolom Kiri: Cover & Info Utama --}}
            <div class="space-y-6">
                
                {{-- Card Upload Cover --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Cover Buku</h3>
                    
                    <div class="relative w-full aspect-[3/4] bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 flex flex-col items-center justify-center overflow-hidden group hover:border-indigo-500 hover:bg-indigo-50/30 transition-all duration-300 cursor-pointer">
                        
                        @if ($cover_image)
                            <img src="{{ $cover_image->temporaryUrl() }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                <p class="text-white font-medium text-sm bg-black/50 px-3 py-1 rounded-full backdrop-blur-sm">Ganti Cover</p>
                            </div>
                        @else
                            <div class="text-center p-6 group-hover:scale-105 transition duration-300">
                                <div class="w-16 h-16 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <x-heroicon-o-photo class="w-8 h-8" />
                                </div>
                                <p class="text-sm font-medium text-gray-700">Klik untuk Upload</p>
                                <p class="text-xs text-gray-400 mt-1">PNG, JPG (Max. 2MB)</p>
                            </div>
                        @endif
                        
                        <input type="file" wire:model="cover_image" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                    </div>

                    @error('cover_image') 
                        <p class="text-red-500 text-xs mt-2 flex items-center">
                            <x-heroicon-o-exclamation-circle class="w-4 h-4 mr-1" /> {{ $message }}
                        </p> 
                    @enderror
                    
                    {{-- Progress Bar --}}
                    <div wire:loading wire:target="cover_image" class="w-full mt-3">
                        <div class="h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-500 animate-progress"></div>
                        </div>
                        <p class="text-center text-xs text-indigo-600 mt-1 animate-pulse">Mengupload...</p>
                    </div>
                </div>

                {{-- Card Status Stok --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Inventaris</h3>
                    
                    <div class="space-y-4">
                        <div class="relative group">
                            <input type="number" id="jumlah_eksemplar_total" wire:model="jumlah_eksemplar_total" class="input-field peer" placeholder=" " />
                            <label for="jumlah_eksemplar_total" class="input-label">Total Stok</label>
                            @error('jumlah_eksemplar_total') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="relative group">
                            <input type="text" id="lokasi_rak" wire:model="lokasi_rak" class="input-field peer" placeholder=" " />
                            <label for="lokasi_rak" class="input-label">Lokasi Rak (Contoh: R-01)</label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Detail Form --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Card Informasi Utama --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600">
                            <x-heroicon-o-information-circle class="w-5 h-5" />
                        </div>
                        Informasi Buku
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Judul (Full Width) --}}
                        <div class="col-span-1 md:col-span-2 relative group">
                            <input type="text" id="judul_buku" wire:model="judul_buku" class="input-field peer" placeholder=" " />
                            <label for="judul_buku" class="input-label">Judul Buku</label>
                            @error('judul_buku') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- ISBN --}}
                        <div class="relative group">
                            <input type="text" id="isbn" wire:model="isbn" class="input-field peer" placeholder=" " />
                            <label for="isbn" class="input-label">Nomor ISBN</label>
                            @error('isbn') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Tahun Terbit --}}
                        <div class="relative group">
                            <input type="number" id="tahun_terbit" wire:model="tahun_terbit" class="input-field peer" placeholder=" " />
                            <label for="tahun_terbit" class="input-label">Tahun Terbit</label>
                            @error('tahun_terbit') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Kategori (Select Modern) --}}
                        <div class="relative group">
                            <select id="kategori_id" wire:model="kategori_id" class="input-field peer appearance-none cursor-pointer">
                                <option value="" disabled selected></option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->kategori_id }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                            <label for="kategori_id" class="input-label">Kategori</label>
                            
                            {{-- Custom Chevron Icon --}}
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400 peer-focus:text-indigo-600 transition-colors">
                                <x-heroicon-o-chevron-down class="w-4 h-4" />
                            </div>
                            @error('kategori_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Penerbit (Select Modern) --}}
                        <div class="relative group">
                            <select id="penerbit_id" wire:model="penerbit_id" class="input-field peer appearance-none cursor-pointer">
                                <option value="" disabled selected></option>
                                @foreach($penerbits as $penerbit)
                                    <option value="{{ $penerbit->penerbit_id }}">{{ $penerbit->nama_penerbit }}</option>
                                @endforeach
                            </select>
                            <label for="penerbit_id" class="input-label">Penerbit</label>
                            
                            {{-- Custom Chevron Icon --}}
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400 peer-focus:text-indigo-600 transition-colors">
                                <x-heroicon-o-chevron-down class="w-4 h-4" />
                            </div>
                            @error('penerbit_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- 
                            CUSTOM MULTI-SELECT UNTUK PENULIS (Alpine.js)
                            Fitur: Pencarian, Tag Badges, Dropdown interaktif
                        --}}
                        <div class="col-span-1 md:col-span-2 relative" 
                             x-data="{
                                 search: '',
                                 open: false,
                                 items: {{ json_encode($semua_penulis->map(function($p){ return ['id' => $p->penulis_id, 'name' => $p->nama_penulis]; })) }},
                                 selected: @entangle('selected_penulis'),
                                 
                                 get filteredItems() {
                                     if (this.search === '') return this.items;
                                     return this.items.filter(item => 
                                         item.name.toLowerCase().includes(this.search.toLowerCase())
                                     );
                                 },
                                 
                                 toggle(id) {
                                     if (this.selected.includes(id)) {
                                         this.selected = this.selected.filter(i => i !== id);
                                     } else {
                                         this.selected.push(id);
                                     }
                                 },
                                 
                                 isSelected(id) {
                                     return this.selected.includes(id);
                                 },

                                 getName(id) {
                                    return this.items.find(i => i.id == id)?.name || 'Unknown';
                                 }
                             }">
                            
                            <label class="block text-sm font-medium text-gray-700 mb-2 ml-1">Penulis</label>
                            
                            {{-- Selected Tags Area --}}
                            <div class="flex flex-wrap gap-2 mb-3 min-h-[2rem]" x-show="selected.length > 0" x-transition>
                                <template x-for="id in selected" :key="id">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100 shadow-sm">
                                        <span x-text="getName(id)"></span>
                                        <button type="button" @click="toggle(id)" class="flex-shrink-0 ml-1.5 h-4 w-4 rounded-full inline-flex items-center justify-center text-indigo-400 hover:bg-indigo-200 hover:text-indigo-600 focus:outline-none transition">
                                            <span class="sr-only">Hapus</span>
                                            <x-heroicon-m-x-mark class="w-3 h-3" />
                                        </button>
                                    </span>
                                </template>
                            </div>

                            {{-- Search Input with Dropdown --}}
                            <div class="relative group">
                                <input type="text" 
                                       x-model="search"
                                       @focus="open = true"
                                       @click.away="open = false"
                                       class="input-field peer" 
                                       placeholder=" " />
                                <label class="input-label">Cari Penulis...</label>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                    <x-heroicon-o-magnifying-glass class="w-4 h-4" />
                                </div>

                                {{-- Dropdown List --}}
                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-2"
                                     x-transition:enter-end="opacity-100 translate-y-0"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 translate-y-0"
                                     x-transition:leave-end="opacity-0 translate-y-2"
                                     class="absolute z-50 mt-1 w-full bg-white shadow-xl rounded-xl border border-gray-100 max-h-60 overflow-auto py-1 custom-scrollbar"
                                     style="display: none;">
                                    
                                    <template x-for="item in filteredItems" :key="item.id">
                                        <div @click="toggle(item.id)" 
                                             class="cursor-pointer px-4 py-2.5 text-sm hover:bg-indigo-50 transition flex items-center justify-between group">
                                            <span x-text="item.name" :class="isSelected(item.id) ? 'font-semibold text-indigo-600' : 'text-gray-700'"></span>
                                            <x-heroicon-s-check-circle class="w-5 h-5 text-indigo-600" x-show="isSelected(item.id)" />
                                        </div>
                                    </template>
                                    
                                    <div x-show="filteredItems.length === 0" class="px-4 py-3 text-sm text-gray-500 text-center italic">
                                        Penulis tidak ditemukan.
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex justify-between items-start mt-1">
                                @error('selected_penulis') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                <span class="text-xs text-gray-400 ml-auto">*Ketik untuk mencari</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Detail Tambahan --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600">
                            <x-heroicon-o-document-text class="w-5 h-5" />
                        </div>
                        Detail & Sinopsis
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Jumlah Halaman --}}
                        <div class="relative group">
                            <input type="number" id="jumlah_halaman" wire:model="jumlah_halaman" class="input-field peer" placeholder=" " />
                            <label for="jumlah_halaman" class="input-label">Jumlah Halaman</label>
                            @error('jumlah_halaman') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Bahasa --}}
                        <div class="relative group">
                            <input type="text" id="bahasa" wire:model="bahasa" class="input-field peer" placeholder=" " />
                            <label for="bahasa" class="input-label">Bahasa</label>
                        </div>

                        {{-- Sinopsis --}}
                        <div class="col-span-1 md:col-span-2 relative group">
                            <textarea id="sinopsis" wire:model="sinopsis" rows="4" class="input-field peer h-auto py-4 min-h-[120px]" placeholder=" "></textarea>
                            <label for="sinopsis" class="input-label">Sinopsis Buku</label>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex justify-end gap-4 pt-4">
                    <a href="{{ route('buku.index') }}" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 hover:text-gray-900 transition shadow-sm">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-200 transform hover:-translate-y-0.5 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed" wire:loading.attr="disabled">
                        <x-heroicon-o-check class="w-5 h-5" wire:loading.remove />
                        <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>Simpan Buku</span>
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>