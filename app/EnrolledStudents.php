<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnrolledStudents extends Model
{
    protected $fillable=['Number','student_no','surname','firstname_middlename','course','year_level','sem', 'ay_id'];
}
