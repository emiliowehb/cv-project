<?php

namespace App\DataTables;

use App\Enums\WorkspaceInviteStatusEnum;
use App\Models\WorkspaceInvitation;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;

class WorkspaceInvitationsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
        ->rawColumns(['status', 'action'])
            ->editColumn('full_name', function (WorkspaceInvitation $invitation) {
                return $invitation->full_name;
            })
            ->editColumn('invited_email', function (WorkspaceInvitation $invitation) {
                return $invitation->invited_email;
            })
            ->editColumn('status', function (WorkspaceInvitation $invitation) {
                return sprintf('<div class="badge badge-light fw-bold">%s</div>', WorkspaceInviteStatusEnum::from($invitation->status)->label());
            })
            ->editColumn('created_at', function (WorkspaceInvitation $invitation) {
                return $invitation->created_at->format('d M Y, h:i a');
            })
            ->addColumn('action', function (WorkspaceInvitation $invitation) {
                return view('pages/apps.workspace-management.invitations.columns._actions', compact('invitation'));
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(WorkspaceInvitation $model): QueryBuilder
    {
        return $model->newQuery()
                     ->where('workspace_id', Auth::user()->workspace_id);
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('workspace-invitations-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('rt' . "<'row'<'col-sm-12'tr>><'d-flex justify-content-between'<'col-sm-12 col-md-5'i><'d-flex justify-content-between'p>>",)
            ->addTableClass('table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer text-gray-600 fw-semibold')
            ->setTableHeadClass('text-start text-muted fw-bold fs-7 text-uppercase gs-0')
            ->orderBy(2)
            ->drawCallback("function() {" . file_get_contents(resource_path('views/pages/apps/workspace-management/invitations/columns/_draw-scripts.js')) . "}");
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('full_name')->title('Full Name'),
            Column::make('invited_email')->title('Email'),
            Column::make('status')->title('Status'),
            Column::make('created_at')->title('Invited Date')->addClass('text-nowrap'),
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
        return 'WorkspaceInvitations_' . date('YmdHis');
    }
}
