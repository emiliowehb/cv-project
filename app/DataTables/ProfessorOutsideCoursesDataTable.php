<?php

namespace App\DataTables;

use App\Models\ProfessorOutsideCourse;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorOutsideCoursesDataTable extends DataTable
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
            ->editColumn('name', function (ProfessorOutsideCourse $course) {
                return $course->name;
            })
            ->editColumn('institution', function (ProfessorOutsideCourse $course) {
                return $course->institution;
            })
            ->editColumn('year', function (ProfessorOutsideCourse $course) {
                return $course->year;
            })
            ->editColumn('country', function (ProfessorOutsideCourse $course) {
                return $course->country->name;
            })
            ->editColumn('town', function (ProfessorOutsideCourse $course) {
                return $course->town;
            })
            ->editColumn('language', function (ProfessorOutsideCourse $course) {
                return $course->language->name;
            })
            ->editColumn('is_graduate', function (ProfessorOutsideCourse $course) {
                return $course->is_graduate ? 'Yes' : 'No';
            })
            ->editColumn('session', function (ProfessorOutsideCourse $course) {
                return $course->session->name;
            })
            ->addColumn('action', function (ProfessorOutsideCourse $course) {
                return view('pages/professors.outside-courses.columns._actions', compact('course'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProfessorOutsideCourse $model): QueryBuilder
    {
        return $model->newQuery()
                     ->with(['country', 'language', 'session'])
                     ->where('professor_id', Auth::user()->professor->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-outside-courses-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/outside-courses/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('name')->title('Course Name')->addClass('text-start'),
            Column::make('institution')->title('Institution'),
            Column::make('year')->title('Year'),
            Column::make('country')->title('Country'),
            Column::make('town')->title('Town'),
            Column::make('language')->title('Language'),
            Column::make('is_graduate')->title('Graduate Course')->addClass('text-start'),
            Column::make('session')->title('Session'),
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
        return 'ProfessorOutsideCourses_' . date('YmdHis');
    }
}
