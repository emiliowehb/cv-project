<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorCourse extends Model
{
    protected $guarded = ['id'];

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function courseLevel()
    {
        return $this->belongsTo(CourseLevel::class);
    }

    public function courseType()
    {
        return $this->belongsTo(CourseType::class);
    }

    public function courseCredit()
    {
        return $this->belongsTo(CourseCredit::class);
    }

    public function courseCategory()
    {
        return $this->belongsTo(CourseCategory::class);
    }

    public function courseProgram()
    {
        return $this->belongsTo(CourseProgram::class);
    }

    public function courseTopic()
    {
        return $this->belongsTo(CourseTopic::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
