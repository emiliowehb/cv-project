<?php

namespace App\Http\Controllers;

use App\DataTables\WorkspaceInvitationsDataTable;
use App\Models\WorkspaceInvitation;
use Illuminate\Http\Request;

class WorkspaceInvitationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(WorkspaceInvitationsDataTable $dataTable)
    {
        return $dataTable->render('pages/apps.workspace-management.invitations.list');
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkspaceInvitation $workspaceInvitation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkspaceInvitation $workspaceInvitation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkspaceInvitation $workspaceInvitation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkspaceInvitation $workspaceInvitation)
    {
        //
    }
}
