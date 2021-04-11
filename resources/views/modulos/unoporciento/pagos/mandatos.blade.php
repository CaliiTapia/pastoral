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
                            <strong>Mandatos</strong>
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
                    <strong>MANDATOS</strong>
                    <div class="dropdown pull-right m-t-none">
                        <button type="button" class="btn btn-default dropdown-toggle btn-xs" data-toggle="dropdown">
                            Descarga de Mandato Tipo
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#">CMR</a>
                            <a class="dropdown-item" href="#">Mandato PAC</a>
                            <a class="dropdown-item" href="#">Mandato PAT</a>
                            <a class="dropdown-item" href="#">Mandato Transbank</a>
                        </div>
                    </div>
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
                            <label>Tipo de Recaudación</label>
                            <select class="form-control">
                                <option>TODAS</option>
                                <option>MANDATO PAT</option>
                                <option>MANDATO PAC</option>
                                <option>MANDATO TRANSBANK</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Estado</label>
                            <select class="form-control">
                                <option>Indiferente</option>
                                <option>Activo</option>
                                <option>Inactivo</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label>Banco</label>
                            <select class="form-control">
                                <option>Todos</option>
                                <option>...</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="rut">Fecha Inicio Aporte</label>                                                
                            <input type="date" class="form-control">
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col-md-4">
                            <label for="rut">Búsqueda textual</label>                                                
                            <input type="text" class="form-control" placeholder="Busca por RUT o Folio de Mandato">
                        </div>
                        <div class="col-md-5">
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
                    <strong>LISTADO DE MANDATOS</strong>
                    <a href="{{ asset('/unoporciento/pagos/mandatos/cargar-mandato') }}" class="btn btn-primary btn-xs pull-right" type="submit"><i class="fa fa-plus"></i> <span class="bold">Cargar Mandato</span></a>
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
                                <th>Tipo Recaudación</th>
                                <th>Banco</th>
                                <th>Folio</th>
                                <th>Contribuyente</th>
                                <th>Monto</th>
                                <th>Inicio Aporte</th>
                                <th>Estado</th>
                                <th class="ancho">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <td>MANDATO PAT</td>
                                <td>Banco Santander</td>
                                <td>12345</td>
                                <td>Juan Pérez Gómez</td>
                                <td class="text-right">$5.000</td>
                                <td class="text-center">Activo</td>
                                <td class="text-center">01-01-2019</td>
                                <td class="text-right">
                                    <a type="button" class="btn btn-outline btn-info" href="{{ asset('/unoporciento/contribuyentes/ver-contribuyente') }}">
                                        <i class="fa fa-address-book" title="Ver Mandato"></i>
                                    </a>
                                </td>
                            </tr>

                            <tr>
                                <td>MANDATO PAC</td>
                                <td>Banco de Chile</td>
                                <td>123456</td>
                                <td>Elisa Fernández Poblete</td>
                                <td class="text-right">$15.000</td>
                                <td class="text-center">Inactivo</td>
                                <td class="text-center">01-05-2019</td>
                                <td class="text-right">
                                    <a type="button" class="btn btn-outline btn-info" href="{{ asset('/unoporciento/contribuyentes/ver-contribuyente') }}">
                                        <i class="fa fa-address-book" title="Ver Mandato"></i>
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