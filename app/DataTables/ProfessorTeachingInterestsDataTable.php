<?php

namespace App\DataTables;

use App\Models\ProfessorTeachingInterest;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorTeachingInterestsDataTable extends DataTable
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
            ->editColumn('teaching_interest_id', function (ProfessorTeachingInterest $teachingInterest) {
                return $teachingInterest->teachingInterest->name;
            })
            ->editColumn('is_current', function (ProfessorTeachingInterest $teachingInterest) {
                return $teachingInterest->is_current ? 'Yes' : 'No';
            })
            ->editColumn('created_at', function (ProfessorTeachingInterest $teachingInterest) {
                return $teachingInterest->created_at->format('d/m/Y');
            })
            ->addColumn('action', function (ProfessorTeachingInterest $teachingInterest) {
                return view('pages/professors.teaching-interests.columns._actions', compact('teachingInterest'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProfessorTeachingInterest $model): QueryBuilder
    {
        return $model->newQuery()
                     ->with(['teachingInterest'])
                     ->where('professor_id', Auth::user()->professor->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-teaching-interest-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/teaching-interests/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('teaching_interest_id')->title('Teaching Interest'),
            Column::make('is_current')->title('Current'),
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
        return 'ProfessorTeachingInterests_' . date('YmdHis');
    }
}
