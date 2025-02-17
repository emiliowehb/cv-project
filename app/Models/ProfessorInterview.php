<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorInterview extends Model
{
    protected $guarded = ['id'];

    public function type()
    {
        return $this->belongsTo(InterviewType::class, 'type_id');
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
}
