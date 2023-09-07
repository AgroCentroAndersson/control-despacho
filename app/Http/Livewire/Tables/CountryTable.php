<?php

namespace App\Http\Livewire\Tables;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Country;
use Illuminate\Database\Eloquent\Builder;
use PHPUnit\Framework\Constraint\Count;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class CountryTable extends DataTableComponent
{
    // protected $model = Country::class;

    public $openModal = false;
    public Country $country;

    protected $rules = [
        'country.name' => 'required|string',
        'country.code' => 'required|string',
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function edit($id)
    {
        $this->openModal = true;
        $this->country = Country::find($id);
    }

    public function save()
    {
        $this->validate();

        $this->country->save();

        $this->openModal = false;

        $this->emit('refreshDatatable');
    }

    public function closeModal()
    {
        $this->openModal = false;
        $this->country = new Country();
    }

    public function customView(): string
    {
        return 'modals.country';
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->searchable()
                ->sortable(),
            Column::make("Nombre", "name")
                ->searchable()
                ->sortable(),
            Column::make("Nombre Interno", "code")
                ->searchable()
                ->sortable(),
            LinkColumn::make('Action')
                ->title(fn () => 'Editar')
                ->location(fn () => '#edit')
                ->attributes(fn ($row) => [
                    'wire:click' => 'edit(' . $row->id . ')',
                    '' => 'positive',
                    'icon' => 'edit',
                ]),
        ];
    }

    public function builder(): Builder
    {
        return Country::query();
    }
}
