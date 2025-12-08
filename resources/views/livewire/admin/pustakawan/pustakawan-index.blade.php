<div class="min-h-screen bg-gray-50/50 pb-12" x-data="{ deleteModalOpen: @entangle('deleteModalOpen') }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 animate-fade-in-up">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Data Pustakawan</h1>
                <p class="text-gray-500 mt-2">Manajemen petugas perpustakaan dan akun akses.</p>
            </div>
            <a href="{{ route('pustakawan.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:-translate-y-0.5 transition-all group">
                <x-heroicon-o-plus class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform" /> 
                Tambah Pustakawan
            </a>
        </div>

        {{-- Flash Messages --}}
        @if (session()->has('message'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
                <x-heroicon-o-check-circle class="w-6 h-6" /> {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
                <x-heroicon-o-exclamation-circle class="w-6 h-6" /> {{ session('error') }}
            </div>
        @endif

        {{-- Search Bar --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 mb-8 sticky top-20 z-20">
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-400">
                    <x-heroicon-o-magnifying-glass class="h-5 w-5" />
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-11 pr-4 py-2.5 border-none rounded-xl bg-transparent focus:ring-2 focus:ring-indigo-500/20" placeholder="Cari nama atau NIP..." />
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                            <th class="px-6 py-4 rounded-tl-2xl">Pustakawan</th>
                            <th class="px-6 py-4">NIP & Kontak</th>
                            <th class="px-6 py-4">Shift & Bergabung</th>
                            <th class="px-6 py-4 text-center rounded-tr-2xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($pustakawans as $item)
                            <tr class="group hover:bg-indigo-50/30 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden border border-gray-300 shrink-0">
                                            @if($item->foto_profil)
                                                <img src="{{ asset('storage/' . $item->foto_profil) }}" class="h-full w-full object-cover">
                                            @else
                                                <span class="text-gray-500 font-bold">{{ substr($item->nama_lengkap, 0, 1) }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $item->nama_lengkap }}</div>
                                            <div class="text-xs text-gray-400">{{ $item->user->email ?? 'No Email' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-mono text-gray-700">{{ $item->nip }}</div>
                                    <div class="text-xs text-gray-500">{{ $item->nomor_telepon ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <span class="inline-flex w-fit items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                            Shift: {{ $item->shift_kerja ?? '-' }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            Join: {{ $item->tanggal_bergabung ? date('d M Y', strtotime($item->tanggal_bergabung)) : '-' }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('pustakawan.edit', $item->pustakawan_id) }}" class="p-2 text-gray-500 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition" title="Edit">
                                            <x-heroicon-o-pencil-square class="w-5 h-5" />
                                        </a>
                                        <button wire:click="confirmDelete({{ $item->pustakawan_id }})" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus">
                                            <x-heroicon-o-trash class="w-5 h-5" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-16 text-center text-gray-500">Data pustakawan belum tersedia.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">{{ $pustakawans->links() }}</div>
        </div>

        {{-- MODAL DELETE TENGAH --}}
        <div x-show="deleteModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex min-h-screen items-center justify-center p-4 text-center">
                <div x-show="deleteModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="deleteModalOpen = false"></div>
                <div x-show="deleteModalOpen" x-transition class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-red-600" />
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Hapus Pustakawan</h3>
                                <div class="mt-2"><p class="text-sm text-gray-500">Apakah Anda yakin? Akun login petugas ini juga akan dihapus.</p></div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="button" wire:click="delete(deleteId)" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition">Ya, Hapus</button>
                        <button type="button" @click="deleteModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>