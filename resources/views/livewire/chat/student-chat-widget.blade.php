<div class="fixed bottom-6 right-6 z-50 flex flex-col items-end" x-data="{ open: @entangle('isOpen') }">
    
    {{-- Chat Window --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95"
         class="mb-4 w-[350px] bg-white rounded-2xl shadow-2xl border border-slate-200 overflow-hidden flex flex-col h-[450px]"
         style="display: none;">
        
        {{-- Header --}}
        <div class="bg-indigo-600 p-4 flex justify-between items-center text-white">
            <div class="flex items-center gap-3">
                <div class="bg-white/20 p-2 rounded-full">
                    <x-heroicon-o-chat-bubble-left-right class="w-5 h-5" />
                </div>
                <div>
                    <h3 class="font-bold text-sm">Live Support</h3>
                    <p class="text-[10px] text-indigo-100 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span> Online
                    </p>
                </div>
            </div>
            <button wire:click="toggleChat" class="text-white/80 hover:text-white">
                <x-heroicon-o-x-mark class="w-5 h-5" />
            </button>
        </div>

        {{-- Messages Body --}}
        <div class="flex-1 p-4 overflow-y-auto bg-slate-50 space-y-3 custom-scrollbar" id="chat-container">
            @forelse($chats as $chat)
                <div class="flex {{ $chat->sender_id == auth()->id() ? 'justify-end' : 'justify-start' }}">
                    <div class="max-w-[80%] rounded-xl px-4 py-2 text-sm {{ $chat->sender_id == auth()->id() ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-white text-slate-700 shadow-sm border border-slate-100 rounded-tl-none' }}">
                        <p>{{ $chat->message }}</p>
                        <p class="text-[10px] mt-1 {{ $chat->sender_id == auth()->id() ? 'text-indigo-200' : 'text-slate-400' }}">
                            {{ $chat->created_at->format('H:i') }}
                        </p>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 text-slate-400">
                    <x-heroicon-o-chat-bubble-oval-left-ellipsis class="w-12 h-12 mx-auto mb-2 opacity-50"/>
                    <p class="text-xs">Mulai percakapan dengan petugas.</p>
                </div>
            @endforelse
        </div>

        {{-- Input Area --}}
        <div class="p-3 bg-white border-t border-slate-100">
            <form wire:submit.prevent="sendMessage" class="flex gap-2">
                <input wire:model="message" type="text" placeholder="Tulis pesan..." 
                       class="flex-1 bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition">
                <button type="submit" class="bg-indigo-600 text-white p-2 rounded-xl hover:bg-indigo-700 transition shadow-md disabled:opacity-50" wire:loading.attr="disabled">
                    <x-heroicon-o-paper-airplane class="w-5 h-5 -rotate-45 translate-x-[-1px] translate-y-[1px]" />
                </button>
            </form>
        </div>
    </div>

    {{-- Floating Button --}}
    <button wire:click="toggleChat" 
            class="relative group bg-indigo-600 hover:bg-indigo-700 text-white p-4 rounded-full shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
        
        <x-heroicon-o-chat-bubble-left-ellipsis class="w-7 h-7" />
        
        @if($unreadCount > 0)
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold w-5 h-5 flex items-center justify-center rounded-full border-2 border-white animate-bounce">
                {{ $unreadCount }}
            </span>
        @endif

        {{-- Tooltip --}}
        <span class="absolute right-full top-1/2 -translate-y-1/2 mr-3 px-3 py-1 bg-slate-800 text-white text-xs rounded-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
            Butuh Bantuan?
        </span>
    </button>

    {{-- Auto Scroll Script --}}
    <script>
        document.addEventListener('livewire:navigated', () => {
            scrollToBottom();
        });
        
        // Scroll setiap kali ada update di Livewire (termasuk polling)
        document.addEventListener('livewire:init', () => {
             Livewire.hook('morph.updated', ({ component, el }) => {
                if(component.name === 'chat.student-chat-widget' && document.getElementById('chat-container')) {
                    scrollToBottom();
                }
             });
        });

        function scrollToBottom() {
            const container = document.getElementById('chat-container');
            if(container) container.scrollTop = container.scrollHeight;
        }
    </script>
</div>