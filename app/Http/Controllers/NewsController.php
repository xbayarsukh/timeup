<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\News;
use Redirect,Response;
use DB,Auth;

class NewsController extends Controller
{
    public function index(){
        $company_id = Auth::user()->companies_id;
        $news = News::where('companies_id', '=', $company_id)->orderBy("created_at", "desc")->paginate(15);
        return view('company.news.newsList', ['news' => $news]);
    }
    public function add(){
        return view('company.news.newsAdd');
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