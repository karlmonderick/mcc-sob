<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarOfActivities extends Model
{
    protected $fillable = [
        'activity_id',
        'remarks'
    ];
    public function activities(){
        return $this->belongsTo('App\Models\Activity');
    }
}
