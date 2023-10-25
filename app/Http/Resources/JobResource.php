<?php

namespace App\Http\Resources;

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
        // dd($this);
        $data= [
            "name" => $this->name,
            "type" => $this->type,
            "created_at" => $this->created_at,
            "logo" => $this->company->logo,
            "company_name" => $this->company->company_name,
            "location" => $this->company->location
        ];
        return $data;
    }
}
