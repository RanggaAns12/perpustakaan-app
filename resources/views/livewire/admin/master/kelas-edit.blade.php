<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Kelas</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi rombongan belajar.</p>
        </div>
        <a href="{{ route('kelas.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm"><x-heroicon-o-arrow-left class="w-4 h-4 mr-2" /> Kembali</a>
    </div>

    <div class="max-w-4xl mx-auto">
        <form wire:submit="update">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                            <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600"><x-heroicon-o-academic-cap class="w-5 h-5" /></div>
                            Informasi Kelas
                        </h3>
                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="relative group">
                                    <select wire:model="tingkat" class="input-field peer appearance-none cursor-pointer">
                                        <option value="" disabled selected></option>
                                        <option value="X">X (Sepuluh)</option>
                                        <option value="XI">XI (Sebelas)</option>
                                        <option value="XII">XII (Dua Belas)</option>
                                    </select>
                                    <label class="input-label">Tingkat</label>
                                    @error('tingkat') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="relative group">
                                    <select wire:model="jurusan_id" class="input-field peer appearance-none cursor-pointer">
                                        <option value="" disabled selected></option>
                                        @foreach($jurusans as $jurusan) <option value="{{ $jurusan->jurusan_id }}">{{ $jurusan->nama_jurusan }}</option> @endforeach
                                    </select>
                                    <label class="input-label">Jurusan</label>
                                    @error('jurusan_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="relative group">
                                <input type="text" wire:model="nama_kelas" class="input-field peer" placeholder=" " />
                                <label class="input-label">Nama Kelas (Contoh: X-RPL-1)</label>
                                @error('nama_kelas') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                             <div class="relative group">
                                <input type="text" wire:model="kode_kelas" class="input-field peer" placeholder=" " />
                                <label class="input-label">Kode Unik (Contoh: XR1)</label>
                                @error('kode_kelas') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Administrasi</h3>
                        <div class="space-y-4">
                            <div class="relative group">
                                <select wire:model="tahun_id" class="input-field peer appearance-none cursor-pointer">
                                    <option value="" disabled selected></option>
                                    @foreach($tahuns as $tahun) <option value="{{ $tahun->tahun_id }}">{{ $tahun->tahun_ajaran }} - {{ $tahun->semester }}</option> @endforeach
                                </select>
                                <label class="input-label">Tahun Ajaran</label>
                                @error('tahun_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                             <div class="relative group">
                                <select wire:model="wali_kelas" class="input-field peer appearance-none cursor-pointer">
                                    <option value="">Pilih Wali Kelas</option>
                                    @foreach($gurus as $guru) <option value="{{ $guru->guru_id }}">{{ $guru->nama_lengkap }}</option> @endforeach
                                </select>
                                <label class="input-label">Wali Kelas</label>
                            </div>
                            <div class="relative group">
                                <input type="number" wire:model="kapasitas" class="input-field peer" placeholder=" " />
                                <label class="input-label">Kapasitas Siswa</label>
                            </div>
                             <div class="relative group">
                                <input type="text" wire:model="ruangan" class="input-field peer" placeholder=" " />
                                <label class="input-label">Ruangan</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-200 flex items-center justify-center gap-2"><x-heroicon-o-check class="w-5 h-5" /> Perbarui Kelas</button>
                </div>
            </div>
        </form>
    </div>
</div>