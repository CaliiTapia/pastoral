<!--Formulario de Comuna  -->
@extends('layouts.admin');
@section('title', 'Usuario')
@section('content')
@include('ValidaNotificacion')
 <div class="content__inner">
<header class="content__title">
<h1><a href="{{asset('mantenedor/user')}}" style="color: #424242"> MANTENEDOR / USUARIO / CREAR USUARIO</a></h1>
    <div class="actions">
     @can('gestionar_usuarios')
        <a class="btn boton" href="{{asset('mantenedor/usuario')}}" role="button">Listado</a> 
        @endcan
        <div class="dropdown actions__item">
            <i data-toggle="dropdown" class="zmdi zmdi-more-vert"></i>
            <div class="dropdown-menu dropdown-menu-right">
                <a href="" class="dropdown-item btn-warning">Refrescar</a>
            </div>
        </div>
    </div>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</header>
<div class="card">
    <div class="card-body">
         <h3 class="card-body__title">REGISTRAR DATOS</h3>
 {!! Form::open(['action' => 'UsuarioController@cambio_pass', 'method' => 'POST']) !!}  
    <div class="row">
        <div class="col-sm-4">
            <div class="input-group">
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" id="password" name="password" class="form-control" required tabindex="7" autocomplete="off">
                    <i class="form-group__bar"></i>
                </div>
                <span id="ver_clave" action="hide" class="input-group-addon zmdi zmdi-eye"></span>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="input-group">
                <div class="form-group" >
                    <label >Confirmar contraseña</label>
                    <input type="password" id="password2" name="password2" class="form-control coincide" required tabindex="7" autocomplete="off">
                    <i class="form-group__bar"></i>
                </div>
            </div>
        </div>
        
        <div class="col-sm-12">
        <div class="form-group">  
            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </button>               
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div> 
 <div class="form-group">
     <span class="input-group-btn">
        {!! form::submit('Enviar',['class'=>'btn btn-light']) !!}
    </span>
 </div>   
</div>
{!! Form::close() !!}
</div>
</div>
@endsection
@section('javascriptSection')       
<script src="{{ asset('vendors/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('/js/ValidarInput.js')}}"></script>    
@endsection

 
