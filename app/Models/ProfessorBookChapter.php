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
}
