@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')
@include('ValidaNotificacion')
<header class="content__title">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <div>
                <div class="col-lg-12">
                    <h2> FORMACIÓN DE AGENTES PASTORALES</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a>Formación</a>
                        </li>
                        <li class="breadcrumb-item">
                            <strong>Ingresar Formación</strong>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="wrapper wrapper-content animated fadeInRight espacio">
    <div class="ibox-content ">
        <div class="row">
            <div class="col-lg-12">
            {{ Form::open([]) }}
                <div class="ibox-title">
                    <h5><strong>INGERSO FORMACIÓN</strong></h5>
                </div>
                
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Rut/Pasaporte</label>
                               <input type="text" name="rut" id="rut" class="form-control rounded">
                            </div> 
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" name="nombre" id="nombre" class="form-control rounded" >
                            </div>  
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Apellido Paterno</label>
                                <input type="text" name="apellidoPaterno" id="apellidoPaterno" class="form-control rounded" >
                            </div>  
                        </div> 
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Apellido Materno</label>
                                <input type="text" name="apellidoMaterno" id="apellidoMaterno" class="form-control rounded" >
                            </div>  
                        </div> 
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Servicio Pastoral</label>
                                <input type="text"  name="servicio" id="servicio" class="form-control rounded" >
                            </div> 
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Diócesis </label>
                                <input type="text"  name="diocesis" id="diocesis" class="form-control rounded" >
                            </div>  
                        </div> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Institucion(es) </label>
                               <textarea type="text"  name="instituciones" id="instituciones" class="form-control rounded" ></textarea>
                            </div>  
                        </div> 
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha de Participacion en Formación</label>
                                <input type="date"  name="fecha" id="fecha" class="form-control rounded">
                            </div> 
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Tipo Capacitación</label>
                                <select class="form-control select2-steps rounded" name="tipoP" id="tipoP">
                                    <option value="{{ null }}">--Seleccione-- </option>
                                </select>
                            </div>  
                        </div> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Nombre Formador</label>
                                <input type="text"  name="formador" id="formador" class="form-control rounded">
                            </div>  
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button class="btn btn-primary float-right" type="submit" href="#">Guardar</button>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
</div>
@endsection