<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 animate-fade-in-up">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Pengaturan Landing Page</h1>
            <p class="text-gray-500 mt-2">Kustomisasi tampilan halaman depan (Beranda) website.</p>
        </div>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm transition">
            <div class="bg-green-100 text-green-600 p-2 rounded-full">
                <x-heroicon-o-check class="w-5 h-5" />
            </div>
            <div>
                <p class="font-semibold">Berhasil Disimpan!</p>
                <p class="text-sm">{{ session('message') }}</p>
            </div>
        </div>
    @endif

    <form wire:submit="update">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Kolom Kiri: Gambar Hero --}}
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                            <x-heroicon-o-photo class="w-5 h-5" />
                        </div>
                        Gambar Utama
                    </h3>
                    
                    <div class="relative w-full aspect-video bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 flex flex-col items-center justify-center overflow-hidden group hover:border-indigo-500 hover:bg-indigo-50/30 transition-all duration-300 cursor-pointer">
                        
                        @if ($gambar_hero_baru)
                            <img src="{{ $gambar_hero_baru->temporaryUrl() }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                <p class="text-white font-medium text-sm bg-black/50 px-3 py-1 rounded-full backdrop-blur-sm">Ganti Baru</p>
                            </div>
                        @elseif ($gambar_hero_lama)
                            <img src="{{ asset('storage/' . $gambar_hero_lama) }}" class="w-full h-full object-cover transition duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                <p class="text-white font-medium text-sm bg-black/50 px-3 py-1 rounded-full backdrop-blur-sm">Ganti Gambar</p>
                            </div>
                        @else
                            <div class="text-center p-6 group-hover:scale-105 transition duration-300">
                                <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <x-heroicon-o-arrow-up-tray class="w-6 h-6" />
                                </div>
                                <p class="text-sm font-medium text-gray-700">Upload Ilustrasi</p>
                                <p class="text-xs text-gray-400 mt-1">Format: JPG, PNG (Max 15MB)</p>
                            </div>
                        @endif
                        
                        <input type="file" wire:model="gambar_hero_baru" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                    </div>

                    {{-- Loading Indicator --}}
                    <div wire:loading wire:target="gambar_hero_baru" class="w-full mt-3">
                        <div class="h-1 w-full bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-500 animate-progress"></div>
                        </div>
                        <p class="text-center text-xs text-indigo-600 mt-1 animate-pulse">Mengupload...</p>
                    </div>
                    
                    @error('gambar_hero_baru') 
                        <p class="text-red-500 text-xs mt-2 flex items-center">
                            <x-heroicon-o-exclamation-circle class="w-4 h-4 mr-1" /> {{ $message }}
                        </p> 
                    @enderror
                </div>

                {{-- Preview Tombol CTA --}}
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-2xl shadow-lg p-6 text-center text-white">
                    <p class="text-xs text-indigo-200 uppercase tracking-widest font-bold mb-4">Preview Tombol</p>
                    <button type="button" class="px-6 py-3 bg-white text-indigo-600 rounded-xl font-bold shadow-lg transform transition hover:scale-105 pointer-events-none">
                        {{ $text_cta ?: 'Mulai Membaca' }}
                    </button>
                </div>
            </div>

            {{-- Kolom Kanan: Form Konten --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Card Hero Content --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2 border-b border-gray-100 pb-3">
                        <x-heroicon-o-computer-desktop class="w-5 h-5 text-indigo-600" />
                        Konten Hero (Atas)
                    </h3>

                    <div class="space-y-6">
                        {{-- Tagline --}}
                        <div class="relative group">
                            <input type="text" id="tagline" wire:model="tagline" class="input-field peer" placeholder=" " />
                            <label for="tagline" class="input-label">Tagline (Teks Kecil di Atas Judul)</label>
                            @error('tagline') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Judul Utama --}}
                        <div class="relative group">
                            <input type="text" id="judul_hero" wire:model="judul_hero" class="input-field peer font-bold" placeholder=" " />
                            <label for="judul_hero" class="input-label">Judul Utama (Headline)</label>
                            @error('judul_hero') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- Deskripsi --}}
                        <div class="relative group">
                            <textarea id="deskripsi_hero" wire:model="deskripsi_hero" rows="3" class="input-field peer h-auto py-4" placeholder=" "></textarea>
                            <label for="deskripsi_hero" class="input-label">Deskripsi Singkat</label>
                        </div>

                        {{-- Text CTA --}}
                        <div class="relative group">
                            <input type="text" id="text_cta" wire:model="text_cta" class="input-field peer" placeholder=" " />
                            <label for="text_cta" class="input-label">Teks Tombol Aksi (CTA)</label>
                        </div>
                    </div>
                </div>

                {{-- Card Kontak Footer --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2 border-b border-gray-100 pb-3">
                        <x-heroicon-o-information-circle class="w-5 h-5 text-indigo-600" />
                        Informasi Kontak (Footer)
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1 md:col-span-2 relative group">
                            <input type="text" id="alamat" wire:model="alamat" class="input-field peer" placeholder=" " />
                            <label for="alamat" class="input-label">Alamat Sekolah</label>
                        </div>

                        <div class="relative group">
                            <input type="text" id="telepon" wire:model="telepon" class="input-field peer" placeholder=" " />
                            <label for="telepon" class="input-label">Nomor Telepon</label>
                        </div>

                        <div class="relative group">
                            <input type="email" id="email" wire:model="email" class="input-field peer" placeholder=" " />
                            <label for="email" class="input-label">Email Resmi</label>
                        </div>
                    </div>
                </div>

                {{-- Tombol Simpan --}}
                <div class="flex justify-end pt-4">
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-200 transform hover:-translate-y-0.5 flex items-center gap-2 disabled:opacity-50" 
                            wire:loading.attr="disabled">
                        
                        <x-heroicon-o-check class="w-5 h-5" wire:loading.remove />
                        
                        {{-- Loading Spinner --}}
                        <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        
                        <span>Simpan Perubahan</span>
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>