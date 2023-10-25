<?php

namespace App\Http\Controllers\API\Front;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Front\CompanyResource;
use App\Models\Company;
use App\Models\Job;
use App\Models\Review;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyProfileController extends Controller
{

    public function  __construct (){
        $this->middleware('auth:sanctum')->except(['show','share']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    try {
        $company = Company::findOrFail($id);

        $companyData = new CompanyResource($company);

        return ApiResponse::sendResponse(200, "", $companyData);

    } catch (ModelNotFoundException $e) {

        return ApiResponse::sendResponse(404, 'Company data not found');
    }
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

    /**
     * bookmark the specified company from storage.
     */
    public function bookmarkJob(Request $request, $companyId, $jobId)
{
    try {
        $company = Company::findOrFail($companyId);
        $user = Auth::user();

        if ($user) {
            
            // Find the job you want to bookmark within the company
            $job = $company->jobs()->find($jobId);

            if ($job) {

                // Check if the user has already bookmarked the job
                if ($user->jobs->contains($job)) {

                    // If the user has already bookmarked the job, unbookmark it
                    $user->jobs()->detach($job);
                    return ApiResponse::sendResponse(200, 'Job unbookmarked successfully');
                } else {

                    // If the user hasn't bookmarked the job, add the bookmark
                    $user->jobs()->attach($job);
                    return ApiResponse::sendResponse(200, 'Job bookmarked successfully');
                }
            } else {
                return ApiResponse::sendResponse(404, 'Job not found in the company');
            }
        } else {
            return ApiResponse::sendResponse(401, 'User not authenticated');
        }
    } catch (ModelNotFoundException $e) {
        return ApiResponse::sendResponse(404, 'Company not found');
    }
}

    /**
     * addReview to the specified company.
     */
    public function addReview(Request $request, string $id)
    {   
        // return ApiResponse::sendResponse(200, 'Data found',  \request()->header());
        $request->validate([
            'title' => 'required|string',
            'comment' => 'required|string',
            'rating' => 'required|integer|between:1,5',
        ]);

        try {
            $company = Company::findOrFail($id);
            $user = Auth::user();

            // Create a new review instance
            $reviewData = new Review([
                'rating' => $request->input('rating'),
                'name' => $request->input('name', 'Anonymous'),
                'title' => $request->input('title'),
                'comment' => $request->input('comment'),
                'user_id' => $user->id,
            ]);

            // Save the review to the company's reviews relationship
            $company->users()->attach($reviewData, [
                'rating' => $request->input('rating'),
                'title' => $request->input('title'),
                'comment' => $request->input('comment'),
                'user_id' => $user->id,
            ]);
    
            return ApiResponse::sendResponse(201,'Review added successfully', $reviewData);

        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404, 'Company profile not found');
        }
    }

    /**
     * share to the specified company.
     */
    public function share(string $id)
    {
        try {
            // $company = Company::where('slug', $slug)->firstOrFail();
            // $company = Company::findOrFail($id);
    
            // $companyData = new CompanyResource($company);
            $shareLink = 'http://127.0.0.1:8000/api/companies/' . $id;
    
            // Return the share link or message as a response
            return ApiResponse::sendResponse(200,'Success', $shareLink);

        } catch (ModelNotFoundException $e) {
            
            return ApiResponse::sendResponse(404, 'Company profile not found');
        }
    }
}
