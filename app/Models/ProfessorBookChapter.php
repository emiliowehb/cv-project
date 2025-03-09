<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorBookChapter extends Model
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

    public function publicationStatus()
    {
        return $this->belongsTo(PublicationStatus::class);
    }

    public function getReviewableDetails()
    {
        $details = "<strong>Type:</strong> " . ($this->type->name ?? 'N/A') . "<br>";
        $details .= "<strong>Book Name:</strong> " . ($this->book_name ?? 'N/A') . "<br>";
        $details .= "<strong>Chapter Title:</strong> " . ($this->chapter_title ?? 'N/A') . "<br>";
        $details .= "<strong>Published Year:</strong> " . ($this->published_year ?? 'N/A') . "<br>";
        $details .= "<strong>Published Month:</strong> " . ($this->published_month ?? 'N/A') . "<br>";
        $details .= "<strong>Volume:</strong> " . ($this->volume ?? 'N/A') . "<br>";
        $details .= "<strong>Number of Pages:</strong> " . ($this->nb_pages ?? 'N/A') . "<br>";
        $details .= "<strong>Publisher:</strong> " . ($this->publisher->name ?? 'N/A') . "<br>";
        $details .= "<strong>Research Area:</strong> " . ($this->researchArea->name ?? 'N/A') . "<br>";
        $details .= "<strong>Notes:</strong> " . ($this->notes ?? 'N/A') . "<br>";
        $details .= "<strong>Status:</strong> " . ($this->publicationStatus->name ?? 'N/A') . "<br>";

        return $details;
    }
}
