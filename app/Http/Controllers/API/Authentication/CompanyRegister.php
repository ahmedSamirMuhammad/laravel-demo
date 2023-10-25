<?php

namespace App\Http\Controllers\API\Authentication;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Helpers\ApiResponse;
use App\Http\Requests\CompanyRegisterRequest;

class CompanyRegister extends Controller
{

    public function register(CompanyRegisterRequest $request)
    {
        $company = Company::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'company_name' => $request->company_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $data['token'] = $company->createToken('Company')->plainTextToken;
        $data['name'] = $company->first_name . " " . $company->last_name;
        $data['company_name'] = $company->company_name;
        $data['email'] = $company->email;

        return ApiResponse::sendResponse(201, 'Account Created Successfully', $data);
    }
}
