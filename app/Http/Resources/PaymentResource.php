<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){

        if ($this->resource == null){
            return null;
        }

        $payment = $this->resource;

        return [
            'id' => $payment->id,
            'company_id' => $payment->company_id,
            'amount' => $payment->amount,
            'expire_date' => $payment->expire_date,
            'created_at' => $payment->created_at,
            'plan' => $payment->plan->name
        ];

    }
}
