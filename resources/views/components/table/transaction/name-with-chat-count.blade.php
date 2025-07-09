<div class="flex items-center gap-2">
    <span class="text-sm font-semibold text-neutral-900">
        {{ \Illuminate\Support\Str::limit($row->product->nama, 25) }}.
    </span>
    @if ($row->chat->count() > 0)
        <span
            class="bg-transparent text-red-500 border border-neutral-300 flex items-center text-xs font-semibold px-2.5 py-0.5 rounded-full">
            <span class="block w-1.5 h-1.5 -ml-0.5 mr-1 bg-red-500 rounded-full animate-pulse"></span>

            <span>{{ $row->chat->count() }} new chats</span>
        </span>
    @endif
</div>
