<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Professor extends Model
{
    protected $guarded = ['id'];

    public function languages() {
        return $this->belongsToMany(Language::class, 'professor_languages', 'professor_id', 'language_id')
            ->withPivot('spoken_language_level_id', 'written_language_level_id');
    }

    public function employments() {
        return $this->hasMany(Employment::class);
    }

    public function degrees() {
        return $this->hasMany(ProfessorDegree::class);
    }

    public function teachingInterests() {
        return $this->hasMany(ProfessorTeachingInterest::class);
    }

    public function expertiseAreas() {
        return $this->hasMany(ProfessorExpertiseArea::class);
    }
}
