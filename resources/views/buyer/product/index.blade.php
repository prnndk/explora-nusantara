<x-layouts.dashboard webTitle="Product">
    <h1 class="text-4xl font-bold">Product</h1>
    <p>Welcome to our product page! Explore a wide range of options designed specifically to provide the solutions
        you're looking for.</p>

    <div class="flex flex-col gap-8 mt-10">
        <div class="flex flex-row justify-between w-full">
            <h5 class="underline underline-offset-8 decoration-4 decoration-mainGreen font-bold">Category</h5>

            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <x-heroicon-m-magnifying-glass class="w-6 h-6 text-gray-500"/>
                </div>
                <input type="search"
                       class="block w-full p-2 px-7 ps-10 text-sm text-gray-600 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Search Product" required/>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-8">
            @for($i=0; $i < 10 ; $i++ )
            <div class="max-w-sm lg:max-w-md bg-white rounded-2xl shadow-lg overflow-hidden ">
                <img src="{{asset('images/mountain-placeholder.jpg')}}" alt="Card Image" class="w-full h-48 object-cover">
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-2">The Coldest Sunset</h2>
                    <p class="text-gray-600 mb-8">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Voluptatibus quia, nulla! Maiores et perferendis eaque.</p>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="bg-yellow-200 bg-opacity-60 text-gray-800 text-sm font-medium px-4 py-1 rounded-full">New</span>
                        <span class="bg-pink-200 bg-opacity-60 text-gray-800 text-sm font-medium px-4 py-1 rounded-full">Popular</span>
                    </div>
                    <p class="text-gray-600">Stock: <span class="text-mainGreen font-semibold">1000</span></p>
                </div>
            </div>
            @endfor
        </div>
    </div>


</x-layouts.dashboard>
