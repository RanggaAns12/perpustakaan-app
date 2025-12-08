<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Data Siswa</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi akademik dan pribadi siswa.</p>
        </div>
        <a href="{{ route('siswa.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
            <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" />
            Kembali
        </a>
    </div>

    <form wire:submit="update">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Kolom Kiri: Foto & Akun --}}
            <div class="space-y-6">
                {{-- Card Foto --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                    <h3 class="text-sm font-semibold text-gray-800 mb-4">Foto Profil</h3>
                    
                    <div class="relative w-40 h-40 mx-auto bg-gray-50 rounded-full border-4 border-white shadow-lg overflow-hidden group cursor-pointer">
                        @if ($new_foto)
                            <img src="{{ $new_foto->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif ($old_foto)
                            <img src="{{ asset('storage/' . $old_foto) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300">
                                <x-heroicon-o-user class="w-20 h-20" />
                            </div>
                        @endif
                        
                        {{-- Overlay --}}
                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                            <x-heroicon-o-camera class="w-8 h-8 text-white" />
                        </div>
                        
                        <input type="file" wire:model="new_foto" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    
                    <p class="text-xs text-gray-400 mt-3">Klik foto untuk mengganti</p>
                    @error('new_foto') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Card Akun Login --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-sm font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <x-heroicon-o-key class="w-4 h-4 text-indigo-500" /> Akun Login
                    </h3>
                    
                    <div class="space-y-4">
                         <div class="relative group">
                            <input type="email" id="email" wire:model="email" class="input-field peer" placeholder=" " />
                            <label for="email" class="input-label">Email Siswa</label>
                            @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="p-3 bg-yellow-50 border border-yellow-100 rounded-xl">
                            <p class="text-xs text-yellow-700">
                                <strong>Note:</strong> Username login adalah <strong>NIS</strong>. Password tidak ditampilkan demi keamanan.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Data Form --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Card Data Pribadi --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600">
                            <x-heroicon-o-identification class="w-5 h-5" />
                        </div>
                        Data Pribadi
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2 relative group">
                            <input type="text" id="nama_lengkap" wire:model="nama_lengkap" class="input-field peer" placeholder=" " />
                            <label for="nama_lengkap" class="input-label">Nama Lengkap</label>
                            @error('nama_lengkap') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="relative group">
                            <input type="text" id="nis" wire:model="nis" class="input-field peer" placeholder=" " />
                            <label for="nis" class="input-label">NIS</label>
                            @error('nis') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="relative group">
                            <select id="kelas_id" wire:model="kelas_id" class="input-field peer appearance-none cursor-pointer">
                                <option value="" disabled></option>
                                @foreach($kelases as $kelas)
                                    <option value="{{ $kelas->kelas_id }}">{{ $kelas->nama_kelas }}</option>
                                @endforeach
                            </select>
                            <label for="kelas_id" class="input-label">Kelas</label>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <x-heroicon-o-chevron-down class="w-4 h-4" />
                            </div>
                            @error('kelas_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="relative group">
                            <select id="jenis_kelamin" wire:model="jenis_kelamin" class="input-field peer appearance-none cursor-pointer">
                                <option value="" disabled></option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <label for="jenis_kelamin" class="input-label">Jenis Kelamin</label>
                             <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <x-heroicon-o-chevron-down class="w-4 h-4" />
                            </div>
                            @error('jenis_kelamin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="relative group">
                            <input type="text" id="tempat_lahir" wire:model="tempat_lahir" class="input-field peer" placeholder=" " />
                            <label for="tempat_lahir" class="input-label">Tempat Lahir</label>
                        </div>

                        <div class="relative group">
                            <input type="date" id="tanggal_lahir" wire:model="tanggal_lahir" class="input-field peer" placeholder=" " />
                            <label for="tanggal_lahir" class="input-label">Tanggal Lahir</label>
                        </div>

                        <div class="col-span-2 relative group">
                            <textarea id="alamat" wire:model="alamat" rows="3" class="input-field peer h-auto py-4" placeholder=" "></textarea>
                            <label for="alamat" class="input-label">Alamat Lengkap</label>
                        </div>
                    </div>
                </div>

                {{-- Card Kontak --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                            <x-heroicon-o-phone class="w-5 h-5" />
                        </div>
                        Kontak & Orang Tua
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative group">
                            <input type="text" id="nomor_telepon" wire:model="nomor_telepon" class="input-field peer" placeholder=" " />
                            <label for="nomor_telepon" class="input-label">No. HP Siswa</label>
                        </div>

                        <div class="md:col-span-2 border-t border-gray-100 my-2"></div>

                        <div class="relative group">
                            <input type="text" id="nama_orangtua" wire:model="nama_orangtua" class="input-field peer" placeholder=" " />
                            <label for="nama_orangtua" class="input-label">Nama Orang Tua/Wali</label>
                        </div>

                        <div class="relative group">
                            <input type="text" id="telepon_orangtua" wire:model="telepon_orangtua" class="input-field peer" placeholder=" " />
                            <label for="telepon_orangtua" class="input-label">No. HP Orang Tua</label>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex justify-end gap-4 pt-4">
                    <a href="{{ route('siswa.index') }}" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition shadow-sm">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-200 transform hover:-translate-y-0.5 flex items-center gap-2 disabled:opacity-50" wire:loading.attr="disabled">
                        <x-heroicon-o-check class="w-5 h-5" wire:loading.remove />
                        <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>