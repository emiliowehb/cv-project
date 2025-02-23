<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorOutsideCourse extends Model
{
    protected $guarded = ['id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
    
}
