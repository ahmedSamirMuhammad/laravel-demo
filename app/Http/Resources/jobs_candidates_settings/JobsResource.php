<?php

namespace App\Http\Resources\jobs_candidates_settings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title'=>$this->name ,
            // 'created_at'=>$this->created_at ,
            'min-salary'=>$this->min_salary ,
            'max-salary'=>$this->max_salary ,
            // 'logo'=>$this->company->logo,
            'type'=>$this->type,
            'location'=>$this->company->location,
            // 'about'=>$this->company->about,
        ];
    }
}
