<?php

namespace App\Http\Controllers\API\Authentication;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User ;
use App\Notifications\EmailVerfyNotify ;
use App\Http\Requests\EmailVerfyRequest ;
use App\Models\Company;
use Ichtrojan\Otp\Otp;

class EmailVerification extends Controller
{
    private $otp;
    public function __construct()
    {
        $this->otp=new Otp;
    }


    public function resendEmailVerify(Request $request){
     $user = $request->user() ;
     return response()->json($user) ;
      $user->notify(new EmailVerfyNotify());
      $success['success']=true;
      return response()->json($success,200);
    }



    public function emailVerify(EmailVerfyRequest $request){
        $user = $request->user() ;
        return response()->json($user) ;

       $otp2=$this->otp->validate($request->email,$request->otp);

       if(!$otp2->status){
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
        $user->update(['email_verified_at'=>now()]);
        $data['success'] = true;
        return ApiResponse::sendResponse(200, 'you are verified now', $data);
    } else {
        return ApiResponse::sendResponse(404, 'User not found', []);
    }

}
}


 