<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Data Guru</h2>
                <p class="text-sm text-gray-500 mt-1">Perbarui informasi guru <span class="text-indigo-600 font-semibold">{{ $nama_lengkap }}</span>.</p>
            </div>
            <a href="{{ route('guru.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" /> Kembali
            </a>
        </div>

        <form wire:submit="update">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- Kolom Kiri: Foto --}}
                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                        <h3 class="text-sm font-semibold text-gray-800 mb-4">Foto Profil</h3>
                        
                        <div class="relative w-40 h-40 mx-auto bg-gray-50 rounded-full border-4 border-white shadow-lg overflow-hidden group cursor-pointer">
                            @if ($new_foto)
                                <img src="{{ $new_foto->temporaryUrl() }}" class="w-full h-full object-cover">
                            @elseif ($old_foto)
                                <img src="{{ asset('storage/' . $old_foto) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-300">
                                    <span class="text-4xl font-bold">{{ substr($nama_lengkap, 0, 1) }}</span>
                                </div>
                            @endif
                            
                            <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                <x-heroicon-o-pencil class="w-8 h-8 text-white" />
                            </div>
                            
                            <input type="file" wire:model="new_foto" class="absolute inset-0 opacity-0 cursor-pointer">
                        </div>
                        
                        <p class="text-xs text-gray-400 mt-3">Klik gambar untuk mengganti</p>
                        @error('new_foto') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Kolom Kanan: Form --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6 border-b border-gray-100 pb-3">Detail Informasi</h3>

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
                                <select wire:model="jenis_kelamin" class="input-field peer appearance-none cursor-pointer">
                                    <option value="" disabled></option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                                <label class="input-label">Jenis Kelamin</label>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                    <x-heroicon-o-chevron-down class="w-4 h-4" />
                                </div>
                            </div>

                            <div class="col-span-1 md:col-span-2 relative group">
                                <input type="text" wire:model="mata_pelajaran" class="input-field peer" placeholder=" " />
                                <label class="input-label">Mata Pelajaran</label>
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
                        </div>

                        {{-- Status Toggle --}}
                        <div class="mt-6 pt-6 border-t border-gray-100 flex items-center justify-between">
                            <div>
                                <span class="block text-sm font-medium text-gray-900">Status Akun</span>
                                <span class="text-xs text-gray-500">Matikan jika guru sudah tidak aktif.</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-medium {{ $status == 'Aktif' ? 'text-green-600' : 'text-red-500' }}">
                                    {{ $status }}
                                </span>
                                <button type="button" 
                                        wire:click="$set('status', '{{ $status == 'Aktif' ? 'Tidak Aktif' : 'Aktif' }}')"
                                        class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none {{ $status == 'Aktif' ? 'bg-indigo-600' : 'bg-gray-200' }}">
                                    <span class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $status == 'Aktif' ? 'translate-x-5' : 'translate-x-0' }}"></span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4">
                        <a href="{{ route('guru.index') }}" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition shadow-sm">
                            Batal
                        </a>
                        <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-200 flex items-center gap-2">
                            <x-heroicon-o-check class="w-5 h-5" /> Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>