<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Ecat;
use App\Salary;
use Redirect,Response;
use DB,Auth;

class SalaryController extends Controller
{
    public function index(){
        $company_id = Auth::user()->companies_id;
        $users = User::where('companies_id', $company_id)->get();
        $salary = [];
        return view('company.salaries.salariesList', ['users' => $users, 'salary' => $salary]);
    }

    public function salary($id){
        $company_id = Auth::user()->companies_id;
        $time_role = DB::table('time_role')->join('users', 'time_role.id', 'users.time_role_id')->where('users.id', $id)->select('time_role.week')->first();
        $weekjobday = $time_role->week;

        function getWorkingDays5($startDate,$endDate,$holidays){

            $endDate = strtotime($endDate);
            $startDate = strtotime($startDate);

            $days = ($endDate - $startDate) / 86400 + 1;

            $no_full_weeks = floor($days / 7);
            $no_remaining_days = fmod($days, 7);

            $the_first_day_of_week = date("N", $startDate);
            $the_last_day_of_week = date("N", $endDate);

            if ($the_first_day_of_week <= $the_last_day_of_week) {
                if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
                if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
            }
            else {
                if ($the_first_day_of_week == 7) {
                    $no_remaining_days--;

                    if ($the_last_day_of_week == 6) {
                        $no_remaining_days--;
                    }
                }
                else {
                    $no_remaining_days -= 2;
                }
            }

        $workingDays = $no_full_weeks * 5;
            if ($no_remaining_days > 0 ){
                $workingDays += $no_remaining_days;
            }

            foreach($holidays as $holiday){
                $time_stamp=strtotime($holiday);

                if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
                    $workingDays--;
            }

            return $workingDays;
        }

        function getWorkingDays6($startDate,$endDate,$holidays){

            $endDate = strtotime($endDate);
            $startDate = strtotime($startDate);

            $days = ($endDate - $startDate) / 86400 + 1;

            $no_full_weeks = floor($days / 7);
            $no_remaining_days = fmod($days, 7);

            $the_first_day_of_week = date("N", $startDate);
            $the_last_day_of_week = date("N", $endDate);

            if ($the_first_day_of_week <= $the_last_day_of_week) {
            
                if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
            }
            else {
                if ($the_first_day_of_week == 7) {
                    $no_remaining_days--;
                }
                else {
                    $no_remaining_days -= 1;
                }
            }

            $workingDays = $no_full_weeks * 6;
            if ($no_remaining_days > 0 ){
                $workingDays += $no_remaining_days;
            }

            foreach($holidays as $holiday){
                $time_stamp=strtotime($holiday);

                if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 7)
                    $workingDays--;
            }

            return $workingDays;
        }

        $holidays=array("2022-12-29");
        if ($weekjobday == 5) {
            $allworkday = getWorkingDays5("2022-12-01","2022-12-31",$holidays);
        }elseif ($weekjobday == 6) {
            $allworkday = getWorkingDays6("2022-12-01","2022-12-31",$holidays);
        }

        $allworkhour = $allworkday * 8;
        $alltime = 0;
        $allday = 0;
        $checktimes = DB::table('time_check')->whereMonth('datetime', '=', \Carbon\Carbon::now()->subMonth()->month)->where('users_id', $id)->get();
        foreach ($checktimes as $checktime) {
            $night = $checktime->night;
            $morning = $checktime->morning;
            $first = date(strtotime($checktime->datetime . $night));
            $last = date(strtotime($checktime->datetime . $night));
            $to = \Carbon\Carbon::createFromFormat('Y-m-d H:s', $checktime->datetime .' '. $morning);
            $from = \Carbon\Carbon::createFromFormat('Y-m-d H:s', $checktime->datetime .' '. $night);
            
            if(isset($morning) && isset($night)){
                $allday = $allday + 1;
            }

            $diff_in_minutes = $to->diffInMinutes($from);
            $alltime = $alltime + ($diff_in_minutes/60-1);
    
        }

        $users = User::where('id', $id)->where('companies_id', $company_id)->first();
        $salary = $users->salary;
        $salaryArray = array(
            'allworkday' => $allworkday,
            'allday' => $allday,
            'allworkhour' => $allworkhour,
            'alltime' => $alltime,
            'salary' => $salary,
            'id' => $id,
        );
        return response()->json($salaryArray);
    }

    public function calc(Request $request){
        $allworkday = $request->allworkday;
        $allday = $request->allday;
        $allworkhour = $request->allworkhour;
        $alltime = $request->alltime;
        $salary = $request->salary;
        $moretime = $request->moretime;
        $food = $request->food;
        $uridchilgaa = $request->uridchilgaa;
        $id = $request->id;
        $busad_suutgal = $request->bsuutgal;
        $amralt = $request->amralt;
        $haoat_sale = $request->haoat_sale;
        $bsalary = ($salary / $allworkhour) * $alltime + $amralt;

        $onehour = $salary / $allworkhour;
        $moretime15 = 0;
        $moretime15 = $moretime * 1.5;
        $moretimes = $moretime15 * $onehour;
        $allfood = 0;
        $allfood = $allday * $food;
        echo $allday . '<br>' . $food . '<br>' . $allfood;
        $ots = $bsalary + $moretimes + $allfood;
        $ndsh = $ots * 0.115;
        $haoat = ($ots - $ndsh) * 0.10;
        $haoat_sale = 16000;
        $allhaoat = $haoat - $haoat_sale;
        $allsuutgal = $ndsh + $allhaoat + $uridchilgaa + $busad_suutgal;
        $total = $ots - $allsuutgal;
        $salary = new Salary();
        $salary -> users_id = $id;
        $salary -> amralt_shagnal = $amralt;
        $salary -> job_days = $allworkday;
        $salary -> jobed_days = $allday;
        $salary -> job_hour = $allworkhour;
        $salary -> jobed_hour = $alltime;
        $salary -> b_salary = $bsalary;
        $salary -> onet_salary = $onehour;
        $salary -> more_time = $moretime;
        $salary -> time_salary = $moretimes;
        $salary -> cook_money = $allfood;
        $salary -> ot_salary = $ots;
        $salary -> nd_shimtgel = $ndsh;
        $salary -> haoat = $haoat;
        $salary -> haoat_sale = $allhaoat;
        $salary -> uridchilgaa = $uridchilgaa;
        $salary -> b_suutgal = $id;
        $salary -> n_suutgal = $allsuutgal;
        $salary -> go_salary = $total;
        $salary -> save();
    }

    public function list($id){
        $salary = DB::table('salaries')
        ->select('*')
        ->where('users_id','=',$id)
        ->get();
        $users = User::where('id', $id)->first();
        $salary2 = $users->salary;

        return view('company.salaries.salaries',compact('salary','salary2'));
    }
}