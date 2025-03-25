<x-layouts.app-white webTitle="Checkout Success">

    <div class="flex flex-col items-center justify-center gap-4">
        <h3 class="font-bold text-2xl">Checkout Successful!</h3>
        <img src="{{ asset('images/checkout-success.svg') }}" alt="">
        <p class="text-lg">Yeay! Your checkout was successful. Thank you for trusting us with your purchase!</p>
        <a href="{{ route('dashboard') }}" class="bg-ecstasy-500 text-white px-4 py-2 rounded-md mt-4">Go to
            Dashboard</a>
    </div>
</x-layouts.app-white>
