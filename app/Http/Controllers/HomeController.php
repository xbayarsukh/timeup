<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\User;
use App\News;
use App\Event;
use App\Location;
use App\Freetime;
use Ismaelw\LaraTeX\LaraTeX;
use Ismaelw\LaraTeX\LaraTeX\src\RawTex;
use PDF, Auth, DB;
use App\Company;

class HomeController extends Controller
{
    public function index(){
        $company = Company::where('id', Auth::user()->companies_id)->first();
        $users = User::where('companies_id', Auth::user()->companies_id)->get();
        $freetimes = Freetime::where('companies_id', Auth::user()->companies_id)->get();
        $news = News::where('companies_id', Auth::user()->companies_id)->get();
        $event = Event::where('companies_id', Auth::user()->companies_id)->get();
        $location = Location::where('companies_id', Auth::user()->companies_id)->get();
        $locations = Location::join('time_role', 'locations.id', '=', 'time_role.locations_id')->join('users', 'time_role.id', '=', 'users.time_role_id')->where('locations.companies_id', Auth::user()->companies_id)->groupBy('locations.id')->select(array('locations.*', DB::raw('COUNT(users.id) as ucount')))->get();
        $check_locations = Location::join('time_role', 'locations.id', '=', 'time_role.locations_id')->join('users', 'time_role.id', '=', 'users.time_role_id')->join('time_check', 'users.id', '=', 'time_check.users_id')->where('locations.companies_id', Auth::user()->companies_id)->where('time_check.datetime', \Carbon\Carbon::today())->groupBy('locations.id')->select(array('locations.id', DB::raw('COUNT(users.id) as ucount')))->get();
        $timecheck = DB::table('time_check')->join('users', 'time_check.users_id', '=', 'users.id')->groupBy('time_check.id')->get();
        $today = DB::table('time_check')->join('users', 'time_check.users_id', '=', 'users.id')->where('users.companies_id', Auth::user()->companies_id)->whereDate('datetime', \Carbon\Carbon::today())->groupBy('time_check.users_id')->get();
        $ago1 = DB::table('time_check')->join('users', 'time_check.users_id', '=', 'users.id')->where('users.companies_id', Auth::user()->companies_id)->whereDate('datetime', \Carbon\Carbon::today()->subDays(1))->groupBy('time_check.users_id')->get();
        $ago2 = DB::table('time_check')->join('users', 'time_check.users_id', '=', 'users.id')->where('users.companies_id', Auth::user()->companies_id)->whereDate('datetime', \Carbon\Carbon::today()->subDays(2))->groupBy('time_check.users_id')->get();
        $ago3 = DB::table('time_check')->join('users', 'time_check.users_id', '=', 'users.id')->where('users.companies_id', Auth::user()->companies_id)->whereDate('datetime', \Carbon\Carbon::today()->subDays(3))->groupBy('time_check.users_id')->get();
        $ago4 = DB::table('time_check')->join('users', 'time_check.users_id', '=', 'users.id')->where('users.companies_id', Auth::user()->companies_id)->whereDate('datetime', \Carbon\Carbon::today()->subDays(4))->groupBy('time_check.users_id')->get();
        $ago5 = DB::table('time_check')->join('users', 'time_check.users_id', '=', 'users.id')->where('users.companies_id', Auth::user()->companies_id)->whereDate('datetime', \Carbon\Carbon::today()->subDays(5))->groupBy('time_check.users_id')->get();
        $ago6 = DB::table('time_check')->join('users', 'time_check.users_id', '=', 'users.id')->where('users.companies_id', Auth::user()->companies_id)->whereDate('datetime', \Carbon\Carbon::today()->subDays(6))->groupBy('time_check.users_id')->get();
        $ago7 = DB::table('time_check')->join('users', 'time_check.users_id', '=', 'users.id')->where('users.companies_id', Auth::user()->companies_id)->whereDate('datetime', \Carbon\Carbon::today()->subDays(7))->groupBy('time_check.users_id')->get();
        $ago8 = DB::table('time_check')->join('users', 'time_check.users_id', '=', 'users.id')->where('users.companies_id', Auth::user()->companies_id)->whereDate('datetime', \Carbon\Carbon::today()->subDays(8))->groupBy('time_check.users_id')->get();
        $ago9 = DB::table('time_check')->join('users', 'time_check.users_id', '=', 'users.id')->where('users.companies_id', Auth::user()->companies_id)->whereDate('datetime', \Carbon\Carbon::today()->subDays(9))->groupBy('time_check.users_id')->get();
        $ago10 = DB::table('time_check')->join('users', 'time_check.users_id', '=', 'users.id')->where('users.companies_id', Auth::user()->companies_id)->whereDate('datetime', \Carbon\Carbon::today()->subDays(10))->groupBy('time_check.users_id')->get();
        $ago11 = DB::table('time_check')->join('users', 'time_check.users_id', '=', 'users.id')->where('users.companies_id', Auth::user()->companies_id)->whereDate('datetime', \Carbon\Carbon::today()->subDays(11))->groupBy('time_check.users_id')->get();
        $ago12 = DB::table('time_check')->join('users', 'time_check.users_id', '=', 'users.id')->where('users.companies_id', Auth::user()->companies_id)->whereDate('datetime', \Carbon\Carbon::today()->subDays(12))->groupBy('time_check.users_id')->get();
        $ago13 = DB::table('time_check')->join('users', 'time_check.users_id', '=', 'users.id')->where('users.companies_id', Auth::user()->companies_id)->whereDate('datetime', \Carbon\Carbon::today()->subDays(13))->groupBy('time_check.users_id')->get();
        return view('company.index', ['company' => $company, 'users' => $users, 'freetimes' => $freetimes, 'timecheck' => $timecheck, 'news' => $news, 'event' => $event, 'location' => $location, 'today' => $today, 'ago1' => $ago1, 'ago2' => $ago2, 'ago3' => $ago3, 'ago4' => $ago4, 'ago5' => $ago5, 'ago6' => $ago6, 'ago7' => $ago7, 'ago8' => $ago8, 'ago9' => $ago9, 'ago10' => $ago10, 'ago11' => $ago11, 'ago12' => $ago12, 'ago13' => $ago13, 'locations' => $locations, 'check_locs' => $check_locations]);
    }
    
    public function index2(){
        echo "sdfasdfhasdlkjfjk";
    }

    public function home(Request $request){
        return view('welcom4');
    }

    public function test(Request $request){
        $pdf = PDF::loadView('latex.tex')->setPaper('a4', 'portrait');
        $path = public_path('pdf_docs/');
        $fileName =  time().'.'. 'pdf' ;
        $pdf->save($path . '/' . $fileName);
        $generated_pdf_link = url('pdf_docs/'.$fileName);
        return $pdf->stream();
    }
}