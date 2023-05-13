<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\UserMongo;
use App\Models\User;

class AuthController extends Controller
{
    Public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->save();

        return redirect()->back();
    }
}
