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

    public function getReviewableDetails()
    {
        $details = "<strong>Type:</strong> " . ($this->type->name ?? 'N/A') . "<br>";
        $details .= "<strong>Title:</strong> " . ($this->name ?? 'N/A') . "<br>";
        $details .= "<strong>Year:</strong> " . ($this->year ?? 'N/A') . "<br>";
        $details .= "<strong>Month:</strong> " . ($this->month ?? 'N/A') . "<br>";
        $details .= "<strong>Volume:</strong> " . ($this->volume ?? 'N/A') . "<br>";
        $details .= "<strong>Number of Pages:</strong> " . ($this->nb_pages ?? 'N/A') . "<br>";
        $details .= "<strong>Publisher:</strong> " . ($this->publisher->name ?? 'N/A') . "<br>";
        $details .= "<strong>Research Area:</strong> " . ($this->researchArea->name ?? 'N/A') . "<br>";
        $details .= "<strong>Primary Field:</strong> " . ($this->primaryField->name ?? 'N/A') . "<br>";
        $details .= "<strong>Secondary Field:</strong> " . ($this->secondaryField->name ?? 'N/A') . "<br>";
        $details .= "<strong>Status:</strong> " . ($this->publicationStatus->name ?? 'N/A') . "<br>";

        return $details;
    }
}
