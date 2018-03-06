<?php

namespace App\Providers;

use Carbon\Carbon;

use App\AcademicYear;
use Auth;
use App\OrganizationAcademicYear;
use App\Organization;
use App\Institute;
use App\User;
use App\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        
            //view()->composer('*', function($view){
              //$view->with('user_get', Auth::user()->id);
          //  });
    
      
        view()->composer('*', function ($view) 
        {

            if(Auth::check()){
                  if(Auth::user()->role_id == 4)
                        {
                            $a_year = DB::table('academic_years')
                            ->join('organization_academic_years', 'academic_years.id','organization_academic_years.ay_id')
                            ->join('officers', 'organization_academic_years.id', '=', 'officers.organization_ay_id')
                            ->where('officers.user_id', Auth::user()->id)
                            ->select('academic_years.*')
                            ->get();
                            View::share('academic_yr', $a_year);
                        }
                if(Auth::user()->role_id == 1 || Auth::user()->role_id == 3 || Auth::user()->role_id == 4 || Auth::user()->role_id == 2){
                    $acad = \App\AcademicYear::all()->sortByDesc("id");
                    View::share('acad_years', $acad);

                    $total_org = DB::table('organization_academic_years')
                    ->select('organization_academic_years.accredited')
                    ->where('accredited', 1)
                    ->count('organization_academic_years.accredited');
                    View::share('get_org', $total_org);

                    $get_org = DB::table('organization_academic_years')
                    ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                    ->join('academic_years', 'organization_academic_years.ay_id', '=', 'academic_years.id')
                    ->select('organization_academic_years.*', 'organizations.name', 'academic_years.*')
                    ->where('accredited', 1)
                    ->get()->sortByDesc('updated_at');
                    View::share('get_total_org', $get_org);

                     $organizations = DB::table('organizations')
                    ->join('organization_academic_years','organizations.id', '=', 'organization_academic_years.organization_id')
                    ->join('academic_years', 'organization_academic_years.ay_id', '=', 'academic_years.id')
                    ->select('organizations.*', 'organization_academic_years.*', 'academic_years.id')
                    ->where('organization_academic_years.accredited', 1)
                    ->get();
                    View::share('get_total_org2', $organizations);

                    $get_reviewed_activity = DB::table('organizations')
                    ->join('organization_academic_years','organizations.id', '=', 'organization_academic_years.organization_id')
                    ->join('academic_years', 'organization_academic_years.ay_id', '=', 'academic_years.id')
                    ->join('activities', 'organization_academic_years.id', '=', 'activities.organization_ay_id')
                    ->select('organizations.*', 'organization_academic_years.*', 'academic_years.id','activities.updated_at as act_updated_at')
                    ->where('activities.review_id', 1)
                    ->get();
                    View::share('get_reviewed_act', $get_reviewed_activity);

                    $getuser = DB::table('users')
                    ->join('roles','users.role_id', '=', 'roles.id')
                    ->where('users.role_id', 1)
                    ->get();
                    View::share('user2', $getuser);

                    $user3 = DB::table('users')
                    ->join('roles','users.role_id', '=', 'roles.id')
                    ->where('users.role_id', 3)
                    ->get();
                    View::share('user3', $user3);

                    //officers
                    $u_id = Auth::user()->id;
                    $count_req = DB::table('activities')
                    ->join('organization_academic_years', 'activities.organization_ay_id', 'organization_academic_years.id')
                     ->join('officers', 'organization_academic_years.id', '=', 'officers.organization_ay_id')
                    ->where('officers.user_id', $u_id)
                    ->where('activities.notify2', 0)
                    ->where('activities.review_id', 1)
                    ->count('activities.notify2');
                    View::share('count_req', $count_req);

                     $count_approve1 = DB::table('activities')
                     ->join('organization_academic_years', 'activities.organization_ay_id', 'organization_academic_years.id')
                     ->join('officers', 'organization_academic_years.id', '=', 'officers.organization_ay_id')
                    ->where('officers.user_id', $u_id)
                    ->where('activities.approval', 1)
                    ->where('activities.notify2', 0)
                    ->count('activities.approval');
                    View::share('count_approve1', $count_approve1);

                    $count_disapprove1 = DB::table('activities')
                    ->join('organization_academic_years', 'activities.organization_ay_id', 'organization_academic_years.id')
                    ->join('officers', 'organization_academic_years.id', '=', 'officers.organization_ay_id')
                    ->where('officers.user_id', $u_id)
                    ->where('activities.approval', 0)
                    ->where('activities.notify2', 0)
                    ->count('activities.approval');
                    View::share('count_disapprove1', $count_disapprove1);


                    $count_req5 = DB::table('activities')
                    ->join('organization_academic_years', 'activities.organization_ay_id', 'organization_academic_years.id')
                     ->join('officers', 'organization_academic_years.id', '=', 'officers.organization_ay_id')
                    ->where('officers.user_id', $u_id)
                    ->where('activities.review_id', 1)
                    ->count('activities.notify2');
                    View::share('count_req5', $count_req5);

                     $count_approve5 = DB::table('activities')
                     ->join('organization_academic_years', 'activities.organization_ay_id', 'organization_academic_years.id')
                     ->join('officers', 'organization_academic_years.id', '=', 'officers.organization_ay_id')
                    ->where('officers.user_id', $u_id)
                    ->where('activities.approval', 1)
                    ->count('activities.approval');
                    View::share('count_approve5', $count_approve5);

                    $count_disapprove5 = DB::table('activities')
                    ->join('organization_academic_years', 'activities.organization_ay_id', 'organization_academic_years.id')
                    ->join('officers', 'organization_academic_years.id', '=', 'officers.organization_ay_id')
                    ->where('officers.user_id', $u_id)
                    ->where('activities.approval', 0)
                    ->count('activities.approval');
                    View::share('count_disapprove5', $count_disapprove5);
                    //END
                    //OSCA
                    $count_approve2 = DB::table('activities')
                    ->where('activities.approval', 1)
                    ->where('activities.notify', 0)
                    ->count('activities.approval');
                    View::share('count_approve2', $count_approve2);

                    $count_disapprove2 = DB::table('activities')
                    ->where('activities.approval', 0)
                    ->where('activities.notify', 0)
                    ->count('activities.approval');
                    View::share('count_disapprove2', $count_disapprove2);
                    //END

                    $count_req2 = DB::table('activities')
                    ->where('activities.notify', 0)
                    ->where('activities.review_id', 0)
                    ->count('activities.notify');
                    View::share('count_req2', $count_req2);


                    $count_req3 = DB::table('activities')
                    ->where('activities.notify3', 0)
                    ->where('activities.approval', 2)
                    ->count('activities.notify3');
                    View::share('count_req3', $count_req3);

                     $getact = DB::table('activities')
                     ->join('organization_academic_years', 'activities.organization_ay_id', 'organization_academic_years.id')
                     ->join('officers', 'organization_academic_years.id', '=', 'officers.organization_ay_id')
                    ->select('activities.*')
                    //->where('activities.review_id', 1)
                    ->where('officers.user_id', $u_id)
                    ->get()->sortByDesc('updated_at');
                    View::share('getact', $getact);

                    $getact_approve = DB::table('activities')
                    ->select('activities.*')
                    ->where('activities.approval', 1)
                    ->where('activities.requestedBy', $u_id)
                    ->get()->sortByDesc('updated_at');
                    View::share('getact_approve', $getact_approve);

                     $getact_approve2 = DB::table('activities')
                    ->select('activities.*')
                    ->where('activities.approval', 1)
                    ->get()->sortByDesc('updated_at');
                    View::share('getact_approve2', $getact_approve2);

                     $users = DB::table('users')
                     ->select('users.*')
                     ->where('users.role_id', 1)
                     ->get();
                    View::share('user', $users);

                    $activities = DB::table('activities')
                    ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
                    ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                    ->select('activities.*', 'organizations.name')
                    ->get()->sortByDesc('activities.updated_at');
                     View::share('activiti', $activities);


                     $liquidation_1 = DB::table('liquidations')
                     ->join('officers','liquidations.submitted_by_user_id', '=','officers.user_id')
                     ->join('organization_academic_years','officers.organization_ay_id', '=', 'organization_academic_years.id')
                     ->join('organizations','organization_academic_years.organization_id','=', 'organizations.id')
                     ->where('liquidations.notify_sas', 0)
                     ->count('liquidations.notify_sas');
                     View::share('count_liquidation_1', $liquidation_1);

                      $liquidation_list_1 = DB::table('liquidations')
                     ->join('officers','liquidations.submitted_by_user_id', '=','officers.user_id')
                     ->join('organization_academic_years','officers.organization_ay_id', '=', 'organization_academic_years.id')
                     ->join('organizations','organization_academic_years.organization_id','=', 'organizations.id')
                     ->select('liquidations.*', 'organizations.name')
                     ->get()->sortByDesc('liquidations.created_at');
                     View::share('liquidation_list', $liquidation_list_1);

                     $liquidations_2 = DB::table('liquidations')
                     ->where('liquidations.notify_osca', 0)
                     ->count('liquidations.notify_osca');
                     View::share('count_liquidations_2', $liquidations_2);

                     $liquidation_list_2 = DB::table('liquidations')
                     ->join('officers','liquidations.submitted_by_user_id', '=','officers.user_id')
                     ->join('organization_academic_years','officers.organization_ay_id', '=', 'organization_academic_years.id')
                     ->join('organizations','organization_academic_years.organization_id','=', 'organizations.id')
                     ->select('liquidations.*', 'organizations.name')
                     ->get()->sortByDesc('liquidations.created_at');
                     View::share('liquidation_list_2', $liquidation_list_2);

                     $liquidationss = DB::table('notifications')
                    ->join('liquidations', 'notifications.liquidation_id','=', 'liquidations.id')
                    ->join('activities', 'liquidations.acitivity_id', '=', 'activities.id')
                    ->join('officers', 'activities.organization_ay_id', '=', 'officers.organization_ay_id')
                    ->where('officers.user_id', $u_id)
                    ->select('notifications.*', 'liquidations.*')
                    ->get()->sortByDesc('notifications.updated_at');
                    View::share('l_liquidation', $liquidationss);

                    $liquidationss_app = DB::table('liquidations')
                    ->join('activities', 'liquidations.acitivity_id', '=', 'activities.id')
                    ->join('organization_academic_years', 'activities.organization_ay_id','=','organization_academic_years.id')
                    ->join('officers', 'organization_academic_years.id', '=','officers.organization_ay_id')
                    ->where('officers.user_id', $u_id)
                    ->select('liquidations.*')
                    ->get()->sortByDesc('notifications.updated_at');
                    View::share('liquidationss_app', $liquidationss_app);

                    //count liquidation approved
                    $a_liquidationss = DB::table('liquidations')
                    ->join('activities', 'liquidations.acitivity_id', '=', 'activities.id')
                    ->join('organization_academic_years', 'activities.organization_ay_id','=','organization_academic_years.id')
                    ->join('officers', 'organization_academic_years.id', '=','officers.organization_ay_id')
                    ->where('officers.user_id', $u_id)
                    ->where('liquidations.notify_officer', 0)
                    ->where('liquidations.approval', 1)
                    ->count('liquidations.approval');
                    View::share('count_a_liquidation', $a_liquidationss);

                    //count liquidation disapproved
                    $d_liquidationss = DB::table('liquidations')
                    ->join('activities', 'liquidations.acitivity_id', '=', 'activities.id')
                    ->join('organization_academic_years', 'activities.organization_ay_id','=','organization_academic_years.id')
                    ->join('officers', 'organization_academic_years.id', '=','officers.organization_ay_id')
                    ->where('officers.user_id', $u_id)
                    ->where('liquidations.notify_officer', 0)
                    ->where('liquidations.approval', 0)
                    ->count('liquidations.approval');
                    View::share('count_d_liquidation', $d_liquidationss);

                    $rev_sas_liquidationss = DB::table('notifications')
                    ->join('liquidations', 'notifications.liquidation_id','=', 'liquidations.id')
                    ->join('activities', 'liquidations.acitivity_id', '=', 'activities.id')
                    ->join('officers', 'activities.organization_ay_id', '=', 'officers.organization_ay_id')
                    ->where('officers.user_id', Auth::user()->id)
                    ->where('notifications.notify_officers', 0)
                    ->where('liquidations.reviewed_sas', 1)
                    ->count('liquidations.reviewed_sas');
                    View::share('count_sas_liquidation', $rev_sas_liquidationss);

                    $rev_osca_liquidationss = DB::table('notifications')
                    ->join('liquidations', 'notifications.liquidation_id','=', 'liquidations.id')
                    ->join('activities', 'liquidations.acitivity_id', '=', 'activities.id')
                    ->join('officers', 'activities.organization_ay_id', '=', 'officers.organization_ay_id')
                    ->where('officers.user_id', Auth::user()->id)
                    ->where('notifications.notify_officers', 0)
                    ->where('liquidations.reviewed_osca', 1)
                    ->count('liquidations.reviewed_osca');
                    View::share('count_osca_liquidation', $rev_osca_liquidationss);

                    $c_cash_requests = DB::table('cash_requests')
                    ->join('activities', 'cash_requests.activity_id','=','activities.id')
                    ->join('officers', 'activities.organization_ay_id', '=', 'officers.organization_ay_id')
                    ->where('officers.user_id', Auth::user()->id)
                    ->select('cash_requests.*' ,'activities.id as act_id')
                    ->get();
                    View::share('c_cash_requests', $c_cash_requests);

                    $c_cash_requests_released = DB::table('cash_requests')
                    ->join('activities', 'cash_requests.activity_id','=','activities.id')
                    ->join('officers', 'activities.organization_ay_id', '=', 'officers.organization_ay_id')
                    ->where('officers.user_id', Auth::user()->id)
                    ->where('cash_requests.notify_officer', 0)
                    ->count('cash_requests.released' );
                    View::share('c_cash_requests_released', $c_cash_requests_released);

                    $cashh = DB::table('cash_requests')
                    ->join('activities', 'cash_requests.activity_id','=','activities.id')
                    ->join('organization_academic_years', 'activities.organization_ay_id','=', 'organization_academic_years.id')
                    ->join('organizations', 'organization_academic_years.organization_id','=', 'organizations.id')
                    ->select('cash_requests.*','organizations.name')
                    ->get();
                    View::share('cashsh', $cashh);

                    $organizationssss = DB::table('organizations')
                    ->join('organization_academic_years','organizations.id', '=', 'organization_academic_years.organization_id')
                    ->join('academic_years', 'organization_academic_years.ay_id', '=', 'academic_years.id')
                    ->select('organizations.*', 'organization_academic_years.*', 'academic_years.id')
                    ->where('organization_academic_years.accredited', 1)
                    ->get();
                    View::share('organizationsss', $organizationssss);

                    $count_organizationsssss = DB::table('organizations')
                    ->join('organization_academic_years','organizations.id', '=', 'organization_academic_years.organization_id')
                    ->join('academic_years', 'organization_academic_years.ay_id', '=', 'academic_years.id')
                    ->where('organization_academic_years.accredited', 1)
                    ->count('organization_academic_years.id');
                    View::share('count_organizationssss', $count_organizationsssss);

                    $new_cash_req_count = DB::table('cash_requests')
                    ->where('cash_requests.notify_igp', 0)
                    ->count('cash_requests.notify_igp');
                    View::share('new_cash_req_count', $new_cash_req_count);



                    $year = AcademicYear::all()->sortByDesc('academic_years.id')->first();
                    View::share('years', $year);

                    $osca = User::where('users.role_id', 1)->first();
                    View::share('osca', $osca);
                    $sas = User::where('users.role_id', 3)->first();
                    View::share('sas', $sas);
                    $igp = User::where('users.role_id', 2)->first();
                    View::share('igp', $igp);

                    
                }

                if(Auth::user()->role_id==4){
                    $user_org = DB::table('officers')
                    ->join('organization_academic_years', 'officers.organization_ay_id', '=', 'organization_academic_years.id')
                    ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                    ->where("user_id", "=", Auth::user()->id)
                    ->select('organizations.*', 'officers.*')
                    ->first();
                    View::share('user_org', $user_org);
                }
            }
        });  

        
        //GET year
        $yr = \App\AcademicYear::all();
        if(count($yr) == 0)
        {
            $yr = Carbon::now()->format('Y');
            View::share('next_yr', $yr);
        }
        else if(count($yr) > 0)
        {
            $next_yr = \App\AcademicYear::all() -> last() -> ay_to; // extract value from field. 
            View::share('next_yr', $next_yr);
        }
        
        //GET date today
        $date = Carbon::now();  
        View::share('date', $date);

        

        View::share('auth', Auth::user());
        

        View::composer('*', function($view) {
            $view->with('auth', Auth::user());
        });

        

        $tc1 = DB::table('funds')
        ->join('academic_years', 'funds.ay_id', '=', 'academic_years.id') 
        ->where('ay_from', $date->year)
        ->where('semester', 1)
        ->sum('amount');
        View::share('tc1', $tc1);
        
        $tc2 = DB::table('funds')
        ->join('academic_years', 'funds.ay_id', '=', 'academic_years.id') 
        ->where('ay_from', $date->year)
        ->where('semester', 2)
        ->sum('amount');
        View::share('tc2', $tc2);

        $total_collection = DB::table('funds')
        ->join('academic_years', 'funds.ay_id', '=', 'academic_years.id') 
        ->where('ay_from', $date->year)
        ->sum('amount');
        View::share('total_collection', $total_collection);

        $total_remaining_1 = DB::table('funds')
        ->join('academic_years', 'funds.ay_id', '=', 'academic_years.id') 
        ->where('ay_from', $date->year)
        ->where('semester', 1)
        ->sum('remaining');
        View::share('total_remaining1', $total_remaining_1);

        $total_remaining_2 = DB::table('funds')
        ->join('academic_years', 'funds.ay_id', '=', 'academic_years.id') 
        ->where('ay_from', $date->year)
        ->where('semester', 2)
        ->sum('remaining');
        View::share('total_remaining2', $total_remaining_2);

        


        

    }

    public function register()
    {
        //
    }
}
