<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorActivity extends Model
{
    protected $guarded = ['id'];


    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function activityService()
    {
        return $this->belongsTo(ProfessionalActivityService::class, 'activity_service_id');
    }
}
