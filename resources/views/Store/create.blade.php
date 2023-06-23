<x-app>
    <div class="m-4">
        <h1 class="font-semibold text-3xl text-center text-bold">Crear Bodega</h1>
    </div>
    <div>
        <x-errors />
        <form action="{{ route('store.store') }}" method="POST">
            @csrf
            <x-input class="mb-4" label='Nombre' name='name' placeholder='Ingrese el nombre de la bodega' icon='home' value="{{ old('name', '') }}"></x-input>
            @livewire('phone')
            <x-input class="mb-4" label='Código de bodega en SAP' name='codeSAP' placeholder='Ingrese el codigo de la bodega' icon='clipboard-check' value="{{ old('codeSAP', '') }}"></x-input>
            <x-input class="mb-4" label='Direccion' name='address' placeholder='Ingrese el nombre de la bodega' icon='globe' value="{{ old('address', '') }}"></x-input>

            <div class="text-end">
                <x-button href="{{ route('store.index') }}" negative>Cancelar</x-button>
                <x-button type='submit' positive>Guardar</x-button>
            </div>
        </form>
    </div>
</x-app>
