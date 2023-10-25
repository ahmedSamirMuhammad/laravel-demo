<?php

namespace App\Http\Resources\EmployeeProfile;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\helpers\ApiResponse;
use App\Models\User;
use App\Http\Resources\EmployeeProfile\SocialResource;
use App\Http\Resources\EmployeeProfile\HistoryResource;
class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "first-name" => $this->first_name,
            "last-name" => $this->last_name,
            "verafied" => $this->verified,
            "avatar" => $this->avatar,
            "aboat" => $this->aboat,
            "title"=>$this->title,
            "nationality"=>$this->nationality,
            "cv"=>$this->cv,

            'skill-name'=>EmployeeSkills::Collection($this->skills),
            'social-link'=>SocialResource::Collection($this->socials),
            'history'=>HistoryResource::Collection($this->histories),

        ];
    }
}
