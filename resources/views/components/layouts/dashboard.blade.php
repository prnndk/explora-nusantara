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
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body x-data="sidebarData">
    <section class="h-full w-full my-5">
        <x-layouts.sidebar />
        <main :class="{ 'ml-80 px-10 max-w-5xl ': sidebarOpenStatus, 'ml-20 px-6': !sidebarOpenStatus }"
            class="transition-all duration-300">
            {{ $slot }}
        </main>
    </section>
    <livewire:toast />
</body>

<script>
    Alpine.data("sidebarData", () => ({
        sidebarOpenStatus: false,

        toggle() {
            this.sidebarOpenStatus = !this.sidebarOpenStatus;
        },
    }));
</script>

{{-- scripts --}}
@stack('scripts')

</html>
