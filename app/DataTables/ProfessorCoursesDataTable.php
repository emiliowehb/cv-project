<?php

namespace App\DataTables;

use App\Models\ProfessorCourse;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorCoursesDataTable extends DataTable
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
            ->editColumn('code', function (ProfessorCourse $course) {
                return $course->code;
            })
            ->editColumn('title', function (ProfessorCourse $course) {
                return $course->title;
            })
            ->editColumn('language', function (ProfessorCourse $course) {
                return $course->language->name;
            })
            ->editColumn('course_level', function (ProfessorCourse $course) {
                return $course->courseLevel->name;
            })
            ->editColumn('course_type', function (ProfessorCourse $course) {
                return $course->courseType->name;
            })
            ->editColumn('course_credit', function (ProfessorCourse $course) {
                return $course->courseCredit->name;
            })
            ->editColumn('course_category', function (ProfessorCourse $course) {
                return $course->courseCategory->name;
            })
            ->editColumn('course_program', function (ProfessorCourse $course) {
                return $course->courseProgram->name;
            })
            ->editColumn('course_topic', function (ProfessorCourse $course) {
                return $course->courseTopic->subject->name . ': ' . $course->courseTopic->name;
            })
            ->editColumn('is_graduate', function (ProfessorCourse $course) {
                return $course->is_graduate ? 'Yes' : 'No';
            })
            ->addColumn('action', function (ProfessorCourse $course) {
                return view('pages/professors.courses.columns._actions', compact('course'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProfessorCourse $model): QueryBuilder
    {
        return $model->newQuery()
                     ->with(['language', 'courseLevel', 'courseType', 'courseCredit', 'courseCategory', 'courseProgram', 'courseTopic', 'courseTopic.subject'])
                     ->where('professor_id', Auth::user()->professor->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-courses-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/courses/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('code')->title('Code')->addClass('text-start'),
            Column::make('title')->title('Title'),
            Column::make('language')->title('Language'),
            Column::make('course_level')->title('Course Level'),
            Column::make('course_type')->title('Course Type'),
            Column::make('course_credit')->title('Course Credit'),
            Column::make('course_category')->title('Course Category'),
            Column::make('course_program')->title('Course Program'),
            Column::make('course_topic')->title('Course Topic'),
            Column::make('is_graduate')->title('Graduate Course')->addClass('text-start'),
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
        return 'ProfessorCourses_' . date('YmdHis');
    }
}
