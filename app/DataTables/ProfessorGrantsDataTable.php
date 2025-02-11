<?php

namespace App\DataTables;

use App\Models\ProfessorGrant;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorGrantsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action'])
            ->editColumn('grant.name', function (ProfessorGrant $professorGrant) {
                return $professorGrant->name;
            })
            ->editColumn('amount', function (ProfessorGrant $professorGrant) {
                return $professorGrant->amount;
            })
            ->editColumn('grant_type', function (ProfessorGrant $professorGrant) {
                return $professorGrant->grant->grantType->code . ' - ' . $professorGrant->grant->grantType->name;
            })
            ->editColumn('grant.currency', function (ProfessorGrant $professorGrant) {
                return $professorGrant->grant->currency->code;
            })
            ->editColumn('grant.fundingSource', function (ProfessorGrant $professorGrant) {
                return $professorGrant->grant->fundingSource->name;
            })
            ->editColumn('role', function (ProfessorGrant $professorGrant) {
                return $professorGrant->role;
            })
            ->editColumn('start_date', function (ProfessorGrant $professorGrant) {
                return $professorGrant->grant->end_date ? Carbon::parse($professorGrant->grant->start_date)->format('d/m/Y') . ' - ' . Carbon::parse($professorGrant->grant->end_date)->format('d/m/Y') : Carbon::parse($professorGrant->grant->start_date)->format('d/m/Y');
            })
            ->addColumn('action', function (ProfessorGrant $grant) {
                return view('pages/professors.grants.columns._actions', compact('grant'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProfessorGrant $model): QueryBuilder
    {
        return $model->newQuery()
                     ->with(['grant', 'grant.grantType', 'grant.currency', 'grant.fundingSource'])
                     ->where('professor_id', Auth::user()->professor->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-grant-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-10'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/grants/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('grant.name')->title('Name')->addClass('text-start'),
            Column::make('grant.amount')->title('Amount'),
            Column::make('grant_type')->title('Grant Type'),
            Column::make('grant.currency')->title('Currency'),
            Column::make('grant.fundingSource')->title('Funding Source'),
            Column::make('role')->title('Role'),
            Column::make('start_date')->title('Date')->addClass('text-start'),
            Column::computed('action')
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false)
                ->width(60)
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'ProfessorGrants_' . date('YmdHis');
    }
}
