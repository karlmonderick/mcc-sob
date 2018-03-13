<?php

namespace App\Http\Controllers;
use App\Institute;
use App\User;
use App\AcademicYear;
use App\PaymentAmount;
use App\Funds;
use Auth;
use Illuminate\Support\Facades\DB;
use App\EnrolledAcademicYear;
use Illuminate\Http\Request;

class EnrolledAcademicYearController extends Controller
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
        $ay = AcademicYear::where('id', '=', $request->input('ay_id'))->first();
        $sem = $request->input('sem');
        $ay_id = $ay->id;
        $institutes = Institute::all()->sortBy('code');
        
        $check_enrolled =  EnrolledAcademicYear::where('ay_id', '=', $ay_id)
        ->where('sem', $sem)
        ->where('ay_id', $ay_id)
        ->count();


        $TotalEnrolled = DB::table('enrolled_academic_years')
        ->where('sem', $sem)
        ->where('ay_id', $ay_id)
        ->sum('enrolled_academic_years.no_of_students');

        $payments = PaymentAmount::all();

        if($check_enrolled>0)
        {
            foreach($payments as $payments){

                $fund = Funds::firstOrNew([
                    'name' => $payments->name,
                    'amount' => $TotalEnrolled * $payments->amount, 
                    'remaining' => $TotalEnrolled * $payments->amount, 
                    'semester' => $sem, 
                    'ay_id' => $ay_id, 
                    'user_id' => Auth::user()->id, 
                    'ay_id' => $request->input('ay_id')
                ]);

                if(count($institutes) != 0){
                    $fund->save();
                }
            }
        }
        
        else
        {
            return redirect()->back()->with('alert-danger', 'No enrollees found!');
        }
        
        
        
       //  return redirect()->route('institutes.show', $ay_id)->with('alert-success', 'Data has been added!');
       // if(count($institutes) != 0)
       // {
        return redirect()->back()->with('alert-success', 'Generate Funds successfully!');
       // }
       // else
        //{
        //    return redirect()->back()->with('alert-danger', 'Sorry but there are no institute listed yet. Pls check the Institute List');;
      //  }
        // return response()->json($payment);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EnrolledAcademicYear  $enrolledAcademicYear
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ay = AcademicYear::findorFail($id);
        $institute_enroll= DB::table('institutes')
        ->leftjoin('enrolled_academic_years', 'institutes.id', '=', 'enrolled_academic_years.institute_id')
        ->select('institutes.*', 'enrolled_academic_years.*')
        ->orderby('code')
        ->where('enrolled_academic_years.ay_id', '=', $id)
        ->get();

        $eay = EnrolledAcademicYear::all();

        $response = [ 
            'institute_enroll' => $institute_enroll
        ];

        $institutes = Institute::all()->sortBy('code');

        $TotalEnrolled_1 = DB::table('enrolled_academic_years')
        ->where('sem','=',1)
        ->where('ay_id','=',$id)
        ->sum('enrolled_academic_years.no_of_students');

        $TotalEnrolled_2 = DB::table('enrolled_academic_years')
        ->where('sem','=',2)
        ->where('ay_id','=',$id)
        ->sum('enrolled_academic_years.no_of_students');
    

        // $total_stud = DB::table('institutes')->sum('total_stud');
        return view('enrolled_ay.index', $response, compact('institutes', 'ay', 'eay', 'TotalEnrolled_1', 'TotalEnrolled_2'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EnrolledAcademicYear  $enrolledAcademicYear
     * @return \Illuminate\Http\Response
     */
    public function edit(EnrolledAcademicYear $enrolledAcademicYear)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EnrolledAcademicYear  $enrolledAcademicYear
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EnrolledAcademicYear $enrolledAcademicYear)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EnrolledAcademicYear  $enrolledAcademicYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(EnrolledAcademicYear $enrolledAcademicYear)
    {
        //
    }
}
