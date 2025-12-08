<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Tambah Periode</h2>
            <p class="text-sm text-gray-500 mt-1">Buka tahun ajaran atau semester baru.</p>
        </div>
        <a href="{{ route('tahun-ajaran.index') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
            <x-heroicon-o-arrow-left class="w-4 h-4 mr-2" /> Kembali
        </a>
    </div>

    <div class="max-w-2xl mx-auto">
        <form wire:submit="save">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8">
                
                <h3 class="text-lg font-semibold text-gray-800 mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600">
                        <x-heroicon-o-calendar-days class="w-5 h-5" />
                    </div>
                    Periode Akademik
                </h3>
                
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Tahun Ajaran --}}
                        <div class="relative group">
                            <input type="text" 
                                   id="tahun_ajaran" 
                                   wire:model="tahun_ajaran" 
                                   class="input-field peer" 
                                   placeholder=" " required />
                            <label for="tahun_ajaran" class="input-label">Tahun Ajaran (2024/2025)</label>
                            @error('tahun_ajaran') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        {{-- Semester --}}
                        <div class="relative group">
                            {{-- PERBAIKAN: Tambahkan ID dan Required --}}
                            <select id="semester" 
                                    wire:model.change="semester" 
                                    class="input-field peer appearance-none cursor-pointer" 
                                    required>
                                <option value="" disabled selected>Pilih Semester</option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                            
                            {{-- PERBAIKAN: Tambahkan FOR agar label bisa diklik --}}
                            <label for="semester" class="input-label">Semester</label>
                            
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <x-heroicon-o-chevron-down class="w-4 h-4" />
                            </div>
                            @error('semester') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Input Tanggal --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="relative group">
                            <input type="date" 
                                   id="tanggal_mulai" 
                                   wire:model="tanggal_mulai" 
                                   class="input-field peer" 
                                   placeholder=" " required />
                            <label for="tanggal_mulai" class="input-label">Tanggal Mulai</label>
                            @error('tanggal_mulai') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div class="relative group">
                            <input type="date" 
                                   id="tanggal_selesai" 
                                   wire:model="tanggal_selesai" 
                                   class="input-field peer" 
                                   placeholder=" " required />
                            <label for="tanggal_selesai" class="input-label">Tanggal Selesai</label>
                            @error('tanggal_selesai') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    {{-- Toggle Aktif --}}
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <div>
                            <span class="block text-sm font-medium text-gray-900">Status Aktif</span>
                            <span class="text-xs text-gray-500">Set sebagai periode berjalan?</span>
                        </div>
                        
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" wire:model="is_aktif" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                        </label>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex justify-end gap-4 pt-8 mt-4 border-t border-gray-100">
                    <a href="{{ route('tahun-ajaran.index') }}" class="px-6 py-3 bg-white border border-gray-300 text-gray-700 rounded-xl font-semibold hover:bg-gray-50 transition shadow-sm">Batal</a>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition shadow-lg shadow-indigo-200 flex items-center gap-2">
                        <x-heroicon-o-check class="w-5 h-5" /> Simpan Periode
                    </button>
                </div>

            </div>
        </form>
    </div>
</div>