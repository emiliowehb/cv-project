<?php

namespace App\DataTables;

use App\Enums\ArticleStatusEnum;
use App\Models\Reviewable;
use App\Models\ProfessorJournalArticle;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class JournalArticleReviewableDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['actions', 'status'])
            ->editColumn('title', function (Reviewable $reviewable) {
                return $reviewable->reviewable->title;
            })
            ->editColumn('year', function (Reviewable $reviewable) {
                return $reviewable->reviewable->year;
            })
            ->editColumn('month', function (Reviewable $reviewable) {
                return ucfirst($reviewable->reviewable->month);
            })
            ->editColumn('first_name', function (Reviewable $reviewable) {
                return $reviewable->first_name . ' ' . $reviewable->middle_name . ' ' . $reviewable->last_name;
            })
            ->editColumn('status', function (Reviewable $reviewable) {
                $status = ArticleStatusEnum::from($reviewable->status);
                $tooltip = $status === ArticleStatusEnum::REJECTED ? 'data-bs-toggle="tooltip" data-bs-placement="top" title="' . $reviewable->reason . '"' : '';
                return '<span class="badge ' . $status->badgeClass() . '" ' . $tooltip . '>' . $status->label() . '</span>';
            })
            ->editColumn('created_at', function (Reviewable $reviewable) {
                return $reviewable->created_at->format('d M Y, h:i a');
            })
            ->addColumn('actions', function (Reviewable $reviewable) {
                return view('pages/apps.professor-submissions.journal-articles.columns._actions', ['reviewable' => $reviewable]);
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Reviewable $model): QueryBuilder
    {
        return $model->newQuery()
            ->where('reviewable_type', ProfessorJournalArticle::class)
            ->where('status', '=', ArticleStatusEnum::WAITING_FOR_VALIDATION)
            ->join('professor_journal_articles', 'reviewables.reviewable_id', '=', 'professor_journal_articles.id')
            ->join('professors', 'professor_journal_articles.professor_id', '=', 'professors.id')
            ->select('reviewables.*', 'professor_journal_articles.title', 'professor_journal_articles.year', 'professor_journal_articles.month', 'professors.first_name', 'professors.middle_name', 'professors.last_name');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('journal-article-reviewables-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/apps/professor-submissions/journal-articles/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('first_name')->title('Submitted By'),
            Column::make('title')->title('Title'),
            Column::make('year')->title('Year'),
            Column::make('month')->title('Month'),
            Column::make('status'),
            Column::make('created_at')->title('Submitted On')->addClass('text-nowrap'),
            Column::computed('actions')
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'JournalArticleReviewables_' . date('YmdHis');
    }
}
