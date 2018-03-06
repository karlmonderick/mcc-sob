<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Activity;
use App\Funds;
use App\Budget;
use App\User;
use App\cash_request;
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

class ActivityController extends Controller
{
    public function index()
    {
        //if ($id == null){
            $activity = Activity::all();
            $response = [
                'activity' => $activity
            ];
            $AcademicYear = AcademicYear::all()->sortByDesc();
            return view('activities.index',$response, compact('orAcademicYearg'));
            //return response()->json($response, 200);
        // }$users = DB::table('users')->where('votes', '=', 100)->get();
        // else{
        //     return $this->show($id);
        // }
    }

    public function create()
    {
        $user_id = Auth::id();
        
        $organization_ay_id_user = DB::table('officers')
        ->join('users', 'officers.user_id', '=', 'users.id')
        ->select('officers.*')
        ->where('users.id', $user_id)
        ->first();

        $officers = DB::table('officers')
        ->join('users', 'officers.user_id', '=', 'users.id')
        ->select('users.*', 'officers.id as officer_id')
        ->where('organization_ay_id', $organization_ay_id_user->organization_ay_id)
        ->get();

        return view('activities.create', compact('officers'));
    }

    public function store(Request $request)
    {

        $ay = AcademicYear::where('ay_from', '=', $request->input('year'))->first();
        $ay_id = $ay->id;
        $current_date = date('Y'.'-'.'m'.'-'.'d');

            $activity = new Activity;
            
             $activity->title = $request->input('title');
             $activity->nature = $request->input('nature');
             $activity->date = $request->input('date');
             $activity->endDate = $request->input('endDate');
     
             $activity->venue = $request->input('venue');
             $activity->participants = $request->input('participants');
             $activity->expectedAttendees = $request->input('expectedAttendees');

             $budgetDescription = [
                     'Description' => $request->input('budgetDescription'),
                     'Cost' => $request->input('budgetCost'),
                     'Quantity' => $request->input('budgetQuantity')
             ];
             $activity->budgetDescription = json_encode($budgetDescription);
             $activity->buggetTotal = $request->input('buggetTotal');
             $activity->approval = $request->input('approval');
             $activity->review_id = $request->input('approval2');
            //  $activity->notify = 0;
            //  $activity->notify2 = 0;
            //  $activity->notify3 = 0;
            //  $activity->released = 0;
            //  $activity->released_by_igp = 0;
             $user_id = Auth::id();
             
             $organization_ay_id_user = DB::table('officers')
             ->join('users', 'officers.user_id', '=', 'users.id')
             ->select('officers.*')
             ->where('users.id', $user_id)
             ->first();
             

             $activity->requestedBy = Auth::id();
             $activity->organization_ay_id = $organization_ay_id_user->organization_ay_id;

             if($activity->date < $current_date)
            	{
            		return redirect()->back()->withInput()->with('alert-danger', 'Oooops sorry. It seems you are trying a date that is already in the past.');
            	}
	        elseif($request->input('date') > $request->input('endDate'))
		        {
		            return redirect()->back()->withInput()->with('alert-danger', 'Date Error!');
		        }        
	        else
		        {
		            $activity->save(); 
		        	
                    return redirect()->route('activities.show', $ay_id)->with('alert-success', 'Data has been saved');
                    // return response()->json($activity);
		        }

        
    }

