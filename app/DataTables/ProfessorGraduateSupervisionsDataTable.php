<?php

namespace App\DataTables;

use App\Models\ProfessorGraduateSupervision;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorGraduateSupervisionsDataTable extends DataTable
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
            ->editColumn('student_first_name', function (ProfessorGraduateSupervision $supervision) {
                return $supervision->studentFullName();
            })
            ->editColumn('start_year', function (ProfessorGraduateSupervision $supervision) {
                return $supervision->start_year;
            })
            ->editColumn('start_month', function (ProfessorGraduateSupervision $supervision) {
                return $supervision->start_month;
            })
            ->editColumn('end_year', function (ProfessorGraduateSupervision $supervision) {
                return $supervision->end_year;
            })
            ->editColumn('end_month', function (ProfessorGraduateSupervision $supervision) {
                return $supervision->end_month;
            })
            ->editColumn('student_program_area', function (ProfessorGraduateSupervision $supervision) {
                return $supervision->student_program_area;
            })
            ->editColumn('student_program_name', function (ProfessorGraduateSupervision $supervision) {
                return $supervision->student_program_name;
            })
            ->editColumn('created_at', function (ProfessorGraduateSupervision $supervision) {
                return $supervision->created_at->format('d/m/Y');
            })
            ->addColumn('action', function (ProfessorGraduateSupervision $supervision) {
                return view('pages/professors.supervisions.columns._actions', compact('supervision'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProfessorGraduateSupervision $model): QueryBuilder
    {
        return $model->newQuery()
                     ->with(['professor', 'studyProgram', 'supervisionStatus', 'supervisionRole'])
                     ->where('professor_id', Auth::user()->professor->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-graduate-supervision-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/supervisions/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('student_first_name')->title('Full Name')->addClass('text-start'),
            Column::make('start_year')->title('Start Year'),
            Column::make('start_month')->title('Start Month'),
            Column::make('end_year')->title('End Year')->nullable(),
            Column::make('end_month')->title('End Month')->nullable(),
            Column::make('student_program_area')->title('Program Area'),
            Column::make('student_program_name')->title('Program Name'),
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
        return 'ProfessorGraduateSupervisions_' . date('YmdHis');
    }
}
