<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class JobsResource extends ResourceCollection{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
        return $this->resource->map(function ($jobs) {
            return (New JobResource($jobs))->resolve();
        });
    }
}