    public function show($id)
    {

         if(Auth::user()->role_id == 4){
            $officer = \App\Officer::where('user_id', '=', Auth::id())->first();
            $org_ay_id = $officer->organization_ay_id;
            $activity = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->select('activities.*', 'organizations.name', 'organization_academic_years.ay_id')
            ->where('ay_id', $id)
            ->where('organization_ay_id', $org_ay_id)
            ->get();

            $act_pending = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->select('activities.*','organization_academic_years.ay_id')
            ->where('ay_id', $id)
            ->where('activities.approval', 2)
            ->where('organization_ay_id', $org_ay_id)
            ->get();

            $act_pending_modal = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->select('activities.*','organization_academic_years.ay_id')
            ->where('ay_id', $id)
            ->where('activities.approval', 2)
            ->where('organization_ay_id', $org_ay_id)
            ->get();

            $act_app = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->select('activities.*', 'organizations.name', 'organization_academic_years.ay_id')
            ->where('ay_id', $id)
            ->where('activities.approval', 1)
            ->where('organization_ay_id', $org_ay_id)
            ->get();

            $cash_code = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
            ->select('cash_requests.*','activities.*')
            ->where('ay_id', $id)
            ->where('activities.approval', 1)
            ->where('cash_requests.released', 0)
            ->where('activities.organization_ay_id', $org_ay_id)
            ->get();

            $released = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
            ->where('organization_academic_years.ay_id', $id)
            ->where('activities.organization_ay_id', $org_ay_id)
            ->where('cash_requests.released', 0)
            ->count('cash_requests.id');            

            $act_dis_app = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->select('activities.*', 'organizations.name', 'organization_academic_years.ay_id')
            ->where('ay_id', $id)
            ->where('activities.approval', 0)
            ->where('organization_ay_id', $org_ay_id)
            ->get();

            $act_count_pen = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->where('ay_id', $id)
            ->where('activities.approval', 2)
            ->where('organization_ay_id', $org_ay_id)
            ->count('activities.approval');

            $act_count_app = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->where('ay_id', $id)
            ->where('activities.approval', 1)
            ->where('organization_ay_id', $org_ay_id)
            ->count('activities.approval');

            $act_count_dis = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->where('ay_id', $id)
            ->where('activities.approval', 0)
            ->where('organization_ay_id', $org_ay_id)
            ->count('activities.approval');

            $c_requests = DB::table('activities')
            ->join('cash_requests', 'activities.id', '=','cash_requests.activity_id')
            ->select('activities.*')
            ->get();
            //$activity->equipmentRequest = json_decode($activity->equipmentRequest,JSON_UNESCAPED_SLASHES);
        }
        else{
            $activity = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->select('activities.*', 'organizations.name', 'organization_academic_years.ay_id')
            ->where('ay_id', $id)
            ->get();

             
        $activ = DB::table('activities')
        ->join('users', 'activities.requestedBy', '=', 'users.id')
        ->join('organizations', 'activities.organization_ay_id', '=', 'organizations.id')
        ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id' )
        ->select('users.remember_token', 'activities.*', 'organizations.name', 'organization_academic_years.organization_id')
        ->where('organization_academic_years.ay_id', $id)
        ->where('activities.approval', 1)

        ->get();
        
        }
        $response = [ 
            'activity' => $activity
        ];
         $count_activity = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->where('ay_id', $id)
            ->where('activities.review_id', 1)
            ->count('activities.review_id');

        $count_approve = DB::table('activities')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->where('ay_id', $id)
        ->where('activities.approval', 1)
        ->count('activities.review_id');

        $count_disapprove = DB::table('activities')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->where('ay_id', $id)
        ->where('activities.approval', 0)
        ->count('activities.review_id');

        $approve_activity = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->select('activities.*')
            ->where('ay_id', $id)
            ->where('activities.approval', 1)
            ->get()->sortByDesc('updated_at');

        $disapprove_activity = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->select('activities.*')
            ->where('ay_id', $id)
            ->where('activities.approval', 0)
            ->get()->sortByDesc('updated_at');

        $rev_activity = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->select('activities.*', 'organizations.name as org_name')
            ->where('ay_id', $id)
            ->where('activities.review_id', 1)
            ->get()->sortByDesc('updated_at');

        $not_rev_activity = DB::table('activities')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->select('activities.*', 'organizations.name as org_name')
        ->where('ay_id', $id)
        ->where('activities.review_id', 0)
        ->get()->sortByDesc('updated_at');

        $cal_activities = DB::table('calendar_activities')
        ->join('organization_academic_years', 'calendar_activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->where('calendar_activities.ay_id', $id)
        ->select('calendar_activities.*','organizations.name as org_name')
        ->orderby('date')
        ->get();
        
        $organizers= DB::table('organization_academic_years')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->where('organization_academic_years.ay_id', $id)
        ->select('organization_academic_years.*','organizations.name as org_name')
        ->get()->sortBy('org_name');

        $not_approve = DB::table('activities')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->select('activities.*')
        ->where('ay_id', $id)
        ->where('activities.approval', 2)
        ->get()->sortByDesc('created_at');

         $count_activity_not = DB::table('activities')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->where('organization_academic_years.ay_id', $id)
        ->where('activities.review_id', 0)
        ->count('activities.review_id');

        $count_not_approve = DB::table('activities')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->where('ay_id', $id)
        ->where('activities.approval', 2)
        ->count('activities.approval');

        $activiis = DB::table('activities')
        ->select('activities.*')
        ->get();
        
         $ay = AcademicYear::find($id);
         $acad_years = AcademicYear::all();
        return view('activities.index', $response, compact('ay','cal_activities','c_requests','activiis','act_count_pen','released','cash_code','act_count_app','act_count_dis', 'act_pending','act_pending_modal','act_app','act_dis_app', 'organizers', 'activ','count_disapprove','approve_activity','disapprove_activity','count_activity','count_approve', 'not_approve', 'count_activity_not', 'count_not_approve', 'acad_years','rev_activity', 'not_rev_activity'));
      //  return response()->json($approve_activity);
    }

    public function edit($id)
    {
        $activity = Activity::findOrFail($id);
        return view('activities.edit', compact('activity'));
    }

    public function update(Request $request, $id)
     {
        $activity = Activity::findOrFail($id);
        $ay = AcademicYear::where('ay_from', '=', $request->input('year'))->first();
        $ay_id = $ay->id;
        $current_date = date('Y'.'-'.'m'.'-'.'d');
    
            
             $activity->title = $request->input('title');
             $activity->nature = $request->input('nature');
             $activity->date = $request->input('date');
             $activity->endDate = $request->input('endDate');
     
             $activity->venue = $request->input('venue');
             $activity->participants = $request->input('participants');
             $activity->expectedAttendees = $request->input('expectedAttendees');
             
             if($request->input('personInCharge') == TRUE)
                 {
                    
                    $activity->personInCharge = json_encode($request->input('personInCharge'));        
                 }
            else
            {
                $act = 0;
            }
            
             if($request->input('budgetDescription') == TRUE && $request->input('budgetCost') == TRUE && $request->input('budgetQuantity') == TRUE)
                {
                 $budgetDescription = [
                         'Description' => $request->input('budgetDescription'),
                         'Cost' => $request->input('budgetCost'),
                         'Quantity' => $request->input('budgetQuantity')
                 ];
                 $activity->budgetDescription = json_encode($budgetDescription);
                 
                 $activity->buggetTotal = $request->input('buggetTotal');
                }
            else
                {
                  $activity->budgetDescription =  $activity->budgetDescription;  
                }


     
             $user_id = Auth::id();
             
             $organization_ay_id_user = DB::table('officers')
             ->join('users', 'officers.user_id', '=', 'users.id')
             ->select('officers.*')
             ->where('users.id', $user_id)
             ->first();
             

             $activity->requestedBy = $organization_ay_id_user->user_id;
             $activity->organization_ay_id = $organization_ay_id_user->organization_ay_id;
             
             
           // return response()->json($activity->personInCharge);

             if($activity->date < $current_date)
            	{
            		return redirect()->route('activities.show', $ay_id)->with('alert-danger', 'Oooops sorry. Failed to submit your request due to the out of date of the Activity.');
            	}
	        elseif($request->input('date') > $request->input('endDate'))
		        {
		            return redirect()->back()->with('alert-danger', 'Date Error!');
		        }        
	        else
		        {
		            $activity->save(); 
            // return view('activities.index', 1);
             		return redirect()->route('activities.show', $ay_id)->with('alert-success', 'Data has been updated!');
		        }
 }

     public function destroy($id)
     {
         $activity = Activity::find($id)->delete();
         return redirect()->back()->with('alert-success', 'Data has been deleted!');
         //return response()->json(['message'=>'Organization deleted']);
     }

     public function approval(Request $request)
     {
        $activity =  Activity::find($request->activityId);
        $approveVAl=1;

        $activity->approval=$approveVAl;
        $activity->notify2 = 0;
        $activity->notify = 0;
        $activity->save();
        return redirect()->back()->with('alert-success', 'You approved this request!');
       // return redirect()->route('activities.index');

     }

      public function disapproval(Request $request)
     {
        $activity =  Activity::find($request->activityId2);
        $disapproveVAl=0;

        $activity->notify = 0;
        $activity->notify2 = 0;
        $activity->approval=$disapproveVAl;
        $activity->save();
        return redirect()->back()->with('alert-danger', 'You disapproved this request!');

     }

    // public function disapproval3(Request $request)
  //   {
     //   $activity =  Activity::find($request->activityId2);
    ///    $disapproveVAl=0;


     //   $activity->approval1=$disapproveVAl;
     //   $activity->approval2=$disapproveVAl;
     //  $activity->approval3=$disapproveVAl;
     //   $activity->save();
      //  return redirect()->back();
       // return redirect()->route('activities.index');
    // }

   //  public function approval3(Request $request)
   //  {
     //   $activity =  Activity::find($request->activityId);
      //  $disapproveVAl=1;

        //$activity->approval3=$disapproveVAl;
       // $activity->save();
      //  return redirect()->back();
    // }
//
    public function print($id)
    {
        $act = DB::table('activities')
        ->join('organization_academic_years', 'activities.organization_ay_id','=','organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id','=','organizations.id')
        ->join('cash_requests', 'activities.id', '=', 'cash_requests.activity_id')
        ->join('budgets','cash_requests.budget_id','=','budgets.id')
        ->join('funds','budgets.fund_id', '=','funds.id')
        ->where('activities.id', $id)
        ->select('activities.*', 'cash_requests.verification_code','organizations.name','funds.name as f_name')
        ->get();

        $ay = DB::table('activities')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('academic_years', 'organization_academic_years.ay_id', '=', 'academic_years.id')
        ->select('academic_years.id')
        ->where('activities.id', $id)
        ->get();

        $igp = User::where('users.role_id', 2)->first();

        $response = 
        [
            'act' => $act,
            'ay' => $ay,
            'igp' => $igp
        ];

//      return response()->json($igp);
       return view('activities.print' ,$response);
    }

   public function add_content(Request $request){
        $act_id = $request->input('activity_id');

        $notify = new Notifications;
        $notify->user_id = $request->input('user_id');
        $notify->activity_id = $request->input('activity_id');
        $notify->comment = $request->input('comment');

        $review_id = Activity::find($request->activity_id);
        $review_id->review_id = 1;
        $review_id->notify2 = 0;
        $review_id->save();


        //$review_id = Activity::whereIn('Activity.id', $act_id)
       //->update(['accredited' => 1]);
        //$review_id->save();
        $notify->save();
      // return response()->json($review_id);
       return redirect()->back();
    }

    public function view_content($id){
        $activity = DB::table('activities')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->select('activities.*', 'organizations.name', 'organization_academic_years.ay_id')
        ->where('activities.id', $id)
        ->get();

        $notify = DB::table('notifications')
        ->join('activities', 'notifications.activity_id', '=', 'activities.id')
        ->join('users', 'notifications.user_id', 'users.id')
        ->select('users.*','notifications.*')
        ->where('notifications.activity_id', $id)
        ->orderby('notifications.id', 'asc')
        ->get();

        $response = [ 
            'activity' => $activity,
            'notify' => $notify
        ];

        if(Auth::user()->role_id == 1)
        {
            $act = Activity::find($id);
            $act->notify = 1;
            $act->save();
       }
       elseif(Auth::user()->role_id == 3)
       {
           $act = Activity::find($id);
            $act->notify3 = 1;
            $act->save();
       }
       else
       {
            if($id == 0)
            {
                $act = Activity::all()
                ->update(['notify2' => 1]);
            }
            else
            {
                $act = Activity::find($id);
                $act->notify2 = 1;
                $act->save();

                $cash_req = cash_request::where('cash_requests.activity_id', $id)
                ->update(['notify_officer' => 1]);
            }
       }
        $act = Activity::find($id);
        $ay = DB::table('activities')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('academic_years', 'organization_academic_years.ay_id', '=', 'academic_years.id')
        ->select('academic_years.id')
        ->where('activities.id', $id)
        ->get();

        //return response()->json($ay);
        return view('activities.show', $response, compact('ay', 'act','notify'));
    }

}
