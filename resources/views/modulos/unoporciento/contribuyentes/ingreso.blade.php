@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')
<header class="content__title">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <div>
                <div class="col-lg-10">
                    <h2> INGRESO DE PAGOS</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">1% Parroquial</a>
                        </li>
                        <li class="breadcrumb-item">
                            <strong>Ingreso de Pagos</strong>
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
                <h5><strong>INGRESO DE PAGOS</strong></h5>
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

                            <h3>
                                Detalle de Comprobante
                            </h3>

                            <div style="padding:20px;">
                                <div class="row form-group" style="border-bottom:1px solid #EEE; padding-bottom:10px;">
                                    <div class="col-md-3">
                                        <label for="rut">Nº Comprobante</label>                                                
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control rounded">
                                    </div>
                                </div>

                                <div class="row form-group" style="border-bottom:1px solid #EEE; padding-bottom:10px;">
                                    <div class="col-md-3">
                                        <label for="rut">Fecha de Pago</label>                                                
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control rounded">
                                    </div>
                                </div>

                                <div class="row form-group" style="border-bottom:1px solid #EEE; padding-bottom:10px;">
                                    <div class="col-md-3">
                                        <label for="rut">Forma de Pago</label>                                                
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control rounded">
                                            <option>EFECTIVO</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row form-group" style="border-bottom:1px solid #EEE; padding-bottom:10px;">
                                    <div class="col-md-3">
                                        <label for="rut">Nº de Cheque/Tarjeta</label>                                                
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" class="form-control rounded">
                                    </div>
                                </div>

                                <div class="row form-group" style="border-bottom:1px solid #EEE; padding-bottom:10px;">
                                    <div class="col-md-3">
                                        <label for="rut">Banco</label>                                                
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control rounded">
                                            <option></option>
                                        </select>
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