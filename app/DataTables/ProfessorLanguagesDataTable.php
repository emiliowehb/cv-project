<?php

namespace App\DataTables;

use App\Models\ProfessorLanguage;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class ProfessorLanguagesDataTable extends DataTable
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
            ->editColumn('language_id', function (ProfessorLanguage $language) {
                return $language?->language?->name;
            })
            ->editColumn('spoken_level', function (ProfessorLanguage $language) {
                return $language?->spokenLevel?->name;
            })
            ->editColumn('written_level', function (ProfessorLanguage $language) {
                return $language?->writtenLevel?->name;
            })
            ->editColumn('created_at', function (ProfessorLanguage $language) {
                return $language?->created_at?->format('d/m/Y');
            })
            ->addColumn('action', function (ProfessorLanguage $language) {
                return view('pages/professors.languages.columns._actions', compact('language'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ProfessorLanguage $model): QueryBuilder
    {
        return $model->newQuery()
                     ->select('professor_languages.*')
                     ->join('languages', 'languages.id', '=', 'professor_languages.language_id')
                     ->with(['language', 'spokenLevel', 'writtenLevel'])
                     ->where('professor_id', Auth::user()->professor->id)
                     ->orderBy('languages.name');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('professor-language-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(0)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/professors/languages/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('language_id')->title('Language'),
            Column::make('spoken_level')->title('Spoken Level'),
            Column::make('written_level')->title('Written Level'),
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
        return 'ProfessorLanguages_' . date('YmdHis');
    }
}
