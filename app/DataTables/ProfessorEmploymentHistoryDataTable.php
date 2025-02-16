<?php

namespace App\DataTables;

use App\Models\Employment;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorEmploymentHistoryDataTable extends DataTable
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
            ->editColumn('employer', function (Employment $employment) {
                return $employment->employer;
            })
            ->editColumn('country_id', function (Employment $employment) {
                return $employment->country->name;
            })
            ->editColumn('position_id', function (Employment $employment) {
                return $employment->position->name;
            })
            ->editColumn('start_year', function (Employment $employment) {
                return $employment->start_year;
            })
            ->editColumn('end_year', function (Employment $employment) {
                return $employment->end_year ?? 'Present';
            })
            ->editColumn('is_current', function (Employment $employment) {
                return $employment->is_current ? 'Yes' : 'No';
            })
            ->editColumn('is_full_time', function (Employment $employment) {
                return $employment->is_full_time ? 'Yes' : 'No';
            })
            ->editColumn('created_at', function (Employment $employment) {
                return $employment->created_at->format('d/m/Y');
            })
            ->addColumn('action', function (Employment $employment) {
                return view('pages/professors.employment-history.columns._actions', compact('employment'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Employment $model): QueryBuilder
    {
        return $model->newQuery()
                     ->select('employments.*')
                     ->with(['country', 'position'])
                     ->where('professor_id', Auth::user()->professor->id)
                     ->orderBy('start_year', 'desc');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-employment-history-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/employment-history/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('employer')->title('Employer'),
            Column::make('country_id')->title('Country'),
            Column::make('position_id')->title('Position'),
            Column::make('start_year')->title('Start Year'),
            Column::make('end_year')->title('End Year'),
            Column::make('is_current')->title('Current'),
            Column::make('is_full_time')->title('Full Time'),
            Column::make('created_at')->title('Date Added')->addClass('text-start'),
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
        return 'ProfessorEmploymentHistory_' . date('YmdHis');
    }
}
