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
                            <a href="#">Cartas y Etiquetas</a>
                        </li>
                        <li class="breadcrumb-item">
                            <strong>Carta Resumen</strong>
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
                <h5><strong>CARTAS RESUMEN</strong></h5>
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

                            <h3 class="m-t-lg">Contribuyentes y Período</h3>

                            <div class="row m-t-lg">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <legend>Contribuyentes</legend>
                                        <div class="form-check abc-radio abc-radio-info form-check-inline">
                                            <input class="form-check-input valid" type="radio" name="genero" id="femenino" checked aria-required="true">
                                            <label class="form-check-label" for="femenino"> Todos </label>
                                        </div>
                                        <div class="form-check abc-radio abc-radio-info form-check-inline">
                                            <input class="form-check-input valid" type="radio" name="genero" id="masculino">
                                            <label class="form-check-label" for="masculino"> Rango </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rut">Inicio</label>
                                        <input type="text" class="form-control rounded" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rut">Término</label>
                                        <input type="text" class="form-control rounded" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row m-b-lg">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Período</label>
                                        <select class="form-control">
                                            <option>2018</option>
                                            <option>2019</option>
                                            <option>2020</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Tipo Recaudación</label>
                                        <select class="form-control">
                                            <option>Todas</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <h3 class="m-t-lg">Remitente y Texto Carta</h3>

                            <div class="row m-t-lg">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Remite</label>
                                        <input type="text" class="form-control rounded" value="Fernando Vives F. SSCC">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>Cargo</label>
                                        <input type="text" class="form-control rounded" value="Párroco">
                                    </div>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Texto Carta Resumen</label>
                                        <textarea class="form-control rounded" rows="6">Por la presente remito el detalle de los aportes mensuales entregados por Ud. como contribución al 1% durante el año 2018. Cualquier duda o desacuerdo con el presente informe, le solicitamos hacerlo presente en la Secretaría Parroquial.</textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Firma Carta Resumen</label>
                                        <textarea class="form-control rounded">Reciban un saludo cariñoso y la bendición para Ud. y su familia.</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row m-t-md">
                                <div class="col-md-12">
                                    <a href="#" class="btn btn-primary pull-left">
                                        <i class="fa fa-list"></i> <span class="bold">Vista Previa</span>
                                    </a>
                                    <a href="#" class="btn btn-primary pull-left m-l-xs">
                                        <i class="fa fa-print"></i> <span class="bold">Generar Cartas de Resumen</span>
                                    </a>
                                    <a href="#" class="btn btn-default pull-left m-l-xs">
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