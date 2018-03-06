<?php

namespace App\Http\Controllers;

use App\Budget;
use App\AcademicYear;
use App\Funds;
use Auth;
use App\OfficerVoting;
use App\Officer;
use App\Saving;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('budget.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $user = Auth::user()->id;
        if(Auth::User()->role_id == 4)
        {
             $officers = DB::table('officers')
            ->join('users', 'officers.user_id', '=', 'users.id')
            ->join('organization_academic_years', 'officers.organization_ay_id', '=', 'organization_academic_years.organization_id')
            ->select('organization_academic_years.organization_id')
            ->where('officers.user_id', $user)
            ->get();

             $officers2 = DB::table('officers')
            ->join('users', 'officers.user_id', '=', 'users.id')
            ->join('organization_academic_years', 'officers.organization_ay_id', '=', 'organization_academic_years.organization_id')
            ->select('organization_academic_years.organization_id')
            ->where('officers.user_id', $user)
            ->get();

            $budget = DB::table('budgets')
            ->join('organization_academic_years', 'budgets.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id') 
            ->join('funds', 'funds.id', '=', 'budgets.fund_id') 
            ->select('budgets.*', 'funds.name as fund_name', 'organizations.name','organization_academic_years.organization_id')
            ->where('organization_academic_years.ay_id', $id)
            ->orderby('fund_name','asc')
            ->orderby('organizations.name','asc')
            ->get();

             $budget2 = DB::table('budgets')
            ->join('organization_academic_years', 'budgets.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id') 
            ->join('funds', 'funds.id', '=', 'budgets.fund_id') 
            ->select('budgets.*', 'funds.*', 'organizations.name','organization_academic_years.organization_id')
            ->where('organization_academic_years.ay_id', $id)
            ->get();

             $budget_id = DB::table('budgets')
            ->join('organization_academic_years', 'budgets.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id') 
            ->join('funds', 'funds.id', '=', 'budgets.fund_id') 
            ->select('budgets.*','funds.semester')
            ->where('organization_academic_years.ay_id', $id)
            ->get();

            $user_id = Auth::user()->id;
            $org_officer = Officer::where('user_id','=',$user_id)->first();
            $org_id = $org_officer->organization_ay_id;

            $u_users = DB::table('users')
            ->join('officer_votings', 'users.id', '=', 'officer_votings.user_id')
            ->join('organization_academic_years', 'officer_votings.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('officers', 'users.id', '=', 'officers.user_id')
            ->select('users.*','officers.position')
            ->where('organization_academic_years.ay_id', $id)
            ->where('organization_academic_years.id', $org_id)
            ->get();

            $off_vote = DB::table('officer_votings')
            ->where('officer_votings.user_id', $user_id)
            ->sum('officer_votings.user_id');

            $officer = DB::table('officers')
            ->where('officers.user_id', $user_id)
            ->sum('officers.user_id');


                

            $org_officer_num = DB::table('officers')
            ->join('organization_academic_years', 'officers.organization_ay_id', '=', 'organization_academic_years.id')
            ->where('officers.organization_ay_id', $org_id)
            ->where('organization_academic_years.ay_id', $id)
            ->count('officers.organization_ay_id');

            $org_saving_num = DB::table('officer_votings')
            ->join('organization_academic_years', 'officer_votings.organization_ay_id', '=', 'organization_academic_years.id')
            ->where('officer_votings.organization_ay_id', $org_id)
            ->where('organization_academic_years.ay_id', $id)
            ->count('officer_votings.organization_ay_id');
        }
        else{
            $budget = DB::table('budgets')
            ->join('organization_academic_years', 'budgets.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id') 
            ->join('funds', 'funds.id', '=', 'budgets.fund_id') 
            ->select('budgets.*', 'organizations.name','funds.name as fund_name', 'funds.semester')
            ->where('funds.ay_id', $id)
            ->where('funds.semester', 1)
            ->get();
            $budget2 = DB::table('budgets')
            ->join('organization_academic_years', 'budgets.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id') 
            ->join('funds', 'funds.id', '=', 'budgets.fund_id') 
            ->select('budgets.*', 'organizations.name','funds.name as fund_name', 'funds.semester')
            ->where('funds.ay_id', $id)
            ->where('funds.semester', 2)
            ->get();
        }



        $response = [ 
            'budget' => $budget
        ];
            
        $ay = AcademicYear::find($id);
        $funds = DB::table('funds')
        ->where('funds.ay_id', $id)
        ->where('funds.semester', 1)
        ->get();

        $funds2 = DB::table('funds')
        ->where('funds.ay_id', $id)
        ->where('funds.semester', 2)
        ->get();

        $orgs = DB::table('organization_academic_years')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id') 
        ->select('organization_academic_years.*', 'organizations.name') 
        ->where('organization_academic_years.ay_id', $id)
        ->where('organization_academic_years.accredited', 1)
        ->get();
    //return response()->json($u_users);

       return view('budgets.index', $response, compact('budget','budget2','budget_savings','org_id','u_users','off_vote','officer', 'ay','officers','org_officer','budget_id','org_officer_num','org_saving_num', 'officers2','funds', 'funds2', 'orgs'));
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $budget = DB::table('budgets')
        ->join('organization_academic_years', 'budgets.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id') 
        ->select('budgets.*', 'organizations.name')
        ->where('budgets.id', $id)
        ->get();
        
        $response = [ 
            'budgets' => $budget
        ];

        // return response()->json($response);
        return view('budgets.edit', $response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $budget = Budget::findOrFail($id);
        $fund = Funds::findOrFail($budget->fund_id);
        $ay_id = $fund->ay_id;
        
        if($budget->budget < $request->input('budget')){
            $more = $request->input('budget') - $budget->budget;
            $budget->remaining += $more;
            $fund->remaining -= $more;
        }
        
        if($budget->budget > $request->input('budget')){
            $less = $budget->budget - $request->input('budget');
            $budget->remaining -= $less;
            $fund->remaining += $more;
        }

        $budget->budget = $request->input('budget');

        $budget->save();
        $fund->save();
        return redirect()->route('budget.show', ['id' => $ay_id])->with('alert-success', 'Success!');     
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Budget  $budget
     * @return \Illuminate\Http\Response
     */
    public function destroy(Budget $budget)
    {
        //
    }

    public function get_budget(Request $request)
    {
       $saving = new Saving;
       $OfficerVote = new OfficerVoting;

        $ay = AcademicYear::where('id', '=', $request->input('ay_id'))->first();
        $ay_id = $ay->id;

        $OfficerVote->organization_ay_id = $request->input('organization_ay_id');
        $OfficerVote->user_id = $request->input('user_id');

        //savings table
        $org_saving_num = $request->input('org_saving_num');
        $org_officer_num = $request->input('org_officer_num') - 1;

        $saving->savings = $request->input('budget');
        $saving->remaining = $request->input('budget');
        $saving->semester = $request->input('sem');
        $saving->organization_ay_id = $request->input('organization_ay_id'); 
        $saving->budget_id = $request->input('budget_id');
        //end savings table

        //budget table
        $budget_id = $request->input('budget_id');
         $ay_id = $request->input('ay_id');

        $budget = Budget::find($budget_id);
        $budget_less = $budget->remaining - $request->input('budget');
        $budget->remaining = $budget_less;
        //end budget table
        if($org_saving_num == $org_officer_num )
        {
        $budget->save();
        $saving->save();
        return redirect()->route('budget.show' , $ay_id)->with('alert-success', 'Budget converted successfully!');
        }
        else
        {   
            $OfficerVote->save();
          //  return response()->json($OfficerVote);
           return redirect()->route('budget.show' , $ay_id)->with('alert-success', 'Success!');
        }

    }
}
