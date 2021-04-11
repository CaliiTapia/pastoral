@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')
<header class="content__title">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <div>
                <div class="col-lg-10">
                    <h2> CONTRIBUYENTES</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">1% Parroquial</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Contribuyentes</a>
                        </li>
                        <li class="breadcrumb-item">
                            <strong>Crear Contribuyente</strong>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="wrapper wrapper-content espacio">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-title">
                <h5><strong>CREAR CONTRIBUYENTE</strong></h5>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Inicio data table -->
            <div class="ibox-content">

                <div class="wizard-big">                    
                    <div class="step-content">

                        <div class="content clearfix">

                            <h3>Datos Personales del Contribuyente</h3>

                            <div class="row m-t-lg">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rut">RUT (*)</label>
                                        <input type="text" placeholder="11.111.111-1" class="form-control rounded">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Nombre (*)</label>
                                        <input type="text" class="form-control rounded">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Apellido Paterno (*)</label>
                                        <input type="text" class="form-control rounded">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Apellido Materno (*)</label>
                                        <input type="text" class="form-control rounded">
                                    </div>
                                </div>
                            </div>

                            <div class="row m-b-lg">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rut">Fecha de Nacimiento (*)</label>
                                        <input type="date" class="form-control rounded">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <legend>Género (*)</legend>
                                        <div class="form-check abc-radio abc-radio-info form-check-inline">
                                            <input class="form-check-input valid" type="radio" name="genero" id="femenino" checked aria-required="true">
                                            <label class="form-check-label" for="femenino"> Femenino </label>
                                        </div>
                                        <div class="form-check abc-radio abc-radio-info form-check-inline">
                                            <input class="form-check-input valid" type="radio" name="genero" id="masculino">
                                            <label class="form-check-label" for="masculino"> Masculino </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Estado Civil</label>
                                        <select class="form-control">
                                            <option>Soltero(a)</option>
                                            <option>Casado(a)</option>
                                            <option>Viudo(a)</option>
                                            <option>Separado(a)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Profesión</label>
                                        <input type="text" class="form-control rounded">
                                    </div>
                                </div>
                            </div>

                            <h3 class="m-t-lg">Dirección y Contacto</h3>

                            <div class="row m-t-lg">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Dirección</label>
                                        <input type="text" class="form-control rounded">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Número</label>
                                        <input type="text" class="form-control rounded">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Departamento</label>
                                        <input type="text" class="form-control rounded">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Sector</label>
                                        <input type="text" class="form-control rounded">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Comuna</label>
                                        <select class="form-control">
                                            <option>Seleccione</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input type="email" class="form-control rounded">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Teléfono 01</label>
                                        <input type="number" class="form-control rounded">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Teléfono 02</label>
                                        <input type="number" class="form-control rounded">
                                    </div>
                                </div>
                            </div>

                            <div class="row m-t-md">
                                <div class="col-md-12">
                                    <a href="#" class="btn btn-primary pull-left">
                                        <i class="fa fa-plus"></i> <span class="bold">Crear Contribuyente</span>
                                    </a>
                                    <a href="{{ asset('/unoporciento/contribuyentes') }}" class="btn btn-default pull-left m-l-xs">
                                        <span class="bold">Volver</span>
                                    </a>
                                </div>
                            </div>
                            
                        </div>

                    </div>
                </div>

                
            </div>
        </div>
        <!-- Fin data table -->
    </div>
</div>  


@endsection