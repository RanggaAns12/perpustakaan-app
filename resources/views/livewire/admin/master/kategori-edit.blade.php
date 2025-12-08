<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Kategori</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi kategori <span class="text-indigo-600 font-semibold">{{ $nama_kategori }}</span>.</p>
        </div>
        <a href="{{ route('kategori.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition shadow-sm">
            <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" /> Kembali
        </a>
    </div>

    <div class="max-w-3xl mx-auto">
        <form wire:submit="update">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600">
                        <x-heroicon-o-pencil-square class="w-5 h-5" />
                    </div>
                    Edit Detail
                </h3>

                <div class="space-y-6">
                    <div class="relative group">
                        <input type="text" id="nama_kategori" wire:model="nama_kategori" class="input-field peer" placeholder=" " />
                        <label for="nama_kategori" class="input-label">Nama Kategori</label>
                        @error('nama_kategori') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Warna Label</label>
                        <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-xl border border-gray-200">
                            <input type="color" wire:model="kode_warna" class="h-10 w-14 rounded cursor-pointer border-0 p-0 bg-transparent shadow-sm">
                            <div class="flex-1">
                                <p class="text-sm text-gray-900 font-mono">{{ $kode_warna }}</p>
                                <p class="text-xs text-gray-500">Preview badge:</p>
                            </div>
                            <div class="px-4 py-1 rounded-full text-xs font-bold text-white shadow-sm transition-colors duration-300" style="background-color: {{ $kode_warna }}">
                                {{ $nama_kategori ?? 'Kategori' }}
                            </div>
                        </div>
                    </div>

                    <div class="relative group">
                        <textarea id="deskripsi" wire:model="deskripsi" rows="4" class="input-field peer h-auto py-4" placeholder=" "></textarea>
                        <label for="deskripsi" class="input-label">Deskripsi</label>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-8 mt-4 border-t border-gray-100">
                    <a href="{{ route('kategori.index') }}" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition shadow-sm">Batal</a>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-200 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <x-heroicon-o-check class="w-5 h-5" /> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>