<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;

class AuthController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Register New User
    |--------------------------------------------------------------------------
    */
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        $user = User::create($data);

        return sendResponse(true,$user,"User Created Successfully",200);
        
    }
    // End Function

    /*
    |--------------------------------------------------------------------------
    | Login User
    |--------------------------------------------------------------------------
    */
    public function Login(LoginRequest $request)
    {

        if(!Auth::attempt($request->only(['email', 'password']))){
            
            return sendResponse(false,[],"Email & Password does not match with our record.",401);

        }

        $user = auth()->user();

        $data["token"] = $user->createToken("API-TOKEN")->plainTextToken;

        return sendResponse(true,$data,"User Login Successfully",200);
        
    }
    // End Function
}
