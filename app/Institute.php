<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institute extends Model
{
    protected $fillable = [
        'name',
        'code'
    ];

    public function organizations(){
        return $this->hasMany('App\Models\Organization');
    }
}
