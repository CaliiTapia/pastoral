<!--Formulario de Comuna  -->
@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')
@include('ValidaNotificacion')
 <div class="content__inner">
<header class="content__title">
<h1><a href="{{asset('mantenedores/user')}}" style="color: #424242"> MANTENEDOR / USUARIO / CREAR CONTACTO</a></h1>
    <div class="actions">
            <a class="btn boton" href="{{ asset('mantenedores/contacto') }}" role="button"> Listado de Contacto</a> 
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
        <h3 class="card-body__title">REGISTRAR DATOS</h3>
        {!! Form::open(['action' => 'ContactoController@store', 'method' => 'POST']) !!}  
        @csrf
        <div class="row">
                <div class="col-md-4">
                    <label>Rut </label>
                    <div class="input-group">
                        <div class="form-group">
                            {{ Form::text('rut_contacto', null ,['tabindex'=>'1','class'=>'form-control rut','placeholder'=>'12123555','style'=>'width:230px;','id'=>'rut','required']) }}
                        </div>
                        <span class="input-group-addon">-</span>
                        <div class="form-group">
                            {{ Form::text('dv_contacto', null ,['tabindex'=>'2','class'=>'form-control rut-dv','placeholder'=>'K','style'=>'width:40px;','id'=>'dv','required']) }}
                        </div>
                    </div>
                    @if($errors->has('rut_contacto'))
                        <p class="text-danger">{{ $errors->first('rut_contacto') }}</p>
                    @elseif($errors->has('dv_contacto'))
                        <p class="text-danger">{{ $errors->first('dv_contacto') }}</p>
                    @endif
                    <i class="form-group__bar"></i>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Nombres (*)</label>
                        {{ Form::text('nombre_contacto', null ,['tabindex'=>'3','class'=>'form-control solo-letras','placeholder'=>'Nombres','id'=>'nombre','required']) }}
                        
                        @if($errors->has('nombre_contacto'))
                            <p class="text-danger">{{ $errors->first('nombre_contacto') }}</p>
                        @endif
                        <i class="form-group__bar"></i>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Apellido Paterno (*)</label>
                        {{ Form::text('paterno_contacto', null,['tabindex'=>'4','class'=>'form-control solo-letras','id'=> 'paterno','required']) }}
                        @if($errors->has('paterno_contacto'))
                            <p class="text-danger">{{$errors-first('paterno_contacto')}}
                        @endif
                        <i class="form-group__bar"></i>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label>Apellido Materno (*)</label>
                        {{ Form::text('materno_contacto', null,['tabindex'=>'5','class'=>'form-control solo-letras','id'=>'materno','required']) }}
                        @if($errors->has('materno_contacto'))
                            <p class="text-danger">{{$errors-first('materno_contacto')}}
                        @endif
                        <i class="form-group__bar"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Dirección </label>
                        {{ Form::text('direccion_contacto',null,['tabindex'=>'6','class'=>'form-control ','placeholder'=>'ej: Av. Roma #1466,Santiago centro,Santiago','id'=>'direccion']) }}
                        @if($errors->has('direccion_contacto'))
                        <p class="text-danger">{{$errors-first('direccion_contacto')}}
                        @endif
                        
                        <i class="form-group__bar"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Telefono Fijo</label>
                        {{ Form::tel('fijo_contacto', null,['tabindex'=>'7','class'=>'form-control solo-numero','placeholder'=>'ej: 227654321','id'=>'fijo']) }}
                        @if($errors->has('fijo_contacto'))
                        <p class="text-danger">{{$errors-first('fijo_contacto')}}
                        @endif
                        <i class="form-group__bar"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Telefono Celular</label>
                        {{ Form::tel('celular_contacto', null,['tabindex'=>'8','class'=>'form-control solo-numero','placeholder'=>'ej: 987654321','id'=>'celular','required']) }}
                        @if($errors->has('celular_contacto'))
                            <p class="text-danger">{{$errors-first('celular_contacto')}}
                        @endif
                        <i class="form-group__bar"></i>
                    </div>
                    </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Email</label>
                        {{ Form::email('email_contacto', null,['tabindex'=>'9','class'=>'form-control','placeholder'=>'usuario@iglesiadesantiago.cl','id'=>'email','required']) }}
                        @if($errors->has('email_contacto'))
                            <p class="text-danger">{{ $errors->first('email_contacto') }}</p>
                        @endif
                        <i class="form-group__bar"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Fecha de Nacimiento (*)</label>
                        {{ Form::date('nacimiento_contacto', null,['tabindex'=>'10','class'=>'form-control mayor-edad','placeholder'=>'usuario@iglesiadesantiago.cl','name'=>'nacimiento_contacto','required','id'=>'nacimiento']) }}
                        @if($errors->has('nacimiento_contacto'))
                            <p class="text-danger">{{ $errors->first('nacimiento_contacto') }}</p>
                        @endif
                        <i class="form-group__bar"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Cargo (*)</label>
                        {{ Form::select('cargo_contacto',$Cargos,'',['tabindex'=>'11','class'=>'form-control select2','placeholder'=>'--Seleccione Cargo--','name'=>'cargo_contacto','id'=>'cargo_contacto','required']) }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label style="margin-bottom: 5px;">Genero (*)</label>
                        <br>
                        <div class="btn-group" data-toggle="buttons" style="display: inherit;text-align: center;">
                            <label class="btn btn-light" id="femenino_lb">
                                <input type="radio" name="sexo" value="F" tabindex="12" id="femenino" autocomplete="off" required> Femenino
                            </label>
                            <label class="btn btn-light" id="masculino_lb">
                                <input type="radio" name="sexo" value="M" tabindex="13" id="masculino" autocomplete="off" required> Masculino
                            </label>
                        </div>
                        <i class="form-group__bar"></i>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <span class="input-group-btn">
                            {{ form::submit('Agregar contacto',['id'=>'btn_contacto','class'=>'btn btn-light','style'=>'margin-top:10px;']) }}
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
    <script src="{{ asset('/js/contactos.js')}}"></script>
@endsection

 
