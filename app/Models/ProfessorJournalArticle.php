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
}
