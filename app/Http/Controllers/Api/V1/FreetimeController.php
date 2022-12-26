<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use DB,Response;
use App\Freetime;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class FreetimeController extends Controller
{
    public function index(){
        $id = auth('sanctum')->user()->id;
        return Freetime::where('users_id', $id)->orderby('created_at','DESC')->get();
    }

    public function store(Request $request){
        $id = auth('sanctum')->user()->id;
        $fields = $request->validate([
            'start' => 'required|string',
            'end' => 'required|string',
            'desc' => 'required|string',
            'category' => 'required|string',
            'date' => ''
        ]);


        if($fields["category"] == "Цагийн чөлөө"){
            DB::table('freetimes')->insertGetId(
                ['start_hour' => $fields["start"], 'end_hour' => $fields['end'], 'date' => $fields['date'], 'category' => $fields['category'], 'description' => $fields["desc"], 'users_id' => auth('sanctum')->user()->id, 'companies_id' => auth('sanctum')->user()->companies_id]
            );
        }else{
            DB::table('freetimes')->insertGetId(
                ['start_day' => $fields["start"], 'end_day' => $fields['end'], 'category' => $fields['category'], 'description' => $fields["desc"], 'users_id' => auth('sanctum')->user()->id, 'companies_id' => auth('sanctum')->user()->companies_id]
            );
        }

        $response = [
            'status' => 'completed',
            'day' => 'mornings'
        ];
    }

    public function category(){
        $companies_id = auth('sanctum')->user()->companies_id;
        return DB::table('ecat')->where('company_id', $companies_id)->get();
    }
    
    public function show($id){
        
    }

    public function update(Request $request){
        
    }

    public function destroy($id){
       
    }
}