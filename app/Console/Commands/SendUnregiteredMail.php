<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\{
    User,
    UnregisteredUserMail
};
use Mail;

class SendUnregiteredMail extends Command{
    
    protected $signature = 'unregistered:send_mail';

    protected $description = 'Sends reminder mail to unfinished regitered users';

    public function __construct(){
        parent::__construct();
    }

    public function handle(){

        $unregistered_users = User::where('role', 'admin')->where('company_id', null)->get();
        
        $unregistered_users->each(function($user){

            $user_unregistered_mail = $user->unregistered_mail;
            
            if($user_unregistered_mail == null || $user_unregistered_mail->sent_counter !== 2){
                
                $mail = $user->email;
                $title = "Fintechjobs.io | Complete your registration";

                $data = array(
                    'name' => $user->name,
                    'newsletter' => false
                );

                try{

                    Mail::send('mails.registrationIncomplete', $data, function($message) use ($mail, $title){
                        $message->to($mail)->subject($title);
                        $message->from('info@fintechjobs.io','Fintechjobs.io');
                     });

                     if($user_unregistered_mail == null){
                        $unregitered_mail = new UnregisteredUserMail();
                        $unregitered_mail->user_id = $user->id;
                        $unregitered_mail->sent_counter = 1;
                        $unregitered_mail->save();
                     }else{
                        $user_unregistered_mail->sent_counter = 2;
                        $user_unregistered_mail->save();
                     }

                }catch(Exception $e){
                    report($e);
                    return false;
                }
            }
            
        });
        
    }
}
