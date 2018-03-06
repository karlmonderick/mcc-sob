<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentAmount extends Model
{
    protected $fillable = [
        'name',
        'amount'
    ];
    
}
