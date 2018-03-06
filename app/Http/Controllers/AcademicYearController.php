<?php

namespace App\Http\Controllers;
use App\AcademicYear;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\DB;
class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $get_user = Auth::user();
        $get_officer = \App\Officer::with("user_id", "=", $get_user->id);
        $years = AcademicYear::all()->count('academic_years.id');
        $check_year = DB::table('academic_years')
        ->join('organization_academic_years', 'academic_years.id', '=', 'organization_academic_years.ay_id')
        ->where('academic_years.id', $id)
        ->count('academic_years.id');
        

        return view('academic_years.index', compact('get_officer','years','check_year'));
        
    }

    public function add_year(Request $request){
        $acad = new AcademicYear;
        $acad->ay_from = $request->input('next_yr');
        $ay_to = $acad->ay_from+1;
        $acad->ay_to = $ay_to;
        $acad->save();
        return redirect()->route('home');
    }
    
    public function destroy($id)
    {
        $get_deleted_year = AcademicYear::where('id', $id)->first();
        $deleted_year = $get_deleted_year->ay_from. '-'.$get_deleted_year->ay_to;
        $count_year = DB::table('academic_years')
        ->join('organization_academic_years', 'academic_years.id', '=', 'organization_academic_years.ay_id')
        ->where('academic_years.id', $id)
        ->count('academic_years.id');

        if($count_year < 1)
        {
        $acad_year = AcademicYear::find($id)->delete();
        return redirect()->back()->with('alert-success', 'A.Y '. $deleted_year. ' has been deleted!');
        // return response()->json($deleted_year);
        }
        else
        {
        return redirect()->back()->with('alert-danger', 'Oooops. Sorry failed to delete!');    
        }
    }
}
