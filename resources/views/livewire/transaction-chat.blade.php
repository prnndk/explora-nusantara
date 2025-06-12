<div>
    <div x-data="{
    
        slideOverOpen: false
    }">
        <button @click="slideOverOpen=true"
            class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium transition-colors bg-white border rounded-md hover:bg-neutral-100 active:bg-white focus:bg-white focus:outline-none focus:ring-2 focus:ring-neutral-200/60 focus:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none">
            <x-heroicon-s-chat-bubble-left-right class="size-4 mx-2" /> Mulai Percakapan</button>
        <template x-teleport="body">
            <div x-show="slideOverOpen" @keydown.window.escape="slideOverOpen=false" class="relative z-[99]">
                <div x-show="slideOverOpen" x-transition.opacity.duration.600ms @click="slideOverOpen = false"
                    class="fixed inset-0 bg-black bg-opacity-10"></div>
                <div class="fixed inset-0 overflow-hidden">
                    <div class="absolute inset-0 overflow-hidden">
                        <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
                            <div x-show="slideOverOpen" @click.away="slideOverOpen = false"
                                x-transition:enter="transform transition ease-in-out duration-500 sm:duration-700"
                                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                                x-transition:leave="transform transition ease-in-out duration-500 sm:duration-700"
                                x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full"
                                class="w-screen max-w-xl">
                                <div
                                    class="flex flex-col h-full py-5 overflow-y-scroll bg-white border-l shadow-lg border-neutral-100/70">
                                    <div class="px-4 sm:px-5">
                                        <div class="flex items-start justify-between pb-1">
                                            <h2 class="text-base font-semibold leading-6 text-gray-900"
                                                id="slide-over-title">Chatting#{{ $transaction->id }}</h2>
                                            <div class="flex items-center h-auto ml-3">
                                                <button @click="slideOverOpen=false"
                                                    class="absolute top-0 right-0 z-30 flex items-center justify-center px-3 py-2 mt-4 mr-5 space-x-1 text-xs font-medium uppercase border rounded-md border-neutral-200 text-neutral-600 hover:bg-neutral-100">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    <span>Close</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="relative flex-1 px-4 mt-5 sm:px-5">
                                        <div class="absolute inset-0 px-4 sm:px-5">
                                            <div class="relative h-full overflow-y-scroll overflow-x-hidden p-3 pb-20 border border-dashed rounded-md border-neutral-300"
                                                id="chat-messages" x-data="{
                                                    scrollToBottom() {
                                                        this.$nextTick(() => {
                                                            this.$el.scrollTop = this.$el.scrollHeight;
                                                        });
                                                    }
                                                }" x-init="scrollToBottom()"
                                                @message-updated.window="scrollToBottom()"
                                                x-intersect:enter="scrollToBottom()">
                                                <div class="flex w-full flex-col gap-4">
                                                    @forelse ($transactionChats as $chat)
                                                        @if ($chat->sender->role === auth()->user()->role)
                                                            {{-- sender --}}
                                                            <div
                                                                class="ml-auto flex max-w-[80%] flex-col gap-2 rounded-2xl rounded-tr-none bg-black p-4 text-sm text-neutral-100 md:max-w-[60%] dark:bg-white dark:text-black">
                                                                <span
                                                                    class="font-semibold">{{ auth()->user()->name }}</span>
                                                                <div class="text-sm text-neutral-300">
                                                                    {{ $chat->message }}
                                                                </div>
                                                                <span
                                                                    class="ml-auto text-xs">{{ $chat->created_at->format('h:i A') }}</span>
                                                            </div>
                                                        @else
                                                            <div
                                                                class="mr-auto flex max-w-[80%] flex-col gap-2 rounded-2xl rounded-tl-none bg-neutral-50 p-4 text-neutral-900 md:max-w-[60%] dark:bg-neutral-900 dark:text-white">
                                                                <span
                                                                    class="font-semibold">{{ $chat->sender->username }}</span>
                                                                <div
                                                                    class="text-sm text-neutral-600 dark:text-neutral-300">
                                                                    {{ $chat->message }}
                                                                </div>
                                                                <span
                                                                    class="ml-auto text-xs">{{ $chat->created_at->format('h:i A') }}</span>
                                                            </div>
                                                        @endif
                                                    @empty
                                                        <div class="text-center text-sm text-neutral-500">
                                                            No messages yet. Start the conversation!
                                                        </div>
                                                    @endforelse
                                                </div>
                                            </div>
                                            <div
                                                class="absolute bottom-0 left-0 right-0 px-4 py-3 bg-white border-t border-neutral-200">
                                                <form wire:submit="sendMessage" class="flex items-center gap-2">
                                                    <textarea wire:model="message" placeholder="Type your message here..."
                                                        class="w-full px-3 py-2 text-sm border border-neutral-300 rounded-md focus:ring-2 focus:ring-neutral-300 focus:outline-none"
                                                        rows="2"></textarea>
                                                    <button type="submit"
                                                        class="inline-flex items-center justify-center h-10 px-4 py-2 text-sm font-medium text-white transition-colors bg-black rounded-md hover:bg-neutral-800 focus:outline-none focus:ring-2 focus:ring-neutral-300">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                            viewBox="0 0 20 20" fill="currentColor">
                                                            <path
                                                                d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('messageUpdated', (event) => {
                scrollChatToBottom();
            });
        });

        document.addEventListener('livewire:update', () => {
            scrollChatToBottom();
        });

        function scrollChatToBottom() {
            setTimeout(() => {
                const chatMessages = document.getElementById('chat-messages');
                if (!chatMessages) {
                    return;
                }
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }, 100); // Small delay to ensure rendering completes
        }
    </script>
@endpush
