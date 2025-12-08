<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Jurusan</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi jurusan.</p>
        </div>
        <a href="{{ route('jurusan.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm"><x-heroicon-o-arrow-left class="w-4 h-4 mr-2" /> Kembali</a>
    </div>

    <div class="max-w-2xl mx-auto">
        <form wire:submit="update">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600"><x-heroicon-o-briefcase class="w-5 h-5" /></div>
                    Edit Jurusan
                </h3>
                
                <div class="space-y-6">
                    <div class="relative group">
                        <input type="text" wire:model="nama_jurusan" class="input-field peer" placeholder=" " />
                        <label class="input-label">Nama Jurusan</label>
                        @error('nama_jurusan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="relative group">
                        <input type="text" wire:model="kode_jurusan" class="input-field peer" placeholder=" " />
                        <label class="input-label">Kode Singkatan</label>
                        @error('kode_jurusan') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="pt-8 mt-6 border-t border-gray-100">
                    <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-200 flex items-center justify-center gap-2">
                        <x-heroicon-o-check class="w-5 h-5" /> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>