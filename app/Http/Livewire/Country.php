<?php

namespace App\Http\Livewire;

use App\Models\Country as ModelsCountry;
use Livewire\Component;
use WireUi\Traits\Actions;

class Country extends Component
{
    use Actions;

    public $openModal = false;

    public $nameCountry;
    public $codeCountry;

    protected $rules = [
        'nameCountry' => 'required|string',
        'codeCountry' => 'required|string',
    ];

    public function addCountry()
    {
        $this->validate();

        ModelsCountry::create([
            'name' => $this->nameCountry,
            'code' => $this->codeCountry,
        ]);

        $this->emit('refreshDatatable');
        $this->openModal = false;

        $this->reset([
            'nameCountry',
            'codeCountry',
        ]);

        $this->dialog()->success(
            $title = 'Creado Exitosamente',
            $description = 'El país fue creado exitosamente'
        );


    }

    public function render()
    {
        return view('livewire.country');
    }
}
