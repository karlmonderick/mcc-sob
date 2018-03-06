<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Funds extends Model
{
    protected $fillable = [
        'name',
        'amount',
        'remaining',
        'semester',
        'ay_id',
        'user_id'
    ];

}
