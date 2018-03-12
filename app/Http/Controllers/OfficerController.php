<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\AcademicYear;
use App\OrganizationAcademicYear;
use App\Organization;
use App\User;
use App\Officer;

class OfficerController extends Controller
{

    public function index()
    {
        $officers = Officer::all();
        $response = [
            'officers' => $funds
        ];
        $user = User::all();
        return view('officers.index',$response, compact('user'));      
    }

    public function show_officers($id)
    {
        $user = Auth::user()->id;

        if(Auth::user()->role_id != 1)
        {
            $users = DB::table('officers')
            ->join('users', 'officers.user_id', '=', 'users.id')
            ->select('officers.*')
            ->where('officers.user_id', $user)
            ->get();

            $officers = DB::table('officers')
            ->join('organization_academic_years', 'officers.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('users', 'officers.user_id', '=', 'users.id')
            ->select('officers.*', 'users.*')
            ->where('organization_academic_years.ay_id', $id)
            ->get();

            $org_ay = OrganizationAcademicYear::where('organization_academic_years.ay_id',$id)->first();
            $o_ay_id = $org_ay->organization_id;
            $org = Organization::where('id',$o_ay_id);
        }

        else
        {
            $officers = DB::table('officers')
            ->join('organization_academic_years', 'officers.organization_ay_id', '=', 'organization_academic_years.id')
            ->join('users', 'officers.user_id', '=', 'users.id')
            ->select('officers.*', 'users.*')
            ->where('organization_ay_id', $id)
            ->get();

            $org_ay = OrganizationAcademicYear::where('organization_academic_years.id',$id)->first();
            $o_ay_id = $org_ay->organization_id;
            $org = Organization::where('id',$o_ay_id);
        }

        $response = [ 
            'officers' => $officers,
            'org' => $org
        ];
        
        // return response()->json($org_ay);
        return view('officers.show',$response, compact('org_ay' ,'users'));
    }

    public function store_officers(Request $request)
    {
       
        $user = new User;
        $officer = new Officer;

        //Get Officer position
        $get_position_president = Officer::where('position', '=', 'President')
        ->where('organization_ay_id', '=', $request->input('organization_ay_id'))
        ->count();
        $get_position_vicepresident = Officer::where('position', '=', 'Vice President')
        ->where('organization_ay_id', '=', $request->input('organization_ay_id'))
        ->count();
        $get_position_secretary = Officer::where('position', '=', 'Secretary')
        ->where('organization_ay_id', '=', $request->input('organization_ay_id'))
        ->count();
        $get_position_treasurer = Officer::where('position', '=', 'Treasurer')
        ->where('organization_ay_id', '=', $request->input('organization_ay_id'))
        ->count();
        $get_position_auditor = Officer::where('position', '=', 'Auditor')
        ->where('organization_ay_id', '=', $request->input('organization_ay_id'))
        ->count();

        //Check if there is existing officer
        if($request->input('position') == 'President' && $get_position_president > 0){
            return back()->with('alert-danger', 'There is already a President');
        }
        if($request->input('position') == 'Vice President' && $get_position_vicepresident > 0){
            return back()->with('alert-danger', 'There is already a Vice President');
        }
        if($request->input('position') == 'Secretary' && $get_position_secretary > 0){
            return back()->with('alert-danger', 'There is already a Secratary');
        }
        if($request->input('position') == 'Treasurer' && $get_position_treasurer > 0){
            return back()->with('alert-danger', 'There is already a Treasurer');
        }
        if($request->input('position') == 'Auditor' && $get_position_auditor > 0){
            return back()->with('alert-danger', 'There is already a Auditor');
        }
        
        //Show enrolled
        $enrolled = DB::table('enrolled_students')
        ->where('id', $request->input('student'))
        ->where('ay_id', $request->input('ay_id'))
        ->where('sem', 1)
        ->first();

        $user->es_id = $enrolled->student_no;
        $user->first_name = $enrolled->firstname_middlename;
        $user->middle_name = 'N/A';
        $user->last_name = $enrolled->surname;
        $user->role_id = $request->input('role_id');
        $user->contact = 'N/A';
        $user->email = 'N/A';
        $user->password = bcrypt($user->es_id);
        $user->photo = 'no-image.jpg';
        $user->status = 1;
        $user->save();

        $userInsertedId = $user->id;
        
        $officer->user_id = $userInsertedId;
        $officer->organization_ay_id = $request->input('organization_ay_id');
        $officer->position = $request->input('position');  
        $officer->save();
        
        $org_ay = $officer->organization_ay_id;
        // return response()->json($officer);

        return back()->with('alert-success', 'New officer has been added!');
        // dd($user);
    }

    public function destroy($id)
    {
        $user = new User;
        $officer = new Officer;
        
        $user->es_id = $request->input('es_id');
        $user->first_name = $request->input('first_name');
        $user->middle_name = $request->input('middle_name');
        $user->last_name = $request->input('last_name');
        $user->role_id = 2;
        $user->contact = $request->input('contact');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->save();

        $userInsertedId = $user->id;

        $officer->user_id = $userInsertedId;
        $officer->organization_ay_id = $request->input('organization_ay_id');
        $officer->position = $request->input('position');
        $officer->save();
        
        $org_ay = $officer->organization_ay_id;
        //return response()->json(array('user'=>$user, 'officer'=>$officer));

        return redirect()->route('officers.show_officers', ['id' => $org_ay]);
    }
}
