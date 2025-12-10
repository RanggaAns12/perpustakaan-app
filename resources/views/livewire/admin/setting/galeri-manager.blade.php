<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Manajemen Galeri</h1>
            <p class="text-gray-500 mt-2">Upload foto kegiatan untuk ditampilkan di Landing Page.</p>
        </div>
    </div>

    @if (session()->has('message'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm transition">
            <x-heroicon-o-check-circle class="w-5 h-5"/> {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Form Upload --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-fit sticky top-24">
            <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                <x-heroicon-o-camera class="w-5 h-5 text-indigo-600" /> Upload Foto Baru
            </h3>
            
            <form wire:submit="save" class="space-y-4">
                {{-- Input Foto --}}
                <div class="relative group cursor-pointer">
                    <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-indigo-500 hover:bg-indigo-50 transition-colors">
                        @if ($foto)
                            <img src="{{ $foto->temporaryUrl() }}" class="w-full h-40 object-cover rounded-lg mb-2">
                        @else
                            <x-heroicon-o-photo class="w-10 h-10 text-gray-400 mx-auto mb-2" />
                            <p class="text-xs text-gray-500">Klik untuk upload (Max 5MB)</p>
                        @endif
                        <input type="file" wire:model="foto" class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                    @error('foto') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                {{-- Input Judul --}}
                <div class="relative group">
                    <input type="text" wire:model="judul" class="input-field peer" placeholder=" " />
                    <label class="input-label">Judul Kegiatan</label>
                    @error('judul') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                {{-- Input Deskripsi --}}
                <div class="relative group">
                    <textarea wire:model="deskripsi" rows="3" class="input-field peer h-auto py-3" placeholder=" "></textarea>
                    <label class="input-label">Deskripsi Singkat</label>
                </div>

                <button type="submit" class="w-full py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition flex items-center justify-center gap-2 shadow-lg shadow-indigo-200" wire:loading.attr="disabled">
                    <span wire:loading.remove>Upload Foto</span>
                    <span wire:loading>Mengupload...</span>
                </button>
            </form>
        </div>

        {{-- Grid Galeri --}}
        <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-4">
            @forelse($galeris as $item)
                <div class="group relative bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                    <div class="aspect-video relative overflow-hidden">
                        <img src="{{ asset('storage/' . $item->foto) }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition flex items-center justify-center">
                            <button wire:click="delete({{ $item->galeri_id }})" 
                                    wire:confirm="Hapus foto ini?"
                                    class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-lg hover:bg-red-700 transform hover:scale-105 transition">
                                Hapus
                            </button>
                        </div>
                    </div>
                    <div class="p-4">
                        <h4 class="font-bold text-gray-900 line-clamp-1">{{ $item->judul }}</h4>
                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $item->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-12 text-center text-gray-400 bg-white rounded-2xl border border-dashed border-gray-200">
                    <x-heroicon-o-photo class="w-12 h-12 mx-auto mb-2 opacity-50" />
                    <p>Belum ada foto di galeri.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>