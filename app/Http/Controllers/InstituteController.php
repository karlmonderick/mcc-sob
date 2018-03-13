<?php

namespace App\Http\Controllers;

use App\Institute;
use App\User;
use App\Course;
use App\AcademicYear;
use App\EnrolledAcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class InstituteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institute = Institute::all()->sortBy('code');
        $course = Course::all()->sortBy('code');
        $response = [
            'institutes' => $institute,
            'courses' => $course
        ];
        $user = User::all();
        return view('institutes.index',$response, compact('user'));
    }

     public function show(Request $id)
    {
        $ay = AcademicYear::findorFail($id);
        $institute = DB::table('institutes')
        ->join('enrolled_academic_years', 'institutes.id', '=', 'enrolled_academic_years.institute_id')
        ->join('academic_years', 'enrolled_academic_years.ay_id', '=', 'academic_years.id')
        ->select('institutes.*', 'enrolled_academic_years.*')
        ->get();

        $eay = EnrolledAcademicYear::all();

        $response = [ 
            'institute' => $institute
        ];

        $institutes = Institute::all();
    

     //  $total_stud = DB::table('institutes')->sum('total_stud');
        return view('institutes.show', $response, compact('institutes', 'ay', 'eay'));
       // return response()->json($ay);
    }

    public function create()
    {
        return view('institutes.create');
    }

   
    public function store(Request $request)
    {
        $this -> validate($request, [
            'name' => 'required|unique:institutes',
            'code' => 'required|unique:institutes',
        ]);
        $ac_year = AcademicYear::all()->first();

        if(count($ac_year) != 0)
        {
        $institute = new Institute;
        
        $institute->name = $request->input('name');
        $institute->code = $request->input('code');
        $institute->save();
        return redirect()->route('institutes.index')->with('alert-success', $institute->name.' has been added!');
        }
        else
        {
            return redirect()->back()->with('alert-danger', 'Failed to add institute. Please add academic year first!');
        }

    }
    

    public function edit($id)
    {

         $institute = DB::table('institutes')
        ->select('institutes.*')
        ->where('institutes.id', $id)
        ->get();

        $response = [
            'institute' => $institute
        ];
     return view('institutes.edit', $response);
    } 

    public function update(Request $request, $id)
    {
        
        $ay = AcademicYear::where('id', '=', $request->input('ay_id'))->first();
        $ay_id = $ay->id;

        $institute = Institute::findOrFail($id);
        $institute->update($request->input());
        //$ins_is = EnrolledAcademicYear::where('institute_id', '=', $request->input('ins_id'))->first();
       // $ins_is = $ins_is->id;
       // $EnrolledAcademicYear = EnrolledAcademicYear::find($ins_is);
       // $EnrolledAcademicYear->no_of_students = $request->input('no_of_students');
        //$ay = AcademicYear::find($id);
       // $EnrolledAcademicYear->save();

        return redirect()->route('institutes.index')->with('alert-success', 'Data has been updated!');
        
    }

    public function destroy($id)
    {
        $institute = Institute::find($id)->delete();
        return redirect()->route('institutes.index')->with('alert-success', 'Data has been deleted!');
    }

    public function store_courses(Request $request)
    {
        $this -> validate($request, [
            'name' => 'required|unique:institutes',
            'code' => 'required|unique:institutes',
        ]);
        
        $ac_year = AcademicYear::all()->first();

        if(count($ac_year) != 0)
        {
            $course = Course::firstOrNew([
                'name' =>  $request->input('name'),
                'code' => $request->input('code'),
                'institute_id' => $request->input('institute_id')
            ]);
            $course->save();
            return redirect()->back()->with('alert-success', $course->name.' has been added!');
        }
        else
        {
            return redirect()->back()->with('alert-danger', 'Failed to add course. Please add academic year first!');
        }
    }

    public function store_2(Request $request)
    {
        $this -> validate($request, [
            'institute_id' => 'required|unique:enrolled_academic_years',
        ]);
        $ay = AcademicYear::where('id', '=', $request->input('ay_id'))->first();
        $ay_id = $ay->id;
     
        $EnrolledAcademicYear = new EnrolledAcademicYear;

        $EnrolledAcademicYear->no_of_students = $request->input('no_of_students');
        $EnrolledAcademicYear->ay_id = $request->input('ay_id');
        $EnrolledAcademicYear->institute_id = $request->input('institute_id');

        return response()->json($EnrolledAcademicYear);
        // $EnrolledAcademicYear->save(); 
        // return redirect()->route('institutes.show', $ay_id)->with('alert-success', 'Data has been added!');
    }
}
