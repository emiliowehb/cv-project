<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorGraduateSupervision extends Model
{
    protected $guarded = ['id'];

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class);
    }

    public function supervisionStatus()
    {
        return $this->belongsTo(SupervisionStatus::class);
    }

    public function supervisionRole()
    {
        return $this->belongsTo(SupervisionRole::class);
    }

    public function studentFullName()
    {
        return $this->student_first_name . ' ' . $this->student_last_name;
    }
}
