<?php

namespace App\Http\Controllers;

use App\CalendarActivities;
use Illuminate\Http\Request;

class CalendarActivitiesController extends Controller
{
    public function store(Request $request)
    	{

            $current_date = date('Y'.'-'.'m'.'-'.'d');

    		$c_activities = new CalendarActivities;
    		$c_activities->name = $request->input('name');
    		$c_activities->nature = $request->input('nature');
    		$c_activities->date = $request->input('date');
    		$c_activities->organization_ay_id = $request->input('organization_ay_id');
    		$c_activities->p_budget = $request->input('p_budget');
            	$c_activities->ay_id = $request->input('ay_id');

            if($c_activities->date < $current_date)
                {
                    return redirect()->back()->with('alert-danger', 'Date error!');
                }
            else
                {
        		$c_activities->save();

        		return redirect()->back()->with('alert-success', 'Data has been added successfully!');
                }
    		//return response()->json($c_activities);
    	}

     public function update(Request $request, $id)
        {
            $current_date = date('Y'.'-'.'m'.'-'.'d');
           $CalendarActivities = CalendarActivities::findOrFail($id);

                
                 $CalendarActivities->name = $request->input('name');
                 $CalendarActivities->nature = $request->input('nature');
                 $CalendarActivities->date = $request->input('date');
                 $CalendarActivities->p_budget = $request->input('p_budget');

                  if($CalendarActivities->date < $current_date)
                {
                    return redirect()->back()->with('alert-danger', 'Date error!');
                }
            else
                {
                $CalendarActivities->save(); 

                return redirect()->back()->with('alert-success', 'Data has been updated!');
                }

                 
         }

     public function destroy($id)
     {
         $CalendarActivities = CalendarActivities::find($id)->delete();
         return redirect()->back()->with('alert-success', 'Data has been deleted!');
         //return response()->json(['message'=>'Organization deleted']);
     }
}
