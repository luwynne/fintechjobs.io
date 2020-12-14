@extends('layouts.super_admin')

@section('content')

<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-lg-12">

                <form action="{{ url('/superadmin/company/'.$company->id.'/edit') }}" method="POST">
                    {{ csrf_field() }}
                    <label for="name">Company name</label>
                    <input type="text" name="name" class="form-control" disabled value="{{$company->name}}">

                    <label for="benefits">Sector</label>
                    <select name="sector" class="form-control">
                        @foreach($sectors as $sector)
                            <option {{ ( $company->sector->id == $sector->id ) ? 'selected' : "" }} value="{{$sector->id}}">{{$sector->name}}</option>
                        @endforeach    
                    <select>

                    <label for="location">Address</label>
                    <input type="text" name="address" class="form-control" disabled value="{{$company->address}}">

                    <label for="experience">Phone</label>
                    <input type="number" name="phone" class="form-control" disabled value="{{$company->phone}}">

                    <label for="benefits">Website</label>
                    <input type="text" name="website" class="form-control" disabled value="{{$company->website}}">

                    <label for="benefits">Package</label>
                    <select name="plan" class="form-control">
                        @foreach($plans as $plan)
                            <option {{ ( $company_last_plan_id == $plan->id ) ? 'selected' : "" }} value="{{$plan->id}}">{{$plan->name}} - {{strip_tags($plan->description)}}</option>
                        @endforeach    
                    <select>

                    <input type="submit" class="btn btn-primary" value="Save">

                </form>
        </div>
            </div>
        </div>
    </div>
</div>

@endsection