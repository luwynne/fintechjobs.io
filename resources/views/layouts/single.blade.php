<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->


<head>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-145190415-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-145190415-1');
    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {!! Robots::metaTag() !!}
    <title>FinTechjobs.io | 
        <?php
        
            if(isset($company)){
                echo $company->name;
            }elseif(isset($job)){
                echo $job->name;
            }elseif(isset($event)){
                echo $event->name;
            } elseif($institute){
                echo $institute->name;
            }
        
        ?>  
    </title>
    <meta name="description" content="Fintech recruitment continues to increase in demand, especially in London, UK and Ireland, as seen by the number of Fintech Jobs available in the UK employment sector."/>
    <meta name="author" content="Luiz Wynne"/>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-responsive.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/sl-slide.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="shortcut icon" href="{{asset('images/ico/fintech_white.png')}}" style="border-radius: 100%">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>


</head>

<body class="<?php echo Route::getCurrentRoute()->getName(); ?>">

<!--Header-->
<header class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" id="btn-menu">
                <span id="top-bar" class="icon-bar"></span>
                <span id="middle-bar" class="icon-bar "></span>
                <span id="bottom-bar" class="icon-bar "></span>			
            </a>
            <a id="logo" class="pull-left" href="/">
                <img width="80px" src="{{asset('images/logo.png')}}">
            </a>
        </div>
            <div class="nav-bar-list-wrapper">
                <div class="nav-bar-list">
                        <ul class="nav" >
                            <li class="{{ (request()->is('/')) ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
                            <li {{{ (Request::is('about') ? 'class=active' : '') }}}><a href="{{ url('/about') }}">About Us</a></li>
                            <li {{{ (Request::is('fintech') ? 'class=active' : '') }}}><a href="{{ url('/fintech') }}">The Fintech</a></li>
                            <li {{{ (Request::is('companies') ? 'class=active' : '') }}}><a href="{{ url('/companies') }}">Companies</a></li>
                            <li {{{ (Request::is('associations') ? 'class=active' : '') }}}><a href="{{ url('/associations') }}">Fintech Associations</a></li>
                            <li {{{ (Request::is('education') ? 'class=active' : '') }}}><a href="{{ url('/education') }}">Education</a></li>
                            <li {{{ (Request::is('events') ? 'class=active' : '') }}}><a href="{{ url('/events') }}">Events</a></li>
                            
                            <li class="dropdown">
                                <a class="active dropdown-toggle" href="#" class=" " data-toggle="dropdown">Blog<i class="icon-angle-down"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="https://blog.fintechjobs.io">BLOG FINTECHJOBS.IO</a></li>
                                    <li><a href="https://blog.fintechjobs.io/career-advice">CAREER ADVICE</a></li>
                                </ul>
                            </li>
                            
                            <li {{{ (Request::is('contact') ? 'class=active' : '') }}}><a href="{{ url('/contact') }}">Contact</a></li>
                            @if(\Auth::check())
                            <li class="dropdown">
                                <a class="active dropdown-toggle" href="#" class=" " data-toggle="dropdown">{{ Auth::user()->name }}<i class="icon-angle-down"></i></a>
                                <ul class="dropdown-menu">
                                    @if(Auth::user()->role !== 'candidate')
                                        <li><a href="{{ url('/admin/home') }}">Dashboard</a></li>
                                    @else
                                        <li><a href="{{ url('/job/myjobs') }}">My saved jobs</a></li> 
                                        <li><a href="{{ url('/job/appliedjobs') }}">My applied jobs</a></li>
                                    @endif
                                    <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                            document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                @csrf
                                            </form>
                                    </li>
                                </ul>
                            </li>
                            @else
                            <li class="login">
                                <a data-toggle="modal" href="{{route('login')}}"><i class="icon-lock"></i></a>
                            </li>
                            @endif
                        </ul>
                </div><!--/.nav-collapse -->
            </div>        
    </div>
</header>
<!-- /header -->
<!-- /header -->

<!--  Login form -->
<div class="modal hide fade in" id="loginForm" aria-hidden="false">
    <div class="modal-header">
        <i class="icon-remove" data-dismiss="modal" aria-hidden="true"></i>
        <h4>Login Form</h4>
    </div>
    <!--Modal Body-->
    <div class="modal-body">
        <form class="form-inline" action="" method="post" id="form-login">
            <input type="text" class="input-small" name="email" placeholder="Email">
            <input type="password" class="input-small" name="password" placeholder="Password">
            <label class="checkbox">
                <input type="checkbox"> Remember me
            </label>
            <button type="submit" name="login" class="btn btn-primary">Sign in</button>
        </form>
        <p>some message</p>
        <a href="#">Forgot your password?</a>
    </div>
    <!--/Modal Body-->
</div>
<!--  /Login form -->


@yield('content')


<!--Bottom-->
<section id="bottom" class="main" style="float: unset">
    <!--Container-->
    <div class="container">

        <!--row-fluids-->
        <div class="row-fluid">

            <!--Contact Form-->
            <div class="span3">
                <h4>ADDRESS</h4>
                <ul class="unstyled address">
                    <li>
                        <i class="icon-home"></i><strong>Address:</strong>
                        Office 263
                        321 - 323 High Rd
                        Chadwell Heath
                        RM6 6AX
                        ENGLAND

                    </li>
                    <li>
                        <i class="icon-envelope"></i>
                        <strong>Email: </strong> info@fintechjobs.io
                    </li>
                    <li>
                        <i class="icon-globe"></i>
                        <strong>Website:</strong> fintechjobs.io
                    </li>
                    <li>
                        <i class="icon-phone"></i>
                        <strong>Toll Free:</strong> +353 1 5563640
                    </li>
                </ul>
            </div>
            <!--End Contact Form-->

            <!--Important Links-->
            <div id="tweets" class="span3">
                <h4>OUR COMPANY</h4>
                <div>
                    <ul class="arrow">
                        <li><a href="{{ url('/about') }}">About Us</a></li>
                        <li><a href="{{ url('/education') }}">Education</a></li>
                        <li><a href="{{ url('/events') }}">Events</a></li>
                        <li><a href="{{ url('/contact') }}">Contact</a></li>
                        <!-- <li><a href="{{ url('/#testimonials') }}">Testimonials</a></li> -->
                        <li><a href="https://blog.fintechjobs.io">Blog</a></li>
                    </ul>
                </div>
            </div>
            <!--Important Links-->
        </div>
        <!--/row-fluid-->
    </div>
    <!--/container-->

</section>
<!--/bottom-->

<!--Footer-->
<footer id="footer">
    <div class="container">
        <div class="row-fluid">
            <div class="span5 cp">
                &copy; 2020 <a target="_blank" href="http://shapebootstrap.net/">FinTechjobs.io</a>. All Rights Reserved. <br>
                Our <a href="{{ url('/privacy-policy') }}">Privacy Policy</a>
            </div>
            <!--/Copyright-->

            <div class="span6">
                <ul class="social pull-right">
                    <li><a href="https://www.facebook.com/fintechjobs.ie/"><i class="icon-facebook"></i></a></li>
                    <li><a href="https://twitter.com/FintechJobs_ie"><i class="icon-twitter"></i></a></li>
                    <li><a href="https://www.linkedin.com/company-beta/24983760/"><i class="icon-linkedin"></i></a></li>
                </ul>
            </div>

            <div class="span1">
                <a id="gototop" class="gototop pull-right" href="#"><i class="icon-angle-up"></i></a>
            </div>
            <!--/Goto Top-->
        </div>
    </div>
</footer>
<!--/Footer-->


<script src="{{asset('js/vendor/modernizr-2.6.2-respond-1.1.0.min.js')}}"></script>

<script src="{{ asset('js/vendor/jquery-1.9.1.min.js') }}"></script>
<script src="{{ asset('js/vendor/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<!-- Required javascript files for Slider -->
<script src="{{ asset('js/jquery.ba-cond.min.js') }}"></script>
<script src="{{ asset('js/jquery.slitslider.js') }}"></script>
<!-- /Required javascript files for Slider -->

<!-- SL Slider -->
<script type="text/javascript">

    $('#btn-menu').click(function(){
        $('.nav-bar-list-wrapper').toggleClass('nav-bar-list-active');
        $("#top-bar").toggleClass("toggle-top-bar");
        $("#middle-bar").toggleClass("toggle-middle-bar");
        $("#bottom-bar").toggleClass("toggle-bottom-bar");
        $('#logo').toggleClass('hide-on-desktop');
    });

    $(function() {
        var Page = (function() {

            var $navArrows = $( '#nav-arrows' ),
                slitslider = $( '#slider' ).slitslider( {
                    autoplay : true
                } ),

                init = function() {
                    initEvents();
                },
                initEvents = function() {
                    $navArrows.children( ':last' ).on( 'click', function() {
                        slitslider.next();
                        return false;
                    });

                    $navArrows.children( ':first' ).on( 'click', function() {
                        slitslider.previous();
                        return false;
                    });
                };

            return { init : init };

        })();

        Page.init();
    });
</script>
<!-- /SL Slider -->

</body>
</html>

