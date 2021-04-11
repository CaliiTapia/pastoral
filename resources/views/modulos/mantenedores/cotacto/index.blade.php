<!--Formulario de Comuna  -->
@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')
@include('ValidaNotificacion')
<div class="content__inner">
    <header class="content__title">
    <h1><a href="{{asset('mantenedor/user')}}" style="color: #424242"> MANTENEDOR / PARROQUIA / ACTUALIZAR DATOS / Parroquia</a></h1>
        <div class="actions">
            <a class="btn boton" href="{{asset('mantenedores/nuevo/contacto')}}" role="button"><i class="zmdi zmdi-collection-plus"></i>  Nuevo Contacto</a> 
            <div class="dropdown actions__item">
                <i data-toggle="dropdown" class="zmdi zmdi-more-vert"></i>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="" class="dropdown-item btn-warning">Refrescar</a>
                </div>
            </div>
        </div>
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </header>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="data-table" class="table table-hover mb-0">
                     <thead>
                         <tr>
                            <th>  </th>
                            <th>Rut</th>
                            <th>Nombres </th>
                            <th>Apellidos </th>
                            <th>Direccion </th>
                            <th>Fijo </th>
                            <th>Celular </th>
                            <th>Correo </th>
                            <th>Cargo </th>
                            <th>Fecha Nacimiento</th>
                        </tr>
                     </thead>
                     <tbody>
                          @foreach($Contactos as $contacto)  
                          <tr>
                            <td>                            
                                <a style="color: #FFFFFF" class="actions__item zmdi zmdi-edit zmdi-hc-fw" href="{{ asset('mantenedores/contacto/editar/'.$contacto->IdFichas) }}">
                                </a>
                                <a style="color: #ee3535" class="actions__item zmdi zmdi-delete" href="#ModalConfirm" data-toggle="modal" onclick="pasaid({{$contacto->IdFichas}})">
                                </a>
                            </td>
                            <td>{{ $contacto->Rut.'-'.$contacto->Dv }}</td>
                            <td>{{ $contacto->Nombres }}</td>
                            <td>{{ $contacto->ApellidoPaterno.' '.$contacto->ApellidoMaterno }}</td>
                            <td>{{ $contacto->Direccion }}</td>
                            <td>{{ $contacto->Fijo }}</td>
                            <td>{{ $contacto->Celular }}</td>
                            <td>{{ $contacto->Email }}</td>
                            <td>{{ $contacto->Descripcion }}</td>
                            <td>{{ date("d-m-Y",strtotime($contacto->FechaNac)) }}</td>
                          </tr>     
                          @endforeach
                     </tbody>
                     </table>
                </div>
        </div>
    </div>
    <!-- Modal Confirm -->
    <div id="ModalConfirm" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="icon-box">
                        <i class="zmdi zmdi-delete animated infinite wobble"></i>
                    </div>				
                    <h4 class="modal-title">¿Estas seguro?</h4>	
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Este registro se eliminara de manera permanente.</p>
                </div>
                <div class="modal-footer">
                    <a class="btn btn-info" data-dismiss="modal">Cancelar</a>
                    <a id="btn_confirm_delete"  class="btn btn-danger" >Borrar</a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Modal Confirm -->
</div>


@endsection
@section('javascriptSection')
    <script src="{{ asset('vendors/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{ asset('/js/ValidarInput.js')}}"></script>
    <script>
        function pasaid($id){
            $("#btn_confirm_delete").attr("href","/mantenedores/contacto/eliminar/"+$id);
        }
    </script>  
@endsection

 
