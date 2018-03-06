<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    protected $fillable = [
        'ay_from',
        'ay_to'
    ];

    public function organizations_ay(){
        return $this->hasMany('App\Models\OrganizationAcademicYear');
    }
}
