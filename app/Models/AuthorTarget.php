<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorTarget extends Model
{
    protected $guarded = ['id'];

    public function authorable()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->morphTo(__FUNCTION__, 'author_for', 'model_id');
    }
}
