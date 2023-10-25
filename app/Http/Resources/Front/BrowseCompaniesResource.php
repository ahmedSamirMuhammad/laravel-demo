<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrowseCompaniesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $rating = $this->users->pluck('pivot.rating')->filter()->average();

        return [
            'id'=>$this->id ,
            'logo'=>$this->logo ,
            'name'=>$this->company_name,
            'rating'=>$rating,
        ];
    }
}
