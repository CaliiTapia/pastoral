@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')
<header class="content__title">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <div>
                <div class="col-lg-10">
                    <h2> RENDICIÓN</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">1% Parroquial</a>
                        </li>
                        <li class="breadcrumb-item">
                            <strong>Rendición de Cuentas</strong>
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
                <h5><strong>RENDICIÓN DE CUENTAS</strong></h5>
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
                                Datos de la Parroquia
                                <a href="#" class="btn btn-info pull-right btn-xs"><i class="fa fa-print"></i> Imprimir</a>  
                                <a href="#" class="btn btn-success pull-right btn-xs" style="margin-right:5px;"><i class="fa fa-download"></i> Descargar</a>
                            </h3>

                            <div class="row " style="margin-top: 25px;">
                            
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rut">Parroquia</label>
                                        <input type="text" value="Total Parroquia" class="form-control rounded">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="rut">Mes</label>
                                        <input type="text" value="Marzo" class="form-control rounded">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rut">Año</label>
                                        <input type="text" value="2020" class="form-control rounded">
                                    </div>
                                </div>
                            </div>

                            <h3>Detalle Rendición</h3>

                            <div style="padding:20px;">
                                <div class="row form-group" style="border-bottom:1px solid #EEE; padding-bottom:10px;">
                                    <div class="col-md-3">
                                        <label for="rut">Porcentaje Parroquial</label>                                                
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" value="70,00" class="form-control rounded" readonly>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="rut">Nro Visitadores</label>                                                
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" value="70,00" class="form-control rounded" readonly>
                                    </div>
                                </div>

                                <div class="row form-group" style="border-bottom:1px solid #EEE; padding-bottom:10px;">
                                    <div class="col-md-3">
                                        <label for="rut">Contribuyentes</label>                                                
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" value="5" class="form-control rounded" readonly>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="rut">Nro Cuotas</label>                                                
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" value="5" class="form-control rounded" readonly>
                                    </div>
                                </div>

                                <div class="row form-group" style="border-bottom:1px solid #EEE; padding-bottom:10px;">
                                    <div class="col-md-7">
                                        <label for="rut">Contribución Total</label>                                                
                                    </div>
                                    <div class="col-md-1" style="text-align:right; padding-top:5px;">
                                        <label for="rut">$</label>                                                
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" value="30.000" class="form-control rounded" readonly style="text-align:right;">
                                    </div>
                                </div>

                                <div class="row form-group" style="border-bottom:1px solid #EEE; padding-bottom:10px;">
                                    <div class="col-md-7">
                                        <label for="rut">1% Aporte Papal</label>                                                
                                    </div>
                                    <div class="col-md-1" style="text-align:right; padding-top:5px;">
                                        <label for="rut">$</label>                                                
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" value="300" class="form-control rounded" readonly style="text-align:right;">
                                    </div>
                                </div>

                                <div class="row form-group" style="border-bottom:1px solid #EEE; padding-bottom:10px;">
                                    <div class="col-md-7">
                                        <label for="rut">Subtotal</label>                                                
                                    </div>
                                    <div class="col-md-1" style="text-align:right; padding-top:5px;">
                                        <label for="rut">$</label>                                                
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" value="29.700" class="form-control rounded" readonly style="text-align:right;">
                                    </div>
                                </div>

                                <div class="row form-group" style="border-bottom:1px solid #EEE; padding-bottom:10px;">
                                    <div class="col-md-7">
                                        <label for="rut">Recaudación</label>                                                
                                    </div>
                                    <div class="col-md-1" style="text-align:right; padding-top:5px;">
                                        <label for="rut">$</label>                                                
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" value="2.970" class="form-control rounded" readonly style="text-align:right;">
                                    </div>
                                </div>

                                <div class="row form-group" style="border-bottom:1px solid #EEE; padding-bottom:10px;">
                                    <div class="col-md-7">
                                        <label for="rut">Total a Deducir</label>                                                
                                    </div>
                                    <div class="col-md-1" style="text-align:right; padding-top:5px;">
                                        <label for="rut">$</label>                                                
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" value="2.970" class="form-control rounded" readonly style="text-align:right;">
                                    </div>
                                </div>

                                <div class="row form-group" style="border-bottom:1px solid #EEE; padding-bottom:10px;">
                                    <div class="col-md-7">
                                        <label for="rut">Monto Líquido a Repartir</label>                                                
                                    </div>
                                    <div class="col-md-1" style="text-align:right; padding-top:5px;">
                                        <label for="rut">$</label>                                                
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" value="26.730" class="form-control rounded" readonly style="text-align:right;">
                                    </div>
                                </div>

                                <div class="row form-group" style="border-bottom:1px solid #EEE; padding-bottom:10px;">
                                    <div class="col-md-7">
                                        <label for="rut">Participación Parroquial</label>                                                
                                    </div>
                                    <div class="col-md-1" style="text-align:right; padding-top:5px;">
                                        <label for="rut">$</label>                                                
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" value="18.711" class="form-control rounded" readonly style="text-align:right;">
                                    </div>
                                </div>

                                <div class="row form-group" style="border-bottom:1px solid #EEE; padding-bottom:10px;">
                                    <div class="col-md-7">
                                        <label for="rut">Participación Diocesana</label>                                                
                                    </div>
                                    <div class="col-md-1" style="text-align:right; padding-top:5px;">
                                        <label for="rut">$</label>                                                
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" value="8.019" class="form-control rounded" readonly style="text-align:right;">
                                    </div>
                                </div>

                                <div class="row form-group" style="border-bottom:1px solid #EEE; padding-bottom:10px;">
                                    <div class="col-md-7">
                                        <label for="rut">Aporte Papal</label>                                                
                                    </div>
                                    <div class="col-md-1" style="text-align:right; padding-top:5px;">
                                        <label for="rut">$</label>                                                
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" value="300" class="form-control rounded" readonly style="text-align:right;">
                                    </div>
                                </div>

                                <div class="row form-group" style="border-bottom:1px solid #EEE; padding-bottom:10px;">
                                    <div class="col-md-7">
                                        <label for="rut">Total a pagar en arzobispado</label>                                                
                                    </div>
                                    <div class="col-md-1" style="text-align:right; padding-top:5px;">
                                        <label for="rut">$</label>                                                
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" value="8.319" class="form-control rounded" readonly style="text-align:right;">
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