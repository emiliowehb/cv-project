<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorWorkingPaper extends Model
{
    protected $guarded = ['id'];

    public function intellectualContribution()
    {
        return $this->belongsTo(IntellectualContribution::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }


}
