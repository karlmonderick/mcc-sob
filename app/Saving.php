<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    protected $fillable = [
        'savings',
        'remaining',
        'semester',
        'organization_ay_id',
        'budget_id'

    ];
}
