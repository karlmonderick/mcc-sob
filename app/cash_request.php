<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cash_request extends Model
{
    protected $fillable = [
        'cash_amount',
        'organizaiton_ay_id',
        'budget_id',
        'verification_code',	
        'released'
    ];
}
