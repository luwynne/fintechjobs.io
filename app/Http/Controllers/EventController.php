<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{
    CreateEventRequest,
    EditEventRequest
};

use App\{
    Event,
    EventImage
};
use Auth;
use Image;
use File;
use Carbon\Carbon;

class EventController extends Controller{

    public function getEvents(){
        $company = Auth::user()->company;
        $events = $company->events;
        return response()->json($events);
    }

    public function createEvent(CreateEventRequest $request){
        if(Auth::user()->company->hasEventCredits() && !Auth::user()->company->isPlanExpired()){
            $event = $this->saveEvent($request, null);
            return response()->json($event, 200);
        }else{
            return response()->json(['message'=>'You have no Event credits'], 403);
        } 
    }


    public function editEvent(EditEventRequest $request, $event_id){
        $event = $this->saveEvent($request, $event_id);
        return response()->json($event, 200);
    }

    private function saveEvent($request, $event_id): Event{
        
        if(isset($event_id)){
            $event = Event::find($event_id);
        }else{
            $event = new Event();
        }
        
        $event->company_id = Auth::user()->company->id;
        $event->name = $request->input('name');

        $start_date = Carbon::parse($request->input('start_date'));
        $end_date = Carbon::parse($request->input('end_date'));

        $event->start_date = $start_date;
        $event->end_date = $end_date;
        $event->address = $request->input('address');
        $event->city = $request->input('city');
        $event->country_id = $request->input('country_id');
        $event->fee = $request->input('fee');

        if (strlen(strstr($request->input('url'),"https://"))>0) {
            $event->url = str_replace("https://", "", $request->input('url'));
        }elseif(strlen(strstr($request->input('url'),"http://"))>0){
            $event->url = str_replace("http://", "", $request->input('url'));
        }else{
            $event->url = $request->input('url');
        } 

        $event->description = $request->input('description');
        

        if($request->input('image')){
            $destinationpath = public_path('admin/img/events/');
            $file_path = $destinationpath.$event->file_name;

            if(File::exists($file_path) && isset($event_id)) {
                unlink($file_path);
            }

            $image = $request->input('image');
            $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            Image::make($image)->save(public_path('admin/img/events/').$name);
            $event->file_name = $name;
        }
        
       
        
        $event->save();

        return $event;

    }

    public function getEventFileName($event_id){
        $event = Event::find($event_id);
        return $event->file_name;
    }
    
}
