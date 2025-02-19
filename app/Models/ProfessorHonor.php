<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfessorHonor extends Model
{
    protected $guarded = ['id'];

    public function honorType()
    {
        return $this->belongsTo(HonorType::class);
    }

    public function honorOrganization()
    {
        return $this->belongsTo(HonorOrganization::class);
    }

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }
}
