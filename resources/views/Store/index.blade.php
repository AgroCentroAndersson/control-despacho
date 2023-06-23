<x-app>

    <div>
        <h1 class="font-italic text-3xl text-center text-bold">Listado de Bodegas</h1>
    </div>
    <div class="text-end mb-4">
        <x-button positive href="{{ route('store.create') }}">Crear nuevo almacen</x-button>
    </div>
    <div>
        @livewire('store-table')
    </div>

</x-app>
