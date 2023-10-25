<?php

namespace App\Http\Resources\Front;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */ 
    public function toArray(Request $request): array
    {
        //calculating the average company rating
        $rating = $this->users->pluck('pivot.rating')->filter()->average();
        $openJobs = $this->jobs->map(function ($job) {
            return [
                'id' => $job->id,
                'title' => $job->name,
                'location' => $job->location,
                'type' => $job->type,
                'post_date' => $job->created_at,
                'is_bookmarked' => $job->isBookmarked(),
            ];
        });

        return [
            'id'=>$this->id ,
            'logo'=>$this->logo ,
            'name'=>$this->company_name,
            'title' => $this->title,
            'location' => $this->location,
            'about' => $this->about,
            'nationality' => $this->nationality,    
            'verified' => $this->verified,
            'rating' => $rating,
            'open_jobs' => $openJobs,
            'reviews' => ReviewsResource::collection($this->users),
            // 'social_medias' => $this->socials->profile_link,
        ];
    }
}
