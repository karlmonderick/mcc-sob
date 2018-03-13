<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnrolledAcademicYear extends Model
{
    protected $fillable = [
        'no_of_students',
        'institute_id',
        'ay_id',
        'sem'
    ];

   public function Institute(){
        return $this->belongsTo('App\Models\Institute');
    }
    public function AcademicYear(){
        return $this->belongsTo('App\Models\AcademicYear');
    }
}
