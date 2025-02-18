<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorBookReview extends Model
{
    protected $guarded = ['id'];


    public function reviewedMedium()
    {
        return $this->belongsTo(ReviewedMedium::class, 'reviewed_medium_id');
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function intellectualContribution()
    {
        return $this->hasOne(IntellectualContribution::class, 'id');
    }
}
