<?php

namespace App\Http\Controllers;

use Carbon\carbon;
use App\Notifications;
use App\User;
use App\Liquidation;
use App\AcademicYear;
use Auth;
use App\cash_request;
use App\OrganizationAcademicYear;
use App\Officer;
use App\Activity;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

                $activity = DB::table('activities')
                ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                ->join('officers', 'organization_academic_years.id', '=', 'officers.organization_ay_id')
                ->where('officers.user_id', Auth::user()->id)
                ->where('organization_academic_years.ay_id', $id)
                ->select('activities.*', 'organizations.name', 'organization_academic_years.ay_id')
                ->get()->sortByDesc('activities.updated_at');

                $cash_requests = DB::table('cash_requests')
                ->join('activities', 'cash_requests.activity_id','=','activities.id')
                ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                ->join('officers', 'organization_academic_years.id', '=', 'officers.organization_ay_id')
                ->join('academic_years', 'organization_academic_years.ay_id', '=', 'academic_years.id')
                ->where('officers.user_id', Auth::user()->id)
                ->where('organization_academic_years.ay_id', $id)
                ->select('cash_requests.*' ,'activities.id as act_id')
                ->get();

                $liquidation = DB::table('notifications')
                ->join('liquidations', 'notifications.liquidation_id','=', 'liquidations.id')
                ->join('activities', 'liquidations.acitivity_id', '=', 'activities.id')
                ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                ->join('officers', 'organization_academic_years.id', '=', 'officers.organization_ay_id')
                ->where('officers.user_id', Auth::user()->id)
                ->where('organization_academic_years.ay_id', $id)
                ->select('notifications.*', 'liquidations.*')
                ->get();

                $cashhs = DB::table('cash_requests')
                ->join('activities', 'cash_requests.activity_id','=','activities.id')
                ->join('organization_academic_years', 'activities.organization_ay_id','=', 'organization_academic_years.id')
                ->join('organizations', 'organization_academic_years.organization_id','=', 'organizations.id')
                ->select('cash_requests.*','organizations.name')
                ->where('organization_academic_years.ay_id', $id)
                ->get();

                $activitiesss = DB::table('activities')
                ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                ->select('activities.*', 'organizations.name')
                ->where('organization_academic_years.ay_id', $id)
                ->get()->sortByDesc('activities.updated_at');

                $organizationsss = DB::table('organizations')
                ->join('organization_academic_years','organizations.id', '=', 'organization_academic_years.organization_id')
                ->join('academic_years', 'organization_academic_years.ay_id', '=', 'academic_years.id')
                ->select('organizations.*', 'organization_academic_years.*', 'academic_years.id')
                ->where('organization_academic_years.accredited', 1)
                ->where('organization_academic_years.ay_id', $id)
                ->get();

                $get_reviewed_acts = DB::table('organizations')
                ->join('organization_academic_years','organizations.id', '=', 'organization_academic_years.organization_id')
                ->join('academic_years', 'organization_academic_years.ay_id', '=', 'academic_years.id')
                ->join('activities', 'organization_academic_years.id', '=', 'activities.organization_ay_id')
                ->select('organizations.*', 'organization_academic_years.*', 'academic_years.id','activities.updated_at as act_updated_at')
                ->where('organization_academic_years.ay_id', $id)
                ->where('activities.review_id', 1)
                ->get();

                $get_yr = AcademicYear::where('academic_years.id', $id)->first();

                $acad_year = DB::table('academic_years')
                ->select('academic_years.*')
                ->get();

                $osca = User::where('users.role_id', 1)->first();
                $sas = User::where('users.role_id', 3)->first();
                $igp = User::where('users.role_id', 2)->first();


                $all_act = DB::table('activities')->where('activities.notify2', 0)->update(['activities.notify2' => 1]);
                $cash_req = cash_request::where('cash_requests.notify_officer', 0)->update(['notify_officer' => 1]);
                $notifications = Notifications::where('notifications.notify_officers', 0)->update(['notify_officers' => 1]);
                
                $liquidation_listss = DB::table('liquidations')
                ->join('officers','liquidations.submitted_by_user_id', '=','officers.user_id')
                ->join('organization_academic_years','officers.organization_ay_id', '=', 'organization_academic_years.id')
                ->join('organizations','organization_academic_years.organization_id','=', 'organizations.id')
                ->where('organization_academic_years.ay_id', $id)
                ->select('liquidations.*', 'organizations.name')
                ->get()->sortByDesc('liquidations.created_at');


                $activitiess = DB::table('activities')
                ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                ->where('organization_academic_years.ay_id', $id)
                ->select('activities.*', 'organizations.name')
                ->get()->sortByDesc('activities.updated_at');

                $response = [
                    'activity' => $activity,
                    'acad_year' => $acad_year,
                    'osca' => $osca,
                    'sas' => $sas,
                    'cash_requests' => $cash_requests,
                    'igp' => $igp,
                    'liquidation' => $liquidation,
                    'get_yr' => $get_yr,
                    'liquidation_listss' => $liquidation_listss,
                    'activitiess' => $activitiess,
                    'cashhs' => $cashhs,
                    'activitiesss' => $activitiesss,
                    'organizationsss' => $organizationsss,
                    'get_reviewed_acts' => $get_reviewed_acts
                             ];
       //return response()->json($liquidation);
        return view('notifications.show', $response);
    }

    public function notifications(Request $request)
    {
        $u_id = Auth::user()->id;
        $acad_year = DB::table('academic_years')
        ->select('academic_years.*')
        ->get();
        if(Auth::user()->role_id == 3){
        $all_act = DB::table('activities')->where('activities.notify3', 0)->update(['activities.notify3' => 1]);
         }

         if(Auth::user()->role_id == 1)
            {
                $liquidations = Liquidation::where('liquidations.notify_osca', 0)->update(['notify_osca' => 1]);

                $liquidation_listss = DB::table('liquidations')
                ->join('officers','liquidations.submitted_by_user_id', '=','officers.user_id')
                ->join('organization_academic_years','officers.organization_ay_id', '=', 'organization_academic_years.id')
                ->join('organizations','organization_academic_years.organization_id','=', 'organizations.id')
                ->select('liquidations.*', 'organizations.name')
                ->get()->sortByDesc('liquidations.created_at');

                $activitiess = DB::table('activities')
                ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                ->select('activities.*', 'organizations.name')
                ->get()->sortByDesc('activities.updated_at');

                $all_act = DB::table('activities')->where('activities.notify', 0)->update(['activities.notify' => 1]);
                $liquidations = Liquidation::where('liquidations.notify_sas', 0)->update(['notify_sas' => 1]);
               
                $response = [
                             'liquidation_listss' => $liquidation_listss,
                             'acad_year' => $acad_year,
                             'activitiess' => $activitiess
                            ];
                return view('notifications.index', $response);
            }

        if(Auth::user()->role_id == 1)
            {
                
                $all_act = DB::table('activities')->where('activities.notify', 0)->update(['activities.notify' => 1]);
                $all_act = DB::table('activities')->where('activities.notify', 0)->update(['activities.notify' => 1]);
                $all_act = DB::table('activities')->where('activities.notify', 0)->update(['activities.notify' => 1]);
               
                
                return view('notifications.index');
            }

        if(Auth::user()->role_id == 4)
        {
                
                $activity = DB::table('activities')
                ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                ->join('officers', 'organization_academic_years.id', '=', 'officers.organization_ay_id')
                ->where('officers.user_id', Auth::user()->id)
                ->select('activities.*')
                ->get()->sortByDesc('activities.updated_at');

                $cash_requests = DB::table('cash_requests')
                ->join('activities', 'cash_requests.activity_id','=','activities.id')
                ->join('officers', 'activities.organization_ay_id', '=', 'officers.organization_ay_id')
                ->where('officers.user_id', Auth::user()->id)
                ->select('cash_requests.*' ,'activities.id as act_id')
                ->get();

                $liquidation = DB::table('notifications')
                ->join('liquidations', 'notifications.liquidation_id','=', 'liquidations.id')
                ->join('activities', 'liquidations.acitivity_id', '=', 'activities.id')
                ->join('officers', 'activities.organization_ay_id', '=', 'officers.organization_ay_id')
                ->where('officers.user_id', Auth::user()->id)
                ->select('notifications.*', 'liquidations.*')
                ->get();

                $osca = User::where('users.role_id', 1)->first();
                $sas = User::where('users.role_id', 3)->first();
                $igp = User::where('users.role_id', 2)->first();

                $all_act = DB::table('activities')->where('activities.notify2', 0)->update(['activities.notify2' => 1]);
                $cash_req = cash_request::where('cash_requests.notify_officer', 0)->update(['notify_officer' => 1]);
                $notifications = Notifications::where('notifications.notify_officers', 0)->update(['notify_officers' => 1]);
                $response = [
                    'activity' => $activity,
                    'acad_year' => $acad_year,
                    'osca' => $osca,
                    'sas' => $sas,
                    'cash_requests' => $cash_requests,
                    'igp' => $igp,
                    'liquidation' => $liquidation
                             ];
       //return response()->json($activity);
        return view('notifications.index', $response);
        }
        if(Auth::user()->role_id == 3)
        {
            
                $liquidation_listss = DB::table('liquidations')
                ->join('officers','liquidations.submitted_by_user_id', '=','officers.user_id')
                ->join('organization_academic_years','officers.organization_ay_id', '=', 'organization_academic_years.id')
                ->join('organizations','organization_academic_years.organization_id','=', 'organizations.id')
                ->select('liquidations.*', 'organizations.name')
                ->get()->sortByDesc('liquidations.created_at');

                $activitiess = DB::table('activities')
                    ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                    ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                    ->select('activities.*', 'organizations.name')
                    ->get()->sortByDesc('activities.updated_at');

                $organizationsss = DB::table('organizations')
                ->join('organization_academic_years','organizations.id', '=', 'organization_academic_years.organization_id')
                ->join('academic_years', 'organization_academic_years.ay_id', '=', 'academic_years.id')
                ->select('organizations.*', 'organization_academic_years.*', 'academic_years.id')
                ->where('organization_academic_years.accredited', 1)
                ->get();


                $all_act = DB::table('activities')->where('activities.notify', 0)->update(['activities.notify' => 1]);
                $liquidations = Liquidation::where('liquidations.notify_sas', 0)->update(['notify_sas' => 1]);
                $organization_academic_years = OrganizationAcademicYear::where('organization_academic_years.notify_sas', 0)->update(['notify_sas' => 1]);
               
                $response = [
                             'liquidation_listss' => $liquidation_listss,
                             'organizationsss' => $organizationsss,
                             'acad_year' => $acad_year,
                             'activitiess' => $activitiess
                            ];
       //return response()->json($activity);
        return view('notifications.index', $response);
        }
        if(Auth::user()->role_id == 2)
        {
                $cashhs = DB::table('cash_requests')
                ->join('activities', 'cash_requests.activity_id','=','activities.id')
                ->join('organization_academic_years', 'activities.organization_ay_id','=', 'organization_academic_years.id')
                ->join('organizations', 'organization_academic_years.organization_id','=', 'organizations.id')
                ->select('cash_requests.*','organizations.name')
                ->get();

                $activitiesss = DB::table('activities')
                ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                ->select('activities.*', 'organizations.name')
                ->get()->sortByDesc('activities.updated_at');

                $organizationsss = DB::table('organizations')
                ->join('organization_academic_years','organizations.id', '=', 'organization_academic_years.organization_id')
                ->join('academic_years', 'organization_academic_years.ay_id', '=', 'academic_years.id')
                ->select('organizations.*', 'organization_academic_years.*', 'academic_years.id')
                ->where('organization_academic_years.accredited', 1)
                ->get();

                $get_reviewed_acts = DB::table('organizations')
                ->join('organization_academic_years','organizations.id', '=', 'organization_academic_years.organization_id')
                ->join('academic_years', 'organization_academic_years.ay_id', '=', 'academic_years.id')
                ->join('activities', 'organization_academic_years.id', '=', 'activities.organization_ay_id')
                ->select('organizations.*', 'organization_academic_years.*', 'academic_years.id','activities.updated_at as act_updated_at')
                ->where('activities.review_id', 1)
                ->get();

                $osca = User::where('users.role_id', 1)->first();
                $sas = User::where('users.role_id', 3)->first();
                $igp = User::where('users.role_id', 2)->first();
                 $cash = cash_request::where('cash_requests.notify_igp', 0)->update(['notify_igp' => 1]);
                $all_act = DB::table('activities')->where('activities.notify', 0)->update(['activities.notify' => 1]);
                $organization_academic_years = OrganizationAcademicYear::where('organization_academic_years.notify', 0)->update(['notify' => 1]);

                $response = [
            'acad_year' => $acad_year,
            'osca' => $osca,
            'sas' => $sas,
            'cashhs' => $cashhs,
            'activitiesss' => $activitiesss,
            'organizationsss' => $organizationsss,
            'get_reviewed_acts' => $get_reviewed_acts
        ];
       //return response()->json($activity);
        return view('notifications.index', $response);
        }
        


    }

    public function rog_notify(Request $request)
    {
        scandir(directory);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       
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

    public function add_content2(Request $request){
        $id = $request->input('id');

        if(Auth::user()->role_id == 3)
            {
                $notify = new Notifications;
                $notify->comment = $request->input('comment');
                $notify->liquidation_id = $id;
                $notify->reviewed_by_sas = 1; 
                $notify->review_by_user_id = Auth::user()->id;

                $liquidation = Liquidation::find($id);
                $liquidation->reviewed_sas = 1; 
                $liquidation->save();
                $notify->save();
              // return response()->json($liquidation);
                return redirect()->back();
            }
        elseif(Auth::user()->role_id == 1)
            {
               $notify = new Notifications;
                $notify->comment = $request->input('comment');
                $notify->liquidation_id = $id;
                $notify->review_by_user_id = Auth::user()->id;

                $liquidation = Liquidation::find($id);
                $liquidation->reviewed_osca = 1; 
                $liquidation->save();
                $notify->save();
              // return response()->json($liquidation);
                return redirect()->back(); 
            }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
}
}

