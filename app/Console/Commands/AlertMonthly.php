<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\{
    Newsletter,
    Job
};

use Mail;
use GuzzleHttp\Client;

class AlertMonthly extends Command
{
    
    protected $signature = 'alert:monthly';

    protected $description = 'Each 2 weeks job alert';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(){

        \Log::info("Cron is working fine!");

        $job_alerts = Newsletter::where('often', 30)->get();

        if($job_alerts){
            $job_alerts->each(function($job_alert){

                $mail = $job_alert->email;
                $id = $job_alert->id;
                $job_search = $job_alert->job_search;
                    
                $client = new Client();

                if($job_search == null || $job_search == ""){
                    $request = $client->get('https://api.jobbio.com/channels/fintechjobsio/feed?&page_size=15&source=fintechjobsio&date_posted=all');
                }else{
                    $request = $client->get('https://api.jobbio.com/channels/fintechjobsio/feed?search='.$job_search.'&page_size=15&source=fintechjobsio&date_posted=all');
                }
                
                $response = json_decode($request->getBody()->__toString());
                
                $jobs = collect();

                foreach($response->results as $response_data){

                    if($response_data->salary_from == 0 && $response_data->salary_to == 0){
                        $salary = "TBC";
                    }else{
                        $salary = "From ".$response_data->salary_from." to ".$response_data->salary_to;
                    }

                    if($response_data->redirect !== null){
                        $url = $response_data->redirect;
                    }else{
                        $url = 'https://jobbio.com/companies/comp/jobs/job?app_source=fintechjobsio&job_id='.$response_data->id.'&source=fintechjobsio';
                    }

                    $jobs->push([
                        'id' => $response_data->id,
                        'title' => $response_data->title,
                        'slug' => $response_data->slug,
                        'salary' => $salary,
                        'location' => $response_data->location->city ." - ".$response_data->location->country,
                        'url' => $url
                    ]);
                }

                if($jobs->count() > 0){

                    $title = "Fintechjobs.io | Job alert";

                    $data = array(
                        'jobs' => $jobs,
                        'id' => $id,
                        'newsletter' => true,
                        'title' => $job_search
                    );

                    try{

                        Mail::send('mails.jobAlert', $data, function($message) use ($mail, $title){
                            $message->to($mail)->subject($title);
                            $message->from('info@fintechjobs.io','Fintechjobs.io');
                        });

                    }catch(Exception $e){
                        report($e);
                        return false;
                    }

                }

            });
        }

        $this->info('AlertDaily Cummand Run successfully!');

    }
}
