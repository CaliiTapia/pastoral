@extends('layouts.admin')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Centro Costo</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Centro Costo</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2">
        <div style="margin:40px 0px 0px 40px">
            <a class="btn btn-primary" href="{{ asset('contaparroquial/mantenedores/centroCosto/crear') }}" role="button"><i class="fa fa-plus-circle" aria-hidden="true"></i> Nuevo centro costo</a>
        </div>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Lista de centros de costos</h5>
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
                                    <th data-hide="phone">Descripción</th>
                                    <th data-hide="phone">Edición</th>
                                    <th data-hide="phone">Status</th>
                                    <th data-hide="phone">Habilitado / Deshabilitado</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($centroCosto as $cc)
                                <tr>
                                    <td>{{ trim($cc->ccCod) !='' ? $cc->ccCod : 'Sin Información' }}</td>
                                    <td>{{ trim($cc->ccDesc) !='' ? $cc->ccDesc : 'Sin Información' }}</td>
                                    <td>
                                        <a href="{{ asset('contaparroquial/mantenedores/centroCosto/editar/'.$cc->ccCod) }}"><i class="fa fa-edit"></i> <span class="bold"> Editar</span></a>
                                    </td>
                                    <td>@if ( $cc->estatus =='A')  <span class="label label-primary">Habilitado</span>  @endif
                                        @if ( $cc->estatus =='I')   <span class="label label-danger">Deshabilitado</span> @endif
                                    </td>
                                    <td>
                                        @if( $cc->estatus == 'A')
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch_{{$cc->id}}" autocomplete="off" onclick="desactivar('{{$cc->id}}')"  checked>
                                                <label class="onoffswitch-label" for="myonoffswitch_{{$cc->id}}">
                                                    <span class="onoffswitch-inner"></span>
                                                    <span class="onoffswitch-switch"></span>
                                                </label>
                                        </div>
                                        @else
                                        <div class="onoffswitch">
                                            <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox"  id="myonoffswitch_{{$cc->id}}" autocomplete="off" onclick="activar('{{$cc->id}}')" >
                                                <label class="onoffswitch-label" for="myonoffswitch_{{$cc->id}}">
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
                    {extend: 'excel', title: 'Centro-Costo'},
                    {extend: 'pdf', title: 'Centro-Costo'},
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
                url:   '/ajax/desactivarCC/'+id,
                type : 'get',
                dataType: 'json',
            }).done(function(response) {
                if(response == 'ok'){
                    $('#myonoffswitch_'+id).attr('onclick',"activar("+id+")");
                    toastr["success"]("Centro costo desactivado","Exito");
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
                url:   '/ajax/activarCC/'+id,
                type : 'get',
                dataType: 'json',
            }).done(function(response) {
                if(response == 'ok'){
                    console.log("activado");
                    $('#myonoffswitch_'+id).attr('onclick',"desactivar("+id+")");
                    toastr["success"]("Centro costo activado","Exito");
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