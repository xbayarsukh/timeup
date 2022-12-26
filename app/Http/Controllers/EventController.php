<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Event;
use App\Ecat;
use Redirect,Response;
use DB,Auth;

class EventController extends Controller
{
    public function index(){
        $company_id = Auth::user()->companies_id;
        $events = Event::join("ecat","events.ecat_id","=","ecat.id")->where('companies_id', '=', $company_id)->select('events.*', DB::raw('ecat.name as cat_name'))->orderBy("created_at", "desc")->paginate(15);
        return view('company.events.eventList', ['events' => $events]);
    }
    public function add(){
        $company_id = Auth::user()->companies_id;
        $cat = DB::table('ecat')->where('company_id',$company_id)->get();
        return view('company.events.eventAdd', ['category' => $cat]);
    }
    public function save(Request $request){

        $todayDate = uniqid(date('HisU'));
        $imageName = $todayDate . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('events/img/'), $imageName);

        $category = $request->category;
        $title = $request->title;
        $description = $request->description;
        $where = $request->where;
        $lat = $request->lat;
        $long = $request->long;
        $when = $request->when;
        $times = $request->many_time;

        $events = new Event();
        $events -> title = $title;
        $events -> description = $description;
        $events -> image = $imageName;
        $events -> location = $where;
        $events -> lat = $lat;
        $events -> long = $long;
        $events -> date = $when;
        $events -> time = $times;
        $events -> ecat_id = $category;
        $events -> companies_id = Auth::user()->companies_id;
        $events -> save();
        return redirect('admin/events')->with('message', 'Амжилттай хадгалагдлаа');
    }
    public function edit($id){
        $company_id = Auth::user()->companies_id;
        $category = DB::table('ecat')->where('company_id', '=', $company_id)->get();
        $event = Event::where('companies_id', '=', $company_id)->where('id', '=', $id)->first();
        return view('company.events.eventEdit', compact('event', 'category'));
    }
    public function update(Request $request){
        $company_id = Auth::user()->companies_id;
        $id = $request->id;
        $category = $request->category;
        $title = $request->title;
        $description = $request->description;
        $where = $request->where;
        $lat = $request->lat;
        $long = $request->long;
        $when = $request->when;
        $times = $request->many_time;

        $events = Event::where('id', $id)->where('companies_id', $company_id)->first();
        $events -> title = $title;
        $events -> description = $description;

        if($request->image != ''){        
            $path = public_path().'/events/img/';
  
            //code for remove old file
            if($events->image != ''  && $events->image != null){
                 $file_old = $path.$events->image;
                 unlink($file_old);
            }
  
            //upload new file
            $todayDate = uniqid(date('HisU'));
            $imageName = $todayDate . '.' . $request->image->getClientOriginalExtension();
            $request->image->move($path, $imageName);
  
            //for update in table
            $events -> image = $imageName;
        }
        
        $events -> location = $where;
        $events -> lat = $lat;
        $events -> long = $long;
        $events -> date = $when;
        $events -> time = $times;
        $events -> ecat_id = $category;
        $events -> companies_id = Auth::user()->companies_id;
        $events -> save();
        
        return redirect('admin/events')->with('message', 'Амжилттай хадгалагдлаа');
    }
    
    public function delete($id){
        $path = public_path().'/events/img/';
        $events = Event::where('id', $id)->first();
        $events->image;
        $file_old = $path.$events->image;
        unlink($file_old);
        
        $company_id = Auth::user()->companies_id;
        $event = Event::where('id', $id)->where('companies_id', $company_id);
        $event->delete();
        return Redirect::back()->with('message','deleted');
    }
}