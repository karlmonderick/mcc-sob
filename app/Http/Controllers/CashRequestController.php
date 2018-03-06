<?php

namespace App\Http\Controllers;

use App\cash_request;
use Carbon\Carbon;
use App\Activity;
use App\Funds;
use App\User;
use App\Budget;
use App\AcademicYear;
use App\Organization;
use Auth;
use Hash;
use App\Notifications;
use Illuminate\Http\Request;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\DB;

class CashRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $o_id = $request->input('organization_ay_id');
        $budget = Budget::where('organization_ay_id', $o_id)->count('budgets.organization_ay_id');

        if($budget >= 1)
        {
        $org_id = Budget::where('organization_ay_id', $o_id)->first();

        $or_id = $org_id->id;
        $b_rem = $org_id->remaining;
        $r_amount = $request->input('amount');
        $activity_id = $request->input('act_id');
        $a_id = cash_request::all()->first();
        
        //$budget = $b_rem - $r_amount;
        //$org_id->remaining = $budget;

         $verify = uniqid();


        $get_cash_req = cash_request::where('cash_requests.activity_id', $activity_id)->count('cash_requests.activity_id');
         //$verify2 = uniqid('id');
         //$verify3 = uniqid('id', true);
        }
        if($budget == 0)
        {
          return redirect()->back()->with('alert-danger', 'Oooops. There something wrong. Please check your budget for this semester.');  
        }

        elseif($get_cash_req >= 1)
        {
        return redirect()->back()->with('alert-danger', 'Oooops. There is already existing data');
        }
        elseif($b_rem > $r_amount && $get_cash_req <= 0)
        {
         $cash_request = new cash_request;
         $cash_request->cash_amount = $request->input('amount');
         $cash_request->organization_ay_id = $request->input('organization_ay_id');
         $cash_request->budget_id = $or_id;
         $cash_request->verification_code = $verify;
         $cash_request->released = $request->input('released');
         $cash_request->activity_id = $activity_id;
         $cash_request->notify_igp = 0;
         $cash_request->notify_officer = 0;
         $cash_request->save();
        // $org_id->save();
         $get_cash_req = Activity::where('activities.id', $activity_id)->update(['activities.released' => 1]);

         return redirect()->back()->with('alert-success', 'Data has been submitted' );
     }
     else
     {
        return redirect()->back()->with('alert-danger', 'Budget error. PLease check the remaining balance of your organization.' ,'alert-danger', 'Budget error. PLease check the remaining balance of your organization.');
     }


      //  return response()->json($get_cash_req);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\cash_request  $cash_request
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    //COUNT NOT YET RELEASED
    $count_not = DB::table('cash_requests')
     ->join('organization_academic_years', 'cash_requests.organization_ay_id', '=', 'organization_academic_years.id')
     ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
     ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
     ->where('cash_requests.released', 0)
     ->count('cash_requests.released');

    //COUNT RELEASED
     $count_released = DB::table('cash_requests')
     ->join('organization_academic_years', 'cash_requests.organization_ay_id', '=', 'organization_academic_years.id')
     ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
     ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
     ->where('cash_requests.released', 1)
     ->count('cash_requests.released');

    //GET NOT YET RELEASED
     $ca_req = DB::table('cash_requests')
     ->join('organization_academic_years', 'cash_requests.organization_ay_id', '=', 'organization_academic_years.id')
     ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
     ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
     ->select('budgets.id', 'cash_requests.*', 'organizations.name')
     ->where('cash_requests.released', 0)
     ->get();

      $ca_req2 = DB::table('cash_requests')
     ->join('organization_academic_years', 'cash_requests.organization_ay_id', '=', 'organization_academic_years.id')
     ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
     ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
     ->select('budgets.id', 'cash_requests.*', 'organizations.name')
     ->where('cash_requests.released', 0)
     ->get();


     //GET RELEASED
     $re_req = DB::table('cash_requests')
     ->join('organization_academic_years', 'cash_requests.organization_ay_id', '=', 'organization_academic_years.id')
     ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
     ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
     ->select('budgets.id', 'cash_requests.*', 'organizations.name')
     ->where('cash_requests.released', 1)
     ->get();

     $cash_req = cash_request::where('cash_requests.notify_igp', 0)->update(['notify_igp' => 1]);


     $ay = AcademicYear::find($id);
     return view('cash_request.index', compact('ay','ca_req', 'ca_req2', 're_req','count_not','count_released'));  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\cash_request  $cash_request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\cash_request  $cash_request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $r_id = $request->input('cash_id');
        
        $budget_req = cash_request::find($r_id);

        $update_budget = Budget::find($budget_req->budget_id);
        $budget_f_id = $update_budget->fund_id;

        $funds = Funds::find($budget_f_id);

        $funds->remaining = $funds->remaining - $budget_req->cash_amount;

        $get_totalAmount_request = $update_budget->remaining - $budget_req->cash_amount;
        $update_budget->remaining = $get_totalAmount_request;
        if($request->input('v_code')==$request->input('v_code_true')){
            $budget_req->released = 1;
            $budget_req->save();
            $update_budget->save();
            $funds->save();

            $get_cash_req = Activity::where('activities.id', $request->input('act_id'))->update(['activities.released_by_igp' => 1]);
            return redirect()->back()->with('alert-success', 'The request has been released.');
            //return response()->json($update_budget->remaining);
        }
        else{
            return redirect()->back()->with('alert-danger', 'Invalid Code.');
            //return response()->json($funds_remaining);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\cash_request  $cash_request
     * @return \Illuminate\Http\Response
     */
    public function destroy(cash_request $cash_request)
    {
        //
    }
}
