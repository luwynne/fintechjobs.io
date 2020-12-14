
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FinTechjobs.io | Dashboard </title>
    <link rel="shortcut icon" href="{{asset('/admin/img/logo.png')}}" style="border-radius: 100%">
    <!-- BOOTSTRAP STYLES-->
    <link href="{{asset('admin/css/bootstrap.css')}}" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="{{asset('admin/css/font-awesome.css')}}" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="{{asset('admin/css/custom.css')}}" rel="stylesheet" />
    <link href="{{asset('admin/css/super_admin_style.css')}}" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    
</head>
<body>



<div id="wrapper">
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="adjust-nav">
            <div class="navbar-header" style="margin-bottom: 40px" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#" >
                    <img width="72" height="67" src="{{asset('images/ico/fintech_white.png')}}" alt="Fintechjobs.io logo white"/>
                </a>

            </div>

                <span class="logout-spn" >
                  <a style="color:#fff;" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                </span>

        </div>
    </div>
    <!-- /. NAV TOP  -->
    <nav class="navbar-default navbar-side" role="navigation" id="navbar-superadmin">
        <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">

                @if(Auth::user()->isSuperAdminAdmin())
                <li {{{ Request::route()->getName() == "super_admin_home" ? 'class=active' : '' }}}>
                    <a href="{!! url('/superadmin/home'); !!}" ><i class="fa fa-desktop "></i>Companies</a>
                </li>     
                @endif
                <!--<li {{{ (Request::is('super_admin_jobs') ? 'class=active' : '') }}}>
                    <a href="{!! url('/superadmin/jobs'); !!}"><i class="fa fa-bar-chart-o"></i>Jobs to approve
                        @if(\App\Helpers\SuperAdminHelper::getJobToApprove()>0)
                            <span class="badge">{{ \App\Helpers\SuperAdminHelper::getJobToApprove() }}</span>
                        @endif
                    </a>
                </li>-->

                @if(Auth::user()->isSuperAdminAdmin())
                <li {{{ Request::route()->getName() == "super_admin_events" ? 'class=active' : '' }}}>
                    <a href="{!! url('/superadmin/events'); !!}"><i class="fa fa-bar-chart-o"></i>Events to approve
                        @if(\App\Helpers\SuperAdminHelper::getEventToApprove()>0)
                            <span class="badge">{{ \App\Helpers\SuperAdminHelper::getEventToApprove() }}</span>
                        @endif
                    
                    </a>
                </li>
                @endif

                <li {{{ Request::route()->getName() == "super_admin_external_events" ? 'class=active' : '' }}}>
                    <a href="{!! url('/superadmin/external_events'); !!}">
                        @if(Auth::user()->isSuperAdminAdmin())
                            <i class="fa fa-bar-chart-o"></i>External events
                            @if(\App\Helpers\SuperAdminHelper::getExternalEventToApprove()>0)
                                <span class="badge">{{ \App\Helpers\SuperAdminHelper::getExternalEventToApprove() }}</span>
                            @endif
                        @else
                            <i class="fa fa-bar-chart-o"></i>Events
                        @endif    
                        @if(\App\Helpers\SuperAdminHelper::getEventToApprove()>0)
                            <span class="badge">{{ \App\Helpers\SuperAdminHelper::getEventToApprove() }}</span>
                        @endif
                    </a>
                </li>

                <li {{{ Request::route()->getName() == "super_admin_create_events" ? 'class=active' : '' }}}>
                    <a href="{!! url('/superadmin/create_event'); !!}"><i class="fa fa-plus-circle"></i>Create event</a>
                </li>

                @if(Auth::user()->isSuperAdminAdmin())
                <li {{{ Request::route()->getName() == "super_admin_courses" ? 'class=active' : '' }}}>
                    <a href="{!! url('/superadmin/courses'); !!}"><i class="fa fa-bar-chart-o"></i>Courses to approve
                        @if(\App\Helpers\SuperAdminHelper::getCourseToApprove()>0)
                            <span class="badge">{{ \App\Helpers\SuperAdminHelper::getCourseToApprove() }}</span>
                        @endif
                    </a>
                </li>
                @endif

                <li {{{ Request::route()->getName() == "super_admin_create_education_institute" ? 'class=active' : '' }}}>
                    <a href="{!! url('/superadmin/create_education_institute'); !!}"><i class="fa fa-plus-circle"></i>Create education institute</a>
                </li>

                <li {{{ Request::route()->getName() == "super_admin_education_institute" ? 'class=active' : '' }}}>
                    <a href="{!! url('/superadmin/education_institutes'); !!}"><i class="fa fa-plus-circle"></i>Education Institutes</a>
                </li>

            </ul>
        </div>

    </nav>

</div>

@yield('content')
