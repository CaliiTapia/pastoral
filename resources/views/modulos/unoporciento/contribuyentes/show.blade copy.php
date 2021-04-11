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

                            <h3>Información del Contribuyente</h3>

                            <div class="row " style="margin-top: 25px;">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rut">Código Contribuyente</label>
                                        <input type="text" value="1" class="form-control rounded" readonly>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rut">RUT</label>
                                        <input type="text" value="11.111.111-1" class="form-control rounded" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row " style="margin-top: 0px;">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rut">Apellido Paterno</label>
                                        <input type="text" value="Pérez" class="form-control rounded" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rut">Apellido Materno</label>
                                        <input type="text" value="Gómez" class="form-control rounded" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rut">Nombres</label>
                                        <input type="text" value="Juan" class="form-control rounded" readonly>
                                    </div>
                                </div>
                            </div>

                            <h3 style="margin-top: 25px;">Datos Generales del Contribuyente</h3>

                            <div class="row " style="margin-top: 25px;">

                                <div class="col-md-12">

                                    <ul class="nav nav-tabs" style="width:100%;">
                                        <li><a data-toggle="tab" href="#home">Datos Personales</a></li>
                                        <li><a data-toggle="tab" href="#menu1">Dirección y Contacto</a></li>
                                        <li><a data-toggle="tab" href="#menu2">Datos Contribución</a></li>
                                    </ul>

                                    <div class="tab-content" style="width:100%;">
                                        <div id="home" class="tab-pane fade in active" style="padding:20px;">

                                            <h3>Datos Personales del Contribuyente</h3>
                                            
                                            <div class="row form-group" style="border-bottom:1px solid #EEE; margin-top:20px;">
                                                <div class="col-md-4">
                                                    <label for="rut">Fecha de Nacimiento</label>                                                
                                                </div>
                                                <div class="col-md-8">
                                                    17/11/1978
                                                </div>
                                            </div>

                                            <div class="row form-group" style="border-bottom:1px solid #EEE;">
                                                <div class="col-md-4">
                                                    <label for="rut">Género</label>                                                
                                                </div>
                                                <div class="col-md-8">
                                                    Masculino
                                                </div>
                                            </div>

                                            <div class="row form-group" style="border-bottom:1px solid #EEE;">
                                                <div class="col-md-4">
                                                    <label for="rut">Estado Civil</label>                                                
                                                </div>
                                                <div class="col-md-8">
                                                    Soltero
                                                </div>
                                            </div>

                                            <div class="row form-group" style="border-bottom:1px solid #EEE;">
                                                <div class="col-md-4">
                                                    <label for="rut">Profesión / Oficio</label>                                                
                                                </div>
                                                <div class="col-md-8">
                                                    Ingeniero Informático
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-md-4">
                                                    <label for="rut">Tratamiento</label>                                                
                                                </div>
                                                <div class="col-md-8">
                                                    Sr.
                                                </div>
                                            </div>

                                        </div>
                                        <div id="menu1" class="tab-pane fade" style="padding:20px;">
                                            
                                            <h3>Dirección y Contacto</h3>
                                            
                                            <div class="row form-group" style="border-bottom:1px solid #EEE; margin-top:20px;">
                                                <div class="col-md-4">
                                                    <label for="rut">Dirección</label>                                                
                                                </div>
                                                <div class="col-md-8">
                                                    AVDA. SAN PABLO 3248
                                                </div>
                                            </div>

                                            <div class="row form-group" style="border-bottom:1px solid #EEE;">
                                                <div class="col-md-4">
                                                    <label for="rut">Sector</label>                                                
                                                </div>
                                                <div class="col-md-8">
                                                    SANTIAGO CENTRO
                                                </div>
                                            </div>

                                            <div class="row form-group" style="border-bottom:1px solid #EEE;">
                                                <div class="col-md-4">
                                                    <label for="rut">Comuna</label>                                                
                                                </div>
                                                <div class="col-md-8">
                                                    SANTIAGO
                                                </div>
                                            </div>

                                            <div class="row form-group" style="border-bottom:1px solid #EEE;">
                                                <div class="col-md-4">
                                                    <label for="rut">Teléfono 1</label>                                                
                                                </div>
                                                <div class="col-md-8">
                                                    1234567890
                                                </div>
                                            </div>

                                            <div class="row form-group" style="border-bottom:1px solid #EEE;">
                                                <div class="col-md-4">
                                                    <label for="rut">Teléfono 2</label>                                                
                                                </div>
                                                <div class="col-md-8">
                                                    1234567890
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-md-4">
                                                    <label for="rut">E-mail</label>                                                
                                                </div>
                                                <div class="col-md-8">
                                                    jperezgomez@usuario.cl
                                                </div>
                                            </div>

                                        </div>
                                        <div id="menu2" class="tab-pane fade" style="padding:20px;">
                                            
                                            <h3>Datos Contribución</h3>

                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover dataTables-Dev" id="listadodevelaciones">
                                                    <thead>
                                                        <tr>
                                                            <th>Tipo Recaudación</th>
                                                            <th>Monto</th>
                                                            <th>Parroquia / Capilla</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>RENDICIÓN PARROQUIA</td>
                                                            <td>5.000</td>
                                                            <td>El Sagrario</td>
                                                        </tr>
                                                        <tr>
                                                            <td>RENDICIÓN PARROQUIA</td>
                                                            <td>5.000</td>
                                                            <td>El Sagrario</td>
                                                        </tr>
                                                        <tr>
                                                            <td>RENDICIÓN PARROQUIA</td>
                                                            <td>5.000</td>
                                                            <td>El Sagrario</td>
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

                
            </div>
        </div>
        <!-- Fin data table -->
    </div>
</div>  


@endsection