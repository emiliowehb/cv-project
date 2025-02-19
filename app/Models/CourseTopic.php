<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseTopic extends Model
{
    public function subject()
    {
        return $this->belongsTo(CourseSubject::class);
    }
}
