@extends('layouts.website')

@section('content')

<!--Slider-->
<section id="slide-show">
     <div id="slider" class="sl-slider-wrapper" style="text-align: center">

        <!--Slider Items-->
        <div class="sl-slider">
            <!--Slider Item1-->
            <div class="sl-slide item1" data-orientation="horizontal" data-slice1-rotation="-25" data-slice2-rotation="-25" data-slice1-scale="2" data-slice2-scale="2">
                <div class="sl-slide-inner" style="background-image: url('images/sample/slider/home-bg.jpg')">
                    <div class="container" >
                        <h2>FinTechjobs.io</h2>
                        <h3 class="gap">Dedicated online FinTech recruitment platform</h3>
                        <button id="job-search-button" class="btn btn-large btn-transparent" style="border-radius: 10px">Job search</button>
                        <a href="{{route('register')}}"><button class="btn btn-large btn-transparent" style="border-radius: 10px;">Companies / Universities</button></a>
                     </div>
                 </div>
             </div>

                    </div>
                </div>
            </div>
            <!--/Slider Item1-->


    </div>
    <!--/Slider Items-->

</div>
<!-- /slider-wrapper -->
</section>
<!--/Slider-->

<section class="main-info">
    <div class="container table-container">
        <div class="row-fluid">
            <div class="span12">
                <h3>Latest positions</h3>
                 <div id="feed-jobs" class="jobbioapp">
                 </div>   
            </div>
        </div>
        <div id="feed-search-block" class="row-fluid">
            <div class="span12">
                <h3>Job search</h3> 
                 <div id="feed-search" class="jobbioapp">
                 </div>   
            </div>
        </div>
    </div>
</section>

<!--Services-->
<section class="services-grey" id="services">
    <div class="container">
        <div class="center gap">
            <i class="icon-credit-card services-icon"></i>
            <h3 class="services-title-dark">What is Fintech?</h3>
        </div>
        <div class="row-fluid">

            <div class="span12">
                <div class="media">
                    <div class="media-body services-content-wrapper">
                        <p class="services-p">
                            Fintech is a mix of the words financial and technology. It is the use of technology that automates and helps improve the use of Financial Services.
                        </p>
                    </div>
                </div>
            </div>     

        </div>

        <div class="gap hide-on-mobile"></div>

    </div>
</section>
<!--/Services-->


<!--Services-->
<section class="services-black" id="services">
    <div class="container">
        <div class="center gap">
            <i class="icon-suitcase services-icon"></i>
            <h3>Jobseekers</h3>
        </div>
        <div class="row-fluid">

            <div class="span12">
                <div class="media">
                    <div class="media-body services-content-wrapper">
                        <p class="services-p">
                        Are you currently searching for Fintech Jobs? If the answer is yes you have come to the right place – Fintechjobs.io is an online meeting platform for people looking for employment in Fintech Companies. Carve out your perfect Fintech Career – Search for Fintech Jobs by using our easy to use <a class="dark-body-a" data-toggle="modal" data-target="#search">Quick Fintech Jobs Search</a>  Finder’ facility. Thinking of advertising or applying for Fintech Jobs in Europe or Worldwide – Think Fintechjobs.io!
                        </p>
                    </div>
                </div>
            </div>


        </div>

        <div class="gap hide-on-mobile"></div>

    </div>
</section>
<!--/Services-->


<!--Services-->
<section class="services-white" id="services">
    <div class="container">
        <div class="center gap">
            <i class="icon-building services-icon"></i>
            <h3 class="services-title-dark">Employers</h3>  
        </div>
        <div class="row-fluid">

            <div class="span12">
                <div class="media">
                    <div class="media-body services-content-wrapper">
                        <p class="services-p">
                            If you are an Employer and wish to post a vacancy on our Fintech UK Jobs Board - we can help you find the best, most suitably qualified people all at a very competitive rate. Job seekers can apply for jobs posted on our Fintech Jobs Board using any device at any time.
                        </p>
                    </div>
                </div>
            </div>

        </div>

        <div class="gap hide-on-mobile"></div>

    </div>
