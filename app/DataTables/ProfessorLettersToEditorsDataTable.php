<?php

namespace App\DataTables;

use App\Enums\ArticleStatusEnum;
use App\Models\ArticleType;
use App\Models\ProfessorArticle;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorLettersToEditorsDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action', 'status'])
            ->editColumn('title', function (ProfessorArticle $article) {
                return $article->title;
            })
            ->editColumn('publisher_name', function (ProfessorArticle $article) {
                return $article->publisher_name;
            })
            ->editColumn('year', function (ProfessorArticle $article) {
                return $article->year;
            })
            ->editColumn('nb_pages', function (ProfessorArticle $article) {
                return $article->nb_pages;
            })
            ->editColumn('url', function (ProfessorArticle $article) {
                return $article->url;
            })
            ->editColumn('notes', function (ProfessorArticle $article) {
                return $article->notes;
            })
            ->addColumn('action', function (ProfessorArticle $article) {
                return view('pages/professors.letters-to-editor.columns._actions', compact('article'));
            })
            ->setRowId('id');
    }

    public function query(ProfessorArticle $model): QueryBuilder
    {
        return $model->newQuery()
                    ->where('article_type_id', ArticleType::where('name', 'Letter to Editor')->first()->id)
                     ->where('professor_id', Auth::user()->professor->id)
                     ->with('type');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-letters-to-editor-articles-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/letters-to-editor/columns/_draw-scripts.js')) . "}");
    }

    public function getColumns(): array
    {
        return [
            Column::make('title')->title('Title')->addClass('text-start'),
            Column::make('publisher_name')->title('Publisher Name'),
            Column::make('year')->title('Year'),
            Column::make('nb_pages')->title('Number of Pages'),
            Column::make('url')->title('URL'),
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
        return 'ProfessorArticles_' . date('YmdHis');
    }
}
