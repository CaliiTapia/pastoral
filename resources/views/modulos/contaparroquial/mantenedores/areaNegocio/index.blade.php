@extends('layouts.admin')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Área de Negocio</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
            <strong>Área de negocio</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <div style="margin:40px 0px 0px 40px">
        <a class="btn btn-success " type="button" href="{{ asset('contaparroquial/mantenedores/areaNegocio/crear') }}" ><i class="fa fa-plus-circle"></i> <span class="bold"> Nueva área de negocio</span></a>
        </div>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Listado de área de negocio</h5>
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
                                    <th data-hide="phone">Código</th>
                                    <th data-hide="phone">Nombre</th>
                                    <th data-hide="phone">Edición</th>
                                    <th data-hide="phone">Status</th>
                                    <th data-hide="phone">Habilitado / Deshabilitado</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($areaNegocio as $aN)
                                <tr>
                                    <td>{{ trim($aN->codAin) !='' ? $aN->codAin : 'Sin Información' }}</td>
                                    <td>{{ trim($aN->areaNom) !='' ? $aN->areaNom : 'Sin Información' }}</td>
                                    <td>
                                        <a href="{{ asset('contaparroquial/mantenedores/areaNegocio/editar/'.$aN->codAin) }}"><i class="fa fa-edit"></i> <span class="bold"> Editar</span></a>
                                    </td>
                                    <td>@if ( $aN->areaStatus =='A')  <span class="label label-primary">Habilitado</span>  @endif
                                        @if ( $aN->areaStatus =='I')   <span class="label label-danger">Deshabilitado</span> @endif
                                    </td>
                                    <td>
                                        @if( $aN->areaStatus == 'A')
                                        <div class="onoffswitch">
                                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch_{{$aN->areaCod}}" autocomplete="off" onclick="desactivar('{{$aN->areaCod}}')"  checked>

                                            <label class="onoffswitch-label" for="myonoffswitch_{{$aN->areaCod}}">
                                                <span class="onoffswitch-inner"></span>
                                                <span class="onoffswitch-switch"></span>
                                            </label>
                                        </div>
                                        @else
                                        <div class="onoffswitch">
                                        <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"  id="myonoffswitch_{{$aN->areaCod}}" autocomplete="off" onclick="activar('{{$aN->areaCod}}')" >

                                            <label class="onoffswitch-label" for="myonoffswitch_{{$aN->areaCod}}">
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
                    {extend: 'excel', title: 'Area-Negocio'},
                    {extend: 'pdf', title: 'Area-Negocio'},
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
                url:   '/ajax/desactivarAN/'+id,
                type : 'get',
                dataType: 'json',
            }).done(function(response) {
                if(response == 'ok'){
                    $('#myonoffswitch_'+id).attr('onclick',"activar("+id+")");
                    toastr["success"]("Área de negocio desactivada","Exito");
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
                url:   '/ajax/activarAN/'+id,
                type : 'get',
                dataType: 'json',
            }).done(function(response) {
                if(response == 'ok'){
                    console.log("activado");
                    $('#myonoffswitch_'+id).attr('onclick',"desactivar("+id+")");
                    toastr["success"]("Área de negocio activada","Exito");
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