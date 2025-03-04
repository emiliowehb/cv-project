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

    public function reviewables()
    {
        return $this->morphMany(Reviewable::class, 'reviewable');
    }
}
