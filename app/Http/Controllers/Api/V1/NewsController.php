<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use DB,Response;
use App\News;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class NewsController extends Controller
{
    public function index(){
        $companies_id = auth('sanctum')->user()->companies_id;
        return News::where('companies_id', $companies_id)->orderby('created_at','DESC')->get();
    }

    public function store(Request $request){

    }
    
    public function show($id){
        
    }

    public function update(Request $request){
        
    }

    public function destroy($id){
       
    }
}