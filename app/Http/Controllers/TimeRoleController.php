<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Location;
use Redirect,Response;
use DB,Auth;
use Illuminate\Support\Facades\Hash;

class TimeRoleController extends Controller
{
    public function index(){
        $company_id = Auth::user()->companies_id;
        $locations = Location::where('companies_id', $company_id)->get();
        $roles = DB::table('time_role')->orderBy("created_at", "desc")->where('companies_id', $company_id)->get();
        $users = [];
        return view('company.roletime.rtimeList', compact('users', 'roles', 'locations'));
    }
    public function add(){
        return view('company.employees.employeAdd', );
    }
    public function save(Request $request){
        $company_id = Auth::user()->companies_id;
        $morning = $request->morning;
        $night = $request->night;
        $week = $request->week;

        DB::table('time_role')->insertGetId(
            ['morning' => $morning, 'night' => $night, 'week' => $week, 'companies_id' => $company_id]
        );

        $company_id = Auth::user()->companies_id;
        $roles = DB::table('time_role')->orderBy("created_at", "desc")->where('companies_id', $company_id)->get();

        return view('company.roletime.role_time',compact('roles'));
    }
    public function filter(Request $request){
        $roles_id = $request->roles_id;
        $company_id = Auth::user()->companies_id;
        $users = DB::table('users')
        ->select('*')
        ->where('companies_id','=',$company_id)
        ->where(function ($query) use ($roles_id){
            $query->where('time_role_id','=',$roles_id)
                ->orWhere('time_role_id','=',0);
        })
        ->get();

        return view('company.roletime.user',compact('users', 'roles_id'));
    }
    public function show(Request $request){
        $loc_id = $request->loc_id;
        $company_id = Auth::user()->companies_id;
        $locations = Location::where('companies_id', $company_id)->where('id', $loc_id)->first();
        return response()->json($locations);
    }
    public function change_user(Request $request){
        $roles_id = $request->roles_id;
        $users_id = $request->users_id;
        $company_id = Auth::user()->companies_id;
        $users = DB::table('users')->where('companies_id', $company_id)->where('id', $users_id)->update(['time_role_id' => $roles_id]);
    }
    public function changed_user(Request $request){
        $users_id = $request->users_id;
        $company_id = Auth::user()->companies_id;
        $users = DB::table('users')->where('companies_id', $company_id)->where('id', $users_id)->update(['time_role_id' => 0]);
    }

    public function add_loc(Request $request){
        $company_id = Auth::user()->companies_id;
        $name = $request->name;
        $center = $request->center;
        $polygons = $request->polygons;

        if(count($polygons) != 0){
            $id = DB::table('locations')->insertGetId(
                ['name' => $name, 'lat' => $center['lat'], 'long' => $center['lng'], 'companies_id' => $company_id]
            );
    
            foreach ($polygons as $polygon) {
                DB::table('polygon')->insert(
                    ['lat' => $polygon['lat'], 'long' => $polygon['lng'], 'locations_id' => $id]
                );
            }
        }

        $locations = DB::table('locations')->orderBy("created_at", "desc")->where('companies_id', $company_id)->get();

        return view('company.roletime.location',compact('locations'));
    }

    public function del_loc(Request $request){
        $company_id = Auth::user()->companies_id;
        $id = $request->id;

        DB::table('locations')->where('companies_id', $company_id)->where('id', $id)->delete();
        DB::table('polygon')->join('locations', 'polygon.locations_id', '=', 'locations.id')->where('locations.companies_id', $company_id)->where('locations.id', $id)->delete();
        
        $locations = DB::table('locations')->orderBy("created_at", "desc")->where('companies_id', $company_id)->get();

        return view('company.roletime.location',compact('locations'));
    }

    public function edit($id){
        $company_id = Auth::user()->companies_id;
        $employe = User::where('companies_id', '=', $company_id)->where('id', '=', $id)->first();
        return view('company.employees.employeEdit', compact('employe'));
    }
    public function update(Request $request){
        $company_id = Auth::user()->companies_id;
        $id = $request->id;
        $lname = $request->lname;
        $fname = $request->fname;
        $register = $request->register;
        $job_title = $request->job_title;
        $salary = $request->salary;
        $phone = $request->phone;
        $email = $request->email;
        $username = $request->username;

        $user = User::where('id', $id)->where('companies_id', $company_id)->first();
        $user -> lname = $lname;
        $user -> fname = $fname;
        
        $user -> salary = $salary;
        $user -> phone = $phone;
        $user -> register = $register;
        $user -> email = $email;
        $user -> job_title = $job_title;
        $user -> username = $username;
        
        if($request->password != ''){
            $user -> password = Hash::make($request->password);
        }

        if($request->image != ''){        
            $path = public_path().'/employees/img/';
  
            //code for remove old file
            if($user->image != ''  && $user->image != null){
                 $file_old = $path.$user->image;
                 unlink($file_old);
            }
  
            //upload new file
            $todayDate = uniqid(date('HisU'));
            $imageName = $todayDate . '.' . $request->image->getClientOriginalExtension();
            $request->image->move($path, $imageName);
  
            //for update in table
            $user -> image = $imageName;
        }
        
        $user -> save();
        
        return redirect('admin/employees')->with('message', 'Амжилттай хадгалагдлаа');
    }
    public function delete($id){
        $company_id = Auth::user()->companies_id;
        $users = DB::table('users')->where('companies_id', $company_id)->where('time_role_id', $id)->update(['time_role_id' => 0]);
        $time_roles = DB::table('time_role')->where('id', $id)->delete();
        return Redirect::back()->with('message','deleted');
    }
}