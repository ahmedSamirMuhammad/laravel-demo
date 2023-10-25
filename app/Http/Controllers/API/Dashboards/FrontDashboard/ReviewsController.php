<?php

namespace App\Http\Controllers\API\Dashboards\FrontDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;
use App\Models\Review;
use App\Models\Personal_access_token;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ReviewResource;

class ReviewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();
        $id = $user->id;

        if (isset($user->company_name)) {
            $review = new ReviewResource(Review::where('company_id', $id)->get());
            $review = ReviewResource::collection($review);
        } else {
            $review = new ReviewResource(Review::where('user_id', $id)->get());
            $review = ReviewResource::collection($review);
        }
        
        if ($review) {
            return ApiResponse::sendResponse(200, 'Data found', $review);
        } else {
            return ApiResponse::sendResponse(404, 'Data not found',  null);
        }
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
    private function userType()
    {
    }
    /**
     * @param bool $id is the company id
     */
    public function show(string $id)
    {
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
