<div> {{-- ROOT ELEMENT (WAJIB ADA) --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Tambah Guru Baru</h2>
                <p class="text-sm text-gray-500 mt-1">Registrasi tenaga pengajar ke dalam sistem.</p>
            </div>
            <a href="{{ route('guru.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" /> Kembali
            </a>
        </div>

        <form wire:submit="save">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Kolom Kiri: Foto & Akun --}}
                <div class="space-y-6">
                    {{-- Upload Foto --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                        <h3 class="text-sm font-semibold text-gray-800 mb-4">Foto Profil</h3>
                        
                        <div class="relative w-40 h-40 mx-auto bg-gray-50 rounded-full border-4 border-white shadow-lg overflow-hidden group cursor-pointer hover:border-indigo-100 transition-all">
                            @if ($foto_profil)
                                <img src="{{ $foto_profil->temporaryUrl() }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex flex-col items-center justify-center text-gray-400">
                                    <x-heroicon-o-user class="w-16 h-16 mb-2" />
                                    <span class="text-xs">Upload Foto</span>
                                </div>
                            @endif
                            
                            {{-- Overlay --}}
                            <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                <x-heroicon-o-camera class="w-8 h-8 text-white" />
                            </div>
                            
                            <input type="file" wire:model.live="foto_profil" class="absolute inset-0 opacity-0 cursor-pointer">
                        </div>
                        
                        @error('foto_profil') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                        
                        <div class="mt-4 p-3 bg-blue-50 rounded-xl text-xs text-blue-700 text-left">
                            <p class="font-bold mb-1">Info Akun Login:</p>
                            <ul class="list-disc list-inside space-y-0.5">
                                <li>Username: <strong>NIP</strong></li>
                                <li>Password: <strong>guru123</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Kolom Kanan: Form Data --}}
                <div class="lg:col-span-2 space-y-6">
                    
                    {{-- Card Data Pribadi --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600">
                                <x-heroicon-o-identification class="w-5 h-5" />
                            </div>
                            Informasi Pribadi
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Nama Lengkap --}}
                            <div class="col-span-1 md:col-span-2 relative group">
                                <input type="text" wire:model="nama_lengkap" class="input-field peer" placeholder=" " />
                                <label class="input-label">Nama Lengkap (dengan Gelar)</label>
                                @error('nama_lengkap') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- NIP --}}
                            <div class="relative group">
                                <input type="text" wire:model.live.debounce.500ms="nip" class="input-field peer" placeholder=" " />
                                <label class="input-label">NIP (Nomor Induk Pegawai)</label>
                                @error('nip') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div class="relative group">
                                {{-- PERBAIKAN: Tambahkan atribut 'required' di sini --}}
                                <select wire:model.live="jenis_kelamin" required class="input-field peer appearance-none cursor-pointer">
                                    <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                
                                <label class="input-label">Jenis Kelamin</label>
                                
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                    <x-heroicon-o-chevron-down class="w-4 h-4" />
                                </div>
                                
                                @error('jenis_kelamin') 
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
                                @enderror
                            </div>

                            {{-- Mata Pelajaran --}}
                            <div class="col-span-1 md:col-span-2 relative group">
                                <input type="text" wire:model="mata_pelajaran" class="input-field peer" placeholder=" " />
                                <label class="input-label">Mata Pelajaran Utama (Opsional)</label>
                            </div>
                        </div>
                    </div>

                    {{-- Card Kontak --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                                <x-heroicon-o-phone class="w-5 h-5" />
                            </div>
                            Kontak & Status
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            {{-- Email --}}
                            <div class="relative group">
                                <input type="email" wire:model.live.debounce.500ms="email" class="input-field peer" placeholder=" " />
                                <label class="input-label">Alamat Email</label>
                                @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Telepon --}}
                            <div class="relative group">
                                <input type="text" wire:model="nomor_telepon" class="input-field peer" placeholder=" " />
                                <label class="input-label">Nomor Telepon / WA</label>
                                @error('nomor_telepon') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>

                            {{-- Status (Toggle) --}}
                            <div class="col-span-1 md:col-span-2 flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                                <div>
                                    <span class="block text-sm font-medium text-gray-900">Status Kepegawaian</span>
                                    <span class="text-xs text-gray-500">Apakah guru ini aktif mengajar?</span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-medium {{ $status == 'Aktif' ? 'text-green-600' : 'text-gray-500' }}">{{ $status }}</span>
                                    <button type="button" 
                                            wire:click="$set('status', '{{ $status == 'Aktif' ? 'Tidak Aktif' : 'Aktif' }}')"
                                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $status == 'Aktif' ? 'bg-indigo-600' : 'bg-gray-200' }}">
                                        <span class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $status == 'Aktif' ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-end gap-4 pt-2">
                        <a href="{{ route('guru.index') }}" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition shadow-sm">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-200 transform hover:-translate-y-0.5 flex items-center gap-2 disabled:opacity-70" wire:loading.attr="disabled">
                            <x-heroicon-o-check class="w-5 h-5" wire:loading.remove />
                            <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Simpan Data
                        </button>
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>