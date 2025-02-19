<?php

namespace App\DataTables;

use App\Models\ProfessorHonor;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorHonorsDataTable extends DataTable
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
            ->editColumn('name', function (ProfessorHonor $honor) {
                return $honor->name;
            })
            ->editColumn('honor_type', function (ProfessorHonor $honor) {
                return $honor->honorType->name;
            })
            ->editColumn('honor_organization', function (ProfessorHonor $honor) {
                return $honor->honorOrganization->name;
            })
            ->editColumn('start_year', function (ProfessorHonor $honor) {
                return $honor->start_year;
            })
            ->editColumn('end_year', function (ProfessorHonor $honor) {
                return $honor->end_year ?? '-';
            })
            ->editColumn('is_ongoing', function (ProfessorHonor $honor) {
                return $honor->is_ongoing ? 'Yes' : 'No';
            })
            ->editColumn('notes', function (ProfessorHonor $honor) {
                return $honor->notes ?? '-';
            })
            ->addColumn('action', function (ProfessorHonor $honor) {
                return view('pages/professors.honors.columns._actions', compact('honor'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProfessorHonor $model): QueryBuilder
    {
        return $model->newQuery()
                     ->with(['honorType', 'honorOrganization'])
                     ->where('professor_id', Auth::user()->professor->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-honor-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/honors/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('name')->title('Name')->addClass('text-start'),
            Column::make('honor_type')->title('Honor Type'),
            Column::make('honor_organization')->title('Honor Organization'),
            Column::make('start_year')->title('Start Year'),
            Column::make('end_year')->title('End Year'),
            Column::make('is_ongoing')->title('Ongoing'),
            Column::make('notes')->title('Notes'),
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
        return 'ProfessorHonors_' . date('YmdHis');
    }
}
