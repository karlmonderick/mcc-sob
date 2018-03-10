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
        return view('enrolled_students.upload');
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

        /*
            --validate--
            this part loops the csv file and replace the characters
            then insert the file to the $escapedItem variable
            $escapedItem  has no further usage
        */
        foreach ($header as $key => $value) {
            $escapedItem=preg_replace('/[., ]/', '', $value);
            array_push($escapedHeader, $escapedItem);
        }
        

        /*
            --looping through otheR columns--
            loop while opening the csv file
        */
        set_time_limit(300);
        
        while($columns=fgetcsv($file))
        {
          
            /*
                --trim data--
                another looping of the csv
            */
            foreach ($columns as $key => &$value) 
            {
                $value=iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE',$value);
            }
           

            $data= array_combine($escapedHeader, $columns);

            /* 
                setting type
                another looping of the csv
            */
            foreach ($data as $key => &$value) {
                // Table update
                
                $stud_num=$data['StudentNo'];
                $surname=$data['Surname'];
                $f_m_name=$data['Firstname-Middlename'];
                $course=$data['Course'];
                $yr_level=$data['Yearlevel'];
                $sem = 1;
                $ay_id =2;

                if($stud_num==NULL){
                    return redirect()->back()->with('alert-danger', 'We think that there is a Student Number that is empty!');
                }
                if($surname==NULL){
                    return redirect()->back()->with('alert-danger', 'Student No: '.$stud_num.' has no surname! Please check CSV File.');
                }
                if($f_m_name==NULL){
                    return redirect()->back()->with('alert-danger', 'Student No: '.$stud_num.' has no first name! Please check CSV File.');
                }
                if($course==NULL){
                    return redirect()->back()->with('alert-danger', 'Student No: '.$stud_num.' has no course! Please check CSV File.');
                }
                if($yr_level==NULL){
                    return redirect()->back()->with('alert-danger', 'Student No: '.$stud_num.' has no year level! Please check CSV File.');
                }


                $es = EnrolledStudents::firstOrNew([
                    'student_no' => $stud_num, 
                    'firstname_middlename' => $f_m_name, 
                    'surname' => $surname, 
                    'course' => $course, 
                    'year_level' => $yr_level, 
                    'sem' => $sem, 
                    'ay_id' => $ay_id
                ]);

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
