<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 animate-fade-in-up">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Pusat Notifikasi</h1>
            <p class="text-slate-500 mt-1">Kelola pesan dan pemberitahuan Anda.</p>
        </div>
        
        {{-- Tombol Hapus Semua / Tandai Baca --}}
        <div class="flex gap-2">
            <button wire:click="markAllRead" class="px-4 py-2 bg-white border border-slate-200 text-slate-600 rounded-xl text-sm font-semibold hover:bg-slate-50 transition shadow-sm">
                Tandai Semua Dibaca
            </button>
        </div>
    </div>

    {{-- Alert --}}
    @if (session()->has('message'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm">
            <x-heroicon-o-check-circle class="w-5 h-5" /> {{ session('message') }}
        </div>
    @endif

    {{-- Tabs --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden min-h-[500px]">
        <div class="border-b border-slate-100 flex">
            <button wire:click="$set('activeTab', 'masuk')" 
                    class="px-6 py-4 text-sm font-bold transition border-b-2 {{ $activeTab == 'masuk' ? 'border-indigo-600 text-indigo-600 bg-indigo-50/50' : 'border-transparent text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">
                Kotak Masuk
            </button>
            
            @if(Auth::user()->isAdmin() || Auth::user()->isPustakawan())
                <button wire:click="$set('activeTab', 'kirim')" 
                        class="px-6 py-4 text-sm font-bold transition border-b-2 {{ $activeTab == 'kirim' ? 'border-indigo-600 text-indigo-600 bg-indigo-50/50' : 'border-transparent text-slate-500 hover:text-slate-800 hover:bg-slate-50' }}">
                    Buat Notifikasi
                </button>
            @endif
        </div>

        <div class="p-6">
            {{-- TAB: KOTAK MASUK --}}
            @if($activeTab == 'masuk')
                <div class="space-y-4">
                    @forelse($notifikasiMasuk as $item)
                        <div class="group flex items-start gap-4 p-4 rounded-xl border transition-all duration-200 {{ $item->is_read ? 'bg-white border-slate-100 opacity-75' : 'bg-indigo-50/30 border-indigo-100 shadow-sm' }}">
                            <div class="shrink-0 mt-1">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $item->is_read ? 'bg-slate-100 text-slate-400' : 'bg-indigo-100 text-indigo-600' }}">
                                    <x-heroicon-o-bell class="w-5 h-5" />
                                </div>
                            </div>
                            <div class="flex-grow">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-bold text-slate-800 {{ $item->is_read ? '' : 'text-indigo-900' }}">{{ $item->judul }}</h4>
                                    <span class="text-xs text-slate-400 whitespace-nowrap ml-2">{{ $item->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-sm text-slate-600 mt-1 leading-relaxed">{{ $item->pesan }}</p>
                                <div class="mt-2 flex items-center gap-2 text-xs text-slate-400">
                                    <span>Oleh: {{ $item->sender->nama_lengkap ?? $item->sender->username ?? 'Sistem' }}</span>
                                </div>
                            </div>
                            <button wire:click="delete({{ $item->notifikasi_id }})" class="text-slate-300 hover:text-red-500 transition p-1">
                                <x-heroicon-o-trash class="w-5 h-5" />
                            </button>
                        </div>
                    @empty
                        <div class="text-center py-20">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                                <x-heroicon-o-inbox class="w-8 h-8" />
                            </div>
                            <p class="text-slate-500 font-medium">Belum ada notifikasi masuk.</p>
                        </div>
                    @endforelse
                    
                    <div class="pt-4">
                        {{ $notifikasiMasuk->links() }}
                    </div>
                </div>
            
            {{-- TAB: KIRIM (Hanya Admin/Pustakawan) --}}
            @elseif($activeTab == 'kirim' && (Auth::user()->isAdmin() || Auth::user()->isPustakawan()))
                <div class="max-w-2xl mx-auto">
                    <form wire:submit="kirim" class="space-y-6">
                        
                        {{-- Target Audience --}}
                        <div class="space-y-1">
                            <label class="font-bold text-slate-700 text-sm">Kirim Kepada</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model.live="target_audience" value="semua_siswa" class="peer sr-only">
                                    <div class="p-3 rounded-xl border border-slate-200 text-center peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 transition hover:bg-slate-50">
                                        <span class="text-sm font-medium">Semua Siswa</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model.live="target_audience" value="semua_guru" class="peer sr-only">
                                    <div class="p-3 rounded-xl border border-slate-200 text-center peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 transition hover:bg-slate-50">
                                        <span class="text-sm font-medium">Semua Guru</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model.live="target_audience" value="semua_pustakawan" class="peer sr-only">
                                    <div class="p-3 rounded-xl border border-slate-200 text-center peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 transition hover:bg-slate-50">
                                        <span class="text-sm font-medium">Pustakawan</span>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model.live="target_audience" value="user_spesifik" class="peer sr-only">
                                    <div class="p-3 rounded-xl border border-slate-200 text-center peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 transition hover:bg-slate-50">
                                        <span class="text-sm font-medium">User Spesifik</span>
                                    </div>
                                </label>
                            </div>
                            @error('target_audience') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Jika User Spesifik --}}
                        @if($target_audience == 'user_spesifik')
                            <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                                <label class="font-bold text-slate-700 text-sm mb-2 block">Cari Pengguna</label>
                                <input type="text" wire:model.live.debounce.300ms="searchUser" placeholder="Ketik nama atau email..." class="input-field mb-2">
                                
                                <div class="max-h-40 overflow-y-auto bg-white rounded-lg border border-slate-200">
                                    @forelse($usersList as $u)
                                        <label class="flex items-center gap-3 p-3 hover:bg-indigo-50 cursor-pointer border-b border-slate-50 last:border-0">
                                            <input type="radio" wire:model="specific_user_id" value="{{ $u->user_id }}" class="text-indigo-600 focus:ring-indigo-500">
                                            <div>
                                                <div class="font-bold text-sm text-slate-800">{{ $u->username }}</div>
                                                <div class="text-xs text-slate-500">{{ $u->email }} ({{ $u->getRoleName() }})</div>
                                            </div>
                                        </label>
                                    @empty
                                        <div class="p-3 text-xs text-slate-400 text-center">Ketik untuk mencari...</div>
                                    @endforelse
                                </div>
                                @error('specific_user_id') <span class="text-red-500 text-xs mt-1">Pilih salah satu user.</span> @enderror
                            </div>
                        @endif

                        {{-- Judul --}}
                        <div class="relative group">
                            <input type="text" wire:model="judul" class="input-field peer" placeholder=" " />
                            <label class="input-label">Judul Notifikasi</label>
                            @error('judul') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        {{-- Pesan --}}
                        <div class="relative group">
                            <textarea wire:model="pesan" rows="4" class="input-field peer h-auto py-4" placeholder=" "></textarea>
                            <label class="input-label">Isi Pesan</label>
                            @error('pesan') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="px-8 py-3 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition flex items-center gap-2">
                                <x-heroicon-o-paper-airplane class="w-5 h-5 -rotate-45" />
                                Kirim Notifikasi
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>