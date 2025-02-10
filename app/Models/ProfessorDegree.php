<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorDegree extends Model
{
    protected $guarded = ['id'];

    public function degree()
    {
        return $this->belongsTo(Degree::class);
    }

    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
