@extends('layouts.single')

@section('content')

<section class="title education-header">
    <div class="container">
        <div class="row-fluid">
            <div class="span6">
                <h1>{{$institute->company->name}}</h1>
            </div>
            <div class="span6">
                <ul class="breadcrumb pull-right">
                    <li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
                    <li><a href="{{ url('/companies') }}">Education</a> <span class="divider">/</span></li>
                    <li class="active">{{$institute->company->name}}</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- / .title -->

<section id="company" class="container main">

    @if($institute->company->logo) 
        <div class="company-description-wrapper company-profile-logo-holder">
            <img src="http://localhost:8888/fintechjobs.io/public/admin/img/logos/{{$institute->company->logo->file_name}}" alt="company-profile-logo">
        </div>
        <br>
    @endif

    @if($institute->company->description->content != '') 
        <div class="company-description-wrapper">
        <p><b>Institute Name:</b> {{$institute->company->name}}<br>
            <b>Institute Address:</b> {{$institute->company->address}}<br>
            @if($institute->company->phone)
                <b>Phone Number:</b> {{$institute->company->phone}}<br>
            @endif
            
            @if($institute->company->website)
                <b>Website Address:</b><a target="_blank" href="//{{$institute->company->website}}"> {{$institute->company->website}}</a><br>
            @endif
            </p>
            <br>
            @if(strlen($institute->company->description->content) > 7)
                <h2>Institute Information</h2>
                {!! $institute->company->description->content !!}
                <br>
            @endif    
        </div>
        <br class="hide-on-mobile">
    @endif
    
    
        
    @if($institute->company->isVideoAllowed())
        @if($institute->company->vimeo_video && $institute->company->vimeo_video->external_id) 
            <iframe src="https://player.vimeo.com/video/{{$institute->company->vimeo_video->external_id}}?autoplay=0&loop=0&autopause=0&api=1&controls=1&muted=0?playsinline=1" 
                width=100% 
                height="400" 
                frameborder="0" 
                allow="fullscreen" 
                allowfullscreen >
            </iframe>
            <br class="hide-on-mobile"><br class="hide-on-mobile">
        @endif
    @endif


    @if($courses->count() > 0)
        <h2 class="company-jobs-h">Courses</h2><br>
        <div class="company-jobs">
            @foreach($courses as $course)
            <div class="open-course-modal" id="{{$course->id}}">
                <div class="open-course-modal-box registration-form company-jobs-block col-md-4">
                    <div class="control-group">
                        <h5>{{$course->name}}</h5>
                    </div>
                </div>
            </div>

            <!--  search positions form -->
            <div class="modal hide fade in" id="modal-{{$course->id}}" aria-hidden="false">
                <div class="modal-wrapper">
                    <div class="modal-header">
                        <i id="{{$course->id}}" class="icon-remove"></i>
                        <h4>{{$course->name}}</h4>
                    </div>
                    <!--Modal Body-->
                    <div class="modal-body">
                        <p id="message_field">
                            {!!$course->description!!}
                        </p>
                        <a href="{{$course->url}}"id="message_field">
                            <h5>Visit the course website</h5>
                        </a>
                    </div>
                    <!--/Modal Body-->
                </div>
            </div>
            <!--  search position form -->
            @endforeach
        </div>
    @endif


    @if($jobs->count() > 0)
        <h2 class="company-jobs-h">Institute jobs</h2><br>
        <div class="company-jobs">
            @foreach($jobs as $job)
            <a href="{{route('website.job.show', [$job->id, strtolower(str_replace(' ', '-', $job->name))])}}">
                <div class="registration-form company-jobs-block col-md-4">
                    <div class="control-group">
                        <h3>{{ \Illuminate\Support\Str::limit($job->name, 26, '') }}</h3>
                        <p>
                            <b>Location: </b>  {{$job->location ? $job->location : $job->company->address }}<br>
                            <b>Salary: </b>{{$job->salary ? $job->salary."k" : 'TBD' }} <br>
                            <b>Posted: </b>{{\Carbon\Carbon::parse($job->updated_at)->diffForHumans()}}
                        </p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    @endif

    <br> <br>

    @if($institute->company->events->count() > 0)
        <h2 class="company-jobs-h">Institute events</h2><br>
        <div class="company-jobs">
            @foreach($institute->company->events as $event)
                <div class="span12 event-block-wrapper">
                    <div class="event-block">
                        <a href="{{route('event_show', [$event->id, strtolower(str_replace(' ', '-', $event->name))])}}">
                            <div style="background-image: linear-gradient(to bottom, rgba(185, 185, 185, 100), rgba(255, 255, 255, 0.73)), url(http://localhost:8888/fintechjobs.io/public/admin/img/events/{{$event->file_name}})" class="box bios event-box">
                                <h3 class="company-list-title">{{$event->name}}</h3>
                                <p>Organizer: {{$event->company->name}}</p>
                                <p>{{$event->city}}</p>
                                <p>{{$event->start_date->format('M d Y')}}</p>
                                <p>{{ $event->fee ?  '£'.$event->fee : 'No entry fee'}}</p>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <br class="hide-on-mobile">
    @endif

    <br> <br>
    <div class="visit-us-wrapper">
        <h4 class="company-jobs-h"><b>Visit us on <a target="_blank" href="//{{$institute->company->website}}"> {{$institute->company->website}}</a></b></h4>        
    </div>       
    
    <br>  
    
    @if($institute->company->isSocialMediaAllowed())
        <div class="company-jobs">
            @foreach($institute->company->social_medias as $social_media)
                @if($social_media->url != '')
                    @switch($social_media->type_id)
                        @case(1)
                        <a target="_blank" href="https://{{$social_media->url}}"><span class="social-icon icon-facebook-sign"></span></a>
                            @break

                        @case(2)
                            <a target="_blank" href="https://{{$social_media->url}}"><span class="social-icon icon-linkedin-sign"></span></a>
                            @break

                        @case(3)
                            <a target="_blank" href="https://{{$social_media->url}}"><span class="social-icon icon-twitter-sign"></span></a>  
                            @break    

                        @default
                            
                    @endswitch
                @endif
            @endforeach 
        </div>
    @endif
    
         

</section>   

<script>

$(document).ready(function(){

    $(".open-course-modal").click(function(e) {
        var modal  = document.getElementById('modal-'+$(this).attr('id'));
        console.log(modal);
        $(modal).fadeIn(50); 
    });

    $(".icon-remove").click(function(e) {
        var modal  = document.getElementById('modal-'+$(this).attr('id'));
        console.log(modal);
        $(modal).fadeOut(150);
    });

});

</script>

@endsection