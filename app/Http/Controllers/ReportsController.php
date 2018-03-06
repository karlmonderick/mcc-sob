<?php

namespace App\Http\Controllers;

use Auth;
use App\AcademicYear;
use App\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function show($id)
    {
    	$ay_id = $id;
        if(Auth::user()->role_id == 2)
            {
            	//funds - first sem
            	$fund_1 = DB::table('funds')
            	->where('funds.semester', 1)
            	->where('funds.ay_id', $id)
            	->select('funds.*')
            	->get();

            	//count funds - first sem
            	$count_fund_1 = DB::table('funds')
            	->where('funds.semester', 1)
            	->where('funds.ay_id', $id)
            	->count('funds.id');

            	//funds - 2nd sem
            	$fund_2 = DB::table('funds')
            	->where('funds.semester', 2)
            	->where('funds.ay_id', $id)
            	->select('funds.*')
            	->get();

            	//funds - 2nd sem
            	$count_fund_2 = DB::table('funds')
            	->where('funds.semester', 2)
            	->where('funds.ay_id', $id)
            	->count('funds.id');

            	//Allocated budget - 1st sem
            	$all_budget_1 = DB::table('budgets')
            	->join('funds', 'budgets.fund_id','=','funds.id')
            	->join('organization_academic_years','budgets.organization_ay_id','organization_academic_years.id')
            	->join('organizations','organization_academic_years.organization_id','organizations.id')
            	->where('funds.ay_id', $ay_id)
            	->where('funds.semester', 1)
            	->select('budgets.*','organizations.*', 'budgets.created_at as budget_date')
            	->orderby('funds.name')
            	->orderby('organizations.name')
            	->get();

            	//count Allocated budget - 1st sem
            	$count_all_budget_1 = DB::table('budgets')
            	->join('funds', 'budgets.fund_id','=','funds.id')
            	->join('organization_academic_years','budgets.organization_ay_id','organization_academic_years.id')
            	->join('organizations','organization_academic_years.organization_id','organizations.id')
            	->where('funds.ay_id', $ay_id)
            	->where('funds.semester', 1)
            	->count('budgets.id');

        		//Allocated budget - 1st sem
            	$all_budget_2 = DB::table('budgets')
            	->join('funds', 'budgets.fund_id','=','funds.id')
            	->join('organization_academic_years','budgets.organization_ay_id','organization_academic_years.id')
            	->join('organizations','organization_academic_years.organization_id','organizations.id')
            	->where('funds.ay_id', $ay_id)
            	->where('funds.semester', 2)
            	->select('budgets.*','organizations.*', 'budgets.created_at as budget_date')
            	->get();

            	//count Allocated budget - 1st sem
            	$count_all_budget_2 = DB::table('budgets')
            	->join('funds', 'budgets.fund_id','=','funds.id')
            	->join('organization_academic_years','budgets.organization_ay_id','organization_academic_years.id')
            	->join('organizations','organization_academic_years.organization_id','organizations.id')
            	->where('funds.ay_id', $ay_id)
            	->where('funds.semester', 2)
            	->count('budgets.id');

            	//activity budget request - 1st sem
            	$activity_1 = DB::table('activities')
            	->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            	->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            	->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
            	->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
            	->join('funds', 'budgets.fund_id', '=', 'funds.id')
            	->where('funds.ay_id', $id)
            	->where('funds.semester', 1)
            	->where('cash_requests.released', 1)
            	->select('activities.*', 'organizations.name')
            	->get();

            	//count activity budget request - 1st sem
            	$count_activity_1 = DB::table('activities')
            	->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            	->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            	->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
            	->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
            	->join('funds', 'budgets.fund_id', '=', 'funds.id')
            	->where('funds.ay_id', $id)
            	->where('funds.semester', 1)
            	->where('cash_requests.released', 1)
            	->count('activities.id');

            	//activity budget request - 2nd sem
            	$activity_2 = DB::table('activities')
            	->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            	->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            	->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
            	->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
            	->join('funds', 'budgets.fund_id', '=', 'funds.id')
            	->where('funds.ay_id', $id)
            	->where('funds.semester', 2)
            	->where('cash_requests.released', 1)
            	->select('activities.*', 'organizations.name')
            	->get();

            	//count activity budget request - 2nd sem
            	$count_activity_2 = DB::table('activities')
            	->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            	->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            	->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
            	->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
            	->join('funds', 'budgets.fund_id', '=', 'funds.id')
            	->where('funds.ay_id', $id)
            	->where('funds.semester', 2)
            	->where('cash_requests.released', 1)
            	->count('activities.id');

            	//cash_request - 1st sem
            	$cash_req_1 = DB::table('cash_requests')
            	->join('activities', 'cash_requests.activity_id', '=', 'activities.id')
            	->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            	->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            	->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
            	->join('funds', 'budgets.fund_id', '=', 'funds.id')
            	->where('funds.ay_id', $id)
            	->where('funds.semester', 1)
            	->where('cash_requests.released', 1)
            	->select('cash_requests.*', 'organizations.name', 'activities.title')
            	->get();

            	//count cash_request - 1st sem
            	$count_cash_req_1 = DB::table('cash_requests')
            	->join('activities', 'cash_requests.activity_id', '=', 'activities.id')
            	->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            	->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            	->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
            	->join('funds', 'budgets.fund_id', '=', 'funds.id')
            	->where('funds.ay_id', $id)
            	->where('funds.semester', 1)
            	->where('cash_requests.released', 1)
            	->count('cash_requests.id');

            	//cash_request - 2nd sem
            	$cash_req_2 = DB::table('cash_requests')
            	->join('activities', 'cash_requests.activity_id', '=', 'activities.id')
            	->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            	->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            	->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
            	->join('funds', 'budgets.fund_id', '=', 'funds.id')
            	->where('funds.ay_id', $id)
            	->where('funds.semester', 2)
            	->where('cash_requests.released', 1)
            	->select('cash_requests.*', 'organizations.name', 'activities.title')
            	->get();

            	//count cash_request - 2nd sem
            	$count_cash_req_2 = DB::table('cash_requests')
            	->join('activities', 'cash_requests.activity_id', '=', 'activities.id')
            	->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            	->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            	->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
            	->join('funds', 'budgets.fund_id', '=', 'funds.id')
            	->where('funds.ay_id', $id)
            	->where('funds.semester', 2)
            	->where('cash_requests.released', 1)
            	->count('cash_requests.id');

            	//Liquidation - 1st sem
            	$liquidation = DB::table('liquidations')
            	->join('activities', 'liquidations.acitivity_id', '=','activities.id')
            	->join('organization_academic_years', 'activities.organization_ay_id', '=','organization_academic_years.id')
            	->join('organizations', 'organization_academic_years.organization_id', '=','organizations.id')
            	->join('budgets', 'organization_academic_years.id', '=', 'budgets.organization_ay_id')
            	->join('funds', 'budgets.fund_id', '=', 'funds.id')
            	->where('organization_academic_years.ay_id', $id)
            	->where('funds.semester', 1)
            	->select('activities.title', 'organizations.name' ,'liquidations.*')
            	->get();

            	//count Liquidation - 1st sem
            	$count_liquidation = DB::table('liquidations')
            	->join('activities', 'liquidations.acitivity_id', '=','activities.id')
            	->join('organization_academic_years', 'activities.organization_ay_id', '=','organization_academic_years.id')
            	->join('organizations', 'organization_academic_years.organization_id', '=','organizations.id')
            	->join('budgets', 'organization_academic_years.id', '=', 'budgets.organization_ay_id')
            	->join('funds', 'budgets.fund_id', '=', 'funds.id')
            	->where('organization_academic_years.ay_id', $id)
            	->where('funds.semester', 1)
            	->count('activities.id');

            	//Liquidation - 2nd sem
            	$liquidation_2 = DB::table('liquidations')
            	->join('activities', 'liquidations.acitivity_id', '=','activities.id')
            	->join('organization_academic_years', 'activities.organization_ay_id', '=','organization_academic_years.id')
            	->join('organizations', 'organization_academic_years.organization_id', '=','organizations.id')
            	->join('budgets', 'organization_academic_years.id', '=', 'budgets.organization_ay_id')
            	->join('funds', 'budgets.fund_id', '=', 'funds.id')
            	->where('organization_academic_years.ay_id', $id)
            	->where('funds.semester', 2)
            	->select('activities.title', 'organizations.name' ,'liquidations.*')
            	->get();

            	//Count Liquidation - 2nd sem
            	$count_liquidation_2 = DB::table('liquidations')
            	->join('activities', 'liquidations.acitivity_id', '=','activities.id')
            	->join('organization_academic_years', 'activities.organization_ay_id', '=','organization_academic_years.id')
            	->join('organizations', 'organization_academic_years.organization_id', '=','organizations.id')
            	->join('budgets', 'organization_academic_years.id', '=', 'budgets.organization_ay_id')
            	->join('funds', 'budgets.fund_id', '=', 'funds.id')
            	->where('organization_academic_years.ay_id', $id)
            	->where('funds.semester', 2)
            	->count('activities.id');


            	$response = [
            		'fund_1' => $fund_1,
            		'fund_2' => $fund_2,
            		'count_fund_1' => $count_fund_1,
            		'count_fund_2' => $count_fund_2,
            		'activity_1' => $activity_1,
            		'activity_2' => $activity_2,
            		'count_activity_1' => $count_activity_1,
            		'count_activity_2' => $count_activity_2,
            		'cash_req_1' => $cash_req_1,
            		'cash_req_2' => $cash_req_2,
            		'count_cash_req_1' => $count_cash_req_1,
            		'count_cash_req_2' => $count_cash_req_2,
            		'all_budget_1' => $all_budget_1,
            		'all_budget_2' => $all_budget_2,
            		'count_all_budget_1' => $count_all_budget_1,
            		'count_all_budget_2' => $count_all_budget_2,
            		'liquidation' => $liquidation,
            		'liquidation_2' => $liquidation_2,
            		'count_liquidation' => $count_liquidation,
            		'count_liquidation_2' => $count_liquidation_2
            		
            	];
            	return view('reports.index', $response, compact('ay_id'));

            }
        if(Auth::user()->role_id == 4)
            {
                $officer = \App\Officer::where('user_id', '=', Auth::id())->first();
                $org_ay_id = $officer->organization_ay_id;

                $accomplished_activity = DB::table('activities')
                ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                ->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
                ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
                ->join('funds', 'budgets.fund_id', '=', 'funds.id')
                ->where('funds.ay_id', $id)
                ->where('funds.semester', 1)
                ->where('cash_requests.released', 1)
                ->where('activities.approval', 1)
                ->where('organization_academic_years.id', $org_ay_id)
                ->select('activities.*')
                ->get();

                $count_accomplished_activity = DB::table('activities')
                ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                ->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
                ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
                ->join('funds', 'budgets.fund_id', '=', 'funds.id')
                ->where('funds.ay_id', $id)
                ->where('funds.semester', 1)
                ->where('cash_requests.released', 1)
                ->where('activities.approval', 1)
                ->where('organization_academic_years.id', $org_ay_id)
                ->count('activities.id');

                $accomplished_activity_2 = DB::table('activities')
                ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                ->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
                ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
                ->join('funds', 'budgets.fund_id', '=', 'funds.id')
                ->where('funds.ay_id', $id)
                ->where('funds.semester', 2)
                ->where('cash_requests.released', 1)
                ->where('activities.approval', 1)
                ->where('organization_academic_years.id', $org_ay_id)
                ->select('activities.*')
                ->get();

                $count_accomplished_activity_2 = DB::table('activities')
                ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                ->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
                ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
                ->join('funds', 'budgets.fund_id', '=', 'funds.id')
                ->where('funds.ay_id', $id)
                ->where('funds.semester', 2)
                ->where('cash_requests.released', 1)
                ->where('activities.approval', 1)
                ->where('organization_academic_years.id', $org_ay_id)
                ->count('activities.id');

                $officer_liquidation = DB::table('liquidations')
                ->join('activities', 'liquidations.acitivity_id', '=', 'activities.id')
                ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                ->where('organization_academic_years.ay_id', $id)
                ->where('liquidations.approval', 1)
                ->where('organization_academic_years.id', $org_ay_id)
                ->select('liquidations.*','activities.title')
                ->get();

                $count_officer_liquidation = DB::table('liquidations')
                ->join('activities', 'liquidations.acitivity_id', '=', 'activities.id')
                ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                ->where('organization_academic_years.ay_id', $id)
                ->where('liquidations.approval', 1)
                ->where('organization_academic_years.id', $org_ay_id)
                ->count('liquidations.id');

                $response = [
                    'accomplished_activity' => $accomplished_activity,
                    'accomplished_activity_2' => $accomplished_activity_2,
                    'officer_liquidation' => $officer_liquidation,
                    'count_accomplished_activity' => $count_accomplished_activity,
                    'count_accomplished_activity_2' => $count_accomplished_activity_2,
                    'count_officer_liquidation' => $count_officer_liquidation
                ];

                return view('reports.index', $response, compact('ay_id'));
               // return response()->json($officer_liquidation);
            }
    	//return response()->json($fund_sem_1);
    }

    public function print(Request $request, $id)
    {
    	$ids = $id;
    	$activity_id= $request->input('activity_id');
    	$ay_id = $request->input('ay_id');
    	$acad_yr_id = AcademicYear::where('academic_years.id', $ay_id)->first();
        
        if(Auth::user()->role_id == 2)
            {
            	if($ids == 1)
        		    	{
        			    	//funds - first sem
        			    	$fund_1 = DB::table('funds')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 1)
        			    	->select('funds.*')
        			    	->get();

        			    	$fund_sum_1 = DB::table('funds')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 1)
        			    	->sum('funds.amount');

        			    	$fund_sum_rem_1 = DB::table('funds')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 1)
        			    	->sum('funds.remaining');

                            $c_fund_1 = DB::table('funds')
                            ->where('funds.ay_id', $ay_id)
                            ->where('funds.semester', 1)
                            ->count('funds.id');

        			    	$response = [
        		    		'fund_1' => $fund_1,
        		    		'fund_sum_1' => $fund_sum_1,
        		    		'fund_sum_rem_1' => $fund_sum_rem_1
        		    	];
        		    	if($c_fund_1 != 0)
        		    	{
        		    		return view('reports.print', $response, compact('ids','acad_yr_id'));
        		    	}
        		    	else
        		    	{
        		    		return redirect()->back()->with('alert-danger', 'Sorry. but there is no availaible data in the list.');
        		    	}

        		    	}



            	elseif($id == 2)
        		    	{
        			    	//funds - 2nd sem
        			    	$fund_2 = DB::table('funds')

        			    	->where('funds.semester', 2)
                            ->where('funds.ay_id', $ay_id)
        			    	->select('funds.*')
        			    	->get();

        			    	$fund_sum_2 = DB::table('funds')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 2)
        			    	->sum('funds.amount');

        			    	$fund_sum_rem_2 = DB::table('funds')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 2)
        			    	->sum('funds.remaining');

                            $c_fund_2 = DB::table('funds')
                            ->where('funds.ay_id', $ay_id)
                            ->where('funds.semester', 2)
                            ->count('funds.id');

        			    	$response = [
        					    		'fund_2' => $fund_2,
        					    		'fund_sum_2' => $fund_sum_2,
        					    		'fund_sum_rem_2' => $fund_sum_rem_2
        						    	];
        			    if($c_fund_2 != 0)
        		    	{
        		    		return view('reports.print', $response, compact('ids','acad_yr_id'));
        		    	}
        		    	else
        		    	{
        		    		return redirect()->back()->with('alert-danger', 'Sorry. but there is no availaible data in the list.');
        		    	}

        			    }

        		elseif($ids == 3)
        		        {
        					//Allocated budget - 1st sem
        			    	$all_budget_1 = DB::table('budgets')
        			    	->join('funds', 'budgets.fund_id','=','funds.id')
        			    	->join('organization_academic_years','budgets.organization_ay_id','organization_academic_years.id')
        			    	->join('organizations','organization_academic_years.organization_id','organizations.id')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 1)
        			    	->select('budgets.*','organizations.*')
            				->orderby('organizations.name')
        			    	->get();

        			    	//Allocated budget - 2nd sem
        			    	$all_budget_2 = DB::table('budgets')
        			    	->join('funds', 'budgets.fund_id','=','funds.id')
        			    	->join('organization_academic_years','budgets.organization_ay_id','organization_academic_years.id')
        			    	->join('organizations','organization_academic_years.organization_id','organizations.id')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 2)
        			    	->select('budgets.*','organizations.*')
        			    	->orderby('organizations.name')
        			    	->get();

        			    	//Sum of Allocated budget - 1st sem
        			    	$all_budget_sum_1 = DB::table('budgets')
        			    	->join('funds', 'budgets.fund_id','=','funds.id')
        			    	->join('organization_academic_years','budgets.organization_ay_id','organization_academic_years.id')
        			    	->join('organizations','organization_academic_years.organization_id','organizations.id')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 1)
        			    	->sum('budgets.budget');

        			    	//Sum of remaining Allocated budget - 1st sem
        			    	$all_budget_sum_rem_1 = DB::table('budgets')
        			    	->join('funds', 'budgets.fund_id','=','funds.id')
        			    	->join('organization_academic_years','budgets.organization_ay_id','organization_academic_years.id')
        			    	->join('organizations','organization_academic_years.organization_id','organizations.id')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 1)
        			    	->sum('budgets.remaining');

        			    	//Sum of Allocated budget - 2nd sem
        			    	$all_budget_sum_2 = DB::table('budgets')
        			    	->join('funds', 'budgets.fund_id','=','funds.id')
        			    	->join('organization_academic_years','budgets.organization_ay_id','organization_academic_years.id')
        			    	->join('organizations','organization_academic_years.organization_id','organizations.id')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 2)
        			    	->sum('budgets.budget');

        			    	//Sum of remaining Allocated budget - 2nd sem
        			    	$all_budget_sum_rem_2 = DB::table('budgets')
        			    	->join('funds', 'budgets.fund_id','=','funds.id')
        			    	->join('organization_academic_years','budgets.organization_ay_id','organization_academic_years.id')
        			    	->join('organizations','organization_academic_years.organization_id','organizations.id')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 2)
        			    	->sum('budgets.remaining');

                            $c_all_budget_1 = DB::table('budgets')
                            ->join('funds', 'budgets.fund_id','=','funds.id')
                            ->join('organization_academic_years','budgets.organization_ay_id','organization_academic_years.id')
                            ->join('organizations','organization_academic_years.organization_id','organizations.id')
                            ->where('funds.ay_id', $ay_id)
                            ->where('funds.semester', 1)
                            ->count('budgets.id');
        			    	$response = [ 
        			    				'all_budget_1' => $all_budget_1,
        			    				'all_budget_2' => $all_budget_2,
        			    				'all_budget_sum_1' => $all_budget_sum_1,
        			    				'all_budget_sum_rem_1' => $all_budget_sum_rem_1,
        			    				'all_budget_sum_1' => $all_budget_sum_1,
        			    				'all_budget_sum_rem_2' => $all_budget_sum_rem_2
        			    				];
        					if($c_all_budget_1 != 0)
            			    	{
            			    		return view('reports.print', $response, compact('ids','acad_yr_id'));
            			    	}
            			    	else
            			    	{
            			    		return redirect()->back()->with('alert-danger', 'Sorry. but there is no availaible data in the list.');
            			    	}
        		        }

        		elseif($ids == 4)
        		        {
        			    	//Allocated budget - 2nd sem
        			    	$all_budget_2 = DB::table('budgets')
        			    	->join('funds', 'budgets.fund_id','=','funds.id')
        			    	->join('organization_academic_years','budgets.organization_ay_id','organization_academic_years.id')
        			    	->join('organizations','organization_academic_years.organization_id','organizations.id')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 2)
        			    	->select('budgets.*','organizations.*')
        			    	->get();

        			    	//Sum of Allocated budget - 2nd sem
        			    	$all_budget_sum_2 = DB::table('budgets')
        			    	->join('funds', 'budgets.fund_id','=','funds.id')
        			    	->join('organization_academic_years','budgets.organization_ay_id','organization_academic_years.id')
        			    	->join('organizations','organization_academic_years.organization_id','organizations.id')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 2)
        			    	->sum('budgets.budget');

        			    	//Sum of remaining Allocated budget - 2nd sem
        			    	$all_budget_sum_rem_2 = DB::table('budgets')
        			    	->join('funds', 'budgets.fund_id','=','funds.id')
        			    	->join('organization_academic_years','budgets.organization_ay_id','organization_academic_years.id')
        			    	->join('organizations','organization_academic_years.organization_id','organizations.id')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 2)
        			    	->sum('budgets.remaining');

                            $c_all_budget_2 = DB::table('budgets')
                            ->join('funds', 'budgets.fund_id','=','funds.id')
                            ->join('organization_academic_years','budgets.organization_ay_id','organization_academic_years.id')
                            ->join('organizations','organization_academic_years.organization_id','organizations.id')
                            ->where('funds.ay_id', $ay_id)
                            ->where('funds.semester', 2)
                            ->count('budgets.id');

        			    	$response = [ 
        			    				'all_budget_2' => $all_budget_2,
        			    				'all_budget_sum_2' => $all_budget_sum_2,
        			    				'all_budget_sum_rem_2' => $all_budget_sum_rem_2
        			    				];
        					if($c_all_budget_2 != 0)
            			    	{
            			    		return view('reports.print', $response, compact('ids','acad_yr_id'));
            			    	}
            			    	else
            			    	{
            			    		return redirect()->back()->with('alert-danger', 'Sorry. but there is no availaible data in the list.');
            			    	}
            		    }

        		elseif($ids == 5)
        				{
        			    	//activity budget request - 1st sem
        			    	$activity_1 = DB::table('activities')
        			    	->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        			    	->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        			    	->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
        			    	->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
        			    	->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 1)
        			    	->where('cash_requests.released', 1)
        			    	->select('activities.*', 'organizations.name')
        			    	->get();

        			    	//sum of activity budget request - 1st sem
        			    	$activity_sum_1 = DB::table('activities')
        			    	->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        			    	->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        			    	->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
        			    	->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
        			    	->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 1)
        			    	->where('cash_requests.released', 1)
        			    	->sum('activities.buggetTotal');

                            $c_activity_1 = DB::table('activities')
                            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                            ->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
                            ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
                            ->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('funds.ay_id', $ay_id)
                            ->where('funds.semester', 1)
                            ->where('cash_requests.released', 1)
                            ->count('activities.id');


        			    	$response = [ 
        			    				'activity_1' => $activity_1,
        			    				'activity_sum_1' => $activity_sum_1
        			    				];

        			    	if($c_activity_1 == 0)
        			    		{
        			    		return redirect()->back()->with('alert-danger', 'Sorry. but there is no availaible data in the list.');
        			    		}
        			    	else
        			    		{
        			    		//return response()->json($activity_1);
        		    		return view('reports.print', $response, compact('ids','acad_yr_id'));
        		    			}
        		    	}

            	elseif($ids == 6)
        				{
        			    	//activity budget request - 2nd sem
        			    	$activity_2 = DB::table('activities')
        			    	->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        			    	->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        			    	->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
        			    	->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
        			    	->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 2)
        			    	->where('cash_requests.released', 1)
        			    	->select('activities.*', 'organizations.name')
        			    	->get();

        			    	//sum of activity budget requests - 2nd sem
        			    	$activity_sum_2 = DB::table('activities')
        			    	->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        			    	->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        			    	->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
        			    	->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
        			    	->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 2)
        			    	->where('cash_requests.released', 1)
        			    	->sum('activities.buggetTotal');

                            $c_activity_2 = DB::table('activities')
                            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                            ->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
                            ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
                            ->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('funds.ay_id', $ay_id)
                            ->where('funds.semester', 2)
                            ->where('cash_requests.released', 1)
                            ->count('activities.id');

        			    	$response = [ 
        			    					'activity_2' => $activity_2,
        			    					'activity_sum_2' => $activity_sum_2

        			    				];
        		    		if($c_activity_2 != 0)
        			    	{
        			    		return view('reports.print', $response, compact('ids','acad_yr_id'));
        			    	}
        			    	else
        			    	{
        			    		return redirect()->back()->with('alert-danger', 'Sorry. but there is no availaible data in the list.');
        			    	}
        			    }

        		elseif($ids == 7)
        				{
        			    	//cash_request - 1st sem
        			    	$cash_req_1 = DB::table('cash_requests')
        			    	->join('activities', 'cash_requests.activity_id', '=', 'activities.id')
        			    	->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        			    	->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        			    	->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
        			    	->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 1)
        			    	->where('cash_requests.released', 1)
        			    	->select('cash_requests.*', 'organizations.name', 'activities.title')
        			    	->get();

        			    	//cash_request_sum - 1st sem
        			    	$cash_req_sum_1 = DB::table('cash_requests')
        			    	->join('activities', 'cash_requests.activity_id', '=', 'activities.id')
        			    	->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        			    	->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        			    	->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
        			    	->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 1)
        			    	->where('cash_requests.released', 1)
        			    	->sum('cash_requests.cash_amount');

                            $c_cash_req_1 = DB::table('cash_requests')
                            ->join('activities', 'cash_requests.activity_id', '=', 'activities.id')
                            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                            ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
                            ->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('funds.ay_id', $ay_id)
                            ->where('funds.semester', 1)
                            ->where('cash_requests.released', 1)
                            ->count('cash_requests.id');

        			    	$response = [	
        			    				 'cash_req_1' => $cash_req_1,
        			    				 'cash_req_sum_1' => $cash_req_sum_1
        			    				 ];
        		    		if($c_cash_req_1 != 0)
        			    	{
        			    		return view('reports.print', $response, compact('ids','acad_yr_id'));
        			    	}
        			    	else
        			    	{
        			    		return redirect()->back()->with('alert-danger', 'Sorry. but there is no availaible data in the list.');
        			    	}
        			    }

        		elseif($ids == 8)
        				{
        			    	//cash_request - 2nd sem
        			    	$cash_req_2 = DB::table('cash_requests')
        			    	->join('activities', 'cash_requests.activity_id', '=', 'activities.id')
        			    	->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        			    	->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        			    	->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
        			    	->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 2)
        			    	->where('cash_requests.released', 1)
        			    	->select('cash_requests.*', 'organizations.name', 'activities.title')
        			    	->get();

        			    	//cash_request_sum - 2nd sem
        			    	$cash_req_sum_2 = DB::table('cash_requests')
        			    	->join('activities', 'cash_requests.activity_id', '=', 'activities.id')
        			    	->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        			    	->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        			    	->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
        			    	->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('funds.ay_id', $ay_id)
        			    	->where('funds.semester', 2)
        			    	->where('cash_requests.released', 1)
        			    	->sum('cash_requests.cash_amount');

                            $c_cash_req_2 = DB::table('cash_requests')
                            ->join('activities', 'cash_requests.activity_id', '=', 'activities.id')
                            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                            ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
                            ->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('funds.ay_id', $ay_id)
                            ->where('funds.semester', 2)
                            ->where('cash_requests.released', 1)
                            ->count('cash_requests.id');

        			    	$response = [ 
        			    					'cash_req_2' => $cash_req_2,
        			    					'cash_req_sum_2' => $cash_req_sum_2

        			    				];
        		    		if($c_cash_req_2 != 0)
            			    	{
            			    		return view('reports.print', $response, compact('ids','acad_yr_id'));
            			    	}
            			    	else
            			    	{
            			    		return redirect()->back()->with('alert-danger', 'Sorry. but there is no availaible data in the list.');
            			    	}
        			    }


        		elseif($ids == 9)
        				{
        			    	//Liquidation - 1st sem
        			    	$liquidation = DB::table('liquidations')
        			    	->join('activities', 'liquidations.acitivity_id', '=','activities.id')
        			    	->join('organization_academic_years', 'activities.organization_ay_id', '=','organization_academic_years.id')
        			    	->join('organizations', 'organization_academic_years.organization_id', '=','organizations.id')
        			    	->join('budgets', 'organization_academic_years.id', '=', 'budgets.organization_ay_id')
        			    	->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('liquidations.ay_id', $ay_id)
        			    	->where('funds.semester', 1)
        			    	->select('activities.title', 'organizations.name' ,'liquidations.*')
        			    	->get();

                            $c_liquidation = DB::table('liquidations')
                            ->join('activities', 'liquidations.acitivity_id', '=','activities.id')
                            ->join('organization_academic_years', 'activities.organization_ay_id', '=','organization_academic_years.id')
                            ->join('organizations', 'organization_academic_years.organization_id', '=','organizations.id')
                            ->join('budgets', 'organization_academic_years.id', '=', 'budgets.organization_ay_id')
                            ->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('liquidations.ay_id', $ay_id)
                            ->where('funds.semester', 1)
                            ->count('liquidations.id');

        			    	$response = [ 
        			    					'liquidation' => $liquidation

        			    				];
        		    		if($c_liquidation != 0)
            			    	{
            			    		return view('reports.print', $response, compact('ids','acad_yr_id'));
            			    	}
            			    	else
            			    	{
            			    		return redirect()->back()->with('alert-danger', 'Sorry. but there is no availaible data in the list.');
            			    	}
        			    }

        		elseif($ids == 10)
        				{
        			    	//Liquidation - 2nd sem
        			    	$liquidation_2 = DB::table('liquidations')
        			    	->join('activities', 'liquidations.acitivity_id', '=','activities.id')
        			    	->join('organization_academic_years', 'activities.organization_ay_id', '=','organization_academic_years.id')
        			    	->join('organizations', 'organization_academic_years.organization_id', '=','organizations.id')
        			    	->join('budgets', 'organization_academic_years.id', '=', 'budgets.organization_ay_id')
        			    	->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('liquidations.ay_id', $ay_id)
        			    	->where('funds.semester', 2)
        			    	->select('activities.title', 'organizations.name' ,'liquidations.*')
        			    	->get();

                            $c_liquidation_2 = DB::table('liquidations')
                            ->join('activities', 'liquidations.acitivity_id', '=','activities.id')
                            ->join('organization_academic_years', 'activities.organization_ay_id', '=','organization_academic_years.id')
                            ->join('organizations', 'organization_academic_years.organization_id', '=','organizations.id')
                            ->join('budgets', 'organization_academic_years.id', '=', 'budgets.organization_ay_id')
                            ->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('liquidations.ay_id', $ay_id)
                            ->where('funds.semester', 2)
                            ->count('liquidations.id');

        			    	$response = [ 
        			    					'liquidation_2' => $liquidation_2

        			    				];
        		    		if($c_liquidation_2 != 0)
            			    	{
            			    		return view('reports.print', $response, compact('ids','acad_yr_id'));
            			    	}
            			    	else
            			    	{
            			    		return redirect()->back()->with('alert-danger', 'Sorry. but there is no availaible data in the list.');
            			    	}
        			    }
        		elseif($ids == 11){
        				//Liquidation - 2nd sem
        				
		                            
        			    	$liquidation_2 = DB::table('liquidations')
		                            ->join('activities', 'liquidations.acitivity_id', '=', 'activities.id')
		                            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
		                            ->where('liquidations.acitivity_id', $activity_id)
		                            ->select('liquidations.*','activities.title')
		                            ->get(); 
			
	                            $c_liquidation_2 = DB::table('liquidations')
	                            ->where('liquidations.acitivity_id', $activity_id)
	                            ->count('liquidations.id');

        			    	$response = [ 
        			    					'liquidation_1' => $liquidation_2

        			    				];
        		    		if($c_liquidation_2 != 0)
            			    	{
            			    		return view('reports.print', $response, compact('ids','acad_yr_id'));
            			    	}
            			    	else
            			    	{
            			    		return redirect()->back()->with('alert-danger', 'Sorry. but there is no availaible data in the lists.');
            			    	}
        		
        		
        		
        		}
        		elseif($ids == 12){
        				//Liquidation - 2nd sem
        			    	$liquidation_2 = DB::table('liquidations')
		                            ->join('activities', 'liquidations.acitivity_id', '=', 'activities.id')
		                            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
		                            ->where('liquidations.acitivity_id', $activity_id)
		                            ->select('liquidations.*','activities.title')
		                            ->get(); 
			
	                            $c_liquidation_2 = DB::table('liquidations')
	                            ->where('liquidations.acitivity_id', $activity_id)
	                            ->count('liquidations.id');

        			    	$response = [ 
        			    					'liquidation_2' => $liquidation_2

        			    				];
        		    		if($c_liquidation_2 != 0)
            			    	{
            			    		return view('reports.print', $response, compact('ids','acad_yr_id'));
            			    	}
            			    	else
            			    	{
            			    		return redirect()->back()->with('alert-danger', 'Sorry. but there is no availaible data in the lists.');
            			    	}
        		
        		
        		
        		}

            }


     if(Auth::user()->role_id == 4)
            {
                if($ids == 1)
                        {
                            $officer = \App\Officer::where('user_id', '=', Auth::id())->first();
                            $org_ay_id = $officer->organization_ay_id;

                            $accomplished_activity = DB::table('activities')
                            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                            ->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
                            ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
                            ->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('cash_requests.released', 1)
                            ->where('funds.ay_id', $ay_id)
                            ->where('funds.semester', 1)
                            ->where('activities.approval', 1)
                            ->where('organization_academic_years.id', $org_ay_id)
                            ->select('activities.*')
                            ->get();  

                            $count_accomplished_activity = DB::table('activities')
                            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                            ->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
                            ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
                            ->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('cash_requests.released', 1)
                            ->where('funds.ay_id', $ay_id)
                            ->where('funds.semester', 1)
                            ->where('activities.approval', 1)
                            ->where('organization_academic_years.id', $org_ay_id)
                            ->count('activities.id');

                            $sum_accomplished_activity = DB::table('activities')
                            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                            ->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
                            ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
                            ->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('cash_requests.released', 1)
                            ->where('funds.ay_id', $ay_id)
                            ->where('funds.semester', 1)
                            ->where('activities.approval', 1)
                            ->where('organization_academic_years.id', $org_ay_id)
                            ->sum('activities.buggetTotal');

                            $response = [ 
                                            'accomplished_activity' => $accomplished_activity,
                                            'sum_accomplished_activity' => $sum_accomplished_activity

                                        ];
                            if($count_accomplished_activity != 0)
                            {
                                return view('reports.print', $response, compact('ids','acad_yr_id'));
                            }
                            else
                            {
                                return redirect()->back()->with('alert-danger', 'Sorry. but there is no availaible data in the list.');
                            }
                        }

                if($ids == 2)
                        {
                            $officer = \App\Officer::where('user_id', '=', Auth::id())->first();
                            $org_ay_id = $officer->organization_ay_id;

                            $accomplished_activity_2 = DB::table('activities')
                            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                            ->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
                            ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
                            ->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('cash_requests.released', 1)
                            ->where('funds.ay_id', $ay_id)
                            ->where('funds.semester', 2)
                            ->where('activities.approval', 1)
                            ->where('organization_academic_years.id', $org_ay_id)
                            ->select('activities.*')
                            ->get();  

                            $count_accomplished_activity_2 = DB::table('activities')
                            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                            ->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
                            ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
                            ->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('cash_requests.released', 1)
                            ->where('funds.ay_id', $ay_id)
                            ->where('funds.semester', 2)
                            ->where('activities.approval', 1)
                            ->where('organization_academic_years.id', $org_ay_id)
                            ->count('activities.id');

                            $sum_accomplished_activity_2 = DB::table('activities')
                            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                            ->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
                            ->join('budgets', 'cash_requests.budget_id', '=', 'budgets.id')
                            ->join('funds', 'budgets.fund_id', '=', 'funds.id')
                            ->where('cash_requests.released', 1)
                            ->where('funds.ay_id', $ay_id)
                            ->where('funds.semester', 2)
                            ->where('activities.approval', 1)
                            ->where('organization_academic_years.id', $org_ay_id)
                            ->sum('activities.buggetTotal');

                            $response = [ 
                                            'accomplished_activity_2' => $accomplished_activity_2,
                                            'sum_accomplished_activity_2' => $sum_accomplished_activity_2

                                        ];
                            if($count_accomplished_activity_2 != 0)
                            {
                                return view('reports.print', $response, compact('ids','acad_yr_id'));
                            }
                            else
                            {
                                return redirect()->back()->with('alert-danger', 'Sorry. but there is no availaible data in the list.');
                            }
                        }

                if($ids == 3)
                        {
                            $officer = \App\Officer::where('user_id', '=', Auth::id())->first();
                            $org_ay_id = $officer->organization_ay_id;

                            $acad_year = DB::table('academic_years')
                            ->join('organization_academic_years', 'organization_academic_years.ay_id', '=', 'academic_years.id')
                            ->where('organization_academic_years.id', $org_ay_id)
                            ->select('academic_years.*')
                            ->get(); 
                            
                            $officer_liquidation = DB::table('liquidations')
                            ->join('activities', 'liquidations.acitivity_id', '=', 'activities.id')
                            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                            ->where('liquidations.acitivity_id', $activity_id)
                            ->select('liquidations.*','activities.title')
                            ->get(); 

                            $count_officer_liquidation = DB::table('liquidations')
                            ->where('liquidations.acitivity_id', $activity_id)
                            ->count('liquidations.id');
                            
                            $liquidation_sum= DB::table('liquidations')
                            ->join('activities', 'liquidations.acitivity_id', '=', 'activities.id')
                            ->where('liquidations.acitivity_id', $activity_id)
                            ->select('liquidations.*','activities.title')
                            ->sum('amount'); 

                            $response = [ 
                                            'officer_liquidation' => $officer_liquidation

                                        ];
                            if($count_officer_liquidation != 0)
                            {
                                return view('reports.print', $response, compact('ids','acad_yr_id', 'liquidation_sum'));
                            }
                            else
                            {
                                return redirect()->back()->with('alert-danger', 'Sorry. but there is no availaible data in the list.');
                            }
                        }
            }
}
}
