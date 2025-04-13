<div x-data="{ openTab: null, openFaqs: {} }" class="space-y-2 mt-4" x-init="$watch('openTab', value => {
    if (typeof value === 'number' && !openFaqs[value]) openFaqs[value] = null;
})">
    @foreach ($items as $index => $item)
        <div class="border rounded-md overflow-hidden">

            <!-- Header -->
            <button @click="openTab = openTab === {{ $index }} ? null : {{ $index }}"
                class="w-full flex justify-between items-center p-5 text-left transition-colors duration-300
                    text-sm font-medium"
                :class="openTab === {{ $index }} ? 'text-orange-500 font-semibold' : 'text-gray-700'">
                <span>{{ $loop->iteration }}. {{ $item['title'] }}</span>
                <svg class="w-5 h-5 transform transition-transform duration-300"
                    :class="{ 'rotate-180': openTab === {{ $index }} }" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Content -->
            <div x-show="openTab === {{ $index }}" x-collapse class="bg-white p-4 text-sm text-gray-700">

                {{-- Media --}}
                @php
                    $media = $item['media'] ?? null;
                    if (Str::contains($media, 'youtube.com/watch')) {
                        preg_match('/v=([^&]+)/', $media, $matches);
                        $videoId = $matches[1] ?? '';
                        $media = "https://www.youtube.com/embed/$videoId";
                    }
                @endphp

                <iframe class="w-full h-64" src="{{ $media }}" frameborder="0" allowfullscreen>
                </iframe>

                {{-- Text Content --}}
                @if (!empty($item['content']))
                    {!! $item['content'] !!}
                @endif

                {{-- FAQ --}}
                @if (!empty($item['faqs']))
                    <div class="space-y-3 mt-4">
                        @foreach ($item['faqs'] as $faqIndex => $faq)
                            <div class="border-b pb-3">
                                <button
                                    @click="openFaqs[{{ $index }}] = openFaqs[{{ $index }}] === {{ $faqIndex }} ? null : {{ $faqIndex }}"
                                    class="w-full text-left flex justify-between items-center">
                                    <span
                                        :class="openFaqs[{{ $index }}] === {{ $faqIndex }} ?
                                            'text-orange-500 font-medium' : 'text-gray-800'">
                                        {{ $faq['question'] }}
                                    </span>
                                    <span
                                        :class="openFaqs[{{ $index }}] === {{ $faqIndex }} ? 'text-orange-500' :
                                            'text-gray-800'">
                                        +
                                    </span>
                                </button>
                                <div x-show="openFaqs[{{ $index }}] === {{ $faqIndex }}" x-collapse
                                    class="mt-2 text-sm text-gray-600">
                                    {{ $faq['answer'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    @endforeach
</div>
