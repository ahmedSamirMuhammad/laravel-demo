<?php

namespace App\Http\Controllers\API\Dashboards\FrontDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;

class DashboardHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    public function index()
    {
        $user = Auth::user();
        $id = $user->id;
        if (isset($user->company_name)) {
            //to get jobs number
            try {
                $jobsNumber = Job::where('company_id', $id)->count();
            } catch (\Exception $e) {
                $jobsNumber = 0;
            }
            //to get reviews number
            try {
                $reviewsNumber = Review::where('company_id', $id)->count();
            } catch (\Exception $e) {
                $reviewsNumber = 0;
            }
        }else{
            //to get number of jobs applied for
            try {
                $jobsNumber = $user->Apply()->count();
            } catch (\Exception $e) {
                $jobsNumber = 0;
            }
            //to get reviews number
            try {
                $reviewsNumber = Review::where('user_id', $id)->count();
            } catch (\Exception $e) {
                $reviewsNumber = 0;
            }
        }
        $data = [
            'jobs_number' => $jobsNumber,
            'reviews_number' => $reviewsNumber
        ];
        return ApiResponse::sendResponse(200, 'Data found', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
