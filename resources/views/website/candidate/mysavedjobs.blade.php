@extends('layouts.website')

@section('content')

<section class="title">
    <div class="container">
        <div class="row-fluid">
            <div class="span6">
                <h1>My saved jobs</h1>
            </div>
        </div>
    </div>
</section>
<!-- / .title -->

<section id="pricing-table" class="container">

@if($jobs->count() > 0)

    <div id="job_table_div">
    <div class="big-gap"></div>
        <!-- if count -->
            <div  class="row-fluid center clearfix">
                <div class="span12">

                    <table class="table table-hover">
                            <thead>
                            <tr class="cell-hide-mobile">
                                <th scope="col">  </th>
                                <th scope="col">Salary</th>
                                <th scope="col">Location</th>
                                <th scope="col">Company</th>
                                <th scope="col">Last updated</th>
                                <th scope="col"></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($jobs as $job)
                            <tr class="job_row" id="row-{{$job->id}}" scope="row">
                                <th scope="row"><a href="{{route('website.job.show', [$job->id, str_replace(' ', '-', $job->name)])}}">{{$job->name}}</a></th>
                                <td class="cell-hide-mobile">{{$job->salary ? $job->salary."k" : 'TBD' }}</td>
                                @if($job->location)
                                <td>{{$job->location}}</td>
                                @else
                                <td>{{$job->company->address}}</td>
                                @endif
                                <td class="cell-hide-mobile">
                                    <a href="{{route('company_show', [$job->company->id, strtolower(str_replace(' ', '-', $job->company->name))])}}">{{$job->company->name}}</a>
                                </td></td>
                                <td class="cell-hide-mobile">{{\Carbon\Carbon::parse($job->updated_at)->diffForHumans()}}</td>
                                <td> <a class="usave-job" id="{{$job->id}}" href="">Unsave</a></td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
            </div>
        <!-- endif -->
    </div>

@else

    <div id="no_jobs_message" class="center">
        <h2>You have no jobs saved</h2>
    </div>

@endif
    

    
</section>

<script>

$(document).ready(function(){

    $(".usave-job").click(function(e) {
        e.preventDefault();
        var job_id = $(".usave-job").attr('id');
        var _token = $('input[name="_token"]').val();
        var jobs_count = $('input[name="jobs_count"]').val();
        $.ajax({
            type: "POST",
            url: 'http://localhost:8888/fintechjobs.io/public/unsave_job/'+job_id,
            data: { _token : _token},
            success:function(html) {
                $("#message").fadeIn(100);
                var id_name = 'row-'+job_id;
                var hidding_row = document.getElementById(id_name);
                jobs_count --;
                $(hidding_row).hide();
                location.reload();
            },
            error:function(e){
                console.log(e);
                $("#message").fadeIn(100);
            }
        });
    });

});

</script>

@endsection