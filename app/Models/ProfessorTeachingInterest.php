<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorTeachingInterest extends Model
{
    
    protected $guarded = ['id'];

    public function teachingInterest()
    {
        return $this->belongsTo(TeachingInterest::class);
    }
}
