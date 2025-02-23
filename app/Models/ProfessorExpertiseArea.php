<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorExpertiseArea extends Model
{
    
    protected $guarded = ['id'];

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function expertiseArea()
    {
        return $this->belongsTo(ExpertiseArea::class);
    }
}
