<?php

namespace App\Http\Controllers;
use App\OrganizationAcademicYear;
use Auth;
use App\Organization;
use App\User;
use App\Officer;
use App\Institute;
use App\AcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrganizationAcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $ay_id = $request->ay_id;

         if(Auth::user()->role_id == 4){
            $officer = \App\Officer::where('user_id', '=', Auth::id())->first();
            $org_ay_id = $officer->organization_ay_id;
            $activity = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->select('activities.*', 'organizations.name', 'organization_academic_years.ay_id')
            ->where('ay_id', $ay_id)
            ->where('organization_ay_id', $org_ay_id)
            ->get();
        }
        else{
            $activity = DB::table('activities')
            ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->select('activities.*', 'organizations.name', 'organization_academic_years.ay_id')
            ->where('ay_id', $ay_id)
            ->get();

            $activ = DB::table('activities')
            ->join('users', 'activities.requestedBy', '=', 'users.id')
            ->join('organizations', 'activities.organization_ay_id', '=', 'organizations.id')
            ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id' )
            ->select('users.remember_token', 'activities.*', 'organizations.name', 'organization_academic_years.organization_id')
            ->where('organization_academic_years.ay_id', $ay_id)
            ->where('activities.approval', 1)
            ->get();        
        }

        $response = [ 
        'activity' => $activity
        ];
        
        $count_activity = DB::table('activities')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->where('ay_id', $ay_id)
        ->where('activities.review_id', 1)
        ->count('activities.review_id');

        $rev_activity = DB::table('activities')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->select('activities.*')
        ->where('ay_id', $ay_id)
        ->where('activities.review_id', 1)
        ->get();
        
        $not_rev_activity = DB::table('activities')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->select('activities.*')
        ->where('ay_id', $ay_id)
        ->where('activities.review_id', 0)
        ->get();

         $count_activity_not = DB::table('activities')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->where('ay_id', $ay_id)
        ->where('activities.review_id', 0)
        ->count('activities.review_id');
        
         $ay = AcademicYear::find($ay_id);
         $acad_years = AcademicYear::all();
     //   return view('activities.index', $response, compact('ay','code', 'activ','count_activity', 'count_activity_not', 'acad_years','rev_activity', 'not_rev_activity'));
       return response()->json($ay);
    }

    
    public function show_only($id)
    {
         $org_ay = OrganizationAcademicYear::find($id);
         $orgs = DB::table('organization_academic_years')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id') 
        ->select('organization_academic_years.*', 'organizations.name') 
        ->where('organization_academic_years.ay_id', $id)
        ->where('organization_academic_years.accredited', 1)
        ->get();
    }

    public function show($id)
    {
        $org_ay = DB::table('organization_academic_years')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->join('academic_years', 'organization_academic_years.ay_id', '=', 'academic_years.id')
        ->select('organization_academic_years.*', 'organizations.name', 'organizations.code', 'organizations.type')
        ->where('ay_id', $id)
        ->orderBy('code')
        ->get();

        // $get_remaining = DB::table('funds')
        // ->where('funds.name', 'Equalizer Funds')
        // ->select('funds.*')
        // ->get();

        $org_id = DB::table('organizations')
        ->where('organizations.code', 'EQUA')
        ->select('organizations.id')
        ->get();

        $response = [ 
            'organization_academic_year' => $org_ay,
            // 'get_remaining' => $get_remaining,
            'org_id' => $org_id
            
        ];
        
        $ay = AcademicYear::find($id);

        return view('organization_academic_years.index',$response, compact('ay'));
    }

    public function edit($id)
    {
        $org_ay = DB::table('organization_academic_years')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->join('academic_years', 'organization_academic_years.ay_id', '=', 'academic_years.id')
        ->select('organization_academic_years.*', 'organizations.name', 'organizations.code', 'organizations.type', 'organization_academic_years.ay_id')
        ->where('accredited', 0)
        ->where('ay_id', $id)
        ->orderBy('code')
        ->get();
        
        $response = [ 
            'organization_academic_year' => $org_ay
        ];
        $org_id = OrganizationAcademicYear::all();
        
        $ay = AcademicYear::find($id);

        return view('organization_academic_years.edit', $response, compact('ay','org_id'));
    }
    
    public function update(Request $request, $id)
    {   
        $req_accredit = $request->input('accredit');

        $count_key = DB::table('organizations')
        ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
        ->where('organization_academic_years.ay_id', $id)
        ->count('organization_academic_years.id');  

        $accredited = DB::table('organizations')
        ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
        ->where('organization_academic_years.accredited', 0)
        ->where('organization_academic_years.ay_id', $id)
        ->count('organization_academic_years.id');

        if($count_key >= 1)
            {
                if($accredited <= 0 || $req_accredit == TRUE)
                    {
                        $accredit = $req_accredit;
                        $org = OrganizationAcademicYear::whereIn('id', $accredit)
                        ->update(['accredited' => 1]);
                   
                        return redirect()->route('organization_academic_years.show', $id)->with('alert-success', 'New Organization/s has been accrdited Successfully!');
                    }
                else
                    {
                        return redirect()->back()->with('alert-danger', 'Failed to accredit an Organization. Please check the list in the table and/or select an Organization in the list to be accredited.');
                    }
            }
        else
            {
                return redirect()->back()->with('alert-danger', 'Failed to accredit an Organization. Please check the list in the table and/or select an Organization in the list to be accredited.');
            }
       //return response()->json($accredited);
    }


    public function destroy($id)
    {
        //
    }


    public function refresh_list($id)
    {
        //$ay = AcademicYear::find($id);
        $org = Organization::all();

        foreach($org as $orgs){
            $org_ay = OrganizationAcademicYear::where('ay_id', $id)
                ->where('organization_id', $orgs->id)
                ->get();
            if(!count($org_ay)){
                $org_ay_input = new OrganizationAcademicYear;
                
                $org_ay_input->organization_id = $orgs->id;
                $org_ay_input->ay_id = $id;
                $org_ay_input->accredited = 0;
                $org_ay_input->save(); 
            }    
            
        }

        return $this->edit($id);
    }

    public function view_info($id)
    {

       

        //Show Organizations
        $org_ay = DB::table('organization_academic_years')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->join('academic_years', 'organization_academic_years.ay_id', '=', 'academic_years.id')
        ->select('organization_academic_years.*', 'organizations.name', 'organizations.code', 'organizations.type', 'organizations.logo')
        ->where('organization_academic_years.id', $id)
        ->first();

        //Show Activities
        $activity = DB::table('activities')
        ->join('organization_academic_years', 'activities.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
        ->leftjoin('users', 'activities.requestedBy', '=', 'users.id')
        ->select('activities.*', 'organizations.name', 'users.first_name as fname', 'users.last_name as lname', 'organization_academic_years.ay_id')
        ->where('organization_ay_id', $id)
        ->get();

         //Get AY
         $ay_id = $org_ay->ay_id;
         $ay = AcademicYear::find($ay_id); 

        //Show enrolled
        $enrolled = DB::table('enrolled_students')
        ->where('ay_id', $ay->id)
        ->where('sem', 1)
        ->get();


        //Get Officers
        $user = Auth::user()->id;

        if(Auth::user()->role_id != 1){
            $users = DB::table('officers')
            ->join('users', 'officers.user_id', '=', 'users.id')
            ->select('officers.*')
            ->where('officers.user_id', $user)
            ->get();

            $officers = DB::table('officers')
            ->join('organization_academic_years', 'officers.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('users', 'officers.user_id', '=', 'users.id')
            ->select('officers.*', 'users.*')
            ->where('organization_academic_years.id', $id)
            ->get();
        }
        else{
            $officers = DB::table('officers')
            ->join('organization_academic_years', 'officers.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('users', 'officers.user_id', '=', 'users.id')
            ->select('officers.*', 'users.*')
            ->where('organization_ay_id', $id)
            ->get();
        }

        $check_budget = DB::table('budgets')
        ->where('organization_ay_id', $id)
        ->count();

        if($check_budget>=1){
            $budget = DB::table('budgets')
            ->where('organization_ay_id', $id)
            ->get();
        }
        else{
            $budget = 0;
        }

        $response = [ 
            'organization_academic_year' => $org_ay,
            'officers' => $officers,
            'activity' => $activity,
            'budget' => $budget,
            'enrolled' => $enrolled
        ];
        
        

        return view('organization_academic_years.info',$response, compact('ay'));
        // return response()->json($enrolled);
    }

}
