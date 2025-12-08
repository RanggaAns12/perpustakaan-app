<div> {{-- ROOT ELEMENT (WAJIB ADA) --}}
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Tambah Kelas</h2>
                <p class="text-sm text-gray-500 mt-1">Buat rombongan belajar baru untuk siswa.</p>
            </div>
            <a href="{{ route('kelas.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition shadow-sm">
                <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" /> Kembali
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <form wire:submit="save">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- Kolom Kiri: Informasi Utama --}}
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                                <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600">
                                    <x-heroicon-o-academic-cap class="w-5 h-5" />
                                </div>
                                Informasi Kelas
                            </h3>
                            
                            <div class="space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Tingkat --}}
                                    <div class="relative group">
                                        {{-- PERBAIKAN: Tambah 'required' --}}
                                        <select wire:model.live="tingkat" required class="input-field peer appearance-none cursor-pointer">
                                            <option value="" disabled selected>Pilih Tingkat</option> {{-- Ubah teks agar lebih jelas --}}
                                            <option value="X">X (Sepuluh)</option>
                                            <option value="XI">XI (Sebelas)</option>
                                            <option value="XII">XII (Dua Belas)</option>
                                        </select>
                                        <label class="input-label">Tingkat</label>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                            <x-heroicon-o-chevron-down class="w-4 h-4" />
                                        </div>
                                        @error('tingkat') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Jurusan --}}
                                    <div class="relative group">
                                        {{-- PERBAIKAN: Tambah 'required' --}}
                                        <select wire:model.live="jurusan_id" required class="input-field peer appearance-none cursor-pointer">
                                            <option value="" disabled selected>Pilih Jurusan</option>
                                            @foreach($jurusans as $jurusan) 
                                                <option value="{{ $jurusan->jurusan_id }}">{{ $jurusan->nama_jurusan }}</option> 
                                            @endforeach
                                        </select>
                                        <label class="input-label">Jurusan</label>
                                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                            <x-heroicon-o-chevron-down class="w-4 h-4" />
                                        </div>
                                        @error('jurusan_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                {{-- Nama Kelas --}}
                                <div class="relative group">
                                    <input type="text" wire:model="nama_kelas" class="input-field peer" placeholder=" " />
                                    <label class="input-label">Nama Kelas (Contoh: X-RPL-1)</label>
                                    @error('nama_kelas') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                {{-- Kode Kelas --}}
                                <div class="relative group">
                                    <input type="text" wire:model="kode_kelas" class="input-field peer" placeholder=" " />
                                    <label class="input-label">Kode Unik (Contoh: XR1)</label>
                                    @error('kode_kelas') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Kanan: Administrasi --}}
                    <div class="space-y-6">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Administrasi</h3>
                            
                            <div class="space-y-4">
                                {{-- Tahun Ajaran --}}
                                <div class="relative group">
                                    {{-- PERBAIKAN: Tambah 'required' --}}
                                    <select wire:model.live="tahun_id" required class="input-field peer appearance-none cursor-pointer">
                                        <option value="" disabled selected>Pilih Tahun Ajaran</option>
                                        @foreach($tahuns as $tahun) 
                                            <option value="{{ $tahun->tahun_id }}">{{ $tahun->tahun_ajaran }} - {{ $tahun->semester }}</option> 
                                        @endforeach
                                    </select>
                                    <label class="input-label">Tahun Ajaran</label>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                        <x-heroicon-o-chevron-down class="w-4 h-4" />
                                    </div>
                                    @error('tahun_id') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                {{-- Wali Kelas --}}
                                <div class="relative group">
                                    {{-- Wali Kelas opsional, tapi untuk kerapian CSS peer, kita bisa tambahkan required --}}
                                    {{-- Atau biarkan tanpa required jika ingin benar-benar opsional, tapi pastikan style label aman --}}
                                    <select wire:model="wali_kelas" class="input-field peer appearance-none cursor-pointer">
                                        <option value="" selected>Pilih Wali Kelas (Opsional)</option>
                                        @foreach($gurus as $guru) 
                                            <option value="{{ $guru->guru_id }}">{{ $guru->nama_lengkap }}</option> 
                                        @endforeach
                                    </select>
                                    <label class="input-label">Wali Kelas</label>
                                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                        <x-heroicon-o-chevron-down class="w-4 h-4" />
                                    </div>
                                </div>

                                {{-- Kapasitas --}}
                                <div class="relative group">
                                    <input type="number" wire:model="kapasitas" class="input-field peer" placeholder=" " />
                                    <label class="input-label">Kapasitas Siswa</label>
                                    @error('kapasitas') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                                </div>

                                {{-- Ruangan --}}
                                <div class="relative group">
                                    <input type="text" wire:model="ruangan" class="input-field peer" placeholder=" " />
                                    <label class="input-label">Ruangan</label>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Simpan --}}
                        <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-200 flex items-center justify-center gap-2">
                            <x-heroicon-o-check class="w-5 h-5" /> Simpan Kelas
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

</div> {{-- END ROOT ELEMENT --}}