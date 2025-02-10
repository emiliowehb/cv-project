<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorLanguage extends Model
{

    protected $guarded = ['id'];

    
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function spokenLevel()
    {
        return $this->belongsTo(LanguageLevel::class, 'spoken_language_level_id');
    }
    
    public function writtenLevel()
    {
        return $this->belongsTo(LanguageLevel::class, 'written_language_level_id');
    }
}
