<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Importers\ExternalEvents;
use Maatwebsite\Excel\Facades\Excel;

class FillExternalEventsTable extends Command
{
    
    protected $signature = 'external_events:fill';

    protected $description = 'Imports external events from Excel spreadsheet';

    public function __construct(){
        parent::__construct();
    }

    public function handle(){
        Excel::import(new ExternalEvents, storage_path('app/public').'/events.xlsx');
        return 'Import finished';
    }
}
