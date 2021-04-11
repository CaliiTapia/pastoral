@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')
@include('ValidaNotificacion') 
<header class="content__title">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <div>
                <div class="col-lg-10">
                    <h2>@include('layouts.urSeleccionada') / Ficha Agente Pastoral</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ asset('pastoral/listado') }}">Agentes Pastorales</a>
                        </li>
                        <li class="breadcrumb-item">
                            <strong>Listado</strong>
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
                <h5><strong>LISTADO AGENTES PASTORALES</strong></h5><small class="m-l-sm"> Ficha de agentes registrados</small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- Inicio data table -->

            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables-Fichas" >
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Tel. Fijo</th>
                                <th>Tel. Móvil</th>
                                <th>Correo</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($fichas as $ficha)
                                <tr class="gradeX">
                                    <td>{{ $ficha->Nombre }}</td>
                                    <td>{{ $ficha->ApellidoPaterno }}</td>
                                    <td>{{ $ficha->ApellidoMaterno }}</td>
                                    <td class="center">{{ $ficha->TelefonoFijo }}</td>
                                    <td class="center">{{ $ficha->TelefonoMovil }}</td>
                                    <th>{{ $ficha->Correo }}</th>
                                    <th>
                                        <a class="btn btn-outline btn-info" href="{{ asset('/pastoral/listado/'.$ficha->IdFicha.'/edit') }}" title="Ver Ficha">
                                        <i class="fa fa-eye"></i>
                                        </a>
                                        @can('dev_bloqueo_ap')
                                        <button class="btn btn-outline btn-danger" onclick="mostrarmodalbloqueo({{$ficha->IdFicha}},'{{ $ficha ->Nombre }}','{{ $ficha ->ApellidoPaterno }}','{{ $ficha ->ApellidoMaterno }}')" title="Cese servicios">
                                        <i class="fa fa-ban"></i>
                                        @endcan
                                    </th>
                                </tr>
                            @endforeach
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Fin data table -->

    </div>
</div>

  <!-- Modal -->
  <div class="modal fade inmodal" id="Modalbloquearap" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <h4 class="modal-title" id="staticBackdropLabel"><Strong><i class="fa fa-pencil"></i> Desactivar Agente Pastoral</Strong></h4>
                <label id="nombreap"> </label>
            </div>
            <form id="formbloqueo">
                <div class="modal-body">
                {{ csrf_field() }}
                    <div class="col-md-12">
                        <div class="form-group">
                            <input type="hidden" name="idfichabloq" id="idfichabloq">
                            <input type="hidden" name="vista" id="vista" value="2">
                            <input type="hidden" name="mot" id="mot" value="2"> 
                            <input type="hidden" name="participacionbloq" id="participacionbloq">
                            <label for="recipient-name" class="col-form-label"><strong>Motivo Cese de funciones</strong></label>
                            <div class="input-group-prepend">
                                <textarea class="form-control rounded" name="motivobloqueo" id="motivobloqueo" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button class="btn btn-primary" id="guardar"><i class="fa fa-check-square-o"></i> Guardar</button>
                </div>
            </form>
        </div>
    </div> 
</div>

@endsection

@section('javascript')

    <script>
        $(document).ready(function(){
            $('.dataTables-Fichas').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ListadoFichas'},
                    {extend: 'pdf', title: 'ListadoFichas'},

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

    </script>

    <script type="text/javascript">

        function mostrarmodalbloqueo(idficha,nombre,apellidopaterno,apellidomaterno){
            var nombreagente = nombre+' '+apellidopaterno+' '+apellidomaterno;
            $('#idfichabloq').val(idficha);
            $('#nombreap').html(nombreagente);
            $.ajax({
            // envia informacion a DB
                type:"GET",
                url:"/participacion_actuallistado/"+idficha,
                success: function(response){
                    $('#participacionbloq').val(response);
                },
                error: function(error){
                    console.log(error);
                    alert("Hay un Error");
                }
            });
            $('#Modalbloquearap').modal('show');
        
        }

        $('#formbloqueo').on('submit', function (e){
            e.preventDefault();
            var motivobloqueo =$('#motivobloqueo').val();
            var mensajeparticipacion=$('#participacionbloq').val();

            if(motivobloqueo== null || motivobloqueo=="")
            {
                swal("Error!", "Debe ingresar un motivo", "error");
            }
            else{
                swal({
                title: "¿Está seguro que desea finalizar el servicio de este Agente?",
                text: mensajeparticipacion,
                type: "warning",
                showCancelButton: true,
                cancelButtonText: "Cancelar",
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Continuar",
                closeOnConfirm: false
                },
                function (isConfirm) {
                    if(isConfirm){
                            $.ajax({
                        // envia informacion a DB
                            type:"POST",
                            url:"/bloqueoAgenteL",
                            data: $('#formbloqueo').serialize(),
                            success: function(response){
                                console.log(response);
                                $('#Modalbloquearap').modal('hide');
                                window.location.reload();
                                },
                            error: function(error){
                                console.log(error);
                                alert("Hay un Error");
                            }
                         });
                    }else{
                        swal("Atención.","El Agente Pastoral no ha sido Cancelado.","error");
                    }
                });
            }
        });    
    </script>

@endsection