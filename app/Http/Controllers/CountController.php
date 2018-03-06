<?php

namespace App\Http\Controllers;
use App\Officer;
use Illuminate\Http\Request;

class CountController extends Controller
{
    public function count_officers()
    {
        $officers = DB::table('officers')
        ->join('organization_academic_years', 'officers.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('users', 'officers.user_id', '=', 'users.id')
        ->select('officers.*', 'users.*')
        ->where('organization_academic_years.ay_id', $id)
        ->get();

        
    }
}
