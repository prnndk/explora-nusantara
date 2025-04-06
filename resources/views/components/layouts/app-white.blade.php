@props([
    'webTitle' => '',
])

<!DOCTYPE html>
<html lang="en" class="font-poppins">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $webTitle }} | Explora Nusantara</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <script src="https://unpkg.com/alpinejs" defer></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col items-start h-screen w-full p-4">
    <div class="flex px-6">
        <div class="flex items-center text-mainGreen md:text-xl font-bold mb-6">
            <img src="{{ asset('images/logo.svg') }}" alt="logo" class="w-12 h-12 md:w-16 md:h-16" />
            <h1 class="ml-4">Explora Nusantara</h1>
        </div>
    </div>

    <section class="min-h-full w-full mx-3 my-5">
        {{ $slot }}
    </section>

</body>

</html>
