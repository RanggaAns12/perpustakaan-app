<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 h-[calc(100vh-6rem)]">
    
    <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden h-full flex flex-col md:flex-row">
        
        {{-- SIDEBAR: LIST SISWA --}}
        <div class="w-full md:w-1/3 border-r border-slate-200 flex flex-col bg-slate-50">
            {{-- Header Sidebar --}}
            <div class="p-4 bg-white border-b border-slate-200">
                <h2 class="font-bold text-lg text-slate-800 mb-4">Pesan Masuk</h2>
                <div class="relative">
                    <input wire:model.live="search" type="text" placeholder="Cari Siswa..." 
                           class="w-full pl-9 pr-4 py-2 bg-slate-100 border-none rounded-xl text-sm focus:ring-2 focus:ring-indigo-500">
                    <x-heroicon-o-magnifying-glass class="w-4 h-4 text-slate-400 absolute left-3 top-2.5" />
                </div>
            </div>

            {{-- List User --}}
            <div class="flex-1 overflow-y-auto custom-scrollbar">
                @foreach($usersList as $user)
                    <div wire:click="selectUser({{ $user->user_id }})" 
                         class="p-4 border-b border-slate-100 cursor-pointer transition hover:bg-indigo-50 {{ $selectedUserId == $user->user_id ? 'bg-indigo-50 border-l-4 border-l-indigo-600' : 'bg-white' }}">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="font-bold text-sm text-slate-800">{{ $user->nama_lengkap ?? $user->username }}</h4>
                            @if($user->last_time)
                                <span class="text-[10px] text-slate-400">{{ $user->last_time->diffForHumans() }}</span>
                            @endif
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-xs text-slate-500 line-clamp-1 max-w-[80%]">
                                {{ $user->last_message }}
                            </p>
                            @if($user->unread > 0)
                                <span class="bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[1.25rem] text-center">
                                    {{ $user->unread }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- MAIN AREA: CHAT ROOM --}}
        <div class="flex-1 flex flex-col bg-white" wire:poll.3s>
            @if($selectedUserId)
                {{-- Chat Header --}}
                @php $activeUser = $usersList->firstWhere('user_id', $selectedUserId); @endphp
                <div class="p-4 border-b border-slate-200 flex items-center justify-between bg-white shadow-sm z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                            {{ substr($activeUser->nama_lengkap ?? 'U', 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-800">{{ $activeUser->nama_lengkap ?? 'Siswa' }}</h3>
                            <p class="text-xs text-slate-500">{{ $activeUser->username }}</p>
                        </div>
                    </div>
                </div>

                {{-- Chat Messages --}}
                <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-slate-50/50" id="staff-chat-container">
                    @foreach($activeChats as $chat)
                        <div class="flex {{ $chat->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-[70%] rounded-2xl px-5 py-3 text-sm shadow-sm
                                        {{ $chat->sender_id == Auth::id() 
                                            ? 'bg-indigo-600 text-white rounded-tr-none' 
                                            : 'bg-white text-slate-700 border border-slate-100 rounded-tl-none' }}">
                                <p>{{ $chat->message }}</p>
                                <p class="text-[10px] mt-1 text-right {{ $chat->sender_id == Auth::id() ? 'text-indigo-200' : 'text-slate-400' }}">
                                    {{ $chat->created_at->format('d M, H:i') }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Chat Input --}}
                <div class="p-4 bg-white border-t border-slate-200">
                    <form wire:submit.prevent="sendMessage" class="flex gap-3">
                        <input wire:model="message" type="text" placeholder="Balas pesan..." 
                               class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-indigo-700 transition shadow-lg flex items-center gap-2">
                            <span>Kirim</span>
                            <x-heroicon-o-paper-airplane class="w-5 h-5 -rotate-45" />
                        </button>
                    </form>
                </div>
                
                {{-- Auto Scroll Script --}}
                <script>
                    function scrollStaffChat() {
                        const container = document.getElementById('staff-chat-container');
                        if(container) container.scrollTop = container.scrollHeight;
                    }
                    
                    document.addEventListener('livewire:navigated', scrollStaffChat);
                    document.addEventListener('livewire:init', () => {
                         Livewire.hook('morph.updated', ({ component }) => {
                            if(component.name === 'chat.staff-chat') scrollStaffChat();
                         });
                    });
                </script>

            @else
                <div class="flex-1 flex flex-col items-center justify-center text-slate-400 bg-slate-50/30">
                    <div class="bg-slate-50 p-6 rounded-full mb-4 shadow-sm">
                        <x-heroicon-o-chat-bubble-left-right class="w-16 h-16 text-slate-300" />
                    </div>
                    <h3 class="text-lg font-bold text-slate-600">Pilih Percakapan</h3>
                    <p class="text-sm">Pilih siswa dari daftar di samping untuk melihat pesan.</p>
                </div>
            @endif
        </div>
    </div>
</div>