</section>
<!--/Services-->


<section id="clients" class="main effect6">
    <div class="container">
        <div class="row-fluid">
            <div class="span4">
                <div class="clearfix">
                    <h3 class="pull-left services-title-dark">Fintech associations</h3>
                    <div class="pull-right">
                        @if(count($associations) > 1)
                            <a class="prev" href="#myCarousel" data-slide="prev"><i class="icon-angle-left icon-large"></i></a> 
                            <a class="next" href="#myCarousel" data-slide="next"><i class="icon-angle-right icon-large"></i></a>
                        @endif
                    </div>
                </div>
                <p class="services-p">Fitnechjobs.io counts on some of the most important european Fintech Associations</p>
            </div>
            <div class="span8">
                <div id="myCarousel" class="carousel slide clients">
                  <!-- Carousel items -->
                  <div class="carousel-inner">
                    @foreach($associations as $association)
                        <div class="item" id="association-{{$association->id}}">
                            <div class="row-fluid">
                                <div class="span4">
                                    <img src="http://localhost:8888/fintechjobs.io/public/admin/img/logos/{{$association->logo->file_name}}">
                                </div>
                                <div class="span8">
                                    <a href="{{route('association_show', [$association->id, strtolower(str_replace(' ', '-', $association->name))])}}">
                                        <h4 class="services-title-dark">{{$association->name}}</h4>
                                    </a>
                                    <p class="services-p">{!! $association->description->content !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- /Carousel items -->

            </div>
        </div>
    </div>
    </div>
</section>



<section id="registration-page" class="container">
    <form class="center" >
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
                    <input type="text" id="email_applcation" name="email_applcation" placeholder="E-mail" class="input-xlarge job_search_field" required>
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



<!--  search positions form -->
<div class="modal hide fade in" id="search" aria-hidden="false">
    <div class="modal-header">
        <i class="icon-remove" data-dismiss="modal" aria-hidden="true"></i>
        <h4>Search position</h4>
    </div>
    <!--Modal Body-->
    <div class="modal-body">

        <form class="form-inline" action="{{route('search')}}" method="post" id="form-login" >
        {{ csrf_field() }}
            <input class="input-xxlarge" type="text" placeholder="Position, Keywords" id="job_name" name="job_name" style="width: 80%"><br>
            <input class="input-xxlarge" type="text" placeholder="Location" id="job_location" name="job_location" style="width: 80%"><br>
            <br><br>
            <button type="submit" class="btn btn-primary" name="search">Search</button>
        </form>
    </div>
    <!--/Modal Body-->
</div>
<!--  search position form -->

<script src="https://widgets.jobbio.com/partner_fluid_widgets_v1.2/feed-search.js" id="jobbio-feed-search-script"></script>
<script src="https://widgets.jobbio.com/partner_fluid_widgets_v1.2/jobs-feed.js" id="jobbio-jobs-feed-script"></script>

<script>

$(document).ready(function(){

    // jobbio search
    jobbio_horizontal_search.widget({
        slug: 'fintechjobsio',
        container: 'feed-search',
        action: 'https://jobs.fintechjobs.io/search',
        googleAutoCompleteKey: 'AIzaSyA2M6EBp2KWTpPMPqr0Doa7PU8q4_gtiKI'
    });

    jobbio_jobs_feed.widget({
        slug: 'fintechjobsio',
        container: 'feed-jobs',
        location: 'https://jobs.fintechjobs.io/job',
        count: 10,
        googleAutoCompleteKey: 'AIzaSyA2M6EBp2KWTpPMPqr0Doa7PU8q4_gtiKI'
    });

    // job search modal
    $("#job-search-button").click(function() {
        $('html, body').animate({
            scrollTop: $("#feed-search-block").offset().top-100
        }, 500);
    });

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
                if(err.errors){
                    message = err.message;
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
