
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
    <nav class="navbar-default navbar-side navbar-superadmin" role="navigation" id="navbar-superadmin">
        <div class="sidebar-collapse">
            <ul class="nav" id="main-menu">
                <li><a href="{!! url('/admin/home'); !!}" ><i class="fa fa-desktop "></i>Dashboard</a></li>
                <li><a href="{!! url('/admin/vacancies'); !!}"><i class="fa fa-table "></i>My vacancies</a></li>
                <li>
                    <a href="{!! url('/admin/applications'); !!}"><i class="fa fa-bar-chart-o"></i>Applications
                        @if(\App\Helpers\JobApplicationsHelper::getApplicationsNumber()>0)
                        <span class="badge">{{\App\Helpers\JobApplicationsHelper::getApplicationsNumber()}}
                        @endif
                    </span>
                    </a>
                </li>
                <li><a href="{!! url('/admin/billing'); !!}"><i class="fa fa-credit-card  "></i>Billing</a></li>
                <li><a href="{!! url('/admin/users'); !!}"><i class="fa fa-desktop  "></i>Users</a></li>
            </ul>
        </div>

    </nav>

</div>

@yield('content')
