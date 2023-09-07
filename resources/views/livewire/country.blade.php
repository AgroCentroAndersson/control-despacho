<div>
    <div class="text-center">
        <h1 class="font-semibolt text-3xl">Paises</h1>
    </div>

    <div class="text-end py-4">
        <x-button label='Crear Nuevo Pais' icon='plus' positive wire:click="$set('openModal', true)"></x-button>
    </div>

    <div>
        @livewire('tables.country-table')
    </div>

    <x-modal wire:model='openModal'>
        <x-card>
            <x-input label='Nombre' placeholder='Ingrese el nombre del pais' wire:model='nameCountry'></x-input>
            <x-input label='Codigo Interno' placeholder='Ingrese el codigo interno de la base' wire:model='codeCountry'></x-input>
            <x-slot name="footer">
                <div class="text-end">
                    <x-button label='Guardar' positive wire:click='addCountry'></x-button>
                </div>
            </x-slot>
        </x-card>

    </x-modal>
</div>
