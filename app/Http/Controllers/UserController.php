<?php

namespace App\Http\Controllers;

use App\User;
use App\Organization;
use App\Role;
use Hash;
use Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function upload_image(Request $request)
    {
        $this->validate($request, ['file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',]);

        $users = User::where('users.id' ,$request->input('u_id'))->first();
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
        $users->photo = $filename;
        //delete the old photi
        //Storage::delete($oldphoto);
        }
        $users->save();

       // return response()->json($filename);
        return redirect()->back()->with('alert-success', 'New Profile Image has been updated');
    }

    public function index()
    {
        $user = User::with('role')
        ->orderBy('es_id')
        ->get();

        $user_e = User::with('role')
        ->orderBy('es_id')
        ->where('role_id', '!=', '4')
        ->get();

        $user_s = User::with('role')
        ->orderBy('es_id')
        ->where('role_id', '4')
        ->get();
       
        return view('users.index', compact('user', 'user_e', 'user_s'));
    }

   
    public function create()
    {
        $org = Organization::all();
        $role = Role::all();
        return view('users.create', compact('org'), compact('role'));
    }

   
    public function store(Request $request)
    {
        $user = new User;
        $user->es_id = $request->input('es_id');
        $user->first_name = $request->input('first_name');
        $user->middle_name = $request->input('middle_name');
        $user->last_name = $request->input('last_name');
        $user->role_id = $request->input('role_id');
        $user->contact = $request->input('contact');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('es_id'));
        $user->status = $request->input('status');
        $user->photo = "";
        

        $users = DB::table('users')
        ->where('role_id', $user->role_id)
        ->get();

        if($user->status==1){
            foreach ($users as $users){
                $users = User::findOrFail($users->id);
                $users->status = 0;
                $users->save();
            }
        }

        $user->save();

        return redirect()->route('users.index')->with('alert-success', 'Data has been saved!');
        
    }

    
    public function show($id)
    {
        $user_id = Auth::user()->id;
        $users = User::findOrFail($user_id);

        return view('users.show', compact('users'));
       // return response()->json($user);
    }

   
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $org = Organization::all();
        $role = Role::all();
        return view('users.edit', compact('user', 'org', 'role'));
    }

   
    public function update(Request $request, $id)
    {
       
         $users = User::findOrFail($id);
        $name = $request->input('first_name');
        $m_name = $request->input('middle_name');
        $l_name = $request->input('last_name');
        $es_id = $request->input('es_id');
        $email = $request->input('email');
        $contact = $request->input('contact');
        $password = $request->input('current_pass');
        $check = Hash::check($password, $users->password);
        if ($check == TRUE && $request->input('password') == $request->input('c_password'))
        {
            $users->password = bcrypt($request->input('password'));
            $users->save();
            return redirect()->route('users.show', $id)->with('alert-success', 'Data has been updated!');
        }
        elseif ($es_id == TRUE)
        {
            $users->es_id = $es_id;
            $users->save();
            return redirect()->route('users.show', $id)->with('alert-success', 'Data has been updated!');
        }
         elseif ($email == TRUE)
        {
            $users->email = $email;
            $users->save();
            return redirect()->route('users.show', $id)->with('alert-success', 'Data has been updated!');
        }
         elseif ($contact == TRUE)
        {
            $users->contact = $contact;
            $users->save();
            return redirect()->route('users.show', $id)->with('alert-success', 'Data has been updated!');
        }
        elseif ($name == TRUE || $m_name == TRUE || $l_name == TRUE)
        {
            $users->first_name = $name;
            $users->middle_name = $m_name;
            $users->last_name = $l_name;
            $users->save();
            return redirect()->route('users.show', $id)->with('alert-success', 'Data has been updated!');
        }
        elseif($check == FALSE){
         return redirect()->route('users.show', $id)->with('alert-danger', 'Current Password error!');
         return back()->json($users);
        }
        elseif($request->input('password') != $request->input('c_password')){
         return redirect()->route('users.show', $id)->with('alert-danger', 'Password doesnt match!');
     }
        
    }
    
    public function destroy($id)
    {
        $user = User::find($id)->delete();
        return redirect()->route('users.index')->with('alert-success', 'Data has been deleted!');
    }


      public function getImage()
    {
        return view('users.edit');
    }

    public function postImage(Request $request)
    {
        $this->validate($request, [
            'image_file' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);
        $imageName = time().'.'.$request->image_file->getClientOriginalExtension();
        $request->image_file->move(public_path('images'), $imageName);
        return back()
            ->with('success','You have successfully upload images.')
            ->with('image',$imageName);
    }

     
}
