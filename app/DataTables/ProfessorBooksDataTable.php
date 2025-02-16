<?php

namespace App\DataTables;

use App\Enums\ArticleStatusEnum;
use App\Models\ProfessorBook;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorBooksDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action', 'admin_status'])
            ->editColumn('book_type_id', function (ProfessorBook $book) {
                return $book->type->name;
            })
            ->editColumn('name', function (ProfessorBook $book) {
                return $book->name;
            })
            ->editColumn('publisher_id', function (ProfessorBook $book) {
                return $book->publisher->name;
            })
            ->editColumn('year', function (ProfessorBook $book) {
                return $book->year;
            })
            ->editColumn('nb_pages', function (ProfessorBook $book) {
                return $book->nb_pages;
            })
            ->editColumn('admin_status', function (ProfessorBook $book) {
                $status = ArticleStatusEnum::from($book->admin_status);
                $tooltip = $status === ArticleStatusEnum::REJECTED ? 'data-bs-toggle="tooltip" data-bs-placement="top" title="' . $status->rejectionReason() . '"' : '';
                return '<span class="badge ' . $status->badgeClass() . '" ' . $tooltip . '>' . $status->label() . '</span>';
            })
            ->addColumn('action', function (ProfessorBook $book) {
                return view('pages/professors.books.columns._actions', compact('book'));
            })
            ->setRowId('id');
    }

    public function query(ProfessorBook $model): QueryBuilder
    {
        return $model->newQuery()
                     ->where('professor_id', Auth::user()->professor->id)
                     ->with('type', 'publisher');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-books-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/books/columns/_draw-scripts.js')) . "}");
    }

    public function getColumns(): array
    {
        return [
            Column::make('book_type_id')->title('Type')->addClass('text-start'),
            Column::make('name')->title('Name')->addClass('text-start'),
            Column::make('publisher_id')->title('Publisher'),
            Column::make('year')->title('Year'),
            Column::make('nb_pages')->title('Number of Pages'),
            Column::make('admin_status')->title('Status')->addClass('text-start'),
            Column::computed('action')
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false)
                ->width(60)
        ];
    }

    protected function filename(): string
    {
        return 'ProfessorBooks_' . date('YmdHis');
    }
}
