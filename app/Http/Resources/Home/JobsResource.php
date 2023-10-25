<?php

namespace App\Http\Resources\Home;

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
            'name'=>$this->name ,
            'type'=>$this->type,
            'location'=>$this->location,
            'postJob'=>$this->created_at,
            // 'number_of_jobs' => $this->count(),

        ];
    }
}
