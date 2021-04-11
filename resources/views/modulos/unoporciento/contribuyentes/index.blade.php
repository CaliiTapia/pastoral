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
                            <strong>Contribuyentes</strong>
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
                <h5><strong>BÚSQUEDA DE CONTRIBUYENTES</strong></h5>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="ibox-content">

                <form class="form-horizontal">
                    <div class="row form-group">
                        
                        <div class="col-md-3">
                            <label>Parroquia / Capilla</label>
                            <select class="form-control">
                                <option>TODAS</option>
                                <option>CAPILLA 01</option>
                                <option>CAPILLA 02</option>
                                <option>CAPILLA 03</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="rut">Búsqueda textual</label>                                                
                            <input type="text" class="form-control" placeholder="Busca por Nombre, Apellidos o RUT">
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
                    <strong>LISTADO DE REGISTROS</strong>
                    <a href="{{ asset('/unoporciento/contribuyentes/crear-contribuyente') }}" class="btn btn-primary btn-xs pull-right" type="submit"><i class="fa fa-plus"></i> <span class="bold">Crear nuevo Contribuyente</span></a>
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
                                <th>Rut</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Nombres</th>
                                <th>Parroquia / Capilla</th>
                                <th class="ancho">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @for($i = 0; $i < 10; $i++)
                            
                            <tr>
                                <td>12.345.678-9</td>
                                <td>Pérez</td>
                                <td>Gómez</td>
                                <td>Juan</td>
                                <td>EL SAGRARIO</td>
                                <td class="text-right">
                                    <a type="button" class="btn btn-outline btn-info" href="{{ asset('/unoporciento/contribuyentes/ver-contribuyente') }}">
                                        <i class="fa fa-address-book" title="Ver Contribuyente"></i>
                                    </a>
                                </td>
                            </tr>

                            @endfor

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Fin data table -->
    </div>
</div>  


@endsection