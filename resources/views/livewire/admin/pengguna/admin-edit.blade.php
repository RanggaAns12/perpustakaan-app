<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in-up">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Edit Data Admin</h1>
            <p class="text-sm text-slate-500">Perbarui informasi akun dan profil administrator.</p>
        </div>
        <a href="{{ route('admin.index') }}" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 transition text-sm font-medium">
            Batal
        </a>
    </div>

    {{-- Alert Error --}}
    @if (session()->has('error'))
        <div class="bg-red-50 text-red-700 p-4 rounded-xl mb-6 flex items-center gap-2 border border-red-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit="update" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
            
            {{-- Bagian 1: Informasi Akun --}}
            <div class="space-y-5">
                <h3 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Akun Login</h3>
                
                {{-- Username (Read Only) --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-500 mb-1">Username (Tidak dapat diubah)</label>
                    <input wire:model="username" type="text" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-100 text-slate-500 cursor-not-allowed" readonly disabled>
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Email</label>
                    <input wire:model="email" type="email" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('email') border-red-500 @enderror">
                    @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Password (Optional) --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Password Baru</label>
                    <input wire:model="password" type="password" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('password') border-red-500 @enderror" placeholder="Kosongkan jika tidak ingin mengganti password">
                    <p class="text-[10px] text-slate-400 mt-1">*Isi hanya jika Anda ingin mereset password akun ini.</p>
                    @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Bagian 2: Data Profil --}}
            <div class="space-y-5">
                <h3 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-2 mb-4">Profil Admin</h3>

                {{-- Nama Lengkap --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                    <input wire:model="nama_lengkap" type="text" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('nama_lengkap') border-red-500 @enderror">
                    @error('nama_lengkap') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- NIP --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">NIP</label>
                    <input wire:model="nip" type="text" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('nip') border-red-500 @enderror">
                    @error('nip') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Nomor Telepon --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor Telepon</label>
                    <input wire:model="nomor_telepon" type="text" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition @error('nomor_telepon') border-red-500 @enderror">
                    @error('nomor_telepon') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                </div>
            </div>
        </div>

        {{-- Footer Tombol --}}
        <div class="px-8 py-5 bg-slate-50 border-t border-slate-200 flex justify-end gap-3">
            <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition transform active:scale-95 flex items-center gap-2">
                <span wire:loading.remove>Simpan Perubahan</span>
                <span wire:loading>Menyimpan...</span>
            </button>
        </div>
    </form>
</div>