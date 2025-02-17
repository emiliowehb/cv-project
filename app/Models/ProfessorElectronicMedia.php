<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorElectronicMedia extends Model
{
    protected $guarded = ['id'];

    public function type()
    {
        return $this->belongsTo(ElectronicMediaType::class, 'type_id');
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
}
