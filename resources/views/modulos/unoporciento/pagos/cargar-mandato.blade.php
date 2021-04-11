@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')
<header class="content__title">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <div>
                <div class="col-lg-10">
                    <h2> PAGOS</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">1% Parroquial</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Mandatos</a>
                        </li>
                        <li class="breadcrumb-item">
                            <strong>Cargar Mandato</strong>
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
                <h5><strong>CARGAR MANDATO</strong></h5>
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

                            <div class="row m-t-xs">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="rut">Folio</label>
                                        <input type="number" class="form-control rounded">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rut">Tipo Recaudación</label>
                                        <select class="form-control">
                                            <option>Seleccione</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rut">Capilla</label>
                                        <select class="form-control">
                                            <option>Seleccione</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Monto</label>
                                        <input type="number" class="form-control rounded">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rut">Periodicidad Pago</label>
                                        <select class="form-control">
                                            <option>MENSUAL</option>
                                            <option>ANUAL</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rut">Banco</label>
                                        <select class="form-control">
                                            <option>Seleccione</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rut">Medio de Pago</label>
                                        <select class="form-control">
                                            <option>Seleccione</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Nro. Cuenta / Tarjeta</label>
                                        <input type="text" class="form-control rounded">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rut">Vencimiento Tarjeta</label>
                                        <input type="text" class="form-control rounded" placeholder="MM/YY">
                                    </div>
                                </div>
                            </div>

                            <div class="row m-b-lg">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rut">Día Descuento</label>
                                        <input type="number" class="form-control rounded">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rut">Fecha Inicio Aporte</label>
                                        <input type="date" class="form-control rounded">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rut">Fecha Firma</label>
                                        <input type="date" class="form-control rounded">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <legend>Reajuste IPC</legend>
                                        <div class="form-check abc-radio abc-radio-info form-check-inline">
                                            <input class="form-check-input valid" type="radio" name="genero" id="femenino" checked aria-required="true">
                                            <label class="form-check-label" for="femenino"> Si </label>
                                        </div>
                                        <div class="form-check abc-radio abc-radio-info form-check-inline">
                                            <input class="form-check-input valid" type="radio" name="genero" id="masculino">
                                            <label class="form-check-label" for="masculino"> No </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <h3 class="m-t-lg">Adjuntar Mandato</h3>

                            <div class="row m-t-lg m-b-lg">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <legend>Tipo de Archivo</legend>
                                        <div class="form-check abc-radio abc-radio-info form-check-inline">
                                            <input class="form-check-input valid" type="radio" name="subir" id="femenino" checked aria-required="true">
                                            <label class="form-check-label" for="femenino"> Cargar PDF </label>
                                        </div>
                                        <div class="form-check abc-radio abc-radio-info form-check-inline">
                                            <input class="form-check-input valid" type="radio" name="subir" id="masculino">
                                            <label class="form-check-label" for="masculino"> Subir Fotografía </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Archivo</label><br>
                                        <input type="file" class="rounded">
                                    </div>
                                </div>
                            </div>

                            <h3 class="m-t-lg">Registro de Estado Mandato</h3>

                            <div class="row m-t-lg">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rut">Estado Mandato</label>
                                        <select class="form-control">
                                            <option>Ingresado</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Motivo</label>
                                        <select class="form-control">
                                            <option>Seleccione</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Fecha Envío Banco</label>
                                        <input type="date" class="form-control rounded">
                                    </div>
                                </div>
                            </div>

                            <div class="row m-t-md">
                                <div class="col-md-12">
                                    <a href="#" class="btn btn-primary pull-left">
                                        <i class="fa fa-plus"></i> <span class="bold">Cargar Mandato</span>
                                    </a>
                                    <a href="{{ asset('/unoporciento/pagos/mandatos') }}" class="btn btn-default pull-left m-l-xs">
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