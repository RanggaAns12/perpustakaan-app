<div class="max-w-2xl mx-auto py-8 px-4">
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-800">Edit Penerbit</h2>
        <a href="{{ route('penerbit.index') }}" class="text-gray-600 hover:text-gray-900 flex items-center gap-1 text-sm">
            <x-heroicon-o-arrow-left class="w-4 h-4" /> Kembali
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <form wire:submit="update" class="space-y-5">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerbit</label>
                <input type="text" wire:model="nama_penerbit" class="w-full rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500">
                @error('nama_penerbit') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kota</label>
                    <input type="text" wire:model="kota" class="w-full rounded-lg border-gray-300">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Telepon</label>
                    <input type="text" wire:model="telepon_penerbit" class="w-full rounded-lg border-gray-300">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" wire:model="email_penerbit" class="w-full rounded-lg border-gray-300">
                 @error('email_penerbit') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                <textarea wire:model="alamat_penerbit" rows="3" class="w-full rounded-lg border-gray-300"></textarea>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 shadow-md">Simpan</button>
            </div>
        </form>
    </div>
</div>