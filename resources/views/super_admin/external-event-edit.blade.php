@extends('layouts.super_admin')

@section('content')

<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-lg-12">

                <form action="{{ url('superadmin/edit_event', [$event->id]) }}" method="POST">
                    {{ csrf_field() }}
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control" value="{{$event->name}}">

                    <label for="name">Company Organiser</label>
                    <input type="text" name="company" class="form-control" value="{{$event->company_organiser}}">

                    <label for="benefits">Description</label><br>
                    <textarea style="min-width: 100%" name ="description" rows="10">{{$event->description}}</textarea><br>

                    <label for="location">Start date and time</label>
                    <input type="datetime" name="start_date" class="form-control" value="{{$event->start_date}}">

                    <label for="experience">End date and time</label>
                    <input type="datetime" name="end_date" class="form-control" value="{{$event->end_date}}">

                    <label for="benefits">City</label>
                    <input type="text" name="city" class="form-control" value="{{$event->city}}">

                    <label for="benefits">Country</label>
                    <select name="country" class="form-control">
                        @foreach($countries as $country)
                            <option {{ ( $event->country_id == $country->id ) ? 'selected' : "" }} value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach    
                    <select>

                    <label for="benefits">Fee</label>
                    <input type="text" name="fee" class="form-control" value="{{$event->fee}}">

                    <label for="benefits">URL</label>
                    <input type="text" name="url" class="form-control" value="{{$event->url}}">

                    @if(Auth::user()->isSuperAdminAdmin())
                        <input type="hidden" name="category_is_menu" value="0"/>
                        <input type="checkbox" name="is_approved" value="1" {{$event->is_approved == true ? 'checked' : ''}}>
                        <label for="is_approved">Is approved</label>  
                    @endif
                    
                    <br>
                    <br>
                    <input type="submit" class="btn btn-success" value="Submit">

                </form>
            </div>
        </div>
        </div>
    </div>
</div>


@endsection