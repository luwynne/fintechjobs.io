<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Importers\EducationInstitutes;
use Maatwebsite\Excel\Facades\Excel;

class FillEducationInstitutesTable extends Command{
    
    protected $signature = 'education_institutes:fill';

    protected $description = 'Fills up the education_institutes table';

    public function __construct(){
        parent::__construct();
    }

    public function handle(){
        Excel::import(new EducationInstitutes, storage_path('app/public').'/institutes.xlsx');
        return 'Import finished';
    }
}
