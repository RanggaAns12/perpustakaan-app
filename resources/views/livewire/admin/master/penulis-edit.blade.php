<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Edit Penulis</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi penulis <span class="text-indigo-600 font-semibold">{{ $nama_penulis }}</span>.</p>
        </div>
        <a href="{{ route('penulis.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-indigo-600 transition shadow-sm">
            <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" /> Kembali
        </a>
    </div>

    <div class="max-w-3xl mx-auto">
        <form wire:submit="update">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                
                <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600"><x-heroicon-o-pencil-square class="w-5 h-5" /></div>
                    Edit Data Diri
                </h3>

                <div class="space-y-6">
                    {{-- Nama Penulis --}}
                    <div class="relative group">
                        <input type="text" id="nama_penulis" wire:model="nama_penulis" class="input-field peer" placeholder=" " />
                        <label for="nama_penulis" class="input-label">Nama Lengkap Penulis</label>
                        @error('nama_penulis') <span class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</span> @enderror
                    </div>

                    {{-- Kebangsaan --}}
                    <div class="relative group">
                        <input type="text" id="kebangsaan" wire:model="kebangsaan" class="input-field peer" placeholder=" " />
                        <label for="kebangsaan" class="input-label">Kebangsaan</label>
                    </div>

                    {{-- Biografi --}}
                    <div class="relative group">
                        <textarea id="biografi" wire:model="biografi" rows="6" class="input-field peer h-auto py-4 min-h-[150px]" placeholder=" "></textarea>
                        <label for="biografi" class="input-label">Biografi Singkat</label>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-8 mt-4 border-t border-gray-100">
                    <a href="{{ route('penulis.index') }}" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition shadow-sm">Batal</a>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-200 flex items-center gap-2">
                        <x-heroicon-o-check class="w-5 h-5" /> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>