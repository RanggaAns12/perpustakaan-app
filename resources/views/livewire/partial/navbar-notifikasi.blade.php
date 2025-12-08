<div class="relative" x-data="{ open: false }" wire:poll.10s>
    {{-- Tombol Lonceng --}}
    <button @click="open = !open" @click.away="open = false" class="relative p-2 rounded-full text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition focus:outline-none">
        <x-heroicon-o-bell class="w-6 h-6" />
        
        @if($unreadCount > 0)
            <span class="absolute top-2 right-2 flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-red-500 border-2 border-white"></span>
            </span>
        @endif
    </button>

    {{-- Dropdown Menu --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-2 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-2 scale-95"
         class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-gray-100 z-50 overflow-hidden origin-top-right"
         style="display: none;">
        
        <div class="px-4 py-3 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-sm font-bold text-gray-900">Notifikasi</h3>
            @if($unreadCount > 0)
                <span class="text-xs bg-red-100 text-red-600 px-2 py-0.5 rounded-full font-bold">{{ $unreadCount }} Baru</span>
            @endif
        </div>

        <div class="max-h-64 overflow-y-auto custom-scrollbar">
            @forelse($notifikasis as $notif)
                <div wire:click="markAsRead({{ $notif->notifikasi_id }})" class="px-4 py-3 hover:bg-indigo-50 transition cursor-pointer border-b border-gray-50 last:border-0 {{ $notif->is_read ? 'opacity-60' : 'bg-white' }}">
                    <div class="flex items-start gap-3">
                        <div class="shrink-0 mt-1">
                            @if($notif->is_read)
                                <x-heroicon-o-envelope-open class="w-5 h-5 text-gray-400" />
                            @else
                                <x-heroicon-s-envelope class="w-5 h-5 text-indigo-500" />
                            @endif
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-800 line-clamp-1">{{ $notif->judul }}</p>
                            <p class="text-xs text-gray-500 line-clamp-2 mt-0.5">{{ $notif->pesan }}</p>
                            <p class="text-[10px] text-gray-400 mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="px-4 py-6 text-center text-gray-400 text-sm">
                    Tidak ada notifikasi baru.
                </div>
            @endforelse
        </div>

        <div class="p-2 border-t border-gray-100 bg-gray-50">
            @if(auth()->user()->isSiswa())
                <a href="{{ route('siswa.notifikasi') }}" class="block text-center text-xs font-bold text-indigo-600 hover:text-indigo-700 py-2 rounded-lg hover:bg-indigo-50 transition">
                    Lihat Semua Notifikasi
                </a>
            @else
                <a href="{{ route('notifikasi.index') }}" class="block text-center text-xs font-bold text-indigo-600 hover:text-indigo-700 py-2 rounded-lg hover:bg-indigo-50 transition">
                    Lihat Semua Notifikasi
                </a>
            @endif
        </div>
    </div>
</div>