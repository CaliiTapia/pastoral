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
                            <strong>Ver Contribuyente</strong>
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
                <h5><strong>VER CONTRIBUYENTE</strong></h5>
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

                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#informacion">Información del Contribuyente</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="tab" href="#compromisos">Compromisos de Pago</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content m-t-lg">
                                
                                <div class="tab-pane container active" id="informacion">
                                    
                                    <h3 class="m-t-lg">Datos Personales del Contribuyente</h3>

                                    <div class="row m-t-lg">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="rut">RUT (*)</label>
                                                <input type="text" value="12.345.678-9" class="form-control rounded" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Nombre (*)</label>
                                                <input type="text" class="form-control rounded" value="Juan">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Apellido Paterno (*)</label>
                                                <input type="text" class="form-control rounded" value="Pérez">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Apellido Materno (*)</label>
                                                <input type="text" class="form-control rounded" value="Gómez">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row m-b-lg">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="rut">Fecha de Nacimiento (*)</label>
                                                <input type="date" class="form-control rounded" value="1990-01-01">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <legend>Género (*)</legend>
                                                <div class="form-check abc-radio abc-radio-info form-check-inline">
                                                    <input class="form-check-input valid" type="radio" name="genero" id="femenino" aria-required="true">
                                                    <label class="form-check-label" for="femenino"> Femenino </label>
                                                </div>
                                                <div class="form-check abc-radio abc-radio-info form-check-inline">
                                                    <input class="form-check-input valid" type="radio" name="genero" id="masculino" checked>
                                                    <label class="form-check-label" for="masculino"> Masculino </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Estado Civil</label>
                                                <select class="form-control">
                                                    <option>Soltero(a)</option>
                                                    <option selected>Casado(a)</option>
                                                    <option>Viudo(a)</option>
                                                    <option>Separado(a)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Profesión</label>
                                                <input type="text" class="form-control rounded" value="Ingeniero Agrónomo">
                                            </div>
                                        </div>
                                    </div>

                                    <h3 class="m-t-lg">Dirección y Contacto</h3>

                                    <div class="row m-t-lg">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Dirección</label>
                                                <input type="text" class="form-control rounded" value="Av. Apoquindo">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label>Número</label>
                                                <input type="text" class="form-control rounded" value="1234">
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
                                                <input type="text" class="form-control rounded" value="El Golf">
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
                                                <input type="email" class="form-control rounded" value="jpg@contribuyente.cl">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Teléfono 01</label>
                                                <input type="number" class="form-control rounded" value="1234567890">
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
                                                <span class="bold">Modificar Contribuyente</span>
                                            </a>
                                            <a href="{{ asset('/unoporciento/contribuyentes') }}" class="btn btn-default pull-left m-l-xs">
                                                <span class="bold">Volver</span>
                                            </a>
                                        </div>
                                    </div>

                                </div>
                                
                                <div class="tab-pane container fade" id="compromisos">

                                    <h3 class="m-t-lg">Compromisos de Pago</h3>

                                    <div class="table-responsive m-t-lg">
                                        <table class="table table-bordered dataTables-Dev" id="listadodevelaciones">
                                            <thead>
                                                <tr>
                                                    <th>Tipo Recaudación</th>
                                                    <th>Periodicidad</th>
                                                    <th>Monto</th>
                                                    <th>Fecha Inicio Aporte</th>
                                                    <th>Estado</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <tr>
                                                    <td>MANDATO PAT</td>
                                                    <td>MENSUAL</td>
                                                    <td class="text-right">$15.000</td>
                                                    <td>01-01-2020</td>
                                                    <td class="text-center">Activo</td>
                                                </tr>
                                                <tr>
                                                    <td>RENDICIÓN PARROQUIA</td>
                                                    <td>MENSUAL</td>
                                                    <td class="text-right">$5.000</td>
                                                    <td>01-01-2020</td>
                                                    <td class="text-center">Inactivo</td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>

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