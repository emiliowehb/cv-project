<?php

namespace App\DataTables;

use App\Models\ProfessorPresentation;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorPresentationsDataTable extends DataTable
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
            ->editColumn('name', function (ProfessorPresentation $presentation) {
                return $presentation->name;
            })
            ->editColumn('year', function (ProfessorPresentation $presentation) {
                return $presentation->year;
            })
            ->editColumn('month', function (ProfessorPresentation $presentation) {
                return $presentation->month;
            })
            ->editColumn('days', function (ProfessorPresentation $presentation) {
                return $presentation->days;
            })
            ->editColumn('event_name', function (ProfessorPresentation $presentation) {
                return $presentation->event_name;
            })
            ->editColumn('country', function (ProfessorPresentation $presentation) {
                return $presentation->country->name;
            })
            ->editColumn('town', function (ProfessorPresentation $presentation) {
                return $presentation->town ? $presentation->town : '-';
            })
            ->editColumn('is_published_in_proceedings', function (ProfessorPresentation $presentation) {
                return $presentation->is_published_in_proceedings ? 'Yes' : 'No';
            })
            ->editColumn('intellectual_contribution', function (ProfessorPresentation $presentation) {
                return $presentation->intellectualContribution->name;
            })
            ->addColumn('action', function (ProfessorPresentation $presentation) {
                return view('pages/professors.presentations.columns._actions', compact('presentation'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProfessorPresentation $model): QueryBuilder
    {
        return $model->newQuery()
                     ->with(['country', 'intellectualContribution'])
                     ->where('professor_id', Auth::user()->professor->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-presentations-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-10'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/presentations/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('name')->title('Name')->addClass('text-start'),
            Column::make('year')->title('Year'),
            Column::make('month')->title('Month'),
            Column::make('days')->title('Days'),
            Column::make('event_name')->title('Event Name'),
            Column::make('country')->title('Country'),
            Column::make('town')->title('Town'),
            Column::make('is_published_in_proceedings')->title('Published in Proceedings'),
            Column::make('intellectual_contribution')->title('Intellectual Contribution'),
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
        return 'ProfessorPresentations_' . date('YmdHis');
    }
}