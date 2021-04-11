@extends('layouts.admin')
@section('title', 'Capilla')
@section('content')
@include('ValidaNotificacion')
<header class="content__title">
     <h1><a href="{{asset('mantenedor/user')}}" style="color: #000000"> MANTENEDOR / CAPILLAS </a></h1>
          <div class="actions">
                <a class="btn boton btn-secondary" href="{{ asset('mantenedores/capilla/create') }}" role="button">Agregar</a>
                <div class="dropdown actions__item">
                    <i data-toggle="dropdown" class="zmdi zmdi-more-vert"></i>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="" class="dropdown-item boton">Refrescar</a>
                    </div>
                </div>
          </div>
</header>    

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Basic Data Tables example with responsive plugin</h5>
                <div class="ibox-tools">
                    <a class="collapse-link">
                        <i class="fa fa-chevron-up"></i>
                    </a>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-wrench"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#" class="dropdown-item">Config option 1</a>
                        </li>
                        <li><a href="#" class="dropdown-item">Config option 2</a>
                        </li>
                    </ul>
                    <a class="close-link">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="ibox-content">

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover tab-capillas" >
                    <thead>
                        <tr>
                            <th></th>
                            <th>Capilla</th>
                            <th>Parroquia</th>
                            <th>Decanato</th>
                            <th>Zona</th>
                            <th>Diócesis</th>
                            <th>Estatus</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($capilla as $c)
                            <tr>
                                <td><a style="color: #FFFFFF" href="{{ url('/mantenedores/capilla/update',[$c->IdCapilla]) }}"><i class="zmdi zmdi-edit zmdi-hc-fw"></i>
                        </a></td>
                                <td>{{ $c->Nombre }}</td>
                                <td>{{ $c->Parroquia }}</td>
                                <td>{{ $c->Decanato }}</td>
                                <td>{{ $c->Zona }}</td>
                                <td>{{ $c->Diocesis }}</td>
                                <td>@if ( $c->Estatus =='1') {{ 'ACTIVO' }} @endif
                                    @if ( $c->Estatus =='0') {{ 'INACTIVO' }} @endif
                                </td>
                            </tr>
                        @endforeach    
                    </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
    </div>
</div>
@endsection

@section('javascript')

<script type="text/javascript">

$(document).ready(function(){
            $('.tab-capillas').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });

        });


</script>

@endsection