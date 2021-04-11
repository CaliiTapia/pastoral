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
                            <strong>Captura Mandatos</strong>
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
                <h5><strong>CAPTURA MANDATOS</strong></h5>
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

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rut">Tipo Mandato</label>
                                        <select class="form-control">
                                            <option>PAC Banco de Chile</option>
                                            <option>PAC Transbank</option>
                                            <option>PAC CMR</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rut">Fecha Contable</label>
                                        <input type="date" class="form-control rounded">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rut">Mes a capturar</label>
                                        <select class="form-control">
                                            <option>01</option>
                                            <option>02</option>
                                            <option>03</option>
                                            <option>04</option>
                                            <option>05</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rut">Año a capturar</label>
                                        <select class="form-control">
                                            <option>2021</option>
                                            <option>2020</option>
                                            <option>2019</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row m-b-lg">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Archivo</label><br>
                                        <input type="file" class="rounded">
                                    </div>
                                </div>
                            </div>

                            <div class="row m-t-md">
                                <div class="col-md-12">
                                    <a href="#" class="btn btn-primary pull-left">
                                        <i class="fa fa-upload"></i> <span class="bold">Subir archivo de Captura</span>
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

<div class="wrapper wrapper-content espacio">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-title">
                <h5>
                    <strong>PROCESAMIENTO DE ARCHIVO CAPTURADO</strong>
                    <div class="dropdown pull-right m-l-xs">
                        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown">
                            Exportar
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">CSV</a>
                            <a class="dropdown-item" href="#">Excel</a>
                            <a class="dropdown-item" href="#">Imprimir</a>
                        </div>
                    </div>
                </h5>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Inicio data table -->
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-bordered dataTables-Dev" id="listadodevelaciones">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>RUT</th>
                                <th>Contribuyente</th>
                                <th>Monto</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>1234</td>
                                <td>12.345.678-9</td>
                                <td>Juan Pérez Gómez</td>
                                <td class="text-right">$5.000</td>
                                <td class="text-center">Aprobado</td>
                            </tr>

                            <tr>
                                <td>1234</td>
                                <td>12.345.678-9</td>
                                <td>Juan Pérez Gómez</td>
                                <td class="text-right">$5.000</td>
                                <td class="text-center">Rechazado</td>
                            </tr>

                            <tr>
                                <td>1234</td>
                                <td>12.345.678-9</td>
                                <td>Juan Pérez Gómez</td>
                                <td class="text-right">$5.000</td>
                                <td class="text-center">Aprobado</td>
                            </tr>

                            <tr>
                                <td>1234</td>
                                <td>12.345.678-9</td>
                                <td>Juan Pérez Gómez</td>
                                <td class="text-right">$5.000</td>
                                <td class="text-center">Rechazado</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Fin data table -->
    </div>
</div>  


@endsection