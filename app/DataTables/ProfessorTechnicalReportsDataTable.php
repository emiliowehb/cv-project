<?php

namespace App\DataTables;

use App\Models\ProfessorTechnicalReport;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorTechnicalReportsDataTable extends DataTable
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
            ->editColumn('year', function (ProfessorTechnicalReport $report) {
                return $report->year;
            })
            ->editColumn('month', function (ProfessorTechnicalReport $report) {
                return $report->month;
            })
            ->editColumn('publisher', function (ProfessorTechnicalReport $report) {
                return $report->publisher->name;
            })
            ->editColumn('identifying_number', function (ProfessorTechnicalReport $report) {
                return $report->identifying_number ?? '-';
            })
            ->editColumn('volume', function (ProfessorTechnicalReport $report) {
                return $report->volume ?? '-';
            })
            ->editColumn('nb_pages', function (ProfessorTechnicalReport $report) {
                return $report->nb_pages ?? '-';
            })
            ->editColumn('work_classification', function (ProfessorTechnicalReport $report) {
                return $report->workClassification->name;
            })
            ->editColumn('research_area', function (ProfessorTechnicalReport $report) {
                return $report->researchArea->name;
            })
            ->editColumn('notes', function (ProfessorTechnicalReport $report) {
                return $report->notes ?? '-';
            })
            ->editColumn('publication_status', function (ProfessorTechnicalReport $report) {
                return $report->publicationStatus->name;
            })
            ->editColumn('intellectual_contribution', function (ProfessorTechnicalReport $report) {
                return $report->intellectualContribution->name;
            })
            ->addColumn('action', function (ProfessorTechnicalReport $report) {
                return view('pages/professors.technical-reports.columns._actions', compact('report'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProfessorTechnicalReport $model): QueryBuilder
    {
        return $model->newQuery()
                     ->with(['publisher', 'workClassification', 'researchArea', 'publicationStatus', 'intellectualContribution'])
                     ->where('professor_id', Auth::user()->professor->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-technical-report-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/technical-reports/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('year')->title('Year')->addClass('text-start'),
            Column::make('month')->title('Month'),
            Column::make('publisher')->title('Publisher'),
            Column::make('identifying_number')->title('Identifying Number'),
            Column::make('volume')->title('Volume'),
            Column::make('nb_pages')->title('Number of Pages'),
            Column::make('work_classification')->title('Work Classification'),
            Column::make('research_area')->title('Research Area'),
            Column::make('notes')->title('Notes'),
            Column::make('publication_status')->title('Publication Status'),
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
        return 'ProfessorTechnicalReports_' . date('YmdHis');
    }
}
