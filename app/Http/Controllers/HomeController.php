<?php

namespace App\Http\Controllers;

use App\Activity;
use App\User;
use App\Officer;
use App\cash_request;
use App\Funds;
use App\AcademicYear;
use App\OrganizationAcademicYear;
use Auth;
use Hash;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //GET SEMESTER'S FUNDS 
        $funds1 = Funds::where('semester', 1)
        ->select('funds.*')
        ->get();
        $funds2 = Funds::where('semester', 2)
        ->select('funds.*')
        ->get();

        //GET ALL ACADEMIC YEARS
        $a_year = DB::table('academic_years')
        ->select('academic_years.*')
        ->get()->sortByDesc('academic_years.id');

        //GET CASH REQUEST
        $cash_req = cash_request::all()->first();
        if(count($cash_req) >= 1)
        {
        $all_requests = Activity::where('id','=',$cash_req->activity_id)->count();
        }
        else
        {
            $all_requests = 0;
        }

        //APPROVAL
        $a_approval1 = Activity::where('approval','=',2)->count();
        $a_approval2 = Activity::where('review_id','=',0)->count();
        
        //GET DATE
        $date = Carbon::now();  
        $year = $date->year;

        // GET ACADEMIC YEAR
        $acad_year = AcademicYear::where('ay_from','=',$year)->first();
        if(count($acad_year) >= 1)
        {
        $current_ay = $acad_year->id;
        $organization_num = OrganizationAcademicYear::where('ay_id','=',$current_ay)
            ->where('accredited', 1)
            ->count();
        }
        else
        {
           $organization_num = 0; 
        }

        //IF ROLE IS STUDENT
        if(Auth::user()->role_id == 4 ){

            //GET USER INFO
            $user_id = Auth::user()->id;
            $org_officer = Officer::where('user_id','=',$user_id)->first();
            $org_id = $org_officer->organization_ay_id;

            //GET ALL ACTIVITIES
            $activity = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->select('activities.*', 'organizations.name', 'organization_academic_years.ay_id')
            ->get();

            //get all academic years
            $a_year = DB::table('academic_years')
            ->select('academic_years.*')
            ->get()->sortByDesc('academic_years.id');

            $org_officer_num = Officer::where('organization_ay_id','=',$org_id)->count();

            $org_num_requests = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->where('activities.organization_ay_id', $org_id) 
            ->count();

            $budget_first = DB::table('budgets')
            ->join('funds', 'budgets.fund_id', '=', 'funds.id') 
            ->join('academic_years', 'funds.ay_id', '=', 'academic_years.id') 
            ->select('budgets.*')
            ->where('budgets.organization_ay_id', $org_id)
            ->where('funds.semester', 1)
            ->first();

            $budget_second = DB::table('budgets')
            ->join('funds', 'budgets.fund_id', '=', 'funds.id') 
            ->join('academic_years', 'funds.ay_id', '=', 'academic_years.id') 
            ->select('budgets.*')
            ->where('budgets.organization_ay_id', $org_id)
            ->where('funds.semester', 2)
            ->first();

            
            $total_budget = DB::table('budgets')
            ->join('funds', 'budgets.fund_id', '=', 'funds.id') 
            ->join('academic_years', 'funds.ay_id', '=', 'academic_years.id') 
            ->where('budgets.organization_ay_id', $org_id)
            ->sum('budget');


            $count_budget = DB::table('budgets')
            ->join('funds', 'budgets.fund_id', '=', 'funds.id') 
            ->join('academic_years', 'funds.ay_id', '=', 'academic_years.id') 
            ->where('budgets.organization_ay_id', $org_id)
            ->count('budget');

            $total_remaining = DB::table('budgets')
            ->join('funds', 'budgets.fund_id', '=', 'funds.id') 
            ->join('academic_years', 'funds.ay_id', '=', 'academic_years.id') 
            ->where('budgets.organization_ay_id', $org_id)
            ->sum('budgets.remaining');

            $count_remaining = DB::table('budgets')
            ->join('funds', 'budgets.fund_id', '=', 'funds.id') 
            ->join('academic_years', 'funds.ay_id', '=', 'academic_years.id') 
            ->where('budgets.organization_ay_id', $org_id)
            ->count('budgets.remaining');

            $officer = \App\Officer::where('user_id', '=', Auth::id())->first();
            $org_ay_id = $officer->organization_ay_id;
            $activity = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->select('activities.*', 'organizations.name', 'organization_academic_years.ay_id')
            ->where('organization_ay_id', $org_ay_id)
            ->get();

            $cash_code = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
            ->where('activities.organization_ay_id', $org_ay_id)
            ->select('cash_requests.*')
            ->get();

            $cash_releas = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
            ->where('activities.organization_ay_id', $org_ay_id)
            ->where('cash_requests.released', 0)
            ->count('cash_requests.released');

            $get_act_id = Activity::all()->first();
            if(count($get_act_id) != 0){
                $g_id = $get_act_id->id;

                $get_buget = DB::table('cash_requests')
                ->where('activity_id', $g_id)
                ->count('cash_requests.id');
            }
            else{
                $get_buget = 0;
            }

            $response = [
                'activity' => $activity,
                'cash_code' => $cash_code
            ];


            return view('home', $response, compact('funds1','funds2','get_buget','cash_releas', 'a_approval1', 'a_approval2', 'a_approval3', 'org_num_requests', 'count_budget', 'count_remaining', 'budget_first', 'budget_second', 'total_budget','total_remaining', 'org_officer_num'));
            // return response()->json($cash_releas);
        }
        

        else{
            $activity = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->select('activities.*', 'organizations.name', 'organization_academic_years.ay_id')
            ->get();

            $count_ias_orgs = DB::table('organizations')
            ->join('institutes', 'organizations.institute_id', '=', 'institutes.id')
            ->where('institutes.code', 'ias')
            ->count('organizations.name');

            $count_ibe_orgs = DB::table('organizations')
            ->join('institutes', 'organizations.institute_id', '=', 'institutes.id')
            ->where('institutes.code', 'ibe')
            ->count('organizations.name');

            $count_ics_orgs = DB::table('organizations')
            ->join('institutes', 'organizations.institute_id', '=', 'institutes.id')
            ->where('institutes.code', 'ics')
            ->count('organizations.name');

            $count_ihm_orgs = DB::table('organizations')
            ->join('institutes', 'organizations.institute_id', '=', 'institutes.id')
            ->where('institutes.code', 'ihm')
            ->count('organizations.name');

            $count_ite_orgs = DB::table('organizations')
            ->join('institutes', 'organizations.institute_id', '=', 'institutes.id')
            ->where('institutes.code', 'ite')
            ->count('organizations.name');


            $response = [
                'activity' => $activity,
                'count_ias_orgs' => $count_ias_orgs,
                'count_ibe_orgs' => $count_ibe_orgs,
                'count_ics_orgs' => $count_ics_orgs,
                'count_ihm_orgs' => $count_ihm_orgs,
                'count_ite_orgs' => $count_ite_orgs
                
            ];
            
            return view('home', $response, compact('funds1','a_year','funds2', 'all_requests','a_approval1', 'a_approval2', 'a_approval3', 'organization_num'));
          //  return response()->json($response);
        }

       
    }
}
