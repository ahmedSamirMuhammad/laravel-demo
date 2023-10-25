<?php

namespace App\Http\Controllers\API\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Throwable;
use App\Helpers\ApiResponse;

class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $provider_user = Socialite::driver($provider)->user();
             $user = User::where([
                'provider' => $provider,
                'provider_id' => $provider_user->id
            ])->first();

            $nameParts = explode(" ", $provider_user->name);
            $firstName = $nameParts[0];
            $lastName = end($nameParts);


            if (!$user) {
                $user = User::create([
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => $provider_user->email,
                    'password' => Hash::make(Str::random(8)),
                    'provider' => $provider,
                    'provider_id' => $provider_user->id,
                    'provider_token' => $provider_user->token,
                ]);
            }

            $data['token'] =  $user->createToken('employeeLogin')->plainTextToken;
            $data['name'] = $provider_user->name;
            $data['email'] =  $user->email;
            // return ApiResponse::sendResponse(200, 'Login Successfully', [
            //     'data' => $data,
            //     'redirect_url' => 'http://localhost:4200/' // Add the redirect URL to the response
            // ]);

            // return view('callback', [
            //     'data' => $data,
            //     'redirectUrl' => 'http://localhost:4200/' // Specify the redirect URL here
            // ]);

            $redirectUrl = 'http://localhost:4200/login?token=' . urlencode($data['token']) . '&name=' . urlencode($data['name']) . '&email=' . urlencode($data['email']);
            return redirect($redirectUrl);

            
            //  return ApiResponse::sendResponse(200, 'Login Successfully', $data);
        } catch (Throwable $e) {
            $error = $e->getMessage();
            return ApiResponse::sendResponse(401, 'Error with your credentials', $error);
        }
    }

     
}
