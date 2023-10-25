<?php

namespace App\Http\Controllers\API\Authentication;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserRegister extends Controller
{
    public function register(UserRegisterRequest $request)
    {
         

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $data['token'] = $user->createToken('User')->plainTextToken;
        $data['name'] = $user->first_name . " " .$user->last_name;
        $data['email'] = $user->email;

        return ApiResponse::sendResponse(201, 'Account Created Successfully', $data);
     }
}
