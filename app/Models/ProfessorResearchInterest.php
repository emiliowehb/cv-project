<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorResearchInterest extends Model
{

    protected $guarded = ['id'];
    
    public function researchInterest()
    {
        return $this->belongsTo(ResearchArea::class, 'research_area_id');
    }
}
