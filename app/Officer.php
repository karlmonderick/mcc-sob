<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    protected $fillable = [
        'user_id',
        'position',
        'organization_ay_id'
    ];
    public function users()
    {
        return $this->belongsTo('App\Users');
    }
    public function organization_ay()
    {
        return $this->belongsTo('App\OrganizationAcademicYear');
    }
}
