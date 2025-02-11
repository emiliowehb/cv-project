<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorGrant extends Model
{
    protected $guarded = ['id'];

    public function grant()
    {
        return $this->belongsTo(Grant::class);
    }
}
