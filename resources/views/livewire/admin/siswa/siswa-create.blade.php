<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Tambah Siswa</h2>
            <p class="text-sm text-gray-500 mt-1">Registrasi siswa baru.</p>
        </div>
        <a href="{{ route('siswa.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm"><x-heroicon-o-arrow-left class="w-4 h-4 mr-2" /> Kembali</a>
    </div>

    <form wire:submit="save">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Kolom Kiri: Foto & Akun --}}
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                    <div class="relative w-32 h-32 mx-auto bg-gray-100 rounded-full border-2 border-dashed border-gray-300 flex items-center justify-center overflow-hidden group hover:border-indigo-500 cursor-pointer">
                        @if ($foto_profil)
                            <img src="{{ $foto_profil->temporaryUrl() }}" class="w-full h-full object-cover">
                        @else
                            <x-heroicon-o-user class="w-12 h-12 text-gray-400" />
                        @endif
                        {{-- Gunakan wire:model.live agar preview langsung muncul --}}
                        <input type="file" wire:model.live="foto_profil" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    <p class="text-sm font-medium text-gray-700 mt-3">Foto Profil</p>
                    <p class="text-xs text-gray-400">Klik untuk upload</p>
                    @error('foto_profil') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Akun Login</h3>
                    <div class="space-y-4">
                         <div class="relative group">
                            <input type="email" wire:model="email" class="input-field peer" placeholder=" " />
                            <label class="input-label">Email (Opsional)</label>
                            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="p-3 bg-blue-50 text-blue-700 text-xs rounded-lg border border-blue-100">
                            <strong>Info:</strong> Username login otomatis menggunakan <strong>NIS</strong> dan password default <strong>siswa123</strong>.
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Data Diri --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600"><x-heroicon-o-identification class="w-5 h-5" /></div>
                        Data Pribadi
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-2 relative group">
                            <input type="text" wire:model="nama_lengkap" class="input-field peer" placeholder=" " />
                            <label class="input-label">Nama Lengkap</label>
                             @error('nama_lengkap') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="relative group">
                            <input type="text" wire:model.live="nis" class="input-field peer" placeholder=" " />
                            <label class="input-label">NIS</label>
                             @error('nis') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>
                        
                        {{-- PERBAIKAN: Dropdown Kelas --}}
                        <div class="relative group">
                            <select wire:model.live="kelas_id" required class="input-field peer appearance-none cursor-pointer">
                                <option value="" disabled selected>Pilih Kelas</option>
                                @foreach($kelases as $kelas) 
                                    <option value="{{ $kelas->kelas_id }}">{{ $kelas->nama_kelas }}</option> 
                                @endforeach
                            </select>
                            <label class="input-label">Kelas</label>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <x-heroicon-o-chevron-down class="w-4 h-4" />
                            </div>
                            @error('kelas_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- PERBAIKAN: Dropdown Jenis Kelamin --}}
                        <div class="relative group">
                            <select wire:model.live="jenis_kelamin" required class="input-field peer appearance-none cursor-pointer">
                                <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            <label class="input-label">Jenis Kelamin</label>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <x-heroicon-o-chevron-down class="w-4 h-4" />
                            </div>
                            @error('jenis_kelamin') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="relative group">
                            <input type="text" wire:model="tempat_lahir" class="input-field peer" placeholder=" " />
                            <label class="input-label">Tempat Lahir</label>
                        </div>
                        <div class="relative group">
                            <input type="date" wire:model="tanggal_lahir" class="input-field peer" placeholder=" " />
                            <label class="input-label">Tanggal Lahir</label>
                        </div>
                         <div class="col-span-2 relative group">
                            <textarea wire:model="alamat" class="input-field peer h-auto py-4" rows="3" placeholder=" "></textarea>
                            <label class="input-label">Alamat Lengkap</label>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">Kontak & Orang Tua</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative group">
                            <input type="text" wire:model="nomor_telepon" class="input-field peer" placeholder=" " />
                            <label class="input-label">No. HP Siswa</label>
                        </div>
                         <div class="relative group">
                            <input type="text" wire:model="nama_orangtua" class="input-field peer" placeholder=" " />
                            <label class="input-label">Nama Orang Tua</label>
                        </div>
                         <div class="relative group">
                            <input type="text" wire:model="telepon_orangtua" class="input-field peer" placeholder=" " />
                            <label class="input-label">No. HP Orang Tua</label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-200 flex items-center justify-center gap-2">
                    <x-heroicon-o-check class="w-5 h-5" /> Simpan Siswa
                </button>
            </div>
        </div>
    </form>
</div>