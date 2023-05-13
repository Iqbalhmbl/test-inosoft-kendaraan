<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserMongo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class ApiController extends Controller
{
    public $successStatus = 200;

    public function login(LoginRequest $request){
        $credentials = $request->only('email', 'password');

        if (JWTAuth::attempt($credentials)) {
            // Login berhasil
            $user = JWTAuth::user();
            $token = JWTAuth::fromUser($user);
            return (new UserResource($request->user()))
                ->additional(['meta' => [
                    'token' => $token,
                ]]);
        } else {
            // Login gagal
            throw new \Exception('Invalid credentials');
        }
    }
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $credentials = $request->only('email', 'password');

        $token = auth()->attempt($credentials);

        return (new UserResource($request->user()))
            ->additional(['meta' => [
                'token' => $token,
            ]]);
    }
}
