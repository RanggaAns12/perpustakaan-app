<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in-up">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Tambah Admin Baru</h1>
            <p class="text-sm text-slate-500">Buat akun administrator baru untuk mengelola sistem.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition text-sm font-medium">
            Kembali
        </a>
    </div>

    {{-- Alert Error/Success --}}
    @if (session()->has('success'))
        <div class="bg-green-50 text-green-700 p-4 rounded-xl mb-6 flex items-center gap-2 border border-green-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 flex items-center gap-2 border border-red-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit="simpan" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            
            {{-- Bagian 1: Informasi Akun (Login) --}}
            <div class="space-y-5">
                <h3 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Informasi Akun</h3>
                
                {{-- Username --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Username</label>
                    <input wire:model="username" type="text" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('username') border-red-500 @enderror" placeholder="Contoh: admin2">
                    @error('username') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                    <input wire:model="email" type="email" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('email') border-red-500 @enderror" placeholder="email@sekolah.sch.id">
                    @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Password</label>
                    <input wire:model="password" type="password" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('password') border-red-500 @enderror" placeholder="Minimal 6 karakter">
                    @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Bagian 2: Data Diri (Profil) --}}
            <div class="space-y-5">
                <h3 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Data Diri Admin</h3>

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                    <input wire:model="nama_lengkap" type="text" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('nama_lengkap') border-red-500 @enderror" placeholder="Nama Lengkap">
                    @error('nama_lengkap') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- NIP --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">NIP (Nomor Induk Pegawai)</label>
                    <input wire:model="nip" type="text" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('nip') border-red-500 @enderror" placeholder="Nomor NIP">
                    @error('nip') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Nomor Telepon --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor Telepon</label>
                    <input wire:model="nomor_telepon" type="text" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('nomor_telepon') border-red-500 @enderror" placeholder="08...">
                    @error('nomor_telepon') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- Footer Tombol --}}
        <div class="px-8 py-5 bg-slate-50 border-t border-slate-200 flex justify-end gap-3">
            <button type="button" wire:click="reset" class="px-5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-200 transition font-medium">
                Reset
            </button>
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition transform active:scale-95 flex items-center gap-2">
                <span wire:loading.remove>Simpan Admin</span>
                <span wire:loading>Menyimpan...</span>
            </button>
        </div>
    </form>
</div>