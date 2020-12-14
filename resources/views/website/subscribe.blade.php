@extends('layouts.website')

@section('content')

<section class="title">
    <div class="container">
        <div class="row-fluid">
            <div class="span6">
                <h1>Newsletter subscription</h1>
            </div>
            <div class="span6">
                <ul class="breadcrumb pull-right">
                    <li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
                    <li class="active">Subscribe</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- / .title -->


<section id="registration-page" class="container">
    <form class="center" >
        {{ csrf_field() }}
        <fieldset class="registration-form">
            <div class="control-group">
                <h3>FinTechjobs Alert</h3>
                <br>
            </div>
            <div class="control-group">
            <input type="text" id="job_search" name="job_search" id="job_search" placeholder="Position name">
                <!-- E-mail -->
                <div class="controls">
                    <input type="text" id="email_applcation" name="email_applcation" placeholder="E-mail" class="input-xlarge" required>
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
                    <button id="form_submit" name="form_submit" type="submit" class="btn btn-info btn-large btn-block">Register</button>
                    <small>By clicking Register you acept our terms and conditions</small>
                </div>
            </div>
        </fieldset>
    </form>
</section>
<!-- /#registration-page -->


<!--  search positions form -->
<div class="modal hide fade in" id="message" aria-hidden="false">
    <div class="modal-wrapper">
        <div class="modal-header">
            <i class="icon-remove" data-dismiss="modal" aria-hidden="true"></i>
            <h4>Subscribe to Job alert</h4>
        </div>
        <!--Modal Body-->
        <div class="modal-body">
            <p id="message_field"></p>
        </div>
        <!--/Modal Body-->
    </div>
</div>
<!--  search position form -->


<script>

$(document).ready(function(){

    //making ajax call to insert user mail into the db
    $("#form_submit").click(function(e) {
        e.preventDefault();
        var job_search = $('input[name="job_search"]').val();
        var email = $('input[name="email_applcation"]').val();
        var often = $('#often_application').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            type: "POST",
            url: 'http://localhost:8888/fintechjobs.io/public/newsletter/create-ajax-newsletter',
            data: { _token : _token , job_search: job_search, email: email, often: often},
            success:function(html) {
                var message = 'Your subscription has been created!';
                document.getElementById("message_field").innerHTML = message;
                $("#message").fadeIn(100);
                $(".icon-remove").click(function() {
                    closeModalAndRedirect(false);
                });
            },
            error:function(e){
                console.log(e);
                var err = JSON.parse(e.responseText);
                var message = '';
                if(err.errors.email && err.errors.email.length > 0){
                    message = err.errors.email[0];
                }else{
                    message = err.message, err.message;
                }
                document.getElementById("message_field").innerHTML = message;
                $("#message").fadeIn(100);
                $(".icon-remove").click(function() {
                    closeModalAndRedirect(true);
                });
            }
        });
    });

    function closeModalAndRedirect(hasError){
        $("#message").fadeOut(200);
        
        if(hasError == false){
            window.location.href = "http://localhost:8888/fintechjobs.io";
        }
    }

});

</script>


@endsection