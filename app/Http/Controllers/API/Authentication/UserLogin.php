<?php

namespace App\Http\Controllers\API\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;
use App\Helpers\ApiResponse ;
use App\Http\Requests\UserLoginRequest;

class UserLogin extends Controller
{
    public function login(UserLoginRequest $request)
    {
        

        $credentials =['email' => $request->email, 'password' => $request->password] ;

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->tokens()->delete();
            $data['token'] =  $user->createToken('employeeLogin',['employee'])->plainTextToken;
            $data['name'] =  $user->first_name . " " . $user->last_name;
            $data['email'] =  $user->email;
            return ApiResponse::sendResponse(200, 'Login Successfully', $data);
        } else {
            return ApiResponse::sendResponse(401, 'Error with your credentials', null);
        }
    }
}
