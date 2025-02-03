<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkspaceInvitation extends Model
{
    protected $guarded = ['id'];

    public function workspace() {
        return $this->belongsTo(Workspace::class);
    }
}
