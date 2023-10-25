<?php

namespace App\Http\Controllers\API\Front;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Front\JobResource;
use App\Models\Category;
use App\Models\Job;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class JobsController extends Controller
{
    /** 
     * Display a listing of the resource.
     */
    public function index(Request $request)
    { 
        try {
            // Paginate the results
            $perPage = $request->input('per_page', 10);
            $jobListings = Job::paginate($perPage);

            $formattedJobListings = JobResource::collection($jobListings);

            // Format the job listings
            return ApiResponse::sendResponse(200, "", $formattedJobListings);
        } catch (ModelNotFoundException $e) {
            return ApiResponse::sendResponse(500, 'An error occurred while fetching job listings');
        }
    }

    /**
     * Applying filters to the job listing.
     */
    public function applyFilters(Request $request)
    {
        // Define the base query for job listings
        $query = Job::query();

        // Apply filters
        if ($request->filled('location')) {
            $query->where('location', $request->input('location'));
        }

        if ($request->filled('category_name')) {
            $categoryName = $request->input('category_name');
        
            // Find the category ID based on the category name
            $categoryId = Category::where('name', $categoryName)->first();
        
            if ($categoryId) {
                // Use the found category ID to filter jobs
                $query->where('category_id', $categoryId->id);
            } else {
                return ApiResponse::sendResponse(404,'There are no category with that name.');
            }
        }
        
        if ($request->filled('experience')) {
            $experience = $request->input('experience');
            $query->where('experience', $experience);
        }

        if ($request->filled('type')) {
            $jobTypes = explode(',', $request->input('type'));
        
            // If it's a string, convert it to an array with one element.
            if (!is_array($jobTypes)) {
                $jobTypes = [$jobTypes];
            }
            $query->whereIn('type', $jobTypes);
        }

        if ($request->filled('min_salary') && $request->filled('max_salary')) {
            $minSalary = $request->input('min_salary');
            $maxSalary = $request->input('max_salary');
            $query->whereBetween('min_salary', [$minSalary, $maxSalary]);
        }
        
        if ($request->filled('min_salary')) {
            $minSalary = $request->input('min_salary');
            $query->where('min_salary', '>=', $minSalary);
        }
        
        if ($request->filled('max_salary')) {
            $maxSalary = $request->input('max_salary');
            $query->where('max_salary', '<=', $maxSalary);
        }
            
        // Paginate the filtered results
        $perPage = $request->input('per_page', 10);
        $jobListings = $query->paginate($perPage);

        $formattedJobListings = JobResource::collection($jobListings);

        // Format the filtered job listings
        return ApiResponse::sendResponse(200, "", $formattedJobListings);
    }

    /**
     * Sorting the job listing.
     */
    public function sort(Request $request)
    {
        // Get the sorting criteria from the request
        $sort = $request->input('sort');
    
        // Create a new query for jobs
        $query = Job::query();
    
        // Apply sorting based on the chosen criteria
        if ($sort === 'newest') {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort === 'oldest') {
            $query->orderBy('created_at', 'asc');
        } 
        // Retrieve the sorted jobs
        $sortedJobs = $query->get();
        return ApiResponse::sendResponse(200, '', $sortedJobs);
    }

    /**
     * Using the pagination
     */
    public function indexPagination($page)
    {
        $perPage = 10;
        // Retrieve the paginated list of jobs
        $jobs = Job::paginate($perPage, ['*'], 'page', $page);
        return ApiResponse::sendResponse(200,'', $jobs);
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
}
