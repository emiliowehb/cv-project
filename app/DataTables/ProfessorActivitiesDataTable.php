<?php

namespace App\DataTables;

use App\Models\ProfessorActivity;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorActivitiesDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action'])
            ->editColumn('start_year', function (ProfessorActivity $activity) {
                return $activity->start_year;
            })
            ->editColumn('end_year', function (ProfessorActivity $activity) {
                return $activity->end_year;
            })
            ->editColumn('activity_service_id', function (ProfessorActivity $activity) {
                return $activity->activityService->name;
            })
            ->editColumn('name', function (ProfessorActivity $activity) {
                return $activity->name;
            })
            ->editColumn('is_current', function (ProfessorActivity $activity) {
                return $activity->is_current ? 'Yes' : 'No';
            })
            ->editColumn('notes', function (ProfessorActivity $activity) {
                return $activity->notes;
            })
            ->addColumn('action', function (ProfessorActivity $activity) {
                return view('pages/professors.activities.columns._actions', compact('activity'));
            })
            ->setRowId('id');
    }

    public function query(ProfessorActivity $model): QueryBuilder
    {
        return $model->newQuery()
                     ->where('professor_id', Auth::user()->professor->id);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-activity-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/activities/columns/_draw-scripts.js')) . "}");
    }

    public function getColumns(): array
    {
        return [
            Column::make('start_year')->title('Start Year')->addClass('text-start'),
            Column::make('end_year')->title('End Year')->addClass('text-start'),
            Column::make('activity_service_id')->title('Activity Service'),
            Column::make('name')->title('Name'),
            Column::make('is_current')->title('Is Current'),
            Column::make('notes')->title('Notes'),
            Column::computed('action')
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false)
                ->width(60)
        ];
    }

    protected function filename(): string
    {
        return 'ProfessorActivities_' . date('YmdHis');
    }
}
