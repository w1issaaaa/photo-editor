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

    public function register(Request $request){
//        $request->validate([
//            'email' => 'required|unique:users|max:255',
//            'name' => 'required',
//            'password' => 'required',
//        ]);

//        $user = User::create($request->validated());
//        return response($user, 201);
        $user =  User::create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            ]);
        return response('created', 201);
        //return response();
//
//        if ($user){
//            return response('created', 201);
//        } else {
//            return response('failed', 500);
//        }
    }

    public function login(Request $request){
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('name','=',$request->username)->where('password','=',Hash::make($request->password))->first();

        if ($user){
            return response('good', 200);
        } else {
            return response('bad', 400);
        }
    }

    public function editUser(Request $request){
       // $user = Auth::user(); // будет так в будущем

        $validated = $request->validate(['id'=>'required']);
        $user = User::findOrFail($request->id);

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
