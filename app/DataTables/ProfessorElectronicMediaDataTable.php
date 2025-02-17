<?php

namespace App\DataTables;

use App\Models\ProfessorElectronicMedia;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorElectronicMediaDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action'])
            ->editColumn('type_id', function (ProfessorElectronicMedia $media) {
                return $media->type->name;
            })
            ->editColumn('name', function (ProfessorElectronicMedia $media) {
                return $media->name;
            })
            ->editColumn('publisher', function (ProfessorElectronicMedia $media) {
                return $media->publisher;
            })
            ->editColumn('year', function (ProfessorElectronicMedia $media) {
                return $media->year;
            })
            ->editColumn('notes', function (ProfessorElectronicMedia $media) {
                return $media->notes;
            })
            ->addColumn('action', function (ProfessorElectronicMedia $media) {
                return view('pages/professors.electronic-media.columns._actions', compact('media'));
            })
            ->setRowId('id');
    }

    public function query(ProfessorElectronicMedia $model): QueryBuilder
    {
        return $model->newQuery()
                     ->where('professor_id', Auth::user()->professor->id)
                     ->with('type');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-electronic-media-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/electronic-media/columns/_draw-scripts.js')) . "}");
    }

    public function getColumns(): array
    {
        return [
            Column::make('type_id')->title('Type')->addClass('text-start'),
            Column::make('name')->title('Name')->addClass('text-start'),
            Column::make('publisher')->title('Publisher'),
            Column::make('year')->title('Year'),
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
        return 'ProfessorElectronicMedia_' . date('YmdHis');
    }
}
