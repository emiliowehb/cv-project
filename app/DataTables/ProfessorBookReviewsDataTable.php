<?php

namespace App\DataTables;

use App\Enums\ArticleStatusEnum;
use App\Models\ProfessorBookReview;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorBookReviewsDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->rawColumns(['action', 'admin_status'])
            ->editColumn('reviewed_medium_id', function (ProfessorBookReview $review) {
                return $review->reviewedMedium->name;
            })
            ->editColumn('name', function (ProfessorBookReview $review) {
                return $review->name;
            })
            ->editColumn('year', function (ProfessorBookReview $review) {
                return $review->year;
            })
            ->editColumn('month', function (ProfessorBookReview $review) {
                return $review->month;
            })
            ->editColumn('periodical_title', function (ProfessorBookReview $review) {
                return $review->periodical_title;
            })
            ->editColumn('reviewed_work_authors', function (ProfessorBookReview $review) {
                return $review->reviewed_work_authors;
            })
            ->editColumn('notes', function (ProfessorBookReview $review) {
                return $review->notes;
            })
            ->editColumn('intellectual_contribution_id', function (ProfessorBookReview $review) {
                return $review->intellectualContribution->name;
            })
            ->addColumn('action', function (ProfessorBookReview $review) {
                return view('pages/professors.book-reviews.columns._actions', compact('review'));
            })
            ->setRowId('id');
    }

    public function query(ProfessorBookReview $model): QueryBuilder
    {
        return $model->newQuery()
                     ->where('professor_id', Auth::user()->professor->id)
                     ->with('reviewedMedium', 'intellectualContribution');
    }

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-book-reviews-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/book-reviews/columns/_draw-scripts.js')) . "}");
    }

    public function getColumns(): array
    {
        return [
            Column::make('reviewed_medium_id')->title('Reviewed Medium')->addClass('text-start'),
            Column::make('name')->title('Name')->addClass('text-start'),
            Column::make('year')->title('Year'),
            Column::make('month')->title('Month'),
            Column::make('periodical_title')->title('Periodical Title'),
            Column::make('reviewed_work_authors')->title('Reviewed Work Authors')->addClass('text-start'),
            Column::make('notes')->title('Notes')->addClass('text-start'),
            Column::make('intellectual_contribution_id')->title('Intellectual Contribution')->addClass('text-start'),
            Column::computed('action')
                ->addClass('text-end text-nowrap')
                ->exportable(false)
                ->printable(false)
                ->width(60)
        ];
    }

    protected function filename(): string
    {
        return 'ProfessorBookReviews_' . date('YmdHis');
    }
}
