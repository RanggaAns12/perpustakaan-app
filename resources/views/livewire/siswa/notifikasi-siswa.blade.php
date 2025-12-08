<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    
    {{-- Header --}}
    <div class="flex items-center justify-between mb-8 animate-fade-in-up">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Kotak Masuk</h1>
            <p class="text-slate-500 mt-1">Pemberitahuan dan informasi terbaru untukmu.</p>
        </div>
        
        <button wire:click="markAllRead" 
                class="inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition shadow-sm group">
            <svg class="w-4 h-4 mr-2 text-slate-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            Tandai Semua Dibaca
        </button>
    </div>

    {{-- Flash Message --}}
    @if (session()->has('message'))
        <div class="mb-6 bg-green-50 border border-green-100 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm animate-fade-in-up">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium">{{ session('message') }}</span>
        </div>
    @endif

    {{-- List Notifikasi --}}
    <div class="space-y-4 animate-fade-in-up delay-100">
        @forelse($notifikasis as $notif)
            <div class="group relative bg-white rounded-2xl border transition-all duration-300 overflow-hidden {{ $notif->is_read ? 'border-slate-100 opacity-80 hover:opacity-100' : 'border-indigo-100 shadow-sm hover:shadow-md ring-1 ring-indigo-50' }}">
                
                {{-- Indikator Belum Dibaca --}}
                @if(!$notif->is_read)
                    <div class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-bl-lg z-10 shadow-sm"></div>
                @endif

                <div class="p-5 sm:p-6 flex flex-col sm:flex-row gap-5">
                    
                    {{-- Icon --}}
                    <div class="shrink-0">
                        <div class="w-12 h-12 rounded-full flex items-center justify-center {{ $notif->is_read ? 'bg-slate-50 text-slate-400' : 'bg-indigo-50 text-indigo-600' }}">
                            @if($notif->is_read)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path></svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            @endif
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="flex-grow cursor-pointer" wire:click="markAsRead({{ $notif->notifikasi_id }})">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
                            <h3 class="text-lg font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">
                                {{ $notif->judul }}
                            </h3>
                            <span class="text-xs font-medium text-slate-400 bg-slate-50 px-2 py-1 rounded-md border border-slate-100 whitespace-nowrap">
                                {{ $notif->created_at->translatedFormat('d M Y, H:i') }}
                            </span>
                        </div>
                        
                        <p class="text-slate-600 leading-relaxed text-sm mb-3">
                            {{ $notif->pesan }}
                        </p>

                        <div class="flex items-center gap-2 text-xs text-slate-400">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span>Dari: <span class="font-semibold text-slate-500">{{ $notif->sender->nama_lengkap ?? 'Sistem Perpustakaan' }}</span></span>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex sm:flex-col justify-end gap-2 border-t sm:border-t-0 sm:border-l border-slate-100 pt-4 sm:pt-0 sm:pl-4 mt-2 sm:mt-0">
                        @if(!$notif->is_read)
                            <button wire:click="markAsRead({{ $notif->notifikasi_id }})" class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Tandai Baca">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </button>
                        @endif
                        <button wire:click="delete({{ $notif->notifikasi_id }})" 
                                wire:confirm="Hapus pesan ini?"
                                class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition" title="Hapus">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-24 bg-white rounded-3xl border border-dashed border-slate-200">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-700">Tidak Ada Pesan</h3>
                <p class="text-slate-500 text-sm mt-1">Kotak masuk kamu bersih.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $notifikasis->links() }}
    </div>
</div>