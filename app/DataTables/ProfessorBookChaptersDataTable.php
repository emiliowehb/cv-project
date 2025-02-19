<?php

namespace App\DataTables;

use App\Enums\ArticleStatusEnum;
use App\Models\ProfessorBookChapter;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorBookChaptersDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action', 'admin_status'])
            ->editColumn('book_type_id', function (ProfessorBookChapter $chapter) {
                return $chapter->type->name;
            })
            ->editColumn('book_name', function (ProfessorBookChapter $chapter) {
                return $chapter->book_name;
            })
            ->editColumn('chapter_title', function (ProfessorBookChapter $chapter) {
                return $chapter->chapter_title;
            })
            ->editColumn('publisher_id', function (ProfessorBookChapter $chapter) {
                return $chapter->publisher->name;
            })
            ->editColumn('published_year', function (ProfessorBookChapter $chapter) {
                return $chapter->published_year;
            })
            ->editColumn('nb_pages', function (ProfessorBookChapter $chapter) {
                return $chapter->nb_pages;
            })
            ->editColumn('admin_status', function (ProfessorBookChapter $chapter) {
                $status = ArticleStatusEnum::from($chapter->admin_status);
                $tooltip = $status === ArticleStatusEnum::REJECTED ? 'data-bs-toggle="tooltip" data-bs-placement="top" title="' . $status->rejectionReason() . '"' : '';
                return '<span class="badge ' . $status->badgeClass() . '" ' . $tooltip . '>' . $status->label() . '</span>';
            })
            ->addColumn('action', function (ProfessorBookChapter $chapter) {
                return view('pages/professors.book-chapters.columns._actions', compact('chapter'));
            })
            ->setRowId('id');
    }

    public function query(ProfessorBookChapter $model): QueryBuilder
    {
        return $model->newQuery()
                     ->where('professor_id', Auth::user()->professor->id)
                     ->with('type', 'publisher');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-book-chapters-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/book-chapters/columns/_draw-scripts.js')) . "}");
    }

    public function getColumns(): array
    {
        return [
            Column::make('book_type_id')->title('Type')->addClass('text-start'),
            Column::make('book_name')->title('Book Name')->addClass('text-start'),
            Column::make('chapter_title')->title('Chapter Title')->addClass('text-start'),
            Column::make('publisher_id')->title('Publisher'),
            Column::make('published_year')->title('Year'),
            Column::make('nb_pages')->title('Number of Pages'),
            Column::make('admin_status')->title('Approval Status')->addClass('text-start'),
            Column::computed('action')
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false)
                ->width(60)
        ];
    }

    protected function filename(): string
    {
        return 'ProfessorBookChapters_' . date('YmdHis');
    }
}
