<?php

namespace App\DataTables;

use App\Models\ProfessorResearchInterest;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorResearchInterestsDataTable extends DataTable
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
            ->editColumn('research_area_id', function (ProfessorResearchInterest $researchInterest) {
                return $researchInterest->researchInterest->name;
            })
            ->editColumn('created_at', function (ProfessorResearchInterest $researchInterest) {
                return $researchInterest->created_at->format('d/m/Y');
            })
            ->addColumn('action', function (ProfessorResearchInterest $researchInterest) {
                return view('pages/professors.research-interests.columns._actions', compact('researchInterest'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProfessorResearchInterest $model): QueryBuilder
    {
        return $model->newQuery()
                     ->with(['researchInterest'])
                     ->where('professor_id', Auth::user()->professor->id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-research-interest-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/research-interests/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('research_area_id')->title('Research Interest'),
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
        return 'ProfessorResearchInterests_' . date('YmdHis');
    }
}
