<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrganizationAcademicYear extends Model
{
    protected $fillable = [
        'organization_id',
        'ay_id',
        'accredited'
    ];

    public function academic_year(){
        return $this->belongsTo('App\Models\AcademicYear');
    }
    public function organization(){
        return $this->belongsTo('App\Models\Organization');
    }
    public function officers(){
        return $this->hasMany('App\Models\Officer');
    }

}
