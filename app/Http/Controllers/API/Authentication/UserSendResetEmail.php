<?php

namespace App\Http\Controllers\API\Authentication;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\ForgetPassRequest;
use App\Helpers\ApiResponse;
use App\Models\Company;
use App\Notifications\resetpassnotify;

class UserSendResetEmail extends Controller
{
	public function forgetPassword(ForgetPassRequest $request)
	{
		$input = $request->only('email');

		// Check if the URL contains "company" or "user"
		$segments = $request->segments();
		if (in_array('company', $segments)) {
			$user = Company::where('email', $input['email'])->first();
		} elseif (in_array('user', $segments)) {
			$user = User::where('email', $input['email'])->first();
		}

		if ($user) {
			$user->notify(new resetpassnotify());
			$data['success'] = true;
			return ApiResponse::sendResponse(200, 'Email Sent Successfully', $data);
		} else {
			return ApiResponse::sendResponse(404, 'User not found', []);
		}
	}
}
