<x-layouts.dashboard webTitle="Tutorial">
    <h1 class="text-4xl font-bold">{{ ucfirst(auth()->user()->role->value) }} Tutorial</h1>
    <p>Quickly learn how to use our export-import software with our helpful text-based tutorials and frequently asked questions.</p>
    <div class="my-10">
        <livewire:tutorial />
    </div>
</x-layouts.dashboard>
