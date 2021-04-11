<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Vendor styles -->
        <link rel="stylesheet" href="vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
        <link rel="stylesheet" href="vendors/bower_components/animate.css/animate.min.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

        
        <!-- App styles -->
        <link rel="stylesheet" href="css/app.min.css">
         <link rel="stylesheet" href="css/estilos.css">
    </head>

    <body data-sa-theme="4">
        <div class="login">
        <form method="POST" action="{{ route('login') }}">
                        @csrf
            <!-- Login -->
            <div class="login__block active" id="l-login">
                <div class="login__block__header2">
                    <img src="{{asset('/img/recursos/logo.png')}}" alt="" class="img-fluid2">
                    Sistema de gestión y solicitud de Fondos
                    <div class="actions actions--inverse login__block__actions">
                        <div class="dropdown">
                            <i data-toggle="dropdown" class="zmdi zmdi-more-vert actions__item"></i>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" data-sa-action="login-switch" data-sa-target="#l-forget-password" href="">Olvido su clave?</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="login__block__body">
                    <div class="form-group">
                        <input id="email" name="email" type="text" class="form-control text-center" placeholder="USUARIO">
                    </div>

                    <div class="form-group">
                        <input id="password" name="password" type="password" class="contiene-mayuscula form-control text-center" placeholder="CLAVE">
                    </div>
                    <div style="display:none;"  class="upperCase label label-warning label-outlined" >
                        Teclas Mayúsculas Activas
                    </div>
                    <br>
                        <button type="submit" class="btn btn-outline-warning">
                            INGRESAR 
                        </button>
                    <style type="text/css">
                        #button-ingreso{
                            color: #FFC701;
                        }
                        #button-ingreso:hover{
                             background-color: #E42E3B;
                        }
                        .label {
                            display: block;
                            text-align: center;
                            white-space: nowrap;
                            vertical-align: baseline;
                            padding: 4px 8px;
                            border-radius: 5px;
                            font-size: 12px;
                            font-weight: 400;
                            color: #FFF
                        }
                        .label.label-warning {
                            background-color: #FFD600
                        }
                        .label.label-outlined {
                            border-width: 1px;
                            border-style: solid;
                            background-color: transparent
                        }
                        .label.label-outlined.label-warning {
                        border-color: #FFD600;
                        color: #FFD600
                        }
                    </style>
                </div>
            </div>
        

    </form>
            <!-- Register -->
            <div class="login__block" id="l-register">
                <div class="login__block__header">
                    <i class="zmdi zmdi-account-circle"></i>
                    Create an account

                    <div class="actions actions--inverse login__block__actions">
                        <div class="dropdown">
                            <i data-toggle="dropdown" class="zmdi zmdi-more-vert actions__item"></i>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" data-sa-action="login-switch" data-sa-target="#l-login" href="">Already have an account?</a>
                                <a class="dropdown-item" data-sa-action="login-switch" data-sa-target="#l-forget-password" href="">Forgot password?</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="login__block__body">
                    <div class="form-group">
                        <input type="text" class="form-control text-center" placeholder="Name">
                    </div>

                    <div class="form-group form-group--centered">
                        <input type="text" class="form-control text-center" placeholder="Email Address">
                    </div>

                    <div class="form-group form-group--centered">
                        <input type="password" class="form-control text-center" placeholder="Password">
                    </div>

                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description">Accept the license agreement</span>
                        </label>
                    </div>

                    <a href="index.html" class="btn btn--icon login__block__btn"><i class="zmdi zmdi-plus"></i></a>
                </div>
            </div>

            <!-- Forgot Password -->
            <div class="login__block" id="l-forget-password">
                <div class="login__block__header">
                    <i class="zmdi zmdi-account-circle"></i>
                    Forgot Password?

                    <div class="actions actions--inverse login__block__actions">
                        <div class="dropdown">
                            <i data-toggle="dropdown" class="zmdi zmdi-more-vert actions__item"></i>

                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" data-sa-action="login-switch" data-sa-target="#l-login" href="">Already have an account?</a>
                                <a class="dropdown-item" data-sa-action="login-switch" data-sa-target="#l-register" href="">Create an account</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="login__block__body">
                    <p class="mb-5">Lorem ipsum dolor fringilla enim feugiat commodo sed ac lacus.</p>

                    <div class="form-group">
                        <input type="text" class="form-control text-center" placeholder="Email Address">
                    </div>

                    <a href="index.html" class="btn btn--icon login__block__btn"><i class="zmdi zmdi-check"></i></a>
                </div>
            </div>
        </div>

        <!-- Older IE warning message -->
            <!--[if IE]>
                <div class="ie-warning">
                    <h1>Warning!!</h1>
                    <p>You are using an outdated version of Internet Explorer, please upgrade to any of the following web browsers to access this website.</p>

                    <div class="ie-warning__downloads">
                        <a href="http://www.google.com/chrome">
                            <img src="img/browsers/chrome.png" alt="">
                        </a>

                        <a href="https://www.mozilla.org/en-US/firefox/new">
                            <img src="img/browsers/firefox.png" alt="">
                        </a>

                        <a href="http://www.opera.com">
                            <img src="img/browsers/opera.png" alt="">
                        </a>

                        <a href="https://support.apple.com/downloads/safari">
                            <img src="img/browsers/safari.png" alt="">
                        </a>

                        <a href="https://www.microsoft.com/en-us/windows/microsoft-edge">
                            <img src="img/browsers/edge.png" alt="">
                        </a>

                        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                            <img src="img/browsers/ie.png" alt="">
                        </a>
                    </div>
                    <p>Sorry for the inconvenience!</p>
                </div>
            <![endif]-->

        <!-- Javascript -->
        <!-- Vendors -->
        
        <script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="vendors/bower_components/popper.js/dist/umd/popper.min.js"></script>
        <script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- App functions and actions -->
        <script src="js/app.min.js"></script>
        <script src="js/ValidarInput.js"></script>
    </body>
</html>