@extends('layouts.single')

@section('content')


    
<section class="title">
    <div class="container">
        <div class="row-fluid">
            <div class="span6">
                <h1>{{$job->name}}</h1>
            </div>
        </div>
    </div>
</section>
<!-- / .title -->


<section itemscope itemtype="http://schema.org/JobPosting" id="terms-use" class="container">
    @if(Session::has('notApplied'))
        <div style="text-align:center;" class="alert alert-info">{{ Session::get('notApplied') }}</div>
    @endif
    
    <ul>
        <p  itemprop="title" class="p-job"><b>Job title: </b><span>{{$job->name}}</span></p>
        <span itemprop="hiringOrganization" itemscope itemtype="http://schema.org/Organization">
            
            <p class="p-job"><b>Company: </b><span itemprop="name">
                <a href="{{route('company_show', [$job->company->id, strtolower(str_replace(' ', '-', $job->company->name))])}}">{{$job->company->name}}</a>
            </span></p>
                
        </span>
        <p class="p-job"><b>Sector: </b><span itemprop="industry">{{$job->company->sector->name}}</span></p>
            <!-- <img height="62" width="92" src="company/images/" alt="This company has no logo"> -->

        <p class="p-job">
        <span itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
           <b>Location:</b>
        @if($job->location)
            <span itemprop="addressLocality">{{$job->location}}</span>
        @else
            <span itemprop="addressRegion">{{$job->company->address}}</span>
         @endif
        </p> 
        </span>
        
        <p class="p-job"><b>Salary: </b><span itemprop="salaryCurrency">{{$job->salary}}</span>k</p>
        @if($job->bonus)
        <p class="p-job">
        <b>Benefits:</b>
        <span itemprop="incentiveCompensation">{{$job->bonus}}</span>
        </p>
        @endif
        <p itemprop="experienceRequirements" class="li-job"><b>Experience required: </b><span>{{$job->experience_years}}</span> year(s)</p>
        </br>
        <p itemprop="description" class="p-job" style="font-size:16px;">{!! $job->description !!}</p>

        </br>
        @if(Auth::user() && Auth::user()->isCandidate())
            <div class="controls">
                <input type="hidden" name="job_id" id="job_id" value="{{$job->id}}">
                @if($job->hasBeenSavedByUser())
                    <h4 id="saved_job">This job has been added to your Saved Jobs!</h4>
                @elseif($job->hasBeenAppliedByUser())
                    <h4>You have already applied for this job</h4>
                @else
                    <button name="save_job" id="save_job" class="btn btn-info btn-large btn-block" style="width: 10%">Save job</button>
                    <h4 style="display:none" id="saved_job">This job has been saved to Your Jobs</h4>
                @endif
                
            </div>
        @endif
        </br>
    </ul>


    @if(!$job->hasBeenAppliedByUser() && $job->expiration > \Carbon\Carbon::now())

        <section id="registration-page" class="container">
            
            <form class="left" method="POST" style="width: 100%" enctype="multipart/form-data" name="application-form" id="application-form">
                {{ csrf_field() }}
                <input type="hidden" name="job_id" value="{{$job->id}}">

                <fieldset class="registration">
                    <div class="control-group">
                        <h3 class="h3-job">Apply now</h3>
                        <!-- Username -->
                        <div class="controls">
                        @if(Auth::user() && Auth::user()->isCandidate())
                            <input value="{{Auth::user()->name }}" type="text" id="name" name="name" placeholder="Name" class="input-xlarge" >
                        @else
                            <input type="text" id="name" name="name" placeholder="Name" class="input-xlarge" required>
                        @endif
                            
                        </div>
                    </div>

                    <div class="control-group">
                        <!-- E-mail -->
                        <div class="controls">
                        @if(Auth::user() && Auth::user()->isCandidate())
                            <input value="{{Auth::user()->email }}" type="text" id="email" name="email" placeholder="Email" class="input-xlarge" >
                        @else
                            <input type="text" id="email" name="email" placeholder="Email" class="input-xlarge" required>
                        @endif    
                        </div>
                    </div>

                    <div class="control-group">
                        <!-- E-mail -->
                        <div class="controls">
                            <input type="text" id="phone" name="phone" placeholder="Phone" class="input-xlarge" required>
                        </div>
                    </div>

                    <div class="control-group">
                        <!-- E-mail -->
                        <div class="controls">
                            <input type="text" id="linkedin" name="linkedin" placeholder="Linkedin URL" class="input-xlarge">
                        </div>
                    </div>

                    <div class="control-group">
                        <!-- E-mail -->
                        <div class="controls">
                            <label class="form-inline" for="coverletter">Cover letter</label>
                                @if(Auth::user() && Auth::user()->isCandidate())
                                    <textarea id="cover_letter" name="cover_letter" rows="5" form="application-form">
                                        <p>Dear Hiring Manager,</p>
                                        <p>I am excited to be applying for the {{$job->name}} position at {{$job->company->name}}. 
                                        This specific role perfectly captures what I hoped to achieve as professional. 
                                        The work your company does is fascinating, and I have read in great detail about the cutting-edge tasks to be performed. 
                                        This position would help set me on the right path to achieve my career goals.</p>
                                        <p>Sincerely</p>
                                        <p>{{Auth::user()->name}}</p>
                                    </textarea>
                                @else
                                    <textarea id="cover_letter" name="cover_letter" rows="5" cols="500" form="application-form"></textarea>
                                @endif
                        </div>
                    </div>

                    <div class="control-group">
                        <!-- E-mail -->
                        <div class="controls form-group">
                            <label class="form-inline" for="file">Upload your CV</label>
                            <input class="btn-file" type="file"  name="file" id="file" placeholder="Upload CV" required>
                        </div>
                    </div>
                    <br>
                    <div class="control-group">
                        <!-- Button -->
                        <div class="controls">
                            <button type="submit" name="apply" id="apply" class="btn btn-info btn-large btn-block job-submit">Submit</button>
                            <small>By clicking submit you acept our terms and conditions</small>
                        </div>
                    </div>
                </fieldset>
            </form>

        </section>
        <!-- /#registration-page -->

    @else
        @if($job->expiration < \Carbon\Carbon::now())
            <div class="alert alert-danger job-expired-div">This job is expired!</div>
        @endif    
    @endif
