<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Grocer;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class GrocerTable extends DataTableComponent
{
    protected $model = Grocer::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Nombre", "name")
                ->sortable(),
            Column::make("Correo", "email")
                ->sortable(),
            Column::make("Telefono", "phone")
                ->sortable(),
            BooleanColumn::make("Estado", "state")
                ->setSuccessValue(1)
                ->sortable(),
        ];
    }
}
