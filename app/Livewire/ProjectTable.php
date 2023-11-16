<?php

namespace App\Livewire;

use App\Models\Project;
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

final class ProjectTable extends PowerGridComponent
{
    use WithExport;

    public function setUp(): array
    {
        // $this->showCheckBox();

        return [
            // Exportable::make('export')
            //     ->striped()
            //     ->type(Exportable::TYPE_XLS, Exportable::TYPE_CSV),
            Header::make()->showSearchInput(),
            Footer::make()
                ->showPerPage()
                ->showRecordCount(),
        ];
    }

    public function datasource(): Builder
    {
        return Project::query();
    }

    public function relationSearch(): array
    {
        return [];
    }

    public function addColumns(): PowerGridColumns
    {
        return PowerGrid::columns()
            ->addColumn('id')
            ->addColumn('name')

           /** Example of custom column using a closure **/
            ->addColumn('name_lower', fn (Project $model) => strtolower(e($model->name)))

            ->addColumn('slug')
            ->addColumn('client_name', fn (Project $model) => $model->client->name)
            ->addColumn('project_type', fn (Project $model) => $model->projectType->name)
            ->addColumn('description')
            ->addColumn('status')
            ->addColumn('start_date', fn (Project $model) => Carbon::parse($model->start_date)->format('d/m/Y'))
            ->addColumn('deadline_date', fn (Project $model) => Carbon::parse($model->deadline_date)->format('d/m/Y'))
            ->addColumn('harga_penawaran')
            ->addColumn('harga_deal')
            ->addColumn('status_server')
            ->addColumn('created_at_formatted', fn (Project $model) => Carbon::parse($model->created_at)->format('d/m/Y H:i:s'));
    }

    public function columns(): array
    {
        return [
            // Column::make('Id', 'id'),
            Column::make('Name', 'name')
                ->sortable()
                ->searchable(),

            // Column::make('Slug', 'slug')
            //     ->sortable()
            //     ->searchable(),

            Column::make('Client', 'client_name'),
            Column::make('Project Type', 'project_type')
                ->bodyAttribute('', 'width: 70px;'),
            // Column::make('Description', 'description')
            //     ->sortable()
            //     ->searchable(),

            Column::make('Status', 'status')
                ->sortable()
                ->searchable(),

            Column::make('Start date', 'start_date')
                ->sortable()
                ->searchable(),

            Column::make('Deadline date', 'deadline_date')
                ->sortable()
                ->searchable(),

            // Column::make('Harga penawaran', 'harga_penawaran'),
            // Column::make('Harga deal', 'harga_deal'),
            // Column::make('Status server', 'status_server')
            //     ->sortable()
            //     ->searchable(),

            // Column::make('Created at', 'created_at_formatted', 'created_at')
            //     ->sortable(),

            Column::action('Action')
        ];
    }

    public function filters(): array
    {
        return [
            Filter::inputText('name')->operators(['contains']),
            Filter::inputText('slug')->operators(['contains']),
            Filter::inputText('description')->operators(['contains']),
            Filter::inputText('status')->operators(['contains']),
            Filter::inputText('start_date')->operators(['contains']),
            Filter::inputText('deadline_date')->operators(['contains']),
            Filter::inputText('status_server')->operators(['contains']),
            Filter::datetimepicker('created_at'),
        ];
    }

    #[\Livewire\Attributes\On('edit')]
    public function edit($rowId): void
    {
        $this->js('alert('.$rowId.')');
    }

    public function actions(\App\Models\Project $row): array
    {
        return [
            Button::add('edit')
                ->bladeComponent('livewire.action-button', [
                    "route"     => '/project/',
                    "id"        => $row->slug,
                    "routeedit" => '/edit',
                    "edit"      => true,
                    "delete"    => true,
                    "detail"    => true,
                ]),

            // Button::add('edit')
            //     ->slot('Edit: '.$row->id)
            //     ->id()
            //     ->class('pg-btn-white dark:ring-pg-primary-600 dark:border-pg-primary-600 dark:hover:bg-pg-primary-700 dark:ring-offset-pg-primary-800 dark:text-pg-primary-300 dark:bg-pg-primary-700')
            //     ->dispatch('edit', ['rowId' => $row->id])
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
