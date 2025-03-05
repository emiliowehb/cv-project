<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorBook extends Model
{
    

    protected $guarded = ['id'];

    public function type()
    {
        return $this->belongsTo(BookType::class, 'book_type_id');
    }

    public function publisher()
    {
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }

    public function reviewables()
    {
        return $this->morphMany(Reviewable::class, 'reviewable');
    }

    public function researchArea()
    {
        return $this->belongsTo(ResearchArea::class, 'research_area_id');
    }

    public function publicationStatus()
    {
        return $this->belongsTo(PublicationStatus::class);
    }
}
