<div>
    @if ($paginator->hasPages())
        <nav role="navigation" aria-label="Pagination Navigation"
             class="flex justify-center items-center space-x-2 mt-4">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="p-3 rounded text-gray-400 cursor-not-allowed">
                    <x-heroicon-s-chevron-left class="w-4 h-4"/>
                </span>
            @else
                <button
                    wire:click="previousPage"
                    wire:loading.attr="disabled"
                    rel="prev"
                    class="p-3 rounded hover:bg-gray-200"
                >
                    <x-heroicon-s-chevron-left class="w-4 h-4"/>
                </button>
            @endif

            @php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();
            @endphp

            <button
                wire:click="gotoPage(1)"
                class="p-3 rounded hover:bg-gray-200 {{ $current === 1 ? 'bg-mainGreen text-white font-bold hover:text-mainGreen' : '' }}"
            >
                1
            </button>

            {{-- Case: Current page is 1 --}}
            @if ($current <= 3&& $last > 3)
                @for ($i = 2; $i <= min(3, $last - 1); $i++)
                    <button
                        wire:click="gotoPage({{ $i }})"
                        class="p-3 rounded hover:bg-gray-200 {{ $current === $i ? 'bg-mainGreen text-white font-bold hover:text-mainGreen' : '' }}"
                    >
                        {{ $i }}
                    </button>
                @endfor
                @if ($last > 4 )
                    <span class="p-3 text-gray-500">...</span>
                    <button
                        wire:click="gotoPage({{ $last }})"
                        class="p-3 rounded hover:bg-gray-200 {{ $current === $last ? 'bg-mainGreen text-white font-bold hover:text-mainGreen' : '' }}"
                    >
                        {{ $last }}
                    </button>
                @endif

            @elseif ($current === 2 && $last > 3)
                @for ($i = 2; $i <= min(4, $last - 1); $i++)
                    <button
                        wire:click="gotoPage({{ $i }})"
                        class="p-3 rounded hover:bg-gray-200 {{ $current === $i ? 'bg-mainGreen text-white font-bold hover:text-mainGreen' : '' }}"
                    >
                        {{ $i }}
                    </button>
                @endfor
                @if ($last > 4)
                    <span class="p-3 text-gray-500">...</span>
                    <button
                        wire:click="gotoPage({{ $last }})"
                        class="p-3 rounded hover:bg-gray-200 {{ $current === $last ? 'bg-mainGreen text-white font-bold hover:text-mainGreen' : '' }}"
                    >
                        {{ $last }}
                    </button>
                @endif

            @elseif ($current >= $last - 2 && $last > 4)
                <span class="p-3 text-gray-500">...</span>
                @for ($i = $last - 2; $i <= $last; $i++)
                    @if ($i >= 2)
                        <button
                            wire:click="gotoPage({{ $i }})"
                            class="p-3 rounded hover:bg-gray-200 {{ $current === $i ? 'bg-mainGreen text-white font-bold hover:text-mainGreen' : '' }}"
                        >
                            {{ $i }}
                        </button>
                    @endif
                @endfor

                {{-- Middle Pages --}}
            @else
                @if ($current > 2)
                    <span class="p-3 text-gray-500">...</span>
                @endif
                @for ($i = $current - 1; $i <= $current + 1; $i++)
                    @if ($i > 1 && $i < $last)
                        <button
                            wire:click="gotoPage({{ $i }})"
                            class="p-3 rounded hover:bg-gray-200 {{ $current === $i ? 'bg-mainGreen text-white font-bold hover:text-mainGreen' : '' }}"
                        >
                            {{ $i }}
                        </button>
                    @endif
                @endfor
                @if ($current < $last - 1)
                    <span class="p-3 text-gray-500">...</span>
                @endif
                <button
                    wire:click="gotoPage({{ $last }})"
                    class="p-3 rounded hover:bg-gray-200 {{ $current === $last ? 'bg-mainGreen text-white font-bold hover:text-mainGreen' : '' }}"
                >
                    {{ $last }}
                </button>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <button
                    wire:click="nextPage"
                    wire:loading.attr="disabled"
                    rel="next"
                    class="p-3 rounded hover:bg-gray-200"
                >
                    <x-heroicon-s-chevron-right class="w-4 h-4"/>
                </button>
            @else
                <span class="p-3 rounded text-gray-400 cursor-not-allowed">
                    <x-heroicon-s-chevron-right class="w-4 h-4"/>
                </span>
            @endif

        </nav>
    @endif
</div>
