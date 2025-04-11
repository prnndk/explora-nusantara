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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex flex-col items-start min-h-screen w-full p-4"
      style="background: linear-gradient(235.71deg, rgba(35,147,145,0) 3.28%, rgba(35,147,145,0.8) 47.15%, #239391 84.53%),
            url('{{ asset('images/container-image.jpg') }}');
           background-size: cover;
           background-position: center;
           background-repeat: no-repeat;
           background-attachment: fixed;">

<div class="flex px-6">
    <x-auth-header/>
</div>

<section class="flex items-center justify-center h-full w-full mt-5">
    <main class="w-full max-w-6xl">
        {{ $slot }}
    </main>
</section>
<livewire:toast/>
</body>

{{-- scripts --}}
@stack('scripts')

</html>
