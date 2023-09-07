<x-modal wire:model='openModal'>
    <x-card title="Editar Pais">
        <div class="grid grid-cols-2 gap-4">
            <x-input label='Pais' wire:model='country.name'></x-input>
            <x-input label='Codigo' wire:model='country.code'></x-input>
        </div>
        <x-slot name='footer'>
            <div class="flex justify-between gap-x-4">
                <div class="flex">
                    <x-button flat label="Cancelar" wire:click='closeModal'/>
                    <x-button primary label="Actualizar" wire:click="save" wire:click='save' />
                </div>
            </div>
        </x-slot>
    </x-card>
</x-modal>
