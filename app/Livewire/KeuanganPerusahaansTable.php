<?php

namespace App\Livewire;

use App\Models\KeuanganBulanan;
use App\Models\KeuanganDetail;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\Exportable;
use PowerComponents\LivewirePowerGrid\Facades\Filter;
use PowerComponents\LivewirePowerGrid\Footer;
use PowerComponents\LivewirePowerGrid\Header;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridColumns;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\WithExport;

final class KeuanganPerusahaansTable extends PowerGridComponent
{
    use WithExport;

    //Custom per page
    public int $perPage = 5;

    //Custom per page values
    public array $perPageValues = [0, 5, 10, 20, 50];

    public function setUp(): array
    {
        $this->showCheckBox();

        return [
            Exportable::make('export')
                ->striped()
                ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()
                ->withoutLoading()
                ->showSearchInput(),
            Footer::make()
                ->showPerPage($this->perPage, $this->perPageValues)
                ->showRecordCount(mode: 'full'),
        ];
    }

    public function datasource(): Builder
    {
        return KeuanganDetail::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('keuangan_bulanan_id', fn (KeuanganDetail $model) => \Carbon\Carbon::create()->month($model->keuanganBulanan->bulan)->format('F'))
            ->addColumn('description')

           /** Example of custom column using a closure **/
            ->addColumn('description_lower', fn (KeuanganDetail $model) => strtolower(e($model->description)))

            ->addColumn('total', fn (KeuanganDetail $model) => 'Rp ' . number_format($model->total, 2, ',', '.'))
            ->addColumn('created_at_formatted', fn (KeuanganDetail $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            Column::make('Id', 'id'),
            Column::make('Bulan', 'keuangan_bulanan_id')
                ->sortable()
                ->searchable(),   
            Column::make('Description', 'description')
                ->sortable()
                ->searchable(),

            Column::make('Total', 'total'),
            Column::make('Created at', 'created_at_formatted', 'created_at')
                ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('description')->operators(['contains']),
            Filter::datetimepicker('created_at'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actions(\App\Models\KeuanganDetail $row): array
    {
        return [
            // Button::add('create-dish')
            //     ->slot('Create a dish')
            //     ->class('bg-indigo-500 text-white'),

            Button::add('edit')
            ->bladeComponent('livewire.action-button', [
                "route"     => '/keuangan-perusahaan/',
                "id"        => $row->id,
                "routeedit" => '/edit',
                "edit"      => true,
                "delete"    => true,
            ]),
        ];
    }

    /*
    public function actionRules($row): array
    {
       return [
            // Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($row) => $row->id === 1)
                ->hide(),
        ];
    }
    */
}
