<x-app>

    <div>
        <h1 class="font-italic text-3xl text-center text-bold">Listado de Bodeguero</h1>
    </div>
    <div class="text-end mb-4">
        <x-button positive href="{{ route('grocer.create') }}">Crear nuevo bodeguero</x-button>
    </div>
    <div>
        @livewire('grocer-table')
    </div>

</x-app>
