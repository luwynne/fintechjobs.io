<?php 

namespace App\Importers;
use Maatwebsite\Excel\Concerns\ToModel;
use App\{
    Country,
    ExternalEvent
};

class ExternalEvents implements ToModel{

    public function model(array $row){

        if (!empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[5])) {
            //dd($row[1]);
            $event = new ExternalEvent();
            $event->company_organiser = $row[7];
            $event->name = $row[2];
            $event->description = '';
            $event->start_date = $row[5];
            $event->end_date = $row[6];
            $event->city = $row[0];
            $event->country_id = Country::where('name', $row[1])->first() ? Country::where('name', $row[1])->first()->id : 1;
            $event->fee = $row[8];
            $event->url = $row[3];
            $event->save();
            return $event;
        }

    }

}