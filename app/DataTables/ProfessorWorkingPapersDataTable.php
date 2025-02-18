<?php

namespace App\DataTables;

use App\Models\ProfessorWorkingPaper;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorWorkingPapersDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action'])
            ->editColumn('year', function (ProfessorWorkingPaper $paper) {
                return $paper->year;
            })
            ->editColumn('identifying_number', function (ProfessorWorkingPaper $paper) {
                return $paper->identifying_number;
            })
            ->editColumn('name', function (ProfessorWorkingPaper $paper) {
                return $paper->name;
            })
            ->editColumn('notes', function (ProfessorWorkingPaper $paper) {
                return $paper->notes;
            })
            ->editColumn('department_id', function (ProfessorWorkingPaper $paper) {
                return $paper->department->name;
            })
            ->editColumn('intellectual_contribution_id', function (ProfessorWorkingPaper $paper) {
                return $paper->intellectualContribution->name;
            })
            ->addColumn('action', function (ProfessorWorkingPaper $paper) {
                return view('pages/professors.working-papers.columns._actions', compact('paper'));
            })
            ->setRowId('id');
    }

    public function query(ProfessorWorkingPaper $model): QueryBuilder
    {
        return $model->newQuery()
                     ->with(['department', 'intellectualContribution'])
                     ->where('professor_id', Auth::user()->professor->id);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-working-papers-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/working-papers/columns/_draw-scripts.js')) . "}");
    }

    public function getColumns(): array
    {
        return [
            Column::make('year')->title('Year')->addClass('text-start'),
            Column::make('identifying_number')->title('Identifying Number'),
            Column::make('name')->title('Name'),
            Column::make('notes')->title('Notes'),
            Column::make('department_id')->title('Department'),
            Column::make('intellectual_contribution_id')->title('Intellectual Contribution'),
            Column::computed('action')
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false)
                ->width(60)
        ];
    }

    protected function filename(): string
    {
        return 'ProfessorWorkingPapers_' . date('YmdHis');
    }
}
