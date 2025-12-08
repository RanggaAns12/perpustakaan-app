<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ returnModalOpen: @entangle('returnModalOpen') }">
    
    <div class="mb-8 animate-fade-in-up">
        <h1 class="text-3xl font-bold text-slate-800">Riwayat Peminjaman</h1>
        <p class="text-slate-500 mt-2 text-lg">Pantau aktivitas literasimu di sini.</p>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-3 shadow-sm animate-fade-in-up">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden animate-fade-in-up delay-100">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-500 border-b border-slate-100 text-xs uppercase tracking-wider bg-slate-50/80">
                        <th class="px-6 py-5 font-bold">Kode Transaksi</th>
                        <th class="px-6 py-5 font-bold">Buku</th>
                        <th class="px-6 py-5 font-bold">Tanggal</th>
                        <th class="px-6 py-5 font-bold text-center">Status</th>
                        <th class="px-6 py-5 font-bold text-right">Denda</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($riwayat as $item)
                        <tr class="hover:bg-indigo-50/30 transition-colors duration-200 group">
                            <td class="px-6 py-4 align-top">
                                <span class="font-mono text-xs font-semibold text-slate-500 bg-slate-100 px-2 py-1 rounded border border-slate-200">
                                    {{ $item->kode_transaksi }}
                                </span>
                            </td>

                            <td class="px-6 py-4 align-top">
                                <div class="flex flex-col gap-2">
                                    @foreach($item->detailPeminjaman as $detail)
                                        <div class="flex items-start gap-2">
                                            <div class="mt-1 min-w-[4px] h-[4px] rounded-full bg-indigo-400"></div>
                                            <div>
                                                <p class="text-sm font-semibold text-slate-800">{{ $detail->buku->judul_buku ?? 'Buku dihapus' }}</p>
                                                <p class="text-xs text-slate-500">{{ $detail->buku->penulis->pluck('nama_penulis')->implode(', ') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>

                            <td class="px-6 py-4 align-top">
                                <div class="flex flex-col gap-1 text-sm">
                                    <span class="text-slate-600 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d M Y') }}
                                    </span>
                                    <span class="text-xs text-slate-400">
                                        s/d {{ \Carbon\Carbon::parse($item->tanggal_jatuh_tempo)->format('d M Y') }}
                                    </span>
                                </div>
                            </td>

                            <td class="px-6 py-4 align-top text-center">
                                @php
                                    $statusClass = match($item->status_peminjaman) {
                                        'Dipinjam' => 'bg-amber-100 text-amber-700 border-amber-200',
                                        'Menunggu Pengembalian' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'Dikembalikan' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                        'Terlambat' => 'bg-rose-100 text-rose-700 border-rose-200',
                                        'Hilang' => 'bg-gray-100 text-gray-700 border-gray-200',
                                        default => 'bg-slate-100 text-slate-700 border-slate-200'
                                    };
                                @endphp
                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-bold border {{ $statusClass }}">
                                    {{ $item->status_peminjaman }}
                                </span>

                                @if(in_array($item->status_peminjaman, ['Dipinjam', 'Terlambat']))
                                    <div class="mt-3">
                                        <button wire:click="confirmReturn({{ $item->peminjaman_id }})"
                                                class="w-full px-3 py-1.5 bg-indigo-600 text-white text-xs font-bold rounded-lg hover:bg-indigo-700 transition shadow-sm">
                                            Ajukan Kembali
                                        </button>
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4 align-top text-right">
                                @if($item->pengembalian && $item->pengembalian->denda && $item->pengembalian->denda->total_denda > 0)
                                    <div class="flex flex-col items-end">
                                        <span class="text-sm font-bold text-rose-600">
                                            Rp {{ number_format($item->pengembalian->denda->total_denda, 0, ',', '.') }}
                                        </span>
                                        <span class="text-[10px] uppercase font-bold tracking-wider {{ $item->pengembalian->denda->status_denda == 'Lunas' ? 'text-emerald-600' : 'text-rose-500' }}">
                                            {{ $item->pengembalian->denda->status_denda }}
                                        </span>
                                    </div>
                                @elseif($item->status_peminjaman == 'Dikembalikan')
                                    <span class="text-emerald-500 text-sm font-medium flex items-center justify-end gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Aman
                                    </span>
                                @else
                                    <span class="text-slate-300 text-2xl leading-none">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-20 text-center text-slate-400">
                                Belum ada riwayat peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $riwayat->links() }}
        </div>
    </div>

    {{-- MODAL KONFIRMASI --}}
    <div x-show="returnModalOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex min-h-screen items-center justify-center p-4 text-center">
            
            {{-- Backdrop --}}
            <div x-show="returnModalOpen" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" 
                 @click="returnModalOpen = false">
            </div>

            {{-- Panel Modal --}}
            <div x-show="returnModalOpen" 
                 x-transition:enter="ease-out duration-300" 
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200" 
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all">
                
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Ajukan Pengembalian Buku</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin mengajukan pengembalian untuk buku ini? 
                                    Status akan berubah menjadi <strong>"Menunggu Pengembalian"</strong>.
                                </p>
                                <p class="text-xs text-indigo-600 mt-2 font-medium">
                                    *Harap segera bawa buku fisik ke perpustakaan untuk verifikasi petugas.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                    <button type="button" 
                            wire:click="ajukanPengembalian" 
                            class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition">
                        Ya, Ajukan
                    </button>
                    <button type="button" 
                            wire:click="cancelReturn" 
                            class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>