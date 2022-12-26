<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use DB,Response;
use App\Event;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index(){
        $companies_id = auth('sanctum')->user()->companies_id;
        return Event::where('companies_id', $companies_id)->orderby('created_at','DESC')->get();
    }

    public function store(Request $request){

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