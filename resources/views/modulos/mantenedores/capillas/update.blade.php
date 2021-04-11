<!--Formulario de Región  -->
@extends('layouts.admin')
@section('title', 'Capilla')
@section('content')
 <div class="content__inner">
<header class="content__title">
    <h1><a href="{{asset('mantenedor/general')}}" style="color: #424242">MANTENEDORES / CAPILLAS</a></h1>
            <div class="actions">
                    <a class="btn btn-light" href="{{asset('mantenedor/capilla')}}" role="button">Listado</a>
                    <div class="dropdown actions__item">
                        <i data-toggle="dropdown" class="zmdi zmdi-more-vert"></i>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="" class="dropdown-item">Refrescar</a>
                        </div>
                    </div>
            </div>
</header>
<div class="card">
    <div class="card-body">
         <h3 class="card-body__title">MODIFICAR DATOS</h3>
{!! Form::open(['route' => ['updateCapilla' , $capilla->IdCapilla]])  !!}     
        <div class="row">
            <div class="col-sm-4">
                <div class="form-group">
                    <label>Nombre de la Capilla</label>
                    {!! Form::text('capilla',$capilla->Nombre,['class'=>'form-control','placeholder'=>'Nombre de la Capilla','required','name'=>'capilla','id'=>'capilla']) !!}
                    <i class="form-group__bar"></i>
                    @if ($errors->has('capilla'))
                    <p class="text-warning">{{ $errors->first('capilla')}}</p>
                    @endif
                </div>
            </div>
            <div class="col-sm-4">
               <label>Parroquia</label>
               <?php
                  $parroquia=\App\Parroquia::where('Estatus',1)->pluck('Nombre','IdParroquia');
               ?>
                  <div class="form-group">
                   {{ Form::select('parroquia',$parroquia,$capilla->P_IdParroquia,['class'=>'form-control select2','required','id'=>'parroquia','name'=>'parroquia','placeholder'=>'--Parroquia--']) }}
                   </div>
              </div>
            <div class="col-sm-4">
                <div class="form-group">
                     <label>Estatus</label>
                        <div class="select">
                            {!! Form::select('estatus', ['' => '--Estatus--', '1' => 'ACTIVO','0' => 'INACTIVO'],$capilla->Estatus, ['class'=>'form-control select2','name'=>'estatus','required']) !!}
                        </div>
                    </div>
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
      <!-- App functions and actions -->
        <script src="{{ asset('js/app.min.js')}}"></script>
        <script src="{{ asset('vendors/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
        <script src="{{ asset('vendors/bower_components/flatpickr/dist/flatpickr.min.js')}}"></script>
@endsection

 
