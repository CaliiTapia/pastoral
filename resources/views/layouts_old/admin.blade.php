<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="{{ asset("favicon.ico") }}">
    <title>1% Parroquial</title>
    {{--Vendor styles--}}
    <link rel="stylesheet" href="{{ asset("vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css") }}">
    <link rel="stylesheet" href="{{ asset("vendors/bower_components/animate.css/animate.min.css") }}">
    <link rel="stylesheet" href="{{ asset("vendors/bower_components/jquery.scrollbar/jquery.scrollbar.css") }}">
    <link rel="stylesheet" href="{{ asset("vendors/bower_components/fullcalendar/dist/fullcalendar.min.css") }}">
    <link rel="stylesheet" href="{{ asset("vendors/bower_components/select2/dist/css/select2.css") }}">

    {{--Javascript--}}
    <script src="{{ asset("vendors/bower_components/jquery/dist/jquery.min.js") }}"></script>
    <script src="{{ asset("vendors/bower_components/popper.js/dist/umd/popper.min.js") }}"></script>
    <script src="{{ asset("vendors/bower_components/bootstrap/dist/js/bootstrap.min.js") }}"></script>
    <script src="{{ asset("vendors/bower_components/jquery.scrollbar/jquery.scrollbar.min.js") }}"></script>
    <script src="{{ asset("vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js") }}"></script>
    <script src="{{ asset("vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js") }}"></script>
    <script src="{{asset("/vendors/bower_components/select2/dist/js/select2.full.min.js")}}"></script>
    <script src="{{ asset("/js/vue.js") }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.15.2/axios.js"></script>

    {{--DataTables--}}
    <script src="{{ asset("/vendors/bower_components/datatables.net/js/jquery.dataTables.min.js") }}"></script>
    <script src="{{ asset("/vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js") }}"></script>
    <script src="{{ asset("/vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js") }}"></script>
    <script src="{{ asset("/vendors/bower_components/jszip/dist/jszip.min.js") }}"></script>
    <script src="{{ asset("/vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js") }}"></script>

    {{-- Notificaciones Toastr --}}
    <link rel="stylesheet" href="{{ asset('/toastr/toastr.min.css') }}">
    <script type="text/javascript" src="{{ asset('/toastr/toastr.min.js') }}"></script>

    {{-- App functions and actions --}} 
    <script src="{{ asset("js/app.min.js") }}"></script>
    {{-- Modals --}}
    <link rel="stylesheet" href="{{ asset("scss/inc/bootstrap-overrides/_modal.scss") }}">
    {{-- App styles --}}
    <link rel="stylesheet" href="{{ asset("css/app.min.css") }}">
    <link rel="stylesheet" href="{{ asset("css/estilos.css") }}">
</head>

<body data-sa-theme="1">
<main class="main">
    <div class="page-loader">
        <div class="page-loader__spinner">
            <svg viewBox="25 25 50 50">
                <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
            </svg>
        </div>
    </div>
    <header class="header color-navbar">
        <div class="navigation-trigger hidden-xl-up" data-sa-action="aside-open" data-sa-target=".sidebar">
        </div>

        <div class="navigation-trigger hidden-xl-up" data-sa-action="aside-open" data-sa-target=".sidebar">
            <h4>Menu</h4>
        </div>

        <div class="logo hidden-sm-down">
            <h1><a href="/home"><img src="{{asset("img/recursos/logo.png")}}" height="auto" width="300"></a></h1>
        </div>
        <ul class="top-nav">
            <li class="hidden-xs-down">

            </li>
        </ul>
        <div class="clock hidden-md-down">
            <div class="time">
                <span class="time__hours"></span>
                <span class="time__min"></span>
                <span class="time__sec"></span>
            </div>
        </div>
    </header>

    @include('layouts.sidebar')    

    <section class="content">
        @yield('content')
        {{--Va todo el contenido--}}
    </section>
</main>
@yield('javascriptSection')
</body>
</html>
