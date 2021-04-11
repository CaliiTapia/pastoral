@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')
@include('ValidaNotificacion')
<header class="content__title">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <div>
                <div class="col-lg-10">
                    <h2> DOCUMENTOS DEVELACIONES</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Descargar Archivos Develaciones</a>
                        </li>
                        <li class="breadcrumb-item">
                            <strong>Descargar Archivos</strong>
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
                <h5><strong>LISTA DOCUMENTOS</strong></h5>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Inicio data table -->
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-hover dataTables-Dev" id="listadescargas">
                        <thead>
                            <tr align="center">
                                <th>N°</th>
                                <th>Descripción</th>
                                <th>Nombre Archivo</th>
                                <th>Zona</th>
                                <th>Parroquia</th>
                                <th>Usuario</th>
                                <th style="text-align: right">Fecha Subida</th>
                                <th style="text-align: center">Descargar Archivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $contadordatos = 1;
                            @endphp
                        @foreach($devarchivosdes as $des)   
                            <tr class="gradeX">
                                <td align="center">{{ $contadordatos }}</td>
                                <td align="center">{{ $des ->MAP_Descripcion }}</td>
                                <td align="center">{{ $des ->MAP_Nombre_Archivo }}</td>
                                <td align="center">{{ $des ->nombrezona }}</td> 
                                <td align="center">{{ $des ->INNombre }}</td> 
                                <td align="center">{{ $des ->Nombre." ".$des ->Apellidos}}</td>
                                <td align="right">{{ $des ->fechadesubida }}</td>
                                <td align="center"><a href="storage/archivosdevelaciones/{{ $des ->MAP_Nombre_Archivo }}" download="{{ $des ->MAP_Nombre_Archivo }}" class="btn btn-outline btn-primary"><i class="fa fa-download" title="Descargar"></i></a></td>
                            </tr>
                            @php
                                $contadordatos ++;
                            @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Fin data table -->
    </div>
@endsection

@section('javascript')
<script>
    $(document).ready(function(){
        $('.dataTables-Dev').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                
            ],
            language: {
                lengthMenu: "Mostrar _MENU_ entradas",
                info: "Mostrando desde _START_ hasta  _END_ de _TOTAL_ ",
                search: "Buscar:",

                buttons:  {
                 
                },

                paginate: {
                    previous: "Anterior",
                    next: "Siguiente"
                }
            } 
        });
  });  
</script>
@endsection