<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'title',
        'nature',
        'date',
        'endDate',
        'venue',
        'participants',
        'expectedAttendees',
        'speakersGuest',
        'optionsSpeakersGuest',
        'suspension',
        'personInCharge',
        'budgetDescription',
        'budgetCost',
        'buggetTotal',
        'sourceOfFund',
        'equipmentRequest',
        'venueEquipmentApproval',
        'quantity',
        'officeUnit',
        'requestedBy',
        'noted',
        'approval1',
        'approval2',
        'approval3',
        'organization_id',
        'comment',
        'notify'
    ];

    public function organizations(){
        return $this->belongsTo('App\Models\Organization');
    }
    public function budgets(){
        return $this->hasMany('App\Models\Budget');
    }
}
