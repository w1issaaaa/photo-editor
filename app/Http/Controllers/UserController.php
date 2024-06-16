<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function test(){
        return response('ok', 200);
    }

    public function testAuth(){
       $authorized = auth('sanctum')->check();

       $user = Auth::user();
       if($authorized){
           return response($user->name, 200);
       } else{
           return response('unauthorized error testAuth', 401);
       }
    }

    public function register(Request $request){
        $user =  User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            ]);

        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['name'] = $user->name;
        $success['response'] = 'created';
        return response($success, 201);
    }


    public function login(Request $request){
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken;
            $success['name'] =  $user->name;

            return response($success, 200);
        }
        else{
            return response('Unauthorized error', 401);
        }
    }

    public function logout(Request $request){
        Auth::user()->tokens()->delete();
        //auth()->user()->tokens()->delete();
        return [
            'message' => 'user logged out'
        ];
    }

    public function editUser(Request $request){
        $user = Auth::user();

        if ($request->filled('name')) {
            $user->name = $request->input('name');
        }
        if ($request->filled('city')) {
            $user->city = $request->input('city');
        }
        if ($request->filled('avatar')) {
            $user->avatar = $request->input('avatar');
        }
        if ($request->filled('telegram')) {
            $user->telegram = $request->input('telegram');
        }
        if ($request->filled('instagram')) {
            $user->instagram = $request->input('instagram');
        }

        $user->save();

        return response()->json($user);
    }

}
