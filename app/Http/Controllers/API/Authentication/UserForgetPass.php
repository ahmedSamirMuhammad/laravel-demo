<?php

namespace App\Http\Controllers\API\Authentication;

use App\Models\User;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ResetPassRequest ;
use App\Helpers\ApiResponse ;
use App\Models\Company;



class UserForgetPass extends Controller
{
    private $otp;
    public function __construct()
    {
        $this->otp=new Otp;
    }
    public function passwordReset(ResetPassRequest $request){

        $otp2=$this->otp->validate($request->email,$request->otp);
        if(! $otp2->status){
              $data['error']=$otp2 ;
             return ApiResponse::sendResponse(401, 'Otp was entered is wrong');

        }


        $segments = $request->segments();
        if (in_array('company', $segments)) {
            $user = Company::where('email', $request->email)->first();
        } elseif (in_array('user', $segments)) {
            $user = User::where('email', $request->email)->first();
        }  
        if ($user) {

         $user->update(['password'=>Hash::make($request->password)]);
        $user->tokens()->delete();
          return ApiResponse::sendResponse(200, 'password changed successfully');
        } else {
            return ApiResponse::sendResponse(404, 'User not found', []);
        }

    }


    
}
