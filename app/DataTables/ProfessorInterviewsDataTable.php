<?php

namespace App\DataTables;

use App\Models\ProfessorInterview;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorInterviewsDataTable extends DataTable
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
            ->editColumn('name', function (ProfessorInterview $professorInterview) {
                return $professorInterview->name;
            })
            ->editColumn('type.name', function (ProfessorInterview $professorInterview) {
                return $professorInterview->type->name;
            })
            ->editColumn('source', function (ProfessorInterview $professorInterview) {
                return $professorInterview->source;
            })
            ->editColumn('notes', function (ProfessorInterview $professorInterview) {
                return $professorInterview->notes;
            })
            ->editColumn('start_date', function (ProfessorInterview $professorInterview) {
                return $professorInterview->end_date ? Carbon::parse($professorInterview->start_date)->format('d/m/Y') . ' - ' . Carbon::parse($professorInterview->end_date)->format('d/m/Y') : Carbon::parse($professorInterview->start_date)->format('d/m/Y');
            })
            ->addColumn('action', function (ProfessorInterview $interview) {
                return view('pages/professors.interviews.columns._actions', compact('interview'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProfessorInterview $model): QueryBuilder
    {
        return $model->newQuery()
                     ->with(['type'])
                     ->where('professor_id', Auth::user()->professor->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-interview-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-10'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/interviews/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('name')->title('Name')->addClass('text-start'),
            Column::make('type.name')->title('Type'),
            Column::make('source')->title('Source'),
            Column::make('notes')->title('Notes'),
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
        return 'ProfessorInterviews_' . date('YmdHis');
    }
}
