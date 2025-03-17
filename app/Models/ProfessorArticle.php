<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorArticle extends Model
{
    protected $guarded = ['id'];


    public function type()
    {
        return $this->belongsTo(ArticleType::class, 'article_type_id');
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function reviewables()
    {
        return $this->morphMany(Reviewable::class, 'reviewable');
    }

    public function getReviewableDetails()
    {
        $details = "<strong>Type:</strong> " . ($this->type->name ?? 'N/A') . "<br>";
        $details .= "<strong>Title:</strong> " . ($this->title ?? 'N/A') . "<br>";
        $details .= "<strong>Publisher Name:</strong> " . ($this->publisher_name ?? 'N/A') . "<br>";
        $details .= "<strong>Year:</strong> " . ($this->year ?? 'N/A') . "<br>";
        $details .= "<strong>Number of Pages:</strong> " . ($this->nb_pages ?? 'N/A') . "<br>";
        $details .= "<strong>URL:</strong> " . ($this->url ?? 'N/A') . "<br>";
        $details .= "<strong>Notes:</strong> " . ($this->notes ?? 'N/A') . "<br>";

        return $details;
    }
}