</section>

<!--  modal starts -->
<div class="modal hide fade in" id="message" aria-hidden="false">
    <div class="modal-wrapper">
        <div class="modal-header">
            <i class="icon-remove" data-dismiss="modal" aria-hidden="true"></i>
            <h4>Saved job</h4>
        </div>
        <!--Modal Body-->
        <div class="modal-body">
            <p id="message_field"></p>
        </div>
        <!--/Modal Body-->
    </div>
</div>
<!--  modal end -->


<script>

$(document).ready(function(){

    //making ajax call to insert user mail into the db
    $("#save_job").click(function(e) {
        e.preventDefault();
        var job_id = $('input[name="job_id"]').val();
        var _token = $('input[name="_token"]').val();
        $.ajax({
            type: "POST",
            url: 'http://localhost:8888/fintechjobs.io/public/save_job/'+job_id,
            data: { _token : _token},
            success:function(html) {
                var message = 'The job has been saved to your jobs!';
                document.getElementById("message_field").innerHTML = message;
                $("#message").fadeIn(100);
                $(".icon-remove").click(function() {
                    closeModal();
                });
            },
            error:function(e){
                console.log(e);
                var err = JSON.parse(e.responseText);
                var message = '';
                message = err.message, err.message;
                document.getElementById("message_field").innerHTML = message;
                $("#message").fadeIn(100);
                $(".icon-remove").click(function() {
                    $("#message").fadeOut(200);
                });
            }
        });
    });

    function closeModal(){
        $("#save_job").hide();
        $("#saved_job").css("display", "block");
        $("#message").fadeOut(200);
    }

    // job application
    $("#application-form").on('submit', function(e) {

        e.preventDefault();

        var job_id = $('input[name="job_id"]').val();
        var form = $(this);
        let formData = new FormData(form[0]);
        
        $.ajax({
            type: "POST",
            url: 'http://localhost:8888/fintechjobs.io/public/job/apply/'+job_id,
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: formData,
            processData: false,
            contentType: false,
            async: false,
            cache: false,
            success:function(html) {
                var message = 'Your application has been sent!';
                document.getElementById("message_field").innerHTML = message;
                $("#message").fadeIn(100);
                $(".icon-remove").click(function() {
                    $("#application-form")[0].reset();
                    closeModal();
                });
            },
            error:function(e){
                console.log(e);
                var err = JSON.parse(e.responseText);
                var message = '';
                message = err.message, err.message;
                document.getElementById("message_field").innerHTML = message;
                $("#message").fadeIn(100);
                $(".icon-remove").click(function() {
                    $("#application-form")[0].reset();
                    $("#message").fadeOut(200);
                });
            }
        });
    });

});

</script>

@endsection


