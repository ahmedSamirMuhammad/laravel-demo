<?php

namespace App\Http\Resources\EmployeeProfile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HistoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "job_name"=>$this->job_name,
            "company_name"=> $this->company_name,
            "date_from"=>$this->date_from,
            "date_to"=>$this->date_To,
            "description"=>$this->description
        ];
    }
}
