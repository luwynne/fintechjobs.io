@extends('layouts.website')

@section('content')

<section class="title">
    <div class="container">
        <div class="row-fluid">
            <div class="span6">
                <h1>Search result for "{{$job_name}}"</h1>
                <h2>
                </h2>
            </div>
        </div>
    </div>
</section>
<!-- / .title -->

<section id="pricing-table" class="container">
    <div class="center">
        <h2>{{$jobs->count()}} job(s) found</h2>
    </div>

    <div class="big-gap"></div>

    <!-- if count -->

        <div class="row-fluid center clearfix">
            <div class="span12">
                <table class="table table-hover">
                    <thead>
                    <tr class="cell-hide-mobile">
                        <th scope="col">  </th>
                        <th scope="col">Salary</th>
                        <th scope="col">Location</th>
                        <th scope="col">Company</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($jobs as $job)
                    <tr scope="row">
                        <th scope="row"><a target="_blank" href="{{$job['url']}}">{{$job['name']}}</a></th>
                        <td class="cell-hide-mobile">{{$job['salary']}}</td>
                        <td>{{$job['location']}}</td>
                        <td class="cell-hide-mobile">
                        @if($job['is_external'] == false)
                            <a href="{{route('company_show', [$job['company_id'], strtolower(str_replace(' ', '-', $job['company_name']))])}}">{{$job['company_name']}}</a>
                        @else
                            <a target="_blank" href="{{$job['url']}}">{{$job['company']}}</a>
                         @endif 
                        </td></td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    <!-- endif -->
</section>


<section id="registration-page" class="container">
    <form class="center" action="{{route('newsletter')}}" method="POST">
        {{ csrf_field() }}
        <fieldset class="registration-form">
            <div class="control-group">
                <h3>FinTechjobs Alert</h3>
                <br>
            </div>
            <div class="control-group">
            <input type="text" id="job_search" name="job_search" class="job_search_field" placeholder="Position name">
                <!-- E-mail -->
                <div class="controls">
                    <input type="text" id="email" name="email" placeholder="E-mail" class="input-xlarge job_search_field" required>
                </div>
            </div>
            <h5>How often do you want to receive our job alert?</h5>
            </br>
            <div class="control-group">
                <!-- Password-->
                <select name="often_application" id="often_application">
                    <option class="input-xlarge" value="0">&nbsp; Each new position</option>    
                    <option class="input-xlarge" value="1">&nbsp; Daily</option>
                    <option class="input-xlarge" value="7">&nbsp; Every week</option>
                    <option class="input-xlarge" value="30">&nbsp; Monthly</label><br>
                </select>
            </div>

            <div class="control-group">
                <!-- Button -->
                <div class="controls">
                    <button id="send_form" type="submit" class="btn btn-info btn-large btn-block">Register</button>
                    <small>By clicking Register you acept our terms and conditions</small>
                </div>
            </div>
        </fieldset>
    </form>
</section>
<!-- /#registration-page -->


<!--  search positions form -->
<div class="modal hide fade in" id="search" aria-hidden="false">
    <div class="modal-wrapper">
        <div class="modal-header">
            <i class="icon-remove" data-dismiss="modal" aria-hidden="true"></i>
            <h4>Register your interest</h4>
        </div>
        <!--Modal Body-->
        <div class="modal-body">

            <form class="form-inline" name="form" id="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <p id="message_show"></p>
                <input type="text" id="newsletter_email" name="newsletter_email" placeholder="E-mail" class="input-xlarge" required>
                <br><br>
                <button id="form_submit" name="form_submit" class="btn btn-primary">Register</button>
            </form>
        </div>
        <!--/Modal Body-->
    </div>
</div>
<!--  search position form -->

<style>

.modal{
    width: 100%!important;
    height: 100vh!important;
    margin-left:0!important;
    left:0!important;
    background:rgba(0,0,0,0.8);
}

.modal-wrapper{
    width:30%;
    height:170px;
    background-color: rgba(255,255,255, 1.0);
    margin: auto;
    margin-top: 10%;
    border-radius: 5px;
}

.modal .icon-remove {
    position: relative!important;
    right: 0!important;
    top: -5px!important;
    left: 102%!important;
    top: -12px!important;
}

.modal .modal-header {
    padding: 8px 20px 0!important;
}

.modal.fade.in {
    top: 0%!important;
}

.modal input[type="text"]{
width:80%;
}

</style>

<script>

$(document).ready(function(){

    //managing modal display
    setTimeout(function () {
        $("#search").fadeIn(200);
     }, 4000);
    $(".icon-remove").click(function() {
        $("#search").fadeOut(200);
    });

    //making ajax call to insert user mail into the db
    $("#form_submit").click(function(e) {
        e.preventDefault();
        var email = $('input[name="newsletter_email"]').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            type: "POST",
            url: 'http://localhost:8888/fintechjobs.io/public/newsletter/create-ajax-newsletter',
            data: { _token : _token , email: email},
            success:function(html) {
                console.log("Newsletter has been created");
                $("#search").fadeOut(100);
            },
            error:function(e){
                $("#search").fadeOut(100);
            }
        });
    });

});

</script>


@endsection
