<?php

namespace App\Http\Controllers;

use App\Course;
use App\AcademicYear;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    
    public function index()
    {
        
    }

    
    public function create()
    {
        //
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

    
    public function show(Course $course)
    {
        $course = Course::all()->sortBy('code');
        $response = [
            'course' => $course
        ];
        return view('course.index',$response);
    }

    
    public function edit(Course $course)
    {
        
    }

    
    public function update(Request $request, $id)
    {
        $this -> validate($request, [
            'name' => 'required|unique:institutes',
            'code' => 'required|unique:institutes',
        ]);
        
        $ac_year = AcademicYear::all()->first();

        if(count($ac_year) != 0)
        {
            $course = Course::where('id', $id)->update([
                'name' =>  $request->input('name'),
                'code' => $request->input('code'),
                'institute_id' => $request->input('institute_id')
            ]);
            return redirect()->back()->with('alert-success', 'A course has been updated!');
        }
        else
        {
            return redirect()->back()->with('alert-danger', 'Failed to add course. Please add academic year first!');
        }
    }

    public function destroy(Course $course)
    {
        //
    }
}
