<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{
    

    protected $guarded = ['id'];

    public function grantType()
    {
        return $this->belongsTo(GrantType::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function fundingSource()
    {
        return $this->belongsTo(FundingSource::class);
    }

    public function professorGrant()
    {
        return $this->belongsTo(ProfessorGrant::class);
    }
}
