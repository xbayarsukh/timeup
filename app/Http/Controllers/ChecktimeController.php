<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Redirect,Response;
use DB,Auth;

class ChecktimeController extends Controller
{
    public function index(){
        $company_id = Auth::user()->companies_id;
        $check_times = [];
        $users = User::where('companies_id', $company_id)->get();
        return view('company.checktime.checktimeList', compact('users', 'check_times'));
    }
    public function add(){
        return view('company.checktime.checktimeAdd');
    }
    public function save(Request $request){

        $todayDate = uniqid(date('HisU'));
        $imageName = $todayDate . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('news/img/'), $imageName);

        $title = $request->title;
        $description = $request->description;

        $news = new News();
        $news -> title = $title;
        $news -> description = $description;
        $news -> image = $imageName;
        $news -> companies_id = Auth::user()->companies_id;
        $news -> save();
        return redirect('admin/news')->with('message', 'Амжилттай хадгалагдлаа');
    }
    public function filter(Request $request){
        $users_id = $request->users_id;
        $company_id = Auth::user()->companies_id;
        $check_times = DB::table('time_check')->join('users', 'users.id', '=', 'time_check.users_id')->where('users.id', $users_id)->where('users.companies_id', $company_id)->select('time_check.*')->get();

        return view('company.checktime.check_time',compact('check_times'));
    }
    public function detail(Request $request){
        $check_id = $request->check_id;
        $company_id = Auth::user()->companies_id;
        $check_times = DB::table('time_check')->join('users', 'users.id', '=', 'time_check.users_id')->where('users.companies_id', $company_id)->where('time_check.id', $check_id)->select('time_check.*')->first();

        return response()->json($check_times);
    }
    public function edit($id){
        $company_id = Auth::user()->companies_id;
        $news = News::where('companies_id', '=', $company_id)->where('id', '=', $id)->first();
        return view('company.news.newsEdit', compact('news'));
    }
    public function update(Request $request){
        $company_id = Auth::user()->companies_id;
        $id = $request->id;
        $title = $request->title;
        $description = $request->description;

        $news = News::where('id', $id)->where('companies_id', $company_id)->first();
        $news -> title = $title;
        $news -> description = $description;

        if($request->image != ''){        
            $path = public_path().'/news/img/';
  
            //code for remove old file
            if($news->image != ''  && $news->image != null){
                 $file_old = $path.$news->image;
                 unlink($file_old);
            }
  
            //upload new file
            $todayDate = uniqid(date('HisU'));
            $imageName = $todayDate . '.' . $request->image->getClientOriginalExtension();
            $request->image->move($path, $imageName);
  
            //for update in table
            $news -> image = $imageName;
        }
        
        $news -> companies_id = Auth::user()->companies_id;
        $news -> save();
        
        return redirect('admin/news')->with('message', 'Амжилттай хадгалагдлаа');
    }
    public function check($id){
        $checktimes = DB::table('time_check')->where('users_id', $id)->orderby('datetime','DESC')->get();
        $eventArray = array();
        foreach($checktimes as $checktime){
            $eventArray[] = array(
                'id'=> $checktime->id,
                'title'=> $checktime->morning,
                'start'=> $checktime->datetime,
                'end'=> $checktime->datetime,
                'lat'=> $checktime->lat_morning,
                'long'=> $checktime->long_morning,
            );
            $checktimes2 = DB::table('time_check')->where('id', $checktime->id)->orderby('datetime','DESC')->get();
            foreach($checktimes2 as $checktime2){
                $eventArray[] = array(
                    'id'=> $checktime2->id,
                    'title'=> $checktime2->night,
                    'start'=> $checktime2->datetime,
                    'end'=> $checktime2->datetime,
                    'lat'=> $checktime2->lat_night,
                    'long'=> $checktime2->long_night,
                );
            }
        }
        print(json_encode($eventArray, JSON_PRETTY_PRINT));
    }
    public function delete($id){
        $path = public_path().'/news/img/';
        $news = Event::where('id', $id)->first();
        $news->image;
        $file_old = $path.$news->image;
        unlink($file_old);

        $company_id = Auth::user()->companies_id;
        $news = News::where('id', $id)->where('companies_id', $company_id);
        $news->delete();
        return Redirect::back()->with('message','deleted');
    }
}