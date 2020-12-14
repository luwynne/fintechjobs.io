<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\{
    Event,
    Newsletter
};
use Mail;
use Carbon\Carbon;

class EventAlertWeekly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'event_alert:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends a weekly newsletter with all the events on the platform';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){

        $today = Carbon::now();
        $events = Event::where('start_date', '>=', $today)->where('end_date', '>=', $today)->orderBy('start_date', 'ASC')->take(10)->get();

        if($events->count() > 0){

            $newsletters = Newsletter::all();

            $newsletters->each(function($newsletter) use($events){

                $title = "Fintechjobs.io | Events";
                $mail = $newsletter->email;

                $data = array(
                    'events' => $events,
                    'id' => $newsletter->id,
                    'newsletter' => true
                );

                try{

                    Mail::send('mails.eventsWeekly', $data, function($message) use ($mail, $title){
                        $message->to($mail)->subject($title);
                        $message->from('info@fintechjobs.io','Fintechjobs.io');
                     });

                }catch(Exception $e){
                    report($e);
                    return false;
                }

            });

        }

        $this->info('AlertDaily Cummand Run successfully!');
        
    }
}
