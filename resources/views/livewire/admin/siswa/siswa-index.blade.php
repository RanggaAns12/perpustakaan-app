<div class="min-h-screen bg-gray-50/50 pb-12" x-data="{ deleteModalOpen: false, deleteId: null }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8 animate-fade-in-up">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Data Siswa</h1>
                <p class="text-gray-500 mt-2">Daftar peserta didik perpustakaan.</p>
            </div>
            <a href="{{ route('siswa.create') }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:-translate-y-0.5 transition-all duration-200 group">
                <x-heroicon-o-plus class="w-5 h-5 mr-2" /> Tambah Siswa
            </a>
        </div>

        {{-- Flash Message --}}
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="fixed bottom-6 right-6 z-50 flex items-center gap-3 bg-white border border-green-100 px-4 py-3 rounded-xl shadow-xl shadow-green-50">
                <div class="bg-green-100 text-green-600 p-2 rounded-full"><x-heroicon-o-check class="w-5 h-5" /></div>
                <div><p class="font-semibold text-gray-900">Berhasil!</p><p class="text-sm text-gray-500">{{ session('message') }}</p></div>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 mb-8 sticky top-20 z-20 backdrop-blur-xl bg-white/90 transition-all hover:shadow-md">
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none"><x-heroicon-o-magnifying-glass class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-500 transition-colors" /></div>
                <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-11 pr-4 py-2.5 bg-transparent border-none rounded-xl text-gray-900 placeholder-gray-400 focus:ring-2 focus:ring-indigo-500/20 transition-all" placeholder="Cari nama siswa atau NIS" />
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100 text-xs uppercase tracking-wider text-gray-500 font-semibold">
                            <th class="px-6 py-4 rounded-tl-2xl">Siswa</th>
                            <th class="px-6 py-4">Kelas</th>
                            <th class="px-6 py-4">Kontak</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-center rounded-tr-2xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($siswas as $siswa)
                            <tr class="group hover:bg-indigo-50/30 transition-colors duration-200">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden border border-gray-300">
                                            @if($siswa->foto_profil)
                                                <img src="{{ asset('storage/' . $siswa->foto_profil) }}" class="h-full w-full object-cover">
                                            @else
                                                <span class="text-gray-500 font-bold text-lg">{{ substr($siswa->nama_lengkap, 0, 1) }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">{{ $siswa->nama_lengkap }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5 font-mono">NIS: {{ $siswa->nis }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">{{ $siswa->kelas->nama_kelas ?? 'Belum Masuk Kelas' }}</span></td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600">{{ $siswa->nomor_telepon ?? '-' }}</div>
                                    <div class="text-xs text-gray-400">{{ $siswa->user->email ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $siswa->status_siswa == 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                        {{ $siswa->status_siswa }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 opacity-80 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('siswa.show', $siswa->siswa_id) }}" class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"><x-heroicon-o-eye class="w-5 h-5" /></a>
                                        <a href="{{ route('siswa.edit', $siswa->siswa_id) }}" class="p-2 text-gray-500 hover:text-yellow-600 hover:bg-yellow-50 rounded-lg transition-all"><x-heroicon-o-pencil-square class="w-5 h-5" /></a>
                                        <button @click="deleteModalOpen = true; deleteId = {{ $siswa->siswa_id }}" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"><x-heroicon-o-trash class="w-5 h-5" /></button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-6 py-16 text-center text-gray-500">Data tidak ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">{{ $siswas->links() }}</div>
        </div>
        {{-- Modal Konfirmasi Hapus (Posisi Tengah) --}}
                <div x-show="deleteModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
                    {{-- 1. Container Flex Center --}}
                    <div class="flex min-h-screen items-center justify-center p-4 text-center">
                        
                        {{-- Overlay Gelap --}}
                        <div x-show="deleteModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity" @click="deleteModalOpen = false"></div>

                        {{-- 2. Panel Modal (Hapus align-bottom/middle lama) --}}
                        <div x-show="deleteModalOpen" 
                            x-transition:enter="ease-out duration-300" 
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="ease-in duration-200" 
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            class="relative w-full max-w-lg transform overflow-hidden rounded-2xl bg-white text-left shadow-xl transition-all">
                            
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                        <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-red-600" />
                                    </div>
                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                        {{-- Sesuaikan Judul per File --}}
                                        <h3 class="text-lg leading-6 font-medium text-gray-900">Konfirmasi Hapus</h3>
                                        <div class="mt-2">
                                            <p class="text-sm text-gray-500">Apakah Anda yakin ingin menghapus data ini? Data yang dihapus tidak dapat dikembalikan.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                                <button type="button" wire:click="delete(deleteId)" @click="deleteModalOpen = false" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition">
                                    Ya, Hapus
                                </button>
                                <button type="button" @click="deleteModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>