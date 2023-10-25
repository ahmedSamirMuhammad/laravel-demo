<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id ,
            'title' => $this->pivot->title,
            'rating'=>$this->pivot->rating ,
            'comment'=>$this->pivot->comment,
            'user_id' => $this->pivot->user_id,
            'date' => $this->pivot->created_at,
        ];
    }
}
