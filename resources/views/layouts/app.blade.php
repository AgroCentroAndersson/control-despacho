<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Control de Depachos</title>

    @vite('resources/css/app.css')


    @wireUiScripts
    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- <script src="//unpkg.com/alpinejs" defer></script> --}}

</head>
<body>
    <x-dialog />
    <nav class="m-4">
        <ul class="flex justify-around">
            <li><a href="{{ route('paises') }}">Paises</a></li>
            <li><a href="{{ route('store.index') }}">Bodegas</a></li>
            <li><a href="{{ route('grocer.index') }}">Bodeguero</a></li>
        </ul>

    </nav>

    <main class="container container-2xl m-auto">
        {{ $slot }}
    </main>
    @livewireScripts
</body>
</html>
