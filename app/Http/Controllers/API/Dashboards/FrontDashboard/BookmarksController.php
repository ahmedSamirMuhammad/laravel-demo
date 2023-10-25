<?php

namespace App\Http\Controllers\API\Dashboards\FrontDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\Job;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\JobResource;

class BookmarksController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:sanctum','ability:employee']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		/*
		the response should contain:
		company -> logo,company_name,location
		job -> name,type,created_at
		*/

        $user =  Auth::user();
		$bookmarked_jobs=new JobResource($user->jobs);
        $bookmarked_jobs=JobResource::collection($bookmarked_jobs);
        return ApiResponse::sendResponse(200, 'Data found',$bookmarked_jobs);
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
