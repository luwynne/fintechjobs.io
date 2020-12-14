@extends('layouts.single')

@section('content')

<section class="title corporative-header">
    <div class="container">
        <div class="row-fluid">
            <div class="span6">
                <h1>{{$event->name}}</h1>
            </div>
            <div class="span6">
                <ul class="breadcrumb pull-right">
                    <li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
                    <li><a href="{{ url('/events') }}">Events</a> <span class="divider">/</span></li>
                    <li class="active">{{$event->name}}</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- / .title -->

<section id="company" class="container main">

    @if($event->company->logo) 
        <div class="company-description-wrapper company-profile-logo-holder">
            <img class="logo-event" src="http://localhost:8888/fintechjobs.io/public/admin/img/logos/{{$event->company->logo->file_name}}" alt="company-profile-logo">
        </div>
        <br>
    @endif

     
        <div class="company-description-wrapper">
        <p><b>Organiser:</b> <a href="{{route('company_show', [$event->company->id, strtolower(str_replace(' ', '-', $event->company->name))])}}">{{$event->company->name}}</a><br>
            <b>Address:</b> {{$event->address}} - {{$event->city}} - {{$event->country}}<br>
            @if($event->company->phone)
                <b>Phone Number:</b> {{$event->company->phone}}<br>
            @endif
            <b>Date and time:</b> from {{$event->start_date}} to {{$event->end_date}}<br>
            <b>Start date and time:</b> {{$event->start_date}}<br>
            <b>Fee:</b> {{$event->fee ? $event->fee : 'No fee'}}<br>
            @if($event->url)
                <b>Website:</b><a target="_blank" href="https://{{$event->url}}"> {{$event->url}}</a><br>
            @endif
            </p>
            <br>
            @if(strlen($event->description) > 7)
            <h2>Event Description</h2>    
            {!! $event->description !!}
                <br>
            @endif    
        </div>
        <br class="hide-on-mobile">

        @if($event->company->isSocialMediaAllowed())
        <div class="company-jobs">
            @foreach($event->company->social_medias as $social_media)
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

@endsection