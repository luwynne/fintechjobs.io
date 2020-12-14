@extends('layouts.super_admin')

@section('content')

<div id="page-wrapper" >
    <div id="page-inner">
        <div class="row">
            <div class="col-lg-12">

                <form action="{{ url('/superadmin/jobs/'.$job->id) }}" method="POST">
                    {{ csrf_field() }}
                    <label for="name">Title</label>
                    <input type="text" name="name" class="form-control" disabled value="{{$job->name}}">

                    <label for="benefits">Description</label><br>
                    <textarea disabled style="min-width: 100%" name ="description" rows="10">{{ $job->render_escaped_html_description() }}</textarea><br>

                    <label for="location">Salary</label>
                    <input type="text" name="salary" class="form-control" disabled value="{{$job->salary}}">

                    <label for="experience">Location</label>
                    <small>In case there is no infromation about the job location, the company location will be displayed</small>
                    <input type="text" name="location" class="form-control" disabled value="{{$job->location}}">

                    <label for="benefits">Experience (years)</label>
                    <input type="text" name="experience" class="form-control" disabled value="{{$job->experience_years}}">

                    <label for="benefits">Bonus</label>
                    <input type="text" name="bonus" class="form-control" disabled value="{{$job->bonus}}">

                    <label for="benefits">Created</label>
                    <input type="text" name="created" class="form-control" disabled value="{{$job->created_at}}">

                    <label for="benefits">Expiration</label>
                    <input type="text" name="expiration" class="form-control" disabled value="{{$job->expiration}}">

                    <label for="benefits">Company</label>
                    <input type="text" name="company" class="form-control" disabled value="{{$job->company->name}}">

                    <label for="benefits">Recruiter</label>
                    <input type="text" name="recruiter" class="form-control" disabled value="{{$job->recruiter->name}}">
                    
                    <br>
                    <input type="submit" class="btn btn-success" value="Approve">

                </form>
        </div>
            </div>
        </div>
    </div>
</div>

@endsection