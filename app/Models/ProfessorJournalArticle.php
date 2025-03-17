<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorJournalArticle extends Model
{
    

    protected $guarded = ['id'];

    public function type()
    {
        return $this->belongsTo(JournalArticleType::class, 'journal_article_type_id');
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
    

    public function status()
    {
        return $this->belongsTo(PublicationStatus::class, 'publication_status_id');
    }

    public function reviewables()
    {
        return $this->morphMany(Reviewable::class, 'reviewable');
    }

    public function primaryField()
    {
        return $this->belongsTo(PublicationPrimaryField::class, 'primary_field_id');
    }

    public function secondaryField()
    {
        return $this->belongsTo(PublicationSecondaryField::class, 'secondary_field_id');
    }

    public function getReviewableDetails()
    {
        $details = "<strong>Title:</strong> " . ($this->title ?? 'N/A') . "<br>";
        $details .= "<strong>Year:</strong> " . ($this->year ?? 'N/A') . "<br>";
        $details .= "<strong>Month:</strong> " . ($this->month ?? 'N/A') . "<br>";
        $details .= "<strong>Volume:</strong> " . ($this->volume ?? 'N/A') . "<br>";
        $details .= "<strong>Issue:</strong> " . ($this->issue ?? 'N/A') . "<br>";
        $details .= "<strong>Pages:</strong> " . ($this->pages ?? 'N/A') . "<br>";
        $details .= "<strong>Notes:</strong> " . ($this->notes ?? 'N/A') . "<br>";
        $details .= "<strong>Primary Field:</strong> " . ($this->primaryField->name ?? 'N/A') . "<br>";
        $details .= "<strong>Secondary Field:</strong> " . ($this->secondaryField->name ?? 'N/A') . "<br>";
        $details .= "<strong>Status:</strong> " . ($this->status->name ?? 'N/A') . "<br>";
        $details .= "<strong>Type:</strong> " . ($this->type->name ?? 'N/A') . "<br>";

        return $details;
    }
}
