<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    
    {{-- Breadcrumb Navigasi --}}
    <div class="mb-6 animate-fade-in-up">
        <a href="{{ route('siswa.katalog') }}" class="text-slate-500 hover:text-indigo-600 flex items-center gap-1 text-sm font-medium transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Katalog
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-slate-100 flex flex-col md:flex-row animate-fade-in-up delay-100">
        
        {{-- Sisi Kiri: Preview Buku --}}
        <div class="w-full md:w-1/3 bg-slate-50 p-8 flex flex-col items-center justify-center text-center border-r border-slate-100">
            <div class="relative w-40 aspect-[2/3] rounded-lg shadow-lg overflow-hidden mb-6 group bg-white">
                @if($buku->cover_buku)
                    <img src="{{ asset('storage/' . $buku->cover_buku) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-slate-200 flex items-center justify-center text-slate-400">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                @endif
            </div>
            <h3 class="font-bold text-slate-800 text-lg leading-tight mb-2">{{ $buku->judul_buku }}</h3>
            <p class="text-sm text-slate-500">{{ $buku->penulis->pluck('nama_penulis')->implode(', ') }}</p>
        </div>

        {{-- Sisi Kanan: Form Konfirmasi --}}
        <div class="w-full md:w-2/3 p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-slate-900">Konfirmasi Peminjaman</h2>
                <p class="text-slate-500 text-sm">Lengkapi detail durasi peminjaman di bawah ini.</p>
            </div>

            {{-- Flash Message Error --}}
            @if (session()->has('error'))
                <div class="bg-red-50 border border-red-100 text-red-600 p-4 rounded-xl text-sm mb-6 flex items-start gap-3">
                    <svg class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{-- Info Alert --}}
            <div class="bg-yellow-50 border border-yellow-100 p-4 rounded-xl mb-6 flex items-start gap-3">
                <svg class="w-5 h-5 text-yellow-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div class="text-sm text-yellow-700">
                    <span class="font-bold">Info:</span> Permintaan ini akan berstatus <strong>Pending</strong>. Silakan temui pustakawan untuk verifikasi dan pengambilan buku fisik.
                </div>
            </div>

            <form wire:submit="prosesPeminjaman" class="space-y-6">
                
                {{-- Grid Input --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    {{-- Tanggal Pinjam (Read Only) --}}
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Mulai</label>
                        <div class="bg-slate-50 px-4 py-3 rounded-xl border border-slate-200 text-slate-700 font-medium cursor-not-allowed">
                            {{ \Carbon\Carbon::parse($tanggal_pinjam)->translatedFormat('d F Y') }}
                        </div>
                    </div>

                    {{-- Pilihan Durasi --}}
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Durasi Pinjam</label>
                        <div class="relative">
                            <select wire:model.live="durasi" class="w-full bg-white px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 outline-none text-slate-700 font-medium appearance-none cursor-pointer">
                                <option value="3">3 Hari</option>
                                <option value="5">5 Hari</option>
                                <option value="7">7 Hari (Standar)</option>
                                <option value="14">14 Hari</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-3 pointer-events-none text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Preview Tanggal Kembali --}}
                <div class="bg-indigo-50 px-5 py-4 rounded-xl border border-indigo-100 flex items-start gap-4">
                    <div class="p-2 bg-white rounded-lg text-indigo-600 shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-indigo-600 uppercase tracking-wider mb-0.5">Batas Pengembalian</p>
                        <p class="text-lg font-bold text-indigo-900">
                            {{ \Carbon\Carbon::parse($tanggal_kembali)->translatedFormat('l, d F Y') }}
                        </p>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100 mt-6">
                    <a href="{{ route('siswa.katalog') }}" class="px-6 py-3 rounded-xl text-slate-600 font-medium hover:bg-slate-50 transition">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:shadow-indigo-300 transition-all transform active:scale-95 flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <span>Ajukan Peminjaman</span>
                        <svg wire:loading.remove wire:target="prosesPeminjaman" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        <svg wire:loading wire:target="prosesPeminjaman" class="animate-spin w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>