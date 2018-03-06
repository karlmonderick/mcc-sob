<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use App\Notifications;
use App\Liquidation;
use App\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class LiquidationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(){

        if(Input::hasFile('file')){

            echo 'Uploaded';
            $file = Input::file('file');
            $file->move('uploads', $file->getClientOriginalName());
            echo '';
        }

    }

    public function index()
    {
        $liquidation = DB::table('liquidations')
        ->join('activities', 'liquidations.acitivity_id', '=' ,'activities.id')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('officers', 'organization_academic_years.id', '=', 'officers.organization_ay_id')
        ->join('users', 'liquidations.approved_by_user_id', '=', 'users.id')
        ->where('officers.user_id', Auth::user()->id)
        ->select('users.*','liquidations.*','activities.title')
        ->get();

        $liquidation_modal = DB::table('liquidations')
        ->join('activities', 'liquidations.acitivity_id', '=' ,'activities.id')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('officers', 'organization_academic_years.id', '=', 'officers.organization_ay_id')
        ->join('users', 'liquidations.approved_by_user_id', '=', 'users.id')
        ->where('officers.user_id', Auth::user()->id)
        ->select('users.*','liquidations.*','activities.title')
        ->get();

        $liquidation_modal_view = DB::table('liquidations')
        ->join('activities', 'liquidations.acitivity_id', '=' ,'activities.id')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('officers', 'organization_academic_years.id', '=', 'officers.organization_ay_id')
        ->join('users', 'liquidations.submitted_by_user_id', '=', 'users.id')
        ->select('users.*','liquidations.*','activities.title')
        ->get();

         $notify = DB::table('notifications')
        ->join('users','notifications.review_by_user_id','=','users.id')
        ->join('liquidations','notifications.liquidation_id' ,'=' ,'liquidations.id')
        ->select('users.*','notifications.*')
        ->get()->sortByDesc('created_at');

        $user = Auth::user()->id;
        $act = DB::table('activities')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->join('officers', 'organization_academic_years.id', 'officers.organization_ay_id')
        ->where('officers.user_id', Auth::user()->id)
        ->select('activities.*')
        ->get();

        $activity = Activity::all();

        $response = [ 'liquidation' => $liquidation,
                      'act' => $act,
                      'activity' => $activity,
                      'liquidation_modal' => $liquidation_modal,
                      'liquidation_modal_view' => $liquidation_modal_view,
                      'notify' => $notify
                    ];
        return view('liquidations.index', $response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user()->id;
        $act = DB::table('activities')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('officers', 'organization_academic_years.id', 'officers.organization_ay_id')
        ->where('officers.user_id', $user)
        ->select('activities.*')
        ->get();

        $response = 
                    [
                        'act' => $act
                    ];
        return view('liquidations.create',$response);
        //return response()->json($act);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);
        
        $approve_by = User::where('users.role_id', 3)->first();
        $user_id = $approve_by->id;

        $liquidation = new liquidation;
        if(Input::hasFile('file')){

        $file = Input::file('file');
        $filename = $file->getClientOriginalName();
        $file->move('uploads', $file->getClientOriginalName());
        $liquidation->picture = $filename;
        }
        $liquidation->item = $request->input('item');
        $liquidation->amount = $request->input('amount');
        $liquidation->official_reciepts = $request->input('receipt');
        $liquidation->acitivity_id = $request->input('act_id');
        $liquidation->submitted_by_user_id = Auth::user()->id;
        $liquidation->approved_by_user_id = $user_id;
        $liquidation->approval = 2;
        $liquidation->reviewed_sas = 2;
        $liquidation->reviewed_osca = 2;
        $liquidation->notify_sas = 0;
        $liquidation->notify_osca = 0;
        $liquidation->notify_officer = 0;
        $liquidation->save();
        return redirect()->back()->with('alert-success', 'New data has been added.');
        //return response()->json($liquidation);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Liquidation  $liquidation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user()->id;
        $activity = Activity::all();
        $liquidation = DB::table('liquidations')
        ->join('activities', 'liquidations.acitivity_id', '=', 'activities.id')
        ->join('users', 'liquidations.submitted_by_user_id', '=','users.id')
        ->where('liquidations.acitivity_id', $id)
        ->select('activities.*', 'users.*','liquidations.*')
        ->get();

        $notify = DB::table('notifications')
        ->join('users','notifications.review_by_user_id','=','users.id')
        ->join('liquidations','notifications.liquidation_id' ,'=' ,'liquidations.id')
        ->where('liquidations.id', $id)
        ->select('users.*','notifications.*')
        ->get()->sortByDesc('created_at');

        if(Auth::user()->role_id == 3)
            {
            $notif = Liquidation::where('id',$id)->first();
            $notif->notify_sas = 1;
            $notif->save();
            }

        if(Auth::user()->role_id == 1)
            {
            $notif = Liquidation::where('id',$id)->first();
            $notif->notify_osca = 1;
            $notif->save();
            }

        if(Auth::user()->role_id == 4)
            {
            $notif = DB::table('notifications')
            ->join('liquidations', 'notifications.liquidation_id', '=', 'liquidations.id')
            ->where('liquidations.acitivity_id',$id)->update(['notifications.notify_officers' => 1]);

            $notif = Liquidation::where('acitivity_id',$id)->first();
            $notif->notify_officer = 1;
            $notif->save();
            }

        $response = 
                    [
                        'liquidation' => $liquidation,
                        'notify' => $notify
                    ];
        return view('liquidations.show',$response);
       // return response()->json($notif);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Liquidation  $liquidation
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $user = Auth::user()->id;
        $activity = Activity::all();
        $act = DB::table('liquidations')
        ->join('activities', 'liquidations.acitivity_id', '=', 'activities.id')
        ->where('liquidations.id', $id)
        ->select('activities.*','liquidations.*')
        ->get();

        $response = 
                    [
                        'act' => $act,
                        'activity' => $activity
                    ];
        return view('liquidations.edit',$response);
       // return response()->json($act);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Liquidation  $liquidation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, ['image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);

        $approve_by = User::where('users.role_id', 3)->first();
        $user_id = $approve_by->id;
        $liquidation = Liquidation::findOrFail($id);
       


       	$liquidation->item = $request->input('item');
        $liquidation->amount = $request->input('amount');
        $liquidation->official_reciepts = $request->input('receipt');
        $liquidation->submitted_by_user_id = Auth::user()->id;
        $liquidation->approved_by_user_id = $user_id;
        $liquidation->save();

       return redirect()->back()->with('alert-success', 'Data has been updated!');
        return response()->json($liquidation);
    }

    public function approval(Request $request)
     {
        $id = $request->input('id');
        $liquidation =  Liquidation::find($id);
        $liquidation->approval = 1;
        $liquidation->save();
        return redirect()->back()->with('alert-success', 'Approved successfully');
       // return response()->json($liquidation);

     }

      public function disapproval(Request $request)
     {
        $id = $request->input('id');
        $liquidation =  Liquidation::find($id);
        $liquidation->approval = 0;
        $liquidation->save();
        return redirect()->back()->with('alert-success', 'Disapproved successfully');

     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Liquidation  $liquidation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Liquidation $liquidation)
    {
        //
    }

    public function view_content($id)
    {
      $act_id= $id;
      $liquidation = DB::table('liquidations')
        ->join('activities', 'liquidations.acitivity_id', '=' ,'activities.id')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('officers', 'organization_academic_years.id', '=', 'officers.organization_ay_id')
        ->join('users', 'liquidations.approved_by_user_id', '=', 'users.id')
        ->where('liquidations.acitivity_id', $id)
        ->where('officers.user_id', Auth::user()->id)
        ->select('users.*','liquidations.*','activities.title')
        ->get();

        $liquidation_modal = DB::table('liquidations')
        ->join('activities', 'liquidations.acitivity_id', '=' ,'activities.id')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('officers', 'organization_academic_years.id', '=', 'officers.organization_ay_id')
        ->join('users', 'liquidations.approved_by_user_id', '=', 'users.id')
        ->where('liquidations.acitivity_id', $id)
        ->where('officers.user_id', Auth::user()->id)
        ->select('users.*','liquidations.*','activities.title', 'liquidations.official_reciepts as or')
        ->get();

        $liquidation_modal_view = DB::table('liquidations')
        ->join('activities', 'liquidations.acitivity_id', '=' ,'activities.id')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('officers', 'organization_academic_years.id', '=', 'officers.organization_ay_id')
        ->join('users', 'liquidations.submitted_by_user_id', '=', 'users.id')
        ->where('liquidations.acitivity_id', $id)
        ->select('users.*','liquidations.*','activities.title')
        ->get();

         $notify = DB::table('notifications')
        ->join('users','notifications.review_by_user_id','=','users.id')
        ->join('liquidations','notifications.liquidation_id' ,'=' ,'liquidations.id')
        ->select('users.*','notifications.*')
        ->get()->sortByDesc('created_at');

        $user = Auth::user()->id;
        $act = DB::table('activities')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->join('officers', 'organization_academic_years.id', 'officers.organization_ay_id')
        ->where('officers.user_id', Auth::user()->id)
        ->select('activities.*')
        ->get();
        
        
        $liquidation_sum = DB::table('liquidations')
        ->where('liquidations.acitivity_id', $id)
        ->sum('amount');

        $activity = Activity::all();

        $response = [ 'liquidation' => $liquidation,
                      'act' => $act,
                      'activity' => $activity,
                      'liquidation_modal' => $liquidation_modal,
                      'liquidation_modal_view' => $liquidation_modal_view,
                      'notify' => $notify
                    ];
        return view('liquidations.index', $response, compact('act_id', 'liquidation_sum'));
    }
}
