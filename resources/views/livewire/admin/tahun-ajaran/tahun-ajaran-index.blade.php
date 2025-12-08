<div class="min-h-screen bg-gray-50/50 pb-12" x-data="{ deleteModalOpen: false, deleteId: null }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 animate-fade-in-up">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Tahun Ajaran</h1>
                <p class="text-gray-500 mt-2">Kelola periode akademik dan semester aktif sekolah.</p>
            </div>
            <a href="{{ route('tahun-ajaran.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:-translate-y-0.5 transition-all duration-200 group">
                <x-heroicon-o-plus class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" /> 
                Tambah Periode
            </a>
        </div>

        {{-- Flash Message --}}
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-white border border-green-100 px-4 py-3 rounded-xl shadow-xl shadow-green-50 transition transform hover:-translate-y-1">
                <div class="bg-green-100 text-green-600 p-2 rounded-full">
                    <x-heroicon-o-check class="w-5 h-5" />
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Berhasil!</p>
                    <p class="text-sm text-gray-500">{{ session('message') }}</p>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class="fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-white border border-red-100 px-4 py-3 rounded-xl shadow-xl shadow-red-50 transition transform hover:-translate-y-1">
                <div class="bg-red-100 text-red-600 p-2 rounded-full">
                    <x-heroicon-o-exclamation-triangle class="w-5 h-5" />
                </div>
                <div>
                    <p class="font-semibold text-gray-900">Gagal!</p>
                    <p class="text-sm text-gray-500">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        {{-- Table Section --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                            <th class="px-6 py-4 rounded-tl-2xl">Tahun Akademik</th>
                            <th class="px-6 py-4 text-center">Semester</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center rounded-tr-2xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($tahunAjarans as $item)
                            <tr class="group hover:bg-indigo-50/30 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 text-lg font-mono group-hover:text-indigo-600 transition-colors">
                                        {{ $item->tahun_ajaran }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ $item->semester == 'Ganjil' ? 'bg-orange-100 text-orange-700 border border-orange-200' : 'bg-blue-100 text-blue-700 border border-blue-200' }}">
                                        {{ $item->semester }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($item->is_aktif)
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 border border-green-200 shadow-sm">
                                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> 
                                            Aktif
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs font-medium bg-gray-100 px-2 py-1 rounded border border-gray-200">
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                        {{-- Edit Button --}}
                                        <a href="{{ route('tahun-ajaran.edit', $item->tahun_id) }}" 
                                           class="p-2 text-gray-500 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-all"
                                           title="Edit Data">
                                            <x-heroicon-o-pencil-square class="w-5 h-5" />
                                        </a>
                                        
                                        {{-- Activate Button (Only if not active) --}}
                                        @if(!$item->is_aktif)
                                            <button wire:click="aktifkan({{ $item->tahun_id }})" 
                                                    class="p-2 text-gray-500 hover:text-green-600 hover:bg-green-50 rounded-lg transition-all" 
                                                    title="Set sebagai Aktif">
                                                <x-heroicon-o-check-circle class="w-5 h-5" />
                                            </button>
                                        @endif
                                        
                                        {{-- Delete Button --}}
                                        <button @click="deleteModalOpen = true; deleteId = {{ $item->tahun_id }}" 
                                                class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                                title="Hapus Data">
                                            <x-heroicon-o-trash class="w-5 h-5" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <x-heroicon-o-calendar class="w-12 h-12 text-gray-300 mb-2" />
                                        <p>Belum ada data tahun ajaran.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $tahunAjarans->links() }}
            </div>
        </div>

        {{-- Modal Delete --}}
        <div x-show="deleteModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                
                {{-- Overlay --}}
                <div x-show="deleteModalOpen" 
                     x-transition.opacity 
                     class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" 
                     @click="deleteModalOpen = false">
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                {{-- Modal Panel --}}
                <div x-show="deleteModalOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full border border-gray-100">
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-red-600" />
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Tahun Ajaran</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Apakah Anda yakin ingin menghapus periode ini? Pastikan tidak ada data kelas atau siswa yang masih terkait dengan tahun ajaran ini.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="button" 
                                wire:click="delete(deleteId)" 
                                @click="deleteModalOpen = false" 
                                class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition shadow-red-200">
                            Ya, Hapus
                        </button>
                        <button type="button" 
                                @click="deleteModalOpen = false" 
                                class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>