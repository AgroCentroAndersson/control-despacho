<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Store;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Columns\BooleanColumn;

class StoreTable extends DataTableComponent
{
    // protected $model = Store::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->hideIf(true)
                ->searchable()
                ->sortable(),
            Column::make("Nombre", "name")
                ->searchable()
                ->sortable(),
            Column::make("Direccion", "address")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            Column::make("Telefono", "phone")
                ->collapseOnTablet()
                ->searchable()
                ->sortable(),
            BooleanColumn::make("Estado", "state")
                ->collapseOnTablet()
                ->searchable()
                ->setSuccessValue(1)
                ->sortable(),
            Column::make("created_at")
                ->hideIf(true)
                ->searchable()
                ->sortable(),

        ];
    }

    public function builder(): Builder
    {
        return Store::query()
                ->where('state', '<=', 1);
    }
}
