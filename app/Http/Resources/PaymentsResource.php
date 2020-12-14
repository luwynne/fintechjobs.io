<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaymentsResource extends ResourceCollection{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
        return $this->resource->map(function ($payments) {
            return (New PaymentResource($payments))->resolve();
        });
    }
}
