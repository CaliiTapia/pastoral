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
                            <strong>Pagos</strong>
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
                <h5><strong>LISTADO PAGOS</strong></h5>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Inicio data table -->
            <div class="ibox-content">
                <div class="table-responsive">

                    <h3>
                        Pagos
                        <a href="{{asset('/porciento-parroquial/ingreso')}}" class="btn btn-success pull-right btn-xs" style="margin-right:5px;"><i class="fa fa-download"></i> Ingresar Pago</a>
                    </h3>

                    <table class="table table-striped table-hover dataTables-Dev" id="listadodevelaciones">
                        <thead>
                            <tr>
                                <th>Nro. Comprobante</th>
                                <th>Contribuyente</th>
                                <th>Fecha Pago</th>
                                <th>Periodo</th>
                                <th>Monto</th>
                                <th>Forma de Pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>12345</td>
                                <td>JUAN PEREZ GOMEZ</td>
                                <td>01-01-2020</td>
                                <td>Ene 2020 - Mar 2020</td>
                                <td>$2.000</td>
                                <td>EFECTIVO</td>
                            </tr>
                            <tr>
                                <td>12345</td>
                                <td>JUAN PEREZ GOMEZ</td>
                                <td>01-01-2020</td>
                                <td>Ene 2020 - Mar 2020</td>
                                <td>$2.000</td>
                                <td>TRANSFERENCIA ELECTRÓNICA</td>
                            </tr>
                            <tr>
                                <td>12345</td>
                                <td>JUAN PEREZ GOMEZ</td>
                                <td>01-01-2020</td>
                                <td>Ene 2020 - Mar 2020</td>
                                <td>$2.000</td>
                                <td>EFECTIVO</td>
                            </tr>
                            <tr>
                                <td>12345</td>
                                <td>JUAN PEREZ GOMEZ</td>
                                <td>01-01-2020</td>
                                <td>Ene 2020 - Mar 2020</td>
                                <td>$2.000</td>
                                <td>EFECTIVO</td>
                            </tr>
                            <tr>
                                <td>12345</td>
                                <td>JUAN PEREZ GOMEZ</td>
                                <td>01-01-2020</td>
                                <td>Ene 2020 - Mar 2020</td>
                                <td>$2.000</td>
                                <td>EFECTIVO</td>
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