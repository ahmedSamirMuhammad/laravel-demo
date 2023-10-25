<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $rating = $this->company->users->pluck('pivot.rating')->filter()->average();

        return [
            'job_id'=>$this->id ,
            'job_name'=>$this->name ,
            'min_salary'=>$this->min_salary ,
            'max_salary'=>$this->max_salary ,
            'job_type'=>$this->type ,
            'job_experience'=>$this->experience ,
            'job_location' => $this->location,
            'job_description' => $this->about,
            'job_date' => $this->created_at,
            'category_id' => $this->category_id,
            'category_name' => $this->category->name,
            'company_id' => $this->company_id,
            'company_logo'=>$this->company->logo ,
            'company_name' => $this->company->company_name,
            'company_rating' => $this->company->users->avg('pivot.rating'),
            'company_nationality' => $this->company->nationality,
            'company_verified' => !is_null($this->company->email_verified_at),
        ];
    }
}
