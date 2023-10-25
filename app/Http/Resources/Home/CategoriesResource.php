<?php

namespace App\Http\Resources\Home;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return[
        //     'name'=>$this->name,
        //         // "jobs"=>[
        //         //     "job name" => $this->jobs->name
        //         // ]
        //     "job"=>$this->jobs->name
        // ];

        // $jobs = $this->jobs->map(function ($job) {
        //     return [
        //         'job name' => $job->name,
        //     ];
        // });

        return [
            'name' => $this->name,
            'jobs' => JobTitleResource::Collection($this->jobs),
            'number_of_jobs' => $this->jobs->count(),
        ];
    }

}
