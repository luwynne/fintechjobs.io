@extends('layouts.website')

@section('content')

<section class="title">
    <div class="container">
        <div class="row-fluid">
            <div class="span6">
                <h1>My applied jobs</h1>
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
        <h2>You have no jobs applied</h2>
    </div>

@endif
    

    
</section>


@endsection