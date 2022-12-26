<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Http\Controllers\Controller;

class UserdController extends Controller
{
    public function index(){
        return User::all();
    }

    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    public function login(Request $request){
        $fields = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('username', $fields['username'])->first();

        $token = $user->createToken('myapptoken')->plainTextToken;

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $response = [
            'user' => $user,
            'token' => $token,
            'message' => false
        ];

        return response($response, 201);
    }

    public function add(){
       
    }
    public function save(Request $request){

    }
    public function edit($id){
        
    }
    public function show(User $user){
        return $user;
    }
    public function update(Request $request){
        
    }
    public function getid(Request $request){
        echo auth('sanctum')->user()->id;
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

    public function delete($id){
       
    }
}