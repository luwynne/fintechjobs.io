@extends('layouts.super_admin')

@section('content')

<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-lg-12">

                <form action="{{ url('/superadmin/create_event') }}" method="POST">
                    {{ csrf_field() }}
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control">

                    <label for="name">Company Organiser</label>
                    <input type="text" name="company" class="form-control">

                    <label for="benefits">Description</label><br>
                    <textarea style="min-width: 100%" name ="description" rows="10"></textarea><br>

                    <label for="location">Start date</label>
                    <input type="date" name="start_date" class="form-control">

                    <label for="location">Start time</label>
                    <input type="time" name="start_time" class="form-control">

                    <label for="experience">End date</label>
                    <input type="date" name="end_date" class="form-control">

                    <label for="location">End time</label>
                    <input type="time" name="end_time" class="form-control">

                    <label for="benefits">City</label>
                    <input type="text" name="city" class="form-control">

                    <label for="benefits">Country</label>
                    <select name="country" class="form-control">
                        @foreach($countries as $country)
                            <option value="{{$country->id}}">{{$country->name}}</option>
                        @endforeach    
                    <select>

                    <label for="benefits">Fee</label>
                    <input type="text" name="fee" class="form-control">

                    <label for="benefits">URL</label>
                    <input type="text" name="url" class="form-control">
                    
                    <br>
                    <input type="submit" class="btn btn-success" value="Submit">

                </form>
            </div>
        </div>
        </div>
    </div>
</div>


@endsection