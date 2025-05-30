<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Workspace extends Model
{
    use SoftDeletes;
    
    protected $guarded = ['id'];


    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
