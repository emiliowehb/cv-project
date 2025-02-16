<?php

namespace App\DataTables;

use App\Models\ProfessorDegree;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorDegreesDataTable extends DataTable
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
            ->editColumn('year', function (ProfessorDegree $degree) {
                return $degree->year;
            })
            ->editColumn('degree', function (ProfessorDegree $degree) {
                return $degree->degree->name;
            })
            ->editColumn('institution_name', function (ProfessorDegree $degree) {
                return $degree->institution_name;
            })
            ->editColumn('discipline', function (ProfessorDegree $degree) {
                return $degree->discipline->name;
            })
            ->editColumn('department', function (ProfessorDegree $degree) {
                return $degree->department->name;
            })
            ->editColumn('created_at', function (ProfessorDegree $degree) {
                return $degree->created_at->format('d/m/Y');
            })
            ->addColumn('action', function (ProfessorDegree $degree) {
                return view('pages/professors.educations.columns._actions', compact('degree'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProfessorDegree $model): QueryBuilder
    {
        return $model->newQuery()
                     ->with(['degree', 'discipline', 'department'])
                     ->where('professor_id', Auth::user()->professor->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-degree-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/educations/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('year')->title('Year')->addClass('text-start'),
            Column::make('degree')->title('Degree'),
            Column::make('institution_name')->title('Institution Name'),
            Column::make('discipline')->title('Discipline'),
            Column::make('department')->title('Department'),
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
        return 'ProfessorDegrees_' . date('YmdHis');
    }
}
