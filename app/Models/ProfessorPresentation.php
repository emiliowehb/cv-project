<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorPresentation extends Model
{
    protected $guarded = ['id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function intellectualContribution()
    {
        return $this->belongsTo(IntellectualContribution::class);
    }
}
