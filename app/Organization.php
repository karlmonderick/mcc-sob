<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'institute_id',
        'code'
        
    ];

    public function users(){
        return $this->hasMany('App\Models\User');
    }

    public function activities(){
        return $this->hasMany('App\Models\Activity');
    }

    public function budgets(){
        return $this->hasMany('App\Models\Budget');
    }
    
    public function liquidations(){
        return $this->hasMany('App\Models\Liquidation');
    }

    public function organization_academic_year(){
        return $this->hasMany('App\Models\OrganizationAcademicYear');
    }
    
    public function institutes(){
        return $this->belongsTo('App\Models\Institute', 'manager_id');
    }

    
}
