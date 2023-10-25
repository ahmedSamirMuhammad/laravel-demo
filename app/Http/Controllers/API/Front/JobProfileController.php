<?php

namespace App\Http\Controllers\API\Front;

use App\Helpers\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Resources\Front\JobResource;
use App\Models\Job;

class JobProfileController extends Controller
{
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
            $job = Job::findOrFail($id);
    
            $jobData = new JobResource($job);
    
            return ApiResponse::sendResponse(200, "", $jobData);
    
        } catch (ModelNotFoundException $e) {
    
            return ApiResponse::sendResponse(404, 'Job data not found');
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
     * share a specified job.
     */
    public function share(string $id)
    {
        try {
            $shareLink = 'http://127.0.0.1:8000/api/jobs/' . $id;
    
            // Return the share link or message as a response
            return ApiResponse::sendResponse(200,'Success', $shareLink);

        } catch (ModelNotFoundException $e) {
            
            return ApiResponse::sendResponse(404, 'Job profile not found');
        }
    }

    /**
     * bookmark the specified job.
     */
    public function bookmark(string $id)
    {
        try {
            $user = Auth::user();
            
            // Find the job you want to bookmark
            $job = Job::findOrFail($id);

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
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404, 'Job not found');
        }
    }

    /**
     * apply for a specified job.
     */
    public function apply(string $jobId)
    {
        try { 
            // Find the job you want to apply for
            $job = Job::findOrFail($jobId);
            $user = Auth::user();

            // Check if the job exists
            if (!$job) {
                return ApiResponse::sendResponse(404, 'Job not found');
            }

            // Check if the user has already applied for the job
            if ($user->apply()->where('job_id', $job->id)->exists()) {
                return ApiResponse::sendResponse(400, 'You have already applied for this job before');
            }

            // Attach the job to the user's applied jobs
            $user->apply()->attach($job);

            return ApiResponse::sendResponse(200, 'Application sent successfully');
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(404, 'Job not found');
        }
    }
}