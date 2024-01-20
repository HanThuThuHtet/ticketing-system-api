<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\Queue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ApiAuthController extends Controller
{


    public function register(RegisterRequest $request){
        $data = $request->validated();
        $user = User::create([
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => Hash::make($data['password'])
        ]);
        //return response()->json($user);
        return response()->json([
            "message" => "Registration Successful",
            "success" => true
        ],200);
    }

    public function login(LoginRequest $request){
        $data = $request->validated();
        if(Auth::attempt($data)){
            /** @var \App\Models\User */
            $user = Auth::user();
            $token = $user->createToken("token")->plainTextToken;
            //return response()->json($token);

            if ($user->role === 'user') {
                $defaultQueue = Queue::where('id', '1')->first();
                $user->queues()->sync($defaultQueue); 
            }

            return response()->json([
                "message" => "Login Successful",
                "success" => true,
                "token" => $token,
                "auth" => new UserResource(Auth::user())
            ]);
         }
         return response()->json([
            "message" => "User Not Found",
            "success" => false
        ],401);


        
    }

    public function logout(Request $request){
        /** @var \App\Models\User */
        $user = Auth::user();
        $user->currentAccessToken()->delete();
        return response()->json([
            "message" => "Logout Successfully",
            "success" => true
        ]);
    }

    public function user(Request $request){
        return new UserResource($request->user);
    }

}
