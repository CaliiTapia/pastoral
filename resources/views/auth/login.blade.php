@extends('layouts.login')

@section('content')

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Login -->
<div class="loginColumns animated fadeInDown">
        <div class="row">
            
            <div class="col-md-6">

            <img alt="image"  width="310px" height="auto" src="{{asset('img/logohnegro.png')}}"/>
                <h2 class="font-bold">Bienvenido al Sistema de Gestión Parroquial</h2>

                <ul class="lista_login">
                    <li type="square">
                        Registre la contabilidad de su parroquia fácilmente.
                    </li>
                    <li type="square">
                        Gestione sus donativos y contribuyentes.
                    </li>
                    <li type="square">
                        Registre y supervise a sus agentes pastorales.
                    </li>
                    <li type="square">
                        Ingrese y emita certificados de sus fieles.
                    </li>
                </ul>

                <!-- <p>
                    <small> <b> Realice un donativo al equipo de informatica, sus aportes son nuestro sueldo, somos casi indigentes. </b> </small>
                </p> -->

            </div>
            <div class="col-md-6">
                <div class="ibox-content box_login">
                    <form class="m-t" role="form" method="POST" action="{{ route('login') }}">
                    @csrf()
                        <div class="form-group imput_login">
                            <label>Nombre de Usuario o Correo Electrónico</label>
                            <input name="email" type="text" class="form-control" required="">
                        </div>
                        <div class="form-group imput_login">
                            <label>Contraseña</label>
                            <input type="password" name="password" class="form-control" required="">
                        </div>
                        <button type="submit" class="btn btn-warning block full-width m-b">Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div>
            <small>© Sistema Desarrollado por la Dirección de Tecnologías de la Información<strong>- Arzobispado de Santiago - Todos los Derechos reservados</strong></small>
            </div>
            <div class="col-md-2 text-right">
               <small>© 1840-{{date('Y')}}</small>
            </div>
        </div>
    </div>


<!-- End Login -->
@endsection


@section('javascript')

@endsection