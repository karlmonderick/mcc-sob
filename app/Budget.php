<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $fillable = [
        'budget',
        'remaining',
        'fund_id',
        'semester',
        'organization_ay_id'
    ];

    public function activities(){
        return $this->belongsTo('App\Models\Activity');
    }

    public function organizations(){
        return $this->belongsTo('App\Models\Organization');
    }
}
