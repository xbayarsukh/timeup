<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use DB,Response,Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class CheckController extends Controller
{
    public function index(){
        return DB::table('time_check')->where('users_id', auth('sanctum')->user()->id)->orderby('datetime','DESC')->get();
    }
    public function store(Request $request){
       
        $input = $request->validate([
            'type' => 'required|string',
            'lat' => 'required|string',
            'long' => 'required|string',
        ]);

        $time = date("H:i");
        
        $day = date("Y-m-d");
        function is_in_polygon($points_polygon, $vertices_x, $vertices_y, $longitude_x, $latitude_y){
            $i = $j = $c = 0;
            for ($i = 0, $j = $points_polygon ; $i < $points_polygon; $j = $i++) {
              if ( (($vertices_y[$i]  >  $latitude_y != ($vertices_y[$j] > $latitude_y)) &&
               ($longitude_x < ($vertices_x[$j] - $vertices_x[$i]) * ($latitude_y - $vertices_y[$i]) / ($vertices_y[$j] - $vertices_y[$i]) + $vertices_x[$i]) ) )
                 $c = !$c;
            }
            echo $c;
            return $c;
        }
        if($input['type'] == 'morning'){
            $locations = DB::table('locations')->join('time_role', 'locations.time_role_id', 'time_role.id')->join('users', 'time_role.id', 'users.time_role_id')->where('users.id', $company_id = Auth::user()->id)->select('locations.*')->get();
            foreach ($locations as $location) {
                $vertices_x = array();
                $vertices_y = array();
                $polygons = DB::table('polygon')->where('polygon.locations_id', $location->id)->get();
                foreach ($polygons as $polygon) {
                    array_push($vertices_x, $polygon->long);
                    array_push($vertices_y, $polygon->lat);
                }
                $points_polygon = count($vertices_x) - 1;
                if (is_in_polygon($points_polygon, $vertices_x, $vertices_y, $input['long'], $input['lat'])){
                    DB::table('time_check')->insertGetId(
                        ['morning' => $time, 'lat_morning' => $input['lat'], 'long_morning' => $input['long'], 'datetime' => $day, 'users_id' => auth('sanctum')->user()->id]
                    );
                    $response = [
                        'status' => 'completed',
                        'day' => 'mornings'
                    ];
                }else {
                    $response = [
                        'status' => 'Та зөвшөөрсөн байршилаас цагаа бүртгүүлнэ үү?',
                        'day' => 'mornings'
                    ];
                }
                  
                
            }
            
            return $response;
        }elseif ($input['type'] == 'night') {
            $locations = DB::table('locations')->join('time_role', 'locations.time_role_id', 'time_role.id')->join('users', 'time_role.id', 'users.time_role_id')->where('users.id', $company_id = Auth::user()->id)->select('locations.*')->get();
            foreach ($locations as $location) {
                $vertices_x = array();
                $vertices_y = array();
                $polygons = DB::table('polygon')->where('users_id', auth('sanctum'))->where('polygon.locations_id', $location->id)->get();
                foreach ($polygons as $polygon) {
                    array_push($vertices_x, $polygon->long);
                    array_push($vertices_y, $polygon->lat);
                }
                $points_polygon = count($vertices_x) - 1;
                if (is_in_polygon($points_polygon, $vertices_x, $vertices_y, $input['long'], $input['lat'])){
                    DB::table('time_check')->where('datetime', $day)->update(
                        ['night' => $time, 'lat_night' => $input['lat'], 'long_night' => $input['long']]
                    );
                    $response = [
                        'status' => 'completed',
                        'day' => 'night'
                    ];
                }else {
                    $response = [
                        'status' => 'Та зөвшөөрсөн байршилаас цагаа бүртгүүлнэ үү?',
                        'day' => 'night'
                    ];
                }
                  
            }
            
            return $response;
        }
    }
    
    public function show(){
        $promotion = DB::table('time_check')->where('users_id', auth('sanctum')->user()->id)->whereDate('created_at', Carbon::today())->first();

        return response()->json($promotion); 
    }
    public function update(Request $request){
        
    }
    public function test(Request $request){
        $mornings = DB::table('time_check')->where('users_id', auth('sanctum')->user()->id)->orderby('datetime', 'DESC')->Select('morning', 'datetime')->SelectRaw('"Ирсэн" as day')->get();
        foreach ($mornings as $morning) {
            $date = $morning->datetime;
            $mcolor = 'green';
            $timem = date_create($morning->morning);
            if(date_format($timem, 'H') > 8){
                $mcolor = 'red';
            }
            $output[] = array(
                'mornight' => $morning->morning,
                'datetime' => $morning->datetime,
                'day' => $morning->day,
                'color' => $mcolor,
            );
            $nights = DB::table('time_check')->where('users_id', auth('sanctum')->user()->id)->where('datetime', $date)->Select('night', 'datetime')->SelectRaw('"Тарсан" as day')->first();
            $ncolor = 'green';
            $timen = date_create($nights->night);
            if(date_format($timen, 'H') < 18){
                $ncolor = 'red';
            }
            $output[] = array(
                'mornight' => $nights->night,
                'datetime' => $nights->datetime,
                'day' => $nights->day,
                'color' => $ncolor,
            );
            
        
        }
        print(json_encode($output, JSON_PRETTY_PRINT));
    }

    public function polygon(){
        $polygons = DB::table('polygon')->join('locations', 'polygon.locations_id', 'locations.id')->join('time_role', 'locations.time_role_id', 'time_role.id')->join('users', 'time_role.id', 'users.time_role_id')->where('users.id', $company_id = Auth::user()->id)->select('polygon.*')->get();
        return response()->json($polygons); 
    }

    public function destroy($id){
       
    }
}