@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')
@include('ValidaNotificacion')
<div class="content__inner">
    <header class="content__title">
    <h1><a  style="color: #424242"> MANTENEDOR / PARROQUIA / ACTUALIZAR DATOS / CONTACTO</a></h1>
        <div class="actions">
                <a class="btn boton" href="{{asset('mantenedores/contacto')}}" role="button"> Listado de Contactos</a> 
                <div class="dropdown actions__item">
                    <i data-toggle="dropdown" class="zmdi zmdi-more-vert"></i>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="" class="dropdown-item btn-warning">Refrescar</a>
                    </div>
                </div>
        </div>
    </header>
    <div class="card">
        <div class="card-body">
        <h3 class="card-body__title">REGISTRAR DATOS </h3>
            {!! Form::open(['url' => route('contacto.update',[ 'id' => $ficha->IdFichas]), 'method' => 'PUT'])  !!}
                @csrf
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Nombres </label>
                            {{ Form::text('nombre_contacto',$ficha->Nombres,['tabindex'=>'1','class'=>'form-control solo-letras','placeholder'=>'Nombres','required']) }}
                            @if($errors->has('nombre_contacto'))
                                <p class="text-danger">{{ $errors->first('nombre_contacto') }}</p>
                            @endif
                            <i class="form-group__bar"></i>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Apellido Paterno </label>
                            {{ Form::text('paterno_contacto',$ficha->ApellidoPaterno,['tabindex'=>'2','class'=>'form-control solo-letras','placeholder'=>'direccion']) }}
                            @if($errors->has('paterno_contacto'))
                                <p class="text-danger">{{ $errors->first('paterno_contacto') }}</p>
                            @endif
                            <i class="form-group__bar"></i>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Apellido Materno</label>
                            {{ Form::text('materno_contacto',$ficha->ApellidoMaterno,['tabindex'=>'3','class'=>'form-control solo-letras','placeholder'=>'direccion','required']) }}
                            @if($errors->has('materno_contacto'))
                                <p class="text-danger">{{ $errors->first('materno_contacto') }}</p>
                            @endif
                            <i class="form-group__bar"></i>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Direccion </label>
                            {{ Form::text('direccion_contacto',$ficha->Direccion,['tabindex'=>'4','class'=>'form-control','placeholder'=>'direccion']) }}
                            @if($errors->has('direccion_contacto'))
                                <p class="text-danger">{{ $errors->first('direccion_contacto') }}</p>
                            @endif
                            <i class="form-group__bar"></i>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Telefono Celular</label>
                            {{ Form::text('celular_contacto',$ficha->Celular ,['tabindex'=>'5','class'=>'form-control solo-numero','placeholder'=>'ej: 987654321','name'=> 'celular_contacto','required']) }}
                            <i class="form-group__bar"></i>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Telefono Fijo</label>
                            {{ Form::text('fijo_contacto',$ficha->Fijo,['tabindex'=>'6','class'=>'form-control solo-numero','placeholder'=>'ej: 987654321','name'=> 'fijo_contacto']) }}
                            <i class="form-group__bar"></i>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Email </label>
                            {{ Form::email('email_contacto',$ficha->Email ,['tabindex'=>'5','class'=>'form-control','placeholder'=>'usuario@iglesiadesantiago.cl','name'=>'email_contacto','required']) }}
                            @if($errors->has('email_contacto'))
                                <p class="text-danger">{{ $errors->first('email_contacto') }}</p>
                            @endif
                            <i class="form-group__bar"></i>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cargo (*)</label>
                            {{ Form::select('cargo_contacto',$Cargos,$ficha->C_IdCargo,['tabindex'=>'11','class'=>'form-control select2','placeholder'=>'--Seleccione Cargo--','name'=>'cargo_contacto','id'=>'cargo_contacto','required']) }}
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
                        <div class="form-group">
                            <span class="input-group-btn">
                                {{ form::submit('Enviar',['class'=>'btn btn-light']) }}
                            </span>
                        </div>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@section('javascriptSection')
    <script src="{{ asset('vendors/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('/js/ValidarInput.js')}}"></script>  
@endsection