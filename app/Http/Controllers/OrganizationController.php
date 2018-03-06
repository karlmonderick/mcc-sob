<?php

namespace App\Http\Controllers;

use App\Organization;
use App\Institute;
use App\User;
use App\OrganizationAcademicYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class OrganizationController extends Controller
{

    public function index()
    {
            $org = Organization::all()->sortBy("code");
            $response = [
                'organizations' => $org
            ];
            
            $ins = Institute::all()->sortBy('code');

            $institutes = Institute::all()->sortBy('code');

            // COUNT NUMBER OF ORGANIZATIONS
            $count_cw = Organization::where('type', '=', 'CW')->count();
            $count_co = Organization::where('type', '=', 'CO')->count();
            $count_isc = Organization::where('type', '=', 'ISC')
            ->count();
            $count_ssc = Organization::where('type', '=', 'SSC')
            ->count();
            $count_ias = Organization::where('type', '=', 'IO')
                ->where('institute_id','=', 2)
                ->count();
            $count_ibe = Organization::where('type', '=', 'IO')
                ->where('institute_id','=',3)
                ->count();
            $count_ics = Organization::where('type', '=', 'IO')
                ->where('institute_id','=',4)
                ->count(); 
            $count_ihm = Organization::where('type', '=', 'IO')
                ->where('institute_id','=',5)
                ->count();
            $count_ite = Organization::where('type', '=', 'IO')
                ->where('institute_id','=',6)
                ->count();
            $count_io = Organization::where('type', '=', 'IO')
                ->count();
            
            $count_eq = Organization::where('type', 'SP')
                ->count();

            $count_sc = $count_isc + $count_ssc;
            $count_total = Organization::all()->count();

            return view('organizations.index',$response, 
                compact('ins', 'institutes', 'count_cw', 'count_co', 'count_ias', 'count_ibe', 'count_ics', 'count_ihm', 'count_ite', 'count_sc', 'count_eq', 'count_total'));
            
    }

 
   public function create()
    {
        $ins = Institute::all();
        $user = User::with('role')->get();
        return view('organizations.create', compact('user'),compact('ins'));
    }
    public function store(Request $request)
    {
         $this -> validate($request, [
            'name' => 'required|unique:organizations',
        ]);
         $ins_list = Institute::all()->first();

         if(count($ins_list) != 0)
         {
            $organization = new Organization;

            $organization->code = $request->input('code');
            $organization->name = $request->input('name');
            $organization->type = $request->input('type');
            $organization->institute_id = $request->input('institute_id');
            $organization->save(); 
            
            return redirect()->route('organizations.index')->with('alert-success', 'Data has been saved');
        }
        else
        {
           return redirect()->route('organizations.index')->with('alert-danger', 'Sorry. But there is no Institute listed yet in the list.'); 
        }
        //return response()->json(['organization' => $organization], 201);
    }

    public function show($id)
    {
        return Organization::find($id);
    }

    public function edit($id)
    {
        $ins = Institute::all();
        $organization = Organization::findOrFail($id);
        return view('organizations.edit', compact('organization', 'ins') );
    }

     public function update(Request $request, $id)
     {
        $this -> validate($request, [
            'name'=> 'required',
        ]);

        $organization = Organization::findOrFail($id);
        $organization->name = $request->input('name');
        $organization->code = $request->input('code');
        $organization->type = $request->input('type');
        $organization->institute_id = $request->input('institute_id');
        $organization->update();
        return redirect()->route('organizations.index')->with('alert-success', 'Data has been updated!');
     }

     public function destroy($id)
     {
         $organization = Organization::find($id)->delete();
         return redirect()->route('organizations.index')->with('alert-success', 'Data has been deleted!');
         //return response()->json(['message'=>'Organization deleted']);
     }

     public function upload_org_logo(Request $request)
     {
         $this->validate($request, ['file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);
 
         $org = Organization::where('id' ,$request->input('o_id'))->first();
         
         if(Input::hasFile('file')){
            //add the new photo
            $file = Input::file('file');
            $filename = $file->getClientOriginalName();
            $file->move('uploads', $file->getClientOriginalName());
            // create instance of Intervention Image
            //$file->resize(20,20);
            //Image::make($file)->resize(800, 400);
            //$oldphoto = $users->photo;
            //update the database
            $org->logo = $filename;
            //delete the old photi
            //Storage::delete($oldphoto);
            $org->save();
            return redirect()->back()->with('alert-success', 'New Logo has been saved');
         }
         else{
            return redirect()->back()->with('alert-danger', 'Error Upload');
         }
         
 
        // return response()->json($filename);
         
     }
}
