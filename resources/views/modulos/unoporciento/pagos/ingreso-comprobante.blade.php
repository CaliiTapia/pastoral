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
                            <a href="#">Comprobantes</a>
                        </li>
                        <li class="breadcrumb-item">
                            <strong>Crear Comprobante</strong>
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
                <h5><strong>CREAR COMPROBANTE</strong></h5>
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
                                        <label for="rut">Contribuyente</label>
                                        <select class="form-control">
                                            <option>Seleccione</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rut">Nº Comprobante</label>
                                        <input type="number" class="form-control rounded">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rut">Fecha Pago</label>
                                        <input type="date" class="form-control rounded">
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
                                        <label for="rut">Forma de Pago</label>
                                        <select class="form-control">
                                            <option>EFECTIVO</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                            <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Nro. Cheque / Tarjeta</label>
                                        <input type="text" class="form-control rounded">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rut">Banco</label>
                                        <select class="form-control">
                                            <option>Seleccione</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <h3 class="m-t-lg">Período a Cancelar</h3>

                            <div class="row m-t-lg">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rut">Desde</label>
                                        <select class="form-control">
                                            <option>Enero</option>
                                            <option>Febrero</option>
                                            <option>Marzo</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label><br>
                                        <select class="form-control">
                                            <option>2020</option>
                                            <option>2021</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rut">Hasta</label>
                                        <select class="form-control">
                                            <option>Enero</option>
                                            <option>Febrero</option>
                                            <option>Marzo</option>
                                            <option>...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>&nbsp;</label><br>
                                        <select class="form-control">
                                            <option>2020</option>
                                            <option>2021</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row m-t-md">
                                <div class="col-md-12">
                                    <a href="#" class="btn btn-primary pull-left">
                                        <i class="fa fa-plus"></i> <span class="bold">Ingresar Comprobante</span>
                                    </a>
                                    <a href="{{ asset('/unoporciento/pagos/comprobantes') }}" class="btn btn-default pull-left m-l-xs">
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