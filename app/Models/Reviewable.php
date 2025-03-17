<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reviewable extends Model
{
    protected $fillable = ['reviewable_type', 'status', 'type_id', 'professor_id', 'reviewable_id', 'reason'];

    public function reviewable()
    {
        return $this->morphTo();
    }

    public function parent()
    {
        return $this->morphTo(__FUNCTION__, 'reviewable_type', 'reviewable_id');
    }
}
