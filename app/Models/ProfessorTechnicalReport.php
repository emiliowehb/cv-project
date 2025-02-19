<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorTechnicalReport extends Model
{
    public $guarded = ['id'];

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class);
    }

    public function workClassification()
    {
        return $this->belongsTo(WorkClassification::class);
    }

    public function researchArea()
    {
        return $this->belongsTo(ResearchArea::class);
    }

    public function publicationStatus()
    {
        return $this->belongsTo(PublicationStatus::class);
    }

    public function intellectualContribution()
    {
        return $this->belongsTo(IntellectualContribution::class);
    }
}
