<?php 

namespace App\Importers;
use Maatwebsite\Excel\Concerns\ToModel;
use App\{
    Country,
    EducationInstitute
};

class EducationInstitutes implements ToModel{

    public function model(array $row){

        if (!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3]) && !empty($row[5])) {
            return new EducationInstitute([
                'name' => $row[1],
                'country_id' => Country::where('name', $row[0])->first() ? Country::where('name', $row[0])->first()->id : 1,
                'url' => $row[2],
                'contact_email' => $row[3],
                'logo_name' => $row[5]
            ]);
        }

    }

}