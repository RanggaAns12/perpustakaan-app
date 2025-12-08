<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Profil Guru</h1>
        <p class="text-gray-500 mt-2">Kelola data pribadi Anda.</p>
    </div>

    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm transition">
            <x-heroicon-o-check-circle class="w-5 h-5"/> {{ session('message') }}
        </div>
    @endif

    {{-- PENTING: Gunakan .prevent untuk mencegah reload halaman --}}
    <form wire:submit.prevent="update">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            
            {{-- Header Foto --}}
            <div class="p-6 bg-indigo-50 border-b border-indigo-100 flex items-center gap-6">
                <div class="relative w-24 h-24 bg-white rounded-full border-4 border-white shadow-md overflow-hidden group">
                    @if ($foto_profil)
                        {{-- Preview Foto Baru --}}
                        <img src="{{ $foto_profil->temporaryUrl() }}" class="w-full h-full object-cover">
                    @elseif ($foto_lama)
                        {{-- Foto Lama dari DB --}}
                        <img src="{{ asset('storage/' . $foto_lama) }}" class="w-full h-full object-cover">
                    @else
                        {{-- Placeholder --}}
                        <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-100">
                            <span class="text-2xl font-bold">{{ substr($nama_lengkap, 0, 1) }}</span>
                        </div>
                    @endif
                    
                    {{-- Input Foto --}}
                    <input type="file" wire:model="foto_profil" class="absolute inset-0 opacity-0 cursor-pointer z-20" title="Ganti Foto">
                    
                    {{-- Overlay Icon --}}
                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 z-10 pointer-events-none">
                        <x-heroicon-o-camera class="w-8 h-8 text-white" />
                    </div>
                </div>
                
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $nama_lengkap }}</h2>
                    <p class="text-indigo-600 text-sm font-medium">{{ $nip }}</p>
                    
                    {{-- Loading State untuk Upload Foto --}}
                    <div wire:loading wire:target="foto_profil" class="text-xs text-indigo-500 mt-1 italic">
                        Sedang mengupload...
                    </div>
                    @error('foto_profil') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="relative group">
                        <input type="text" id="nama_lengkap" wire:model="nama_lengkap" class="input-field peer" placeholder=" " />
                        <label for="nama_lengkap" class="input-label">Nama Lengkap</label>
                        @error('nama_lengkap') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="relative group">
                        <input type="text" id="nip" wire:model="nip" class="input-field peer" placeholder=" " />
                        <label for="nip" class="input-label">NIP (Username Login)</label>
                        @error('nip') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="relative group">
                        <input type="email" id="email" wire:model="email" class="input-field peer" placeholder=" " />
                        <label for="email" class="input-label">Email</label>
                        @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div class="relative group">
                        <input type="text" id="nomor_telepon" wire:model="nomor_telepon" class="input-field peer" placeholder=" " />
                        <label for="nomor_telepon" class="input-label">Nomor Telepon</label>
                        @error('nomor_telepon') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Ubah Password --}}
                <div class="border-t border-gray-100 pt-6">
                    <h3 class="text-sm font-bold text-gray-800 mb-4">Ubah Password</h3>
                    <p class="text-xs text-gray-500 mb-4">Biarkan kosong jika tidak ingin mengubah password.</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative group">
                            <input type="password" wire:model="password" class="input-field peer" placeholder=" " />
                            <label class="input-label">Password Baru</label>
                            @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="relative group">
                            <input type="password" wire:model="password_confirmation" class="input-field peer" placeholder=" " />
                            <label class="input-label">Konfirmasi Password Baru</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 flex justify-end">
                <button type="submit" 
                        class="px-6 py-2 bg-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled">
                    
                    <span wire:loading.remove>Simpan Perubahan</span>
                    
                    {{-- Loading Spinner saat tombol diklik --}}
                    <span wire:loading class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Menyimpan...
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>