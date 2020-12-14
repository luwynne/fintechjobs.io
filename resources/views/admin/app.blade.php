<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FinTechjobs.io | Dashboard </title>
    <link rel="shortcut icon" href="{{asset('/admin/img/logo.png')}}" style="border-radius: 100%">
    <!-- BOOTSTRAP STYLES-->
    <link href="{{asset('admin/css/bootstrap.css')}}" rel="stylesheet" />
    <!-- FONTAWESOME STYLES-->
    <link href="{{asset('admin/css/font-awesome.css')}}" rel="stylesheet" />
    <!-- CUSTOM STYLES-->
    <link href="{{asset('admin/css/custom.css')}}" rel="stylesheet" />
    <!-- GOOGLE FONTS-->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
    <script src="{{asset('admin/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admin/js/custom.js')}}"></script>
    <script src="{{asset('admin/js/jquery-1.10.2.js')}}"></script>
    <script src="{{asset('admin/js/main.js')}}"></script>

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
                    <img width="72" height="67" src="{{asset('images/ico/fintech_white.png')}}" />
                </a>

            </div>

                <span class="logout-spn" >
                    <a style="color:#fff;" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="fa fa-power-off"></i>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </span>
        </div>
    </div>

    <div id="app">
        <main-component></main-component>
    </div>

<script type="text/javascript" src="../js/app.js"></script>
<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=97tb03zdmb5b27dr33mtc2t72ydc9b28phzgjdtp4r6iusv7"></script>
<script>tinymce.init({ selector:'textarea' });</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.js"></script>
</div>



