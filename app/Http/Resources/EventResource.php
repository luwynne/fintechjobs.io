<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\{
    Event,
    ExternalEvent
};
use Carbon\Carbon;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        if ($this->resource == null){
            return null;
        }

        $event = $this->resource;

        if($event['start_date'] !== null && $event['start_date'] !== ""){
            $date = new Carbon($event['start_date']);
            $start_date = $date->format('d/m/y');
        }else{
            $start_date = "TBC";
        }

        return [
            'name' => $event['name'],
            'organizer' => $event['organizer'],
            'location' => $event['location'],
            'start_date' => $start_date,
            'fee' => $event['fee'],
            'url' => $event['url'],
            'image_path' => $event['image_path'],
            'year_month' => $event['year_month'],
        ];
    }
}
