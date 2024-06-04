<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            'email' => 'required|unique:users|max:255',
            'name' => 'required',
            'password' => 'required',
        ]);

        $user = User::firstOrCreate([
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            ]);
        if ($user){
            return response('created', 201);
        }else {
            return response('failed', 500);
        }
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


}
