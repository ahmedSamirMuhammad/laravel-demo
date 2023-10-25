<?php

namespace App\Http\Controllers\API\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth ;
use Laravel\Sanctum\PersonalAccessToken ;
use App\Helpers\ApiResponse ;

class UserLogout extends Controller
{
    public function destroy(Request $request)
    {
        $request->user()->tokens->each(function (PersonalAccessToken $token) {
            $token->delete();
        });

         return ApiResponse::sendResponse(200, 'Logged out successfully');

    }
}
