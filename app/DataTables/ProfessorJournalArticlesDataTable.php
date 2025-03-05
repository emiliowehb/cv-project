<?php

namespace App\DataTables;

use App\Enums\ArticleStatusEnum;
use App\Models\ProfessorArticle;
use App\Models\ProfessorJournalArticle;
use App\Models\Reviewable;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorJournalArticlesDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action', 'admin_status'])
            ->editColumn('journal_article_type_id', function (ProfessorJournalArticle $article) {
                return $article->type->name;
            })
            ->editColumn('publication_status_id', function (ProfessorJournalArticle $article) {
                return $article->status->name;
            })
            ->editColumn('title', function (ProfessorJournalArticle $article) {
                return $article->title;
            })
            ->editColumn('volume', function (ProfessorJournalArticle $article) {
                return $article->volume;
            })
            ->editColumn('issue', function (ProfessorJournalArticle $article) {
                return $article->issue;
            })
            ->editColumn('pages', function (ProfessorJournalArticle $article) {
                return $article->pages;
            })
            ->editColumn('notes', function (ProfessorJournalArticle $article) {
                return $article->notes;
            })
            ->editColumn('primary_field_id', function (ProfessorJournalArticle $article) {
                return $article->primaryField->name;
            })
            ->editColumn('secondary_field_id', function (ProfessorJournalArticle $article) {
                return $article->secondaryField->name;
            })
            ->editColumn('admin_status', function (ProfessorJournalArticle $article) {
                $reviewable = $article->reviewables()->orderBy('created_at', 'desc')->first();
                if (!$reviewable) {
                    return '<span class="badge badge-secondary">Not Reviewed</span>';
                }
                $status = ArticleStatusEnum::from($reviewable->status);
                $tooltip = $status === ArticleStatusEnum::REJECTED ? 'data-bs-toggle="tooltip" data-bs-placement="top" title="Admin rejection reason: ' . $reviewable->reason . '"' : '';
                return '<span class="badge ' . $status->badgeClass() . '" ' . $tooltip . '>' . $status->label() . '</span>';
            })
            ->addColumn('action', function (ProfessorJournalArticle $article) {
                return view('pages/professors.journal-articles.columns._actions', compact('article'));
            })
            ->setRowId('id')
            ->setRowClass(function (ProfessorJournalArticle $article) {
                $reviewable = $article->reviewables()->orderBy('created_at', 'desc')->first();
                if ($reviewable && $reviewable->status === ArticleStatusEnum::REJECTED->value) {
                    return 'table-danger';
                } else if($reviewable && $reviewable->status === ArticleStatusEnum::VALIDATED->value) {
                    return 'table-success';
                } else if($reviewable && $reviewable->status === ArticleStatusEnum::WAITING_FOR_VALIDATION->value) {
                    return 'table-warning';
                }
                return 'table-warning';
            });
    }

    public function query(ProfessorJournalArticle $model): QueryBuilder
    {
        return $model->newQuery()
                     ->where('professor_id', Auth::user()->professor->id)
                     ->with(['type', 'primaryField', 'secondaryField', 'reviewables']);
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-journal-articles-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/journal-articles/columns/_draw-scripts.js')) . "}");
    }

    public function getColumns(): array
    {
        return [
            Column::make('journal_article_type_id')->title('Type')->addClass('text-start'),
            Column::make('publication_status_id')->title('Status')->addClass('text-start'),
            Column::make('title')->title('Title')->addClass('text-start'),
            Column::make('volume')->title('Volume'),
            Column::make('issue')->title('Issue'),
            Column::make('pages')->title('Pages'),
            Column::make('notes')->title('Notes'),
            Column::make('primary_field_id')->title('Primary Field'),
            Column::make('secondary_field_id')->title('Secondary Field'),
            Column::make('admin_status')->title('Approval Status')->addClass('text-center'),
            Column::computed('action')
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false)
                ->width(60)
        ];
    }

    protected function filename(): string
    {
        return 'ProfessorJournalArticles_' . date('YmdHis');
    }
}
