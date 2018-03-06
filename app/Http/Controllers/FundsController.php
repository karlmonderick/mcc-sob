<?php

namespace App\Http\Controllers;

use App\Funds;
use App\Budget;
use Auth;
use App\Institute;
use App\AcademicYear;
use App\EnrolledAcademicYearController;
use App\user;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FundsController extends Controller
{
    public function index()
    {
    }

    public function create_funds($id)
    {
        $ay = AcademicYear::find($id);
        return view('funds.create', compact('ay'));
    }

    public function store(Request $request) //BUDGET ALLOCATION PROCESS
    {

        $total_enrollee = DB::table('enrolled_academic_years')
        ->sum('enrolled_academic_years.no_of_students');
        
        $enrollee = DB::table('enrolled_academic_years')
        ->where('ay_id',$request->input('ay_id'))
        ->where('sem',$request->input('sem'))
        ->get();
        
        
        $fund = new Funds;
        $fund->name = $request->input('name');
        $fund->amount =  $total_enrollee * $request->input('amount');
        $fund->remaining = $total_enrollee * $request->input('amount');
        $fund->semester = $request->input('semester');
        $fund->ay_id = $request->input('ay_id');
        $fund->user_id = $request->input('user_id');
        
        $ay_id = $fund->ay_id;

        //return response()->json($enrollee);

        //return redirect()->back()->with('alert-success', 'Added '.$fund->name.' successfully!');
        return redirect()->back()->with('alert-success', 'Hello');
        // return view('funds.index', $response, compact('ay'))->with('alert.success', 'Data has been saved');
    }

     public function show($id)
    {
        
        $funds = DB::table('funds')
        ->join('academic_years', 'funds.ay_id', '=', 'academic_years.id')
        ->select('funds.*', 'academic_years.ay_from', 'academic_years.ay_to')
        ->where('ay_id', $id)
        ->get();

        $funds1sem = DB::table('funds')
        ->where('funds.ay_id', $id)
        ->where('funds.semester', 1)
        ->orderby('name')
        ->get();

        $funds2sem = DB::table('funds')
        ->where('funds.ay_id', $id)
        ->where('funds.semester', 2)
        ->orderby('name')
        ->get();

        $response = [ 
            'funds' => $funds
        ];
        $ins = Institute::all();
        $ay = AcademicYear::find($id);


        $budget = DB::table('budgets')
        ->join('organization_academic_years', 'budgets.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id') 
        ->join('funds', 'funds.id', '=', 'budgets.fund_id') 
        ->select('budgets.*', 'organizations.name','funds.name as fund_name')
        ->where('organization_academic_years.ay_id', $id)
        ->where('funds.semester', 1)
        ->orderby('fund_name', 'asc')
        ->orderby('name', 'asc')
        ->get();

        $budget2 = DB::table('budgets')
        ->join('organization_academic_years', 'budgets.organization_ay_id', '=', 'organization_academic_years.id')
        ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id') 
        ->join('funds', 'budgets.fund_id', '=', 'funds.id') 
        ->select('budgets.*', 'organizations.name','funds.name as fund_name')
        ->where('organization_academic_years.ay_id', $id)
        ->where('funds.semester', 2)
        ->orderby('fund_name', 'asc')
        ->orderby('name', 'asc')
        ->get();

             //GET TOTAL NUMBER OF ENROLLED sem 1
             $total_enrollee1 = DB::table('enrolled_academic_years')
             ->where('sem', 1)
             ->sum('enrolled_academic_years.no_of_students');

             //GET TOTAL NUMBER OF ENROLLED sem 2
             $total_enrollee2 = DB::table('enrolled_academic_years')
             ->where('sem', 2)
             ->sum('enrolled_academic_years.no_of_students');

             $institute_enrolled_1= DB::table('institutes')
             ->leftjoin('enrolled_academic_years', 'institutes.id', '=', 'enrolled_academic_years.institute_id')
             ->select('institutes.*', 'enrolled_academic_years.*')
             ->orderby('code')
             ->where('enrolled_academic_years.ay_id', '=', $id)
             ->where('sem', 1)
             ->get();

             $institute_enrolled_2= DB::table('institutes')
             ->leftjoin('enrolled_academic_years', 'institutes.id', '=', 'enrolled_academic_years.institute_id')
             ->select('institutes.*', 'enrolled_academic_years.*')
             ->orderby('code')
             ->where('enrolled_academic_years.ay_id', '=', $id)
             ->where('sem', 2)
             ->get();

    
            //GET ALL ACCREDITED ORGANIZATION
            $all_ac_orgs = DB::table('organizations')
            ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
            ->orderby('code')
            ->where('ay_id',$id)
            ->where('organization_academic_years.accredited', 1)
            ->get();
    
            //GET ALL INSTITUTE ORG.
            $io_orgs = DB::table('organizations')
            ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
            ->orderby('institute_id')
            ->where('ay_id',$id)
            ->where('type','IO')
            ->where('organization_academic_years.accredited', 1)
            ->get();
    
            //GET ALL CULTURAL ORG.
            $co_orgs = DB::table('organizations')
            ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
            ->orderby('code')
            ->where('ay_id',$id)
            ->where('type','CO')
            ->where('organization_academic_years.accredited', 1)
            ->get();
    
            //GET ALL COLLEGE WIDE ORG.
            $cw_orgs = DB::table('organizations')
            ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
            ->orderby('code')
            ->where('ay_id',$id)
            ->where('type','CW')
            ->where('organization_academic_years.accredited', 1)
            ->get();
    
            //GET ALL ISC
            $isc_orgs = DB::table('organizations')
            ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
            ->orderby('name')
            ->where('ay_id',$id)
            ->where('type','ISC')
            ->where('organization_academic_years.accredited', 1)
            ->get();
    
            //GET SSC
            $ssc_orgs = DB::table('organizations')
            ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
            ->orderby('code')
            ->where('ay_id',$id)
            ->where('type','SSC')
            ->where('organization_academic_years.accredited', 1)
            ->get();
    
            //GET SP
            $sp_orgs = DB::table('organizations')
            ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
            ->orderby('code')
            ->where('ay_id',$id)
            ->where('type','SP')
            ->where('organization_academic_years.accredited', 1)
            ->get();
    
            //GET SPORTS
            $sports_orgs = DB::table('organizations')
            ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
            ->orderby('code')
            ->where('ay_id',$id)
            ->where('type','SPORTS')
            ->where('organization_academic_years.accredited', 1)
            ->get();

            //GET number of organization in a institute
            $num_org = DB::table('organization_academic_years')
            ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
            ->orderby('institute_id')
            ->where('ay_id',$id)
            ->where('type','IO')
            ->groupBy('institute_id')
            ->select('institute_id', DB::raw('count(*) as total'))
            ->pluck('total','institute_id')->all();

            //GET number of organization in an institute
             $count_ias_org = DB::table('organizations')
             ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
             ->join('institutes', 'organizations.institute_id', '=', 'institutes.id')
             ->where('ay_id',$id)
             ->where('type','IO')
             ->where('organization_academic_years.accredited', 1)
             ->where('institutes.code','=', 'IAS')
             ->count();
             $count_ibe_org = DB::table('organizations')
             ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
             ->join('institutes', 'organizations.institute_id', '=', 'institutes.id')
             ->where('ay_id',$id)
             ->where('type','IO')
             ->where('organization_academic_years.accredited', 1)
             ->where('institutes.code','=', 'IBE')
             ->count();
             $count_ics_org = DB::table('organizations')
             ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
             ->join('institutes', 'organizations.institute_id', '=', 'institutes.id')
             ->where('ay_id',$id)
             ->where('type','IO')
             ->where('organization_academic_years.accredited', 1)
             ->where('institutes.code','=', 'ICS')
             ->count();
             $count_ihm_org = DB::table('organizations')
             ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
             ->join('institutes', 'organizations.institute_id', '=', 'institutes.id')
             ->where('ay_id',$id)
             ->where('type','IO')
             ->where('organization_academic_years.accredited', 1)
             ->where('institutes.code','=', 'IHM')
             ->count();
             $count_ite_org = DB::table('organizations')
             ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
             ->join('institutes', 'organizations.institute_id', '=', 'institutes.id')
             ->where('ay_id',$id)
             ->where('type','IO')
             ->where('organization_academic_years.accredited', 1)
             ->where('institutes.code','=', 'ITE')
             ->count();


        return view('funds.index',$response, compact('ay','ins', 'budget', 'budget2', 'funds1sem', 'funds2sem', 'all_ac_orgs', 'io_orgs', 'co_orgs', 'cw_orgs', 
        'isc_orgs', 'ssc_orgs','sp_orgs', 'sports_orgs', 'institute_enrolled_1' ,'institute_enrolled_2', 'total_enrollee1','total_enrollee2', 'num_org', 'count_ias_org', 'count_ibe_org'
        , 'count_ics_org', 'count_ihm_org', 'count_ite_org'));
       
    }

    public function edit($id)
    {
        $fund = Funds::findOrFail($id);
        $ay_id = $fund->ay_id;
        $ay = AcademicYear::find($ay_id);

        return view('funds.edit', compact('fund', 'ay'));
    }

     public function update(Request $request, $id)
     {

        $fund = Funds::findOrFail($id);
       
        $fund->name = $request->input('name');
        if($fund->amount < $request->input('amount')){
            $more = $request->input('amount') - $fund->amount;
            $fund->remaining += $more;
        }
        

        if($fund->amount > $request->input('amount')){
            $less = $fund->amount - $request->input('amount');
            $fund->remaining -= $less;
        }

        $fund->amount = $request->input('amount');
        $fund->semester = $request->input('semester');
        $fund->save();
        
        $ay_id = $fund->ay_id;

        return redirect()->route('funds.show', ['id' => $ay_id])->with('alert-success', $fund->name.' has been updated!');
     }

     public function destroy($id)
     {
         $Funds = Funds::find($id)->delete();
         return redirect()->route('funds.index')->with('alert-info', 'Data has been deleted!');
         //return response()->json(['message'=>'Organization deleted']);
     }
     
     public function choose_allocation($id){
        $fund = Funds::findOrFail($id);

        return view('funds.allocate');
        
     }

     public function allocate_funds(Request $request) //BUDGET ALLOCATION PROCESS
     {
        $ay_id = $request->input('ay_id'); 
        $sem = $request->input('sem');
        $academics1sem = $request->input(); 
        
        $funds1sem = DB::table('funds')
        ->where('funds.ay_id', $ay_id)
        ->where('funds.semester', 1)
        ->get();

        $funds2sem = DB::table('funds') 
        ->where('funds.ay_id', $ay_id)
        ->where('funds.semester', 2)
        ->get();
        
                //GET TOTAL NUMBER OF ENROLLED
                $total_enrollee = DB::table('enrolled_academic_years')
                ->where('sem', $sem)
                ->sum('enrolled_academic_years.no_of_students');
                
                //GET ENROLLED LIST PER SEM AND YEAR
                $enrollee = DB::table('enrolled_academic_years')
                ->leftjoin('institutes', 'enrolled_academic_years.institute_id', '=', 'institutes.id')
                ->orderby('code')
                ->where('ay_id',$request->input('ay_id'))
                ->where('sem',$request->input('sem'))
                ->get();
       
                //IF THERE ARE NO ENROLLED - RETURN ERROR
                $enrollee_num = count($enrollee);
                if($enrollee_num == 0){
                   return redirect()->back()->with('alert-danger', 'Sorry but there are no enrollees listed yet. Pls check the Enrolled List');
                }
       
               //GET ALL ACCREDITED ORGANIZATION
               $all_ac_orgs = DB::table('organizations')
               ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
               ->orderby('code')
               ->where('ay_id',$request->input('ay_id'))
               ->where('organization_academic_years.accredited', 1)
               ->get();
       
               //GET ALL INSTITUTE ORG.
               $io_orgs = DB::table('organizations')
               ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
               ->orderby('institute_id')
               ->where('ay_id',$request->input('ay_id'))
               ->where('type','IO')
               ->where('organization_academic_years.accredited', 1)
               ->get();
       
               //GET ALL CULTURAL ORG.
               $co_orgs = DB::table('organizations')
               ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
               ->orderby('code')
               ->where('ay_id',$request->input('ay_id'))
               ->where('type','CO')
               ->where('organization_academic_years.accredited', 1)
               ->get();
       
               //GET ALL COLLEGE WIDE ORG.
               $cw_orgs = DB::table('organizations')
               ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
               ->orderby('code')
               ->where('ay_id',$request->input('ay_id'))
               ->where('type','CW')
               ->where('organization_academic_years.accredited', 1)
               ->get();
       
               //GET ALL ISC
               $isc_orgs = DB::table('organizations')
               ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
               ->orderby('code')
               ->where('ay_id',$request->input('ay_id'))
               ->where('type','ISC')
               ->where('organization_academic_years.accredited', 1)
               ->get();
       
               //GET SSC
               $ssc_orgs = DB::table('organizations')
               ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
               ->orderby('code')
               ->where('ay_id',$request->input('ay_id'))
               ->where('type','SSC')
               ->where('organization_academic_years.accredited', 1)
               ->get();
       
               //GET EQ
               $eq_orgs = DB::table('organizations')
               ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
               ->orderby('code')
               ->where('ay_id',$request->input('ay_id'))
               ->where('type','SP')
               ->where('organization_academic_years.accredited', 1)
               ->get();
       
               //GET SP
               $sp_orgs = DB::table('organizations')
               ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
               ->orderby('code')
               ->where('ay_id',$request->input('ay_id'))
               ->where('type','SPORTS')
               ->where('organization_academic_years.accredited', 1)
               ->get();
       
               //GET FUNDS LIST IN THE SEM SELECTED
                $funds_list = DB::table('funds')
                ->where('ay_id', $request->input('ay_id'))
                ->where('semester', $request->input('sem'))
                ->get();

        //ALLOCATION PROCESS
        foreach($funds_list as $flist){
            // ACADEMIC
            if($flist->name == 'Academic'){
                foreach($isc_orgs as $isc){
                    
                    $budget = new Budget;

                    //IF OPTION IS EQUAL (1)
                    if($request->input('Academic-sem')==1){
                        $budget->budget =  $flist->amount/count($isc_orgs);
                    }
                    //IF OPTION IS EQUATIBLE (2)
                    else{
                        foreach($enrollee as $ie1){
                            if($isc->institute_id == $ie1->institute_id){
                                $percent = ($ie1->no_of_students / $total_enrollee);
                                $budget->budget =  $flist->amount*$percent;
                            }
                        }
                    }
                    $budget->remaining =  $budget->budget;
                    $budget->fund_id = $flist->id;
                    $budget->organization_ay_id = $isc->id;

                    $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
                    ->where('organization_ay_id', '=', $budget->organization_ay_id)
                    ->count();

                    if($check_budget > 0){
                        return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
                    }
                    else{
                        $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
                        ->where('organization_ay_id', '=', $budget->organization_ay_id)
                        ->count();

                        if($check_budget > 0){
                            return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
                        }
                        else{
                            $budget->save();
                        }
                    }
                } 
            }

            // CULTURAL
            if($flist->name == 'Cultural'){
                foreach($co_orgs as $co){
                    $budget = new Budget;
                    $budget->budget =  $flist->amount/count($co_orgs);
                    $budget->remaining = $flist->amount/count($co_orgs);
                    $budget->fund_id = $flist->id;
                    $budget->organization_ay_id = $co->id;
                    
                    $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
                    ->where('organization_ay_id', '=', $budget->organization_ay_id)
                    ->count();

                    if($check_budget > 0){
                        return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
                    }
                    else{
                        $budget->save();
                    }
                }
                
            }

            // PUBLICATION
            if($flist->name == 'Publication'){
                foreach($eq_orgs as $eq){
                    $budget = new Budget;
                    $budget->budget =  $flist->amount/count($eq_orgs);
                    $budget->remaining = $flist->amount/count($eq_orgs);
                    $budget->fund_id = $flist->id;
                    $budget->organization_ay_id = $eq->id;
                    
                    $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
                    ->where('organization_ay_id', '=', $budget->organization_ay_id)
                    ->count();

                    if($check_budget > 0){
                        return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
                    }
                    else{
                        $budget->save();
                    }
                }
                
            }

            // SPORTS
            if($flist->name == 'Sports'){
                foreach($sp_orgs as $sp){
                    $budget = new Budget;
                    $budget->budget =  $flist->amount/count($sp_orgs);
                    $budget->remaining = $flist->amount/count($sp_orgs);
                    $budget->fund_id = $flist->id;
                    $budget->organization_ay_id = $sp->id;
                    
                    $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
                    ->where('organization_ay_id', '=', $budget->organization_ay_id)
                    ->count();

                    if($check_budget > 0){
                        return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
                    }
                    else{
                        $budget->save();
                    }
                }    
            }

            // STUDENT COUNCIL
            if($flist->name == 'Student Council'){
                foreach($ssc_orgs as $ssc){
                    $budget = new Budget;
                    $budget->budget =  $flist->amount/2;
                    $budget->remaining = $flist->amount/2;
                    $budget->fund_id = $flist->id;
                    $budget->organization_ay_id = $ssc->id;
                    
                    $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
                    ->where('organization_ay_id', '=', $budget->organization_ay_id)
                    ->count();

                    if($check_budget > 0){
                        return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
                    }
                    else{
                        $budget->save();
                    }
                }
                foreach($isc_orgs as $isc){
                    foreach($enrollee as $e){
                        if($isc->institute_id == $e->institute_id){
                            $budget = new Budget;
                            //IF OPTION IS EQUAL (1)
                            if($request->input('Student_Council-sem')==1){
                                $budget->budget =  ($flist->amount/2)/count($isc_orgs);
                                $budget->remaining = $budget->budget;
                            }
                            //IF OPTION IS EQUATIBLE (2)
                            else{
                                foreach($enrollee as $ie1){
                                    if($isc->institute_id == $ie1->institute_id){
                                        $budget->budget =  75*$ie1->no_of_students;
                                        $budget->remaining = 75*$ie1->no_of_students;
                                    }
                                }
                            }
                            
                            $budget->fund_id = $flist->id;
                            $budget->organization_ay_id = $isc->id;
                            
                            $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
                    ->where('organization_ay_id', '=', $budget->organization_ay_id)
                    ->count();

                    if($check_budget > 0){
                        return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
                    }
                    else{
                        $budget->save();
                    }
                        }
                        
                    }
                   
                }
                
            }

            // STUDENT ACTIVTIES
            if($flist->name == 'Student Activity'){
                //IF OPTION IS EQUAL (1)
                if($request->input('Student_Activity-sem')==1){
                    $sa_all_orgs = count($cw_orgs)+count($io_orgs);

                    foreach($cw_orgs as $cw){
                        $budget = new Budget;
                        $budget->budget =  $flist->amount/$sa_all_orgs;
                        $budget->remaining = $flist->amount/$sa_all_orgs;
                        $budget->fund_id = $flist->id;
                        $budget->organization_ay_id = $cw->id;
                        
                        $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
                        ->where('organization_ay_id', '=', $budget->organization_ay_id)
                        ->count();
    
                        if($check_budget > 0){
                            return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
                        }
                        else{
                            $budget->save();
                        }
                    }
                    foreach($io_orgs as $io){
                        foreach($enrollee as $e){
                            if($io->institute_id == $e->institute_id){
                                $num_org = DB::table('organization_academic_years')
                                ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                                ->orderby('institute_id')
                                ->where('ay_id',$request->input('ay_id'))
                                ->where('type','IO')
                                ->where('institute_id', $e->institute_id)
                                ->get();
                                $budget = new Budget;
                                $budget->budget =  $flist->amount/$sa_all_orgs;
                                $budget->remaining = $flist->amount/$sa_all_orgs;;
                                $budget->fund_id = $flist->id;
                                $budget->organization_ay_id = $io->id;
                                
                                $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
                        ->where('organization_ay_id', '=', $budget->organization_ay_id)
                        ->count();
    
                        if($check_budget > 0){
                            return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
                        }
                        else{
                            $budget->save();
                        }
                            }
                        }
                    }
                    
                }
                //IF OPTION IS EQUATIBLE (2)
                else{
                    foreach($cw_orgs as $cw){
                        $budget = new Budget;
                        $budget->budget =  ($flist->amount*.10)/count($cw_orgs);
                        $budget->remaining = ($flist->amount*.10)/count($cw_orgs);
                        $budget->fund_id = $flist->id;
                        $budget->organization_ay_id = $cw->id;
                        
                        $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
                        ->where('organization_ay_id', '=', $budget->organization_ay_id)
                        ->count();
    
                        if($check_budget > 0){
                            return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
                        }
                        else{
                            $budget->save();
                        }
                    }
                    foreach($io_orgs as $io){
                        foreach($enrollee as $e){
                            if($io->institute_id == $e->institute_id){
                                $num_org = DB::table('organization_academic_years')
                                ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
                                ->orderby('institute_id')
                                ->where('ay_id',$request->input('ay_id'))
                                ->where('type','IO')
                                ->where('institute_id', $e->institute_id)
                                ->get();
                                $budget = new Budget;
                                $budget->budget =  ((75*$e->no_of_students)*.90)/count($num_org);
                                $budget->remaining = ((75*$e->no_of_students)*.90)/count($num_org);
                                $budget->fund_id = $flist->id;
                                $budget->organization_ay_id = $io->id;
                                
                                $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
                                ->where('organization_ay_id', '=', $budget->organization_ay_id)
                                ->count();
    
                        if($check_budget > 0){
                            return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
                        }   
                        else{
                            $budget->save();
                        }
                            }
                        }
                    }
                }
               
            }
            
        }
        // return response()->json($request->input());
        return redirect()->back()->with('alert-success', 'Allocated successfully!');
     }

    //  {
        
        
        
        // //GET TOTAL NUMBER OF ENROLLED
        //  $total_enrollee = DB::table('enrolled_academic_years')
        //  ->sum('enrolled_academic_years.no_of_students');
         
        //  //GET ENROLLED LIST PER SEM AND YEAR
        //  $enrollee = DB::table('enrolled_academic_years')
        //  ->leftjoin('institutes', 'enrolled_academic_years.institute_id', '=', 'institutes.id')
        //  ->orderby('code')
        //  ->where('ay_id',$request->input('ay_id'))
        //  ->where('sem',$request->input('sem'))
        //  ->get();

        //  //IF THERE ARE NO ENROLLED - RETURN ERROR
        //  $enrollee_num = count($enrollee);
        //  if($enrollee_num == 0){
        //     return redirect()->back()->with('alert-danger', 'Sorry but there are no enrollees listed yet. Pls check the Enrolled List');
        //  }

        // //GET ALL ACCREDITED ORGANIZATION
        // $all_ac_orgs = DB::table('organizations')
        // ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
        // ->orderby('code')
        // ->where('ay_id',$request->input('ay_id'))
        // ->where('organization_academic_years.accredited', 1)
        // ->get();

        // //GET ALL INSTITUTE ORG.
        // $io_orgs = DB::table('organizations')
        // ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
        // ->orderby('institute_id')
        // ->where('ay_id',$request->input('ay_id'))
        // ->where('type','IO')
        // ->where('organization_academic_years.accredited', 1)
        // ->get();

        // //GET ALL CULTURAL ORG.
        // $co_orgs = DB::table('organizations')
        // ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
        // ->orderby('code')
        // ->where('ay_id',$request->input('ay_id'))
        // ->where('type','CO')
        // ->where('organization_academic_years.accredited', 1)
        // ->get();

        // //GET ALL COLLEGE WIDE ORG.
        // $cw_orgs = DB::table('organizations')
        // ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
        // ->orderby('code')
        // ->where('ay_id',$request->input('ay_id'))
        // ->where('type','CW')
        // ->where('organization_academic_years.accredited', 1)
        // ->get();

        // //GET ALL ISC
        // $isc_orgs = DB::table('organizations')
        // ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
        // ->orderby('code')
        // ->where('ay_id',$request->input('ay_id'))
        // ->where('type','ISC')
        // ->where('organization_academic_years.accredited', 1)
        // ->get();

        // //GET SSC
        // $ssc_orgs = DB::table('organizations')
        // ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
        // ->orderby('code')
        // ->where('ay_id',$request->input('ay_id'))
        // ->where('type','SSC')
        // ->where('organization_academic_years.accredited', 1)
        // ->get();

        // //GET EQ
        // $eq_orgs = DB::table('organizations')
        // ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
        // ->orderby('code')
        // ->where('ay_id',$request->input('ay_id'))
        // ->where('type','EQ')
        // ->where('organization_academic_years.accredited', 1)
        // ->get();

        // //GET SP
        // $sp_orgs = DB::table('organizations')
        // ->join('organization_academic_years', 'organizations.id', '=', 'organization_academic_years.organization_id')
        // ->orderby('code')
        // ->where('ay_id',$request->input('ay_id'))
        // ->where('type','SP')
        // ->where('organization_academic_years.accredited', 1)
        // ->get();

        // //GET FUNDS LIST IN THE SEM SELECTED
        //  $funds_list = DB::table('funds')
        //  ->where('ay_id', $request->input('ay_id'))
        //  ->where('semester', $request->input('sem'))
        //  ->get();


    //      //ALLOCATION PROCESS
    //      foreach($funds_list as $flist){
    //         if($flist->name == 'Academic'){
    //             foreach($isc_orgs as $isc){
    //                 $budget = new Budget;
    //                 $budget->budget =  $flist->amount/count($isc_orgs);
    //                 $budget->remaining = $flist->amount/count($isc_orgs);
    //                 $budget->fund_id = $flist->id;
    //                 $budget->organization_ay_id = $isc->id;

    //                 $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
    //                 ->where('organization_ay_id', '=', $budget->organization_ay_id)
    //                 ->count();

    //                 if($check_budget > 0){
    //                     return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
    //                 }
    //                 else{
                        
    //                     $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
    //                 ->where('organization_ay_id', '=', $budget->organization_ay_id)
    //                 ->count();

    //                 if($check_budget > 0){
    //                     return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
    //                 }
    //                 else{
    //                     $budget->save();
    //                 }
    //                 }
                   
    //             }
                
    //         }
    //         if($flist->name == 'Cultural'){
    //             foreach($co_orgs as $co){
    //                 $budget = new Budget;
    //                 $budget->budget =  $flist->amount/count($co_orgs);
    //                 $budget->remaining = $flist->amount/count($co_orgs);
    //                 $budget->fund_id = $flist->id;
    //                 $budget->organization_ay_id = $co->id;
                    
    //                 $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
    //                 ->where('organization_ay_id', '=', $budget->organization_ay_id)
    //                 ->count();

    //                 if($check_budget > 0){
    //                     return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
    //                 }
    //                 else{
    //                     $budget->save();
    //                 }
    //             }
                
    //         }
    //         if($flist->name == 'Publication'){
    //             foreach($eq_orgs as $eq){
    //                 $budget = new Budget;
    //                 $budget->budget =  $flist->amount/count($eq_orgs);
    //                 $budget->remaining = $flist->amount/count($eq_orgs);
    //                 $budget->fund_id = $flist->id;
    //                 $budget->organization_ay_id = $eq->id;
                    
    //                 $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
    //                 ->where('organization_ay_id', '=', $budget->organization_ay_id)
    //                 ->count();

    //                 if($check_budget > 0){
    //                     return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
    //                 }
    //                 else{
    //                     $budget->save();
    //                 }
    //             }
                
    //         }
    //         if($flist->name == 'Sports'){
    //             foreach($sp_orgs as $sp){
    //                 $budget = new Budget;
    //                 $budget->budget =  $flist->amount/count($sp_orgs);
    //                 $budget->remaining = $flist->amount/count($sp_orgs);
    //                 $budget->fund_id = $flist->id;
    //                 $budget->organization_ay_id = $sp->id;
                    
    //                 $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
    //                 ->where('organization_ay_id', '=', $budget->organization_ay_id)
    //                 ->count();

    //                 if($check_budget > 0){
    //                     return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
    //                 }
    //                 else{
    //                     $budget->save();
    //                 }
    //             }
                
    //         }
    //         if($flist->name == 'Student Council'){
    //             foreach($ssc_orgs as $ssc){
    //                 $budget = new Budget;
    //                 $budget->budget =  $flist->amount/2;
    //                 $budget->remaining = $flist->amount/2;
    //                 $budget->fund_id = $flist->id;
    //                 $budget->organization_ay_id = $ssc->id;
                    
    //                 $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
    //                 ->where('organization_ay_id', '=', $budget->organization_ay_id)
    //                 ->count();

    //                 if($check_budget > 0){
    //                     return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
    //                 }
    //                 else{
    //                     $budget->save();
    //                 }
    //             }
    //             foreach($isc_orgs as $isc){
    //                 foreach($enrollee as $e){
    //                     if($isc->institute_id == $e->institute_id){
    //                         $budget = new Budget;
    //                         $budget->budget =  75*$e->no_of_students;
    //                         $budget->remaining = 75*$e->no_of_students;
    //                         $budget->fund_id = $flist->id;
    //                         $budget->organization_ay_id = $isc->id;
                            
    //                         $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
    //                 ->where('organization_ay_id', '=', $budget->organization_ay_id)
    //                 ->count();

    //                 if($check_budget > 0){
    //                     return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
    //                 }
    //                 else{
    //                     $budget->save();
    //                 }
    //                     }
                        
    //                 }
                   
    //             }
                
    //         }
    //         if($flist->name == 'Student Activity'){
    //             foreach($cw_orgs as $cw){
    //                 $budget = new Budget;
    //                 $budget->budget =  ($flist->amount*.10)/count($cw_orgs);
    //                 $budget->remaining = ($flist->amount*.10)/count($cw_orgs);
    //                 $budget->fund_id = $flist->id;
    //                 $budget->organization_ay_id = $cw->id;
                    
    //                 $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
    //                 ->where('organization_ay_id', '=', $budget->organization_ay_id)
    //                 ->count();

    //                 if($check_budget > 0){
    //                     return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
    //                 }
    //                 else{
    //                     $budget->save();
    //                 }
    //             }
    //             foreach($io_orgs as $io){
    //                 foreach($enrollee as $e){
    //                     if($io->institute_id == $e->institute_id){
    //                         $num_org = DB::table('organization_academic_years')
    //                         ->join('organizations', 'organization_academic_years.organization_id', '=', 'organizations.id')
    //                         ->orderby('institute_id')
    //                         ->where('ay_id',$request->input('ay_id'))
    //                         ->where('type','IO')
    //                         ->where('institute_id', $e->institute_id)
    //                         ->get();
    //                         $budget = new Budget;
    //                         $budget->budget =  ((75*$e->no_of_students)*.90)/count($num_org);
    //                         $budget->remaining = ((75*$e->no_of_students)*.90)/count($num_org);
    //                         $budget->fund_id = $flist->id;
    //                         $budget->organization_ay_id = $io->id;
                            
    //                         $check_budget = Budget::where('fund_id', '=', $budget->fund_id)
    //                 ->where('organization_ay_id', '=', $budget->organization_ay_id)
    //                 ->count();

    //                 if($check_budget > 0){
    //                     return redirect()->back()->with('alert-danger', 'There is already existing data, failed to allocate!');
    //                 }
    //                 else{
    //                     $budget->save();
    //                 }
    //                     }
    //                 }
    //             }
                
    //         }
            
    //      }
         
 
    //     // return response()->json($funds_list);
 
    //     return redirect()->back()->with('alert-success', 'Allocated successfully!');
    //     // return view('funds.index', $response, compact('ay'))->with('alert.success', 'Data has been saved');}


     


}   
