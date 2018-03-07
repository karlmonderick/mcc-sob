<?php

namespace App\Http\Controllers;

use App\EnrolledStudents;
use App\AcademicYear;

use CsvData;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class EnrolledStudentsController extends Controller
{
    
    public function index()
    {
        $ay = AcademicYear::find($id);
        return view('enrolled_students.index');
    }


    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {   
        //get file
        $upload=$request->file('upload_file');
        $filePath=$upload->getRealPath();

        //open and read
        $file=fopen($filePath, 'r');

        $header= fgetcsv($file);

        // dd($header);
        $escapedHeader=[];

        //validate
        foreach ($header as $key => $value) {
            $escapedItem=preg_replace('/[., ]/', '', $value);
            array_push($escapedHeader, $escapedItem);
        }

        //looping through othe columns
        while($columns=fgetcsv($file))
        {
          
            //trim data
            foreach ($columns as $key => &$value) 
            {
                $value=iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$value);
            }
           
            $data= array_combine($escapedHeader, $columns);

            // setting type
            foreach ($data as $key => &$value) {
                // Table update
                $num=$data['No'];
                $stud_num=$data['StudentNo'];
                $surname=$data['Surname'];
                $f_m_name=$data['Firstname-Middlename'];
                $program=$data['Program'];
                $yr_level=$data['Yearlevel'];

                $es = EnrolledStudents::firstOrNew(['year_level' => $yr_level]);
                $es->student_no = $stud_num;
                $es->surname = $surname;
                $es->firstname_middlename = $f_m_name;
                $es->course = $program;
                $es->sem =  1;
                $es->ay_id = 2;
                $es->save();
            }
        }
            return redirect()->back()->with('alert-success', 'Sucessfully Uploaded!');
 
    }

    
    public function show($id)
    {
        $ay = AcademicYear::find($id);
        
        $enrolled = DB::table('enrolled_students')
        ->where('ay_id', $id)
        ->get();

        return view('enrolled_students.index', compact('ay', 'enrolled'));
    }

   
    public function edit($id)
    {
        //
    }

   
    public function update(Request $request, $id)
    {
        //
    }

   
    public function destroy($id)
    {
        //
    }

    public function store2(Request $request)
        {
            $data = $request->file('upload_file');
            $csv_data = json_decode($data->csv_data, true);
    
            foreach ($csv_data as $row) {
                $contact = new EnrolledStudents();
    
                foreach (config('app.db_sob') as $index => $field) {
                    $contact->$field = $row[$request->fields[$index]];
                }
                //$contact->save();
            }
                // EnrolledStudents::insert($dataArray);
                // return redirect()->back()->with('alert-success', 'File uploaded successfully!');
                // dd($enrolled_students);
                return response()->json($contact->$field);
               
     
        }
}
