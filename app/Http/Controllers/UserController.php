<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Redirect,Response;
use DB,Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $company_id = Auth::user()->companies_id;
        $user = User::where('companies_id', '=', $company_id)->orderBy("created_at", "desc")->paginate(15);
        return view('company.employees.employeList', ['users' => $user]);
    }
    public function add(){
        return view('company.employees.employeAdd');
    }
    public function save(Request $request){

        $todayDate = uniqid(date('HisU'));
        $imageName = $todayDate . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('employees/img/'), $imageName);

        $lname = $request->lname;
        $fname = $request->fname;
        $register = $request->register;
        $job_title = $request->job_title;
        $salary = $request->salary;
        $phone = $request->phone;
        $email = $request->email;
        $username = $request->username;
        $password = $request->password;

        $user = new User();
        $user -> lname = $lname;
        $user -> fname = $fname;
        $user -> image = $imageName;
        $user -> salary = $salary;
        $user -> phone = $phone;
        $user -> register = $register;
        $user -> email = $email;
        $user -> job_title = $job_title;
        $user -> username = $username;
        $user -> password = Hash::make($password);
        $user -> role_id = 3;
        $user -> companies_id = Auth::user()->companies_id;
        $user -> save();
        return redirect('admin/employees')->with('message', 'Амжилттай хадгалагдлаа');
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
        $path = public_path().'/employees/img/';
        $user = User::where('id', $id)->first();
        $user->image;
        $file_old = $path.$user->image;
        unlink($file_old);
        
        $company_id = Auth::user()->companies_id;
        $user = User::where('id', $id)->where('companies_id', $company_id);
        $user->delete();
        return Redirect::back()->with('message','deleted');
    }
}