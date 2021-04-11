@extends('layouts.admin')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Auxiliar</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
            <strong>Auxiliar</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <div style="margin:40px 0px 0px 40px">
            <a class="btn btn-primary" href="{{ asset('contaparroquial/mantenedores/auxiliares/crear') }}" role="button"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo auxiliar</a>
        </div>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Listado de auxiliares</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                    <table id="dataTables-centros" class="table table-striped table-bordered table-hover dataTables-centros">
                        <thead>
                            <tr>
                                <th data-hide="true">Código</th>
                                <th data-hide="true">Nombre</th>
                                <th data-hide="true">Apellido</th>
                                <th data-hide="true">Rut </th>
                                <th data-hide="true">Teléfono</th>
                                <th data-hide="true">Email</th>
                                <th data-hide="true">Dirección</th>
                                <th data-hide="true">Comuna</th>
                                <th data-hide="true">Ciudad</th>
                                <th data-hide="true">País</th>
                                <th data-hide="true">Edición</th>
                                <th data-hide="true">Status</th>
                                <th data-hide="true">Habilitado / Deshabilitado</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($auxi as $au)
                            <tr>
                                <td>{{ trim($au->codAux) !='' ? $au->codAux : 'Sin Información' }}</td>
                                <td>{{ trim($au->nomAux) !='' ? $au->nomAux : 'Sin Información' }}</td>
                                <td>{{ trim($au->apllAux) !='' ? $au->apllAux : 'Sin Información' }}</td>
                                <td>{{ trim($au->rutAux) !='' ? $au->rutAux : 'Sin Información' }}</td>
                                <td>{{ trim($au->fonoAux) !='' ? $au->fonoAux : 'Sin Información' }}</td>
                                <td>{{ trim($au->mailAux) !='' ? $au->mailAux : 'Sin Información' }}</td>
                                <td>{{ trim($au->dirAux) !='' ? $au->dirAux : 'Sin Información'}}</td>
                                <td>{{ trim($au->nombreComuna) !='' ? $au->nombreComuna : 'Sin Información' }}</td>
                                <td>{{ trim($au->nombreCiudad) !='' ? $au->nombreCiudad : 'Sin Información' }}</td>
                                <td>{{ trim($au->nombrePais) !='' ? $au->nombrePais : 'Sin Información' }}</td>
                                <td>
                                    <a href="{{ asset('contaparroquial/mantenedores/auxiliares/editar/'.$au->codAux) }}"><i class="fa fa-edit"></i> <span class="bold"> Editar</span></a>
                                </td>
                                <td>@if ( $au->statusAux =='A')  <span class="label label-primary">Habilitado</span>
                                @else ( $au->statusAux =='I')   <span class="label label-danger">Deshabilitado</span> @endif</td>
                                <td>
                                    @if( $au->statusAux == 'A')
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch_{{$au->codAux}}" autocomplete="off" onclick="desactivar('{{$au->codAux}}')"  checked>
                                            <label class="onoffswitch-label" for="myonoffswitch_{{$au->codAux}}">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                    </div>
                                    @else
                                    <div class="onoffswitch">
                                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"  id="myonoffswitch_{{$au->codAux}}" autocomplete="off" onclick="activar('{{$au->codAux}}')" >
                                            <label class="onoffswitch-label" for="myonoffswitch_{{$au->codAux}}">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                    </div>
                                    @endif
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
<script>
         $(document).ready(function(){
            $('.dataTables-centros').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Auxiliares'},
                    {extend: 'pdf', title: 'Auxiliares'},
                    {extend: 'print',
                        customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');
                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ],
                language: {
                    lengthMenu: "Mostrar _MENU_ entradas",
                    info: "Mostrando desde _START_ hasta  _END_ de _TOTAL_ ",
                    search: "Buscar:",
                    buttons:  {
                     copy : "Copiar",
                     print : "Imprimir"
                    },
                    paginate: {
                        previous: "Anterior",
                        next: "Siguiente"
                    }
                }               
        });
      });

      function desactivar(id){
        if(id != ''){
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:   '/ajax/desactivarAU/'+id,
                type : 'get',
                dataType: 'json',
            }).done(function(response) {
                if(response == 'ok'){
                    $('#myonoffswitch_'+id).attr('onclick',"activar("+id+")");
                    toastr["success"]("Auxiliar desactivado","Exito");
                    location.reload(); 

                }
            }).fail(function(){
                //alert("Inicie secion nuevamente");
                //window.location.reload(); 
            });
        }else{
            alert("[ERROR: ID ES INDEFINIDO] ID = "+id);
        }
    }
    function activar(id){
        if(id != ''){
            $.ajax({
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:   '/ajax/activarAU/'+id,
                type : 'get',
                dataType: 'json',
            }).done(function(response) {
                if(response == 'ok'){
                    console.log("activado");
                    $('#myonoffswitch_'+id).attr('onclick',"desactivar("+id+")");
                    toastr["success"]("Auxiliar activado","Exito");
                    location.reload(); 
                }
            }).fail(function(){
                //alert("Inicie secion nuevamente");
                //window.location.reload(); 
            });
        }else{
            alert("[ERROR: ID ES INDEFINIDO] ID = "+id);
        }
    }

    </script> 


@endsection
