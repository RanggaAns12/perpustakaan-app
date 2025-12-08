<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Profil Saya</h1>
        <p class="text-gray-500 mt-2">Kelola informasi akun dan data pribadi Anda.</p>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
             class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm transition">
            <div class="bg-green-100 text-green-600 p-2 rounded-full">
                <x-heroicon-o-check class="w-5 h-5" />
            </div>
            <div>
                <p class="font-semibold">Berhasil!</p>
                <p class="text-sm">{{ session('message') }}</p>
            </div>
        </div>
    @endif

    <form wire:submit="update">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- KOLOM KIRI: FOTO & INFO --}}
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                    <h3 class="text-sm font-semibold text-gray-800 mb-6">Foto Profil</h3>
                    
                    <div class="relative w-40 h-40 mx-auto bg-gray-50 rounded-full border-4 border-white shadow-lg overflow-hidden group cursor-pointer hover:border-indigo-100 transition duration-300">
                        @if ($foto_profil)
                            <img src="{{ $foto_profil->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif ($foto_lama)
                            <img src="{{ asset('storage/' . $foto_lama) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-100">
                                <span class="text-4xl font-bold text-gray-400">{{ substr($nama_lengkap, 0, 1) }}</span>
                            </div>
                        @endif
                        
                        {{-- Overlay Upload Icon --}}
                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                            <x-heroicon-o-camera class="w-8 h-8 text-white" />
                        </div>
                        
                        {{-- Input File Hidden --}}
                        <input type="file" wire:model="foto_profil" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    
                    <p class="text-xs text-gray-400 mt-3">Klik foto untuk mengganti.</p>
                    <div wire:loading wire:target="foto_profil" class="text-xs text-indigo-600 mt-1 animate-pulse">Mengupload...</div>
                    @error('foto_profil') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                </div>

                {{-- Info Read Only --}}
                <div class="bg-indigo-50 rounded-2xl border border-indigo-100 p-6">
                    <h4 class="text-sm font-bold text-indigo-900 mb-4 flex items-center gap-2">
                        <x-heroicon-o-identification class="w-4 h-4" /> Info Kepegawaian
                    </h4>
                    <div class="space-y-3">
                        <div>
                            <span class="text-xs text-indigo-400 uppercase font-semibold">NIP (Nomor Induk)</span>
                            <div class="font-mono text-sm text-indigo-800">{{ $nip ?? '-' }}</div>
                        </div>
                        <div>
                            <span class="text-xs text-indigo-400 uppercase font-semibold">Role Akun</span>
                            <div class="flex items-center gap-1 text-sm text-indigo-800">
                                <span class="w-2 h-2 rounded-full bg-green-500"></span> Pustakawan
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: FORM EDIT --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 border-b border-gray-100 pb-3 flex items-center gap-2">
                        <x-heroicon-o-pencil-square class="w-5 h-5 text-indigo-600" />
                        Edit Informasi
                    </h3>

                    <div class="space-y-6">
                        {{-- Nama Lengkap --}}
                        <div class="relative group">
                            <input type="text" id="nama_lengkap" wire:model="nama_lengkap" class="input-field peer" placeholder=" " />
                            <label for="nama_lengkap" class="input-label">Nama Lengkap</label>
                            @error('nama_lengkap') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Email --}}
                            <div class="relative group">
                                <input type="email" id="email" wire:model="email" class="input-field peer" placeholder=" " />
                                <label for="email" class="input-label">Alamat Email</label>
                                @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- No Telepon --}}
                            <div class="relative group">
                                <input type="text" id="nomor_telepon" wire:model="nomor_telepon" class="input-field peer" placeholder=" " />
                                <label for="nomor_telepon" class="input-label">Nomor Telepon / WA</label>
                                @error('nomor_telepon') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="border-t border-gray-100 my-2"></div>
                        
                        <h4 class="text-sm font-semibold text-gray-800">Ganti Password</h4>
                        <p class="text-xs text-gray-500 mb-4">Kosongkan jika tidak ingin mengubah password.</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Password Baru --}}
                            <div class="relative group" x-data="{ show: false }">
                                <input :type="show ? 'text' : 'password'" id="password" wire:model="password" class="input-field peer pr-10" placeholder=" " />
                                <label for="password" class="input-label">Password Baru</label>
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-indigo-600 focus:outline-none">
                                    <x-heroicon-o-eye class="w-5 h-5" x-show="!show" />
                                    <x-heroicon-o-eye-slash class="w-5 h-5" x-show="show" style="display: none;" />
                                </button>
                                @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            {{-- Konfirmasi Password --}}
                            <div class="relative group" x-data="{ show: false }">
                                <input :type="show ? 'text' : 'password'" id="password_confirmation" wire:model="password_confirmation" class="input-field peer pr-10" placeholder=" " />
                                <label for="password_confirmation" class="input-label">Ulangi Password Baru</label>
                                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-indigo-600 focus:outline-none">
                                    <x-heroicon-o-eye class="w-5 h-5" x-show="!show" />
                                    <x-heroicon-o-eye-slash class="w-5 h-5" x-show="show" style="display: none;" />
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-8">
                        <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-200 flex items-center gap-2">
                            <x-heroicon-o-check class="w-5 h-5" /> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>