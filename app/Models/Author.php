<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    // The attributes that are mass assignable.
    protected $fillable = [
        'name',
    ];

    // The attributes that should be hidden for arrays.
    protected $hidden = [
        'created_at', 'updated_at',
    ];
}
