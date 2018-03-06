<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Liquidation extends Model
{
    protected $fillable = [
        'activity_id',
        'budget_id',
        'organization_id',
        'liquidation'
    ];

    public function activities(){
        return $this->belongsTo('App\Models\Activity');
    }

    public function budgets(){
        return $this->belongsTo('App\Models\Budget');
    }

    public function organizations(){
        return $this->belongsTo('App\Models\Organization');
    }
}
