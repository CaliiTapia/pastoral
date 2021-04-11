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
                            <a href="#">Pagos</a>
                        </li>
                        <li class="breadcrumb-item">
                            <strong>Comprobantes</strong>
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
                <h5>
                    <strong>COMPROBANTES</strong>
                </h5>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="ibox-content">

                <form class="form-horizontal">
                    <div class="row form-group">                        
                        <div class="col-md-3">
                            <label>Forma de Pago</label>
                            <select class="form-control">
                                <option>Todas</option>
                                <option>...</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Capilla</label>
                            <select class="form-control">
                                <option>Todas</option>
                                <option>...</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Visitador</label>
                            <select class="form-control">
                                <option>Todos</option>
                                <option>...</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Banco</label>
                            <select class="form-control">
                                <option>Todos</option>
                                <option>...</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col-md-2">
                            <label for="rut">Desde</label>                                                
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <label for="rut">Hasta</label>                                                
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="rut">Búsqueda textual</label>                                                
                            <input type="text" class="form-control" placeholder="RUT, Contribuyente o Código de Comprobante">
                        </div>
                        <div class="col-md-4">
                            <label>&nbsp;</label><br>
                            <button class="btn btn-success pull-left" type="submit"><i class="fa fa-search"></i> <span class="bold">Buscar</span></button>

                            <div class="dropdown pull-left m-l-xs">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                    Exportar
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">CSV</a>
                                    <a class="dropdown-item" href="#">Excel</a>
                                    <a class="dropdown-item" href="#">Imprimir</a>
                                </div>
                            </div>                            
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

<div class="wrapper wrapper-content espacio">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-title">
                <h5>
                    <strong>LISTADO DE COMPROBANTES</strong>
                    <a href="{{ asset('/unoporciento/pagos/comprobantes/ingreso-comprobante') }}" class="btn btn-primary btn-xs pull-right" type="submit"><i class="fa fa-plus"></i> <span class="bold">Ingreso de Comprobante</span></a>
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
                                <th>Nro. Comprobante</th>
                                <th>Fecha Pago</th>
                                <th>Período</th>
                                <th>Contribuyente</th>
                                <th>Monto</th>
                                <th>Forma Pago</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>12345</td>
                                <td>01-01-2021</td>
                                <td>Ene 2020</td>
                                <td>Juan Pérez Gómez</td>
                                <td class="text-right">$5.000</td>
                                <td class="text-center">EFECTIVO</td>
                                <td class="text-center">
                                    <a type="button" class="btn btn-outline btn-info" href="#">
                                        <i class="fa fa-money" title="Ver Mandato"></i>
                                    </a>
                                    <a type="button" class="btn btn-outline btn-info" href="#">
                                        <i class="fa fa-times" title="Anular Mandato"></i>
                                    </a>
                                    <a type="button" class="btn btn-outline btn-info" href="#">
                                        <i class="fa fa-print" title="Imprimir"></i>
                                    </a>
                                    <a type="button" class="btn btn-outline btn-info" href="#">
                                        <i class="fa fa-envelope" title="Enviar por Correo"></i>
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td>12345</td>
                                <td>01-01-2021</td>
                                <td>Ene 2020</td>
                                <td>Juan Pérez Gómez</td>
                                <td class="text-right">$5.000</td>
                                <td class="text-center">EFECTIVO</td>
                                <td class="text-center">
                                    <a type="button" class="btn btn-outline btn-info" href="#">
                                        <i class="fa fa-money" title="Ver Mandato"></i>
                                    </a>
                                    <a type="button" class="btn btn-outline btn-info" href="#">
                                        <i class="fa fa-times" title="Anular Mandato"></i>
                                    </a>
                                    <a type="button" class="btn btn-outline btn-info" href="#">
                                        <i class="fa fa-print" title="Imprimir"></i>
                                    </a>
                                    <a type="button" class="btn btn-outline btn-info" href="#">
                                        <i class="fa fa-envelope" title="Enviar por Correo"></i>
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td>12345</td>
                                <td>01-01-2021</td>
                                <td>Ene 2020</td>
                                <td>Juan Pérez Gómez</td>
                                <td class="text-right">$5.000</td>
                                <td class="text-center">EFECTIVO</td>
                                <td class="text-center">
                                    <a type="button" class="btn btn-outline btn-info" href="#">
                                        <i class="fa fa-money" title="Ver Mandato"></i>
                                    </a>
                                    <a type="button" class="btn btn-outline btn-info" href="#">
                                        <i class="fa fa-times" title="Anular Mandato"></i>
                                    </a>
                                    <a type="button" class="btn btn-outline btn-info" href="#">
                                        <i class="fa fa-print" title="Imprimir"></i>
                                    </a>
                                    <a type="button" class="btn btn-outline btn-info" href="#">
                                        <i class="fa fa-envelope" title="Enviar por Correo"></i>
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td>12345</td>
                                <td>01-01-2021</td>
                                <td>Ene 2020</td>
                                <td>Juan Pérez Gómez</td>
                                <td class="text-right">$5.000</td>
                                <td class="text-center">EFECTIVO</td>
                                <td class="text-center">
                                    <a type="button" class="btn btn-outline btn-info" href="#">
                                        <i class="fa fa-money" title="Ver Mandato"></i>
                                    </a>
                                    <a type="button" class="btn btn-outline btn-info" href="#">
                                        <i class="fa fa-times" title="Anular Mandato"></i>
                                    </a>
                                    <a type="button" class="btn btn-outline btn-info" href="#">
                                        <i class="fa fa-print" title="Imprimir"></i>
                                    </a>
                                    <a type="button" class="btn btn-outline btn-info" href="#">
                                        <i class="fa fa-envelope" title="Enviar por Correo"></i>
                                    </a>
                                </td>
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