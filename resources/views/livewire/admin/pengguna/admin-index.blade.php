<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in-up">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Manajemen Admin</h1>
            <p class="text-sm text-slate-500">Kelola data administrator sistem.</p>
        </div>
        <a href="{{ route('admin.create') }}" wire:navigate class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-semibold hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 flex items-center gap-2 transform active:scale-95">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg> 
            Tambah Admin
        </a>
    </div>

    {{-- Alert Success --}}
    @if (session()->has('success'))
        <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-6 flex items-center gap-2 border border-green-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Search Bar --}}
    <div class="bg-white p-2 rounded-xl border border-slate-200 mb-6 shadow-sm focus-within:ring-2 focus-within:ring-indigo-100 transition-all">
        <div class="relative">
            <input wire:model.live="search" type="text" placeholder="Cari Nama, NIP, atau Username..." class="w-full pl-10 pr-4 py-2 border-none focus:ring-0 text-sm text-slate-700 placeholder-slate-400 rounded-lg">
            <svg class="w-5 h-5 text-slate-400 absolute left-3 top-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
    </div>

    {{-- Tabel Admin --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase text-xs font-semibold tracking-wide">
                    <tr>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Akun (Username/Email)</th>
                        <th class="px-6 py-4">Kontak</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($admins as $admin)
                        <tr class="hover:bg-slate-50/50 transition duration-150">
                            {{-- Nama & NIP --}}
                            <td class="px-6 py-4 align-top">
                                <div class="font-bold text-slate-800">{{ $admin->nama_lengkap }}</div>
                                <div class="text-xs text-slate-500 font-mono mt-0.5">NIP: {{ $admin->nip }}</div>
                            </td>

                            {{-- Username & Email --}}
                            <td class="px-6 py-4 align-top">
                                <div class="text-slate-800 font-medium">{{ $admin->user->username ?? '-' }}</div>
                                <div class="text-xs text-slate-500">{{ $admin->user->email ?? '-' }}</div>
                            </td>

                            {{-- Kontak --}}
                            <td class="px-6 py-4 align-top text-slate-600">
                                {{ $admin->nomor_telepon ?? '-' }}
                            </td>

                            {{-- Status Akun --}}
                            <td class="px-6 py-4 align-top text-center">
                                @if($admin->user->is_active ?? false)
                                    <span class="inline-flex px-2 py-1 rounded text-xs font-bold bg-green-100 text-green-700 border border-green-200">Aktif</span>
                                @else
                                    <span class="inline-flex px-2 py-1 rounded text-xs font-bold bg-red-100 text-red-700 border border-red-200">Non-Aktif</span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 align-top text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('admin.edit', $admin->admin_id) }}" wire:navigate 
                                       class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Edit Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    
                                    {{-- Tombol Hapus --}}
                                    <button wire:click="delete({{ $admin->admin_id }})" 
                                            wire:confirm="Yakin ingin menghapus admin ini? Akun login juga akan terhapus."
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Hapus Data">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 bg-slate-50/50">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 mb-2 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <p>Tidak ada data admin ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination --}}
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $admins->links() }}
        </div>
    </div>
</div>