<x-app>
    <div class="m-4">
        <h1 class="font-semibold text-3xl text-center text-bold">Crear Bodega</h1>
    </div>
    <div>
        <x-errors />
        <form action="{{ route('grocer.store') }}" method="POST">
            @csrf
            <x-input class="mb-4" type="text" label='Nombre' name='name' placeholder='Ingrese el nombre del bodeguero' icon='user' value="{{ old('name', '') }}"></x-input>
            <x-input class="mb-4" type="text" label='Usuario' name='username' placeholder='Ingrese el nombre del bodeguero' icon='user' value="{{ old('username', '') }}" style="text-transform: uppercase;"></x-input>
            <x-input class="mb-4" typer="email" label='Correo' name='email' placeholder='Ingrese el correo del bodeguero' icon='at-symbol' value="{{ old('email', '') }}"></x-input>
            @livewire('phone', ['phone' => old('phone', '')])

            <div class="mb-4">
                <x-native-select label="Almacen" name="store_id">
                    <option value="0" selected>Seleccione un almacen</option>
                    @foreach ($stores as $store)
                        <option value="{{ $store->id }}">{{ $store->name }}</option>
                    @endforeach
                </x-native-select>
            </div>

            <div class="text-end">
                <x-button href="{{ route('grocer.index') }}" negative>Cancelar</x-button>
                <x-button type='submit' positive>Guardar</x-button>
            </div>
        </form>
    </div>
</x-app>
