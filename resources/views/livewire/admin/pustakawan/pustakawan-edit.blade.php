<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Pustakawan</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui data petugas <span class="text-indigo-600 font-semibold">{{ $nama_lengkap }}</span>.</p>
        </div>
        <a href="{{ route('pustakawan.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
            <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" /> Kembali
        </a>
    </div>

    <form wire:submit="update">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                    <h3 class="text-sm font-semibold text-gray-800 mb-4">Foto Profil</h3>
                    <div class="relative w-40 h-40 mx-auto bg-gray-50 rounded-full border-4 border-white shadow-lg overflow-hidden group cursor-pointer">
                        @if ($new_foto)
                            <img src="{{ $new_foto->temporaryUrl() }}" class="w-full h-full object-cover">
                        @elseif ($old_foto)
                            <img src="{{ asset('storage/' . $old_foto) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-100">
                                <span class="text-4xl font-bold text-gray-400">{{ substr($nama_lengkap, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                            <x-heroicon-o-pencil class="w-8 h-8 text-white" />
                        </div>
                        <input type="file" wire:model="new_foto" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    <p class="text-xs text-gray-400 mt-2">Klik untuk ganti foto</p>
                    @error('new_foto') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6 border-b border-gray-100 pb-3">Detail Petugas</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1 md:col-span-2 relative group">
                            <input type="text" wire:model="nama_lengkap" class="input-field peer" placeholder=" " />
                            <label class="input-label">Nama Lengkap</label>
                            @error('nama_lengkap') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="relative group">
                            <input type="text" wire:model="nip" class="input-field peer" placeholder=" " />
                            <label class="input-label">NIP</label>
                            @error('nip') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="relative group">
                            <input type="email" wire:model="email" class="input-field peer" placeholder=" " />
                            <label class="input-label">Email</label>
                            @error('email') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="relative group">
                            <input type="text" wire:model="nomor_telepon" class="input-field peer" placeholder=" " />
                            <label class="input-label">Nomor Telepon</label>
                        </div>

                        <div class="relative group">
                            <select wire:model="shift_kerja" class="input-field peer appearance-none cursor-pointer">
                                <option value="Pagi">Shift Pagi</option>
                                <option value="Siang">Shift Siang</option>
                                <option value="Full Time">Full Time</option>
                            </select>
                            <label class="input-label">Shift Kerja</label>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400"><x-heroicon-o-chevron-down class="w-4 h-4" /></div>
                        </div>

                        <div class="relative group">
                            <input type="date" wire:model="tanggal_bergabung" class="input-field peer" placeholder=" " />
                            <label class="input-label">Tanggal Bergabung</label>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-200 flex items-center gap-2">
                        <x-heroicon-o-check class="w-5 h-5" /> Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>