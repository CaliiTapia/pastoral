@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')
@include('ValidaNotificacion')
<header class="content__title">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <div>
                <div class="col-lg-10">
                    <h2> DEVELACIONES</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Agentes Pastorales</a>
                        </li>
                        <li class="breadcrumb-item">
                            <strong>Develaciones</strong>
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
                <h5><strong>LISTADO DEVELACIONES</strong></h5>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- Inicio data table -->
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-hover dataTables-Dev" id="listadodevelaciones">
                        <thead>
                            <tr>
                                <th>Rut</th>
                                <th>Notificación</th>
                                <th>Cant. Denuncias</th>
                                <th>Cant. Parroquias</th>
                                <th >Zona</th>
                                <th>Parroquia</th>
                                <th>Fecha Notificación</th>
                                <th>Estado</th>
                                <th class="ancho">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                        @php
                            $rut_apactual="";
                            $idprocesoactual=0;
                        @endphp
                        @foreach($datostabla as $d)
                            @if ($d ->MAP_IdEstado==3 or $d ->MAP_IdEstado==4)
                                @php
                                    $rut_apactual=$d->MAP_RutAP;
                                    $idprocesoactual=$d->MAP_IdProceso;
                                @endphp
                            @elseif ($d ->MAP_IdEstado==2)
                                @if ($rut_apactual == $d->MAP_RutAP and $idprocesoactual == $d->MAP_IdProceso)
                                    {{--  no muestro nada por que es el mismo proceso y rut del anterior, es decir ya esta bloqueado o activado  --}}
                                @else
                                    <tr class="gradeX">
                                        <td>{{ $d ->MAP_RutAP }}</td>
                                        <td>{{ $d ->MAP_NumeroNotificacion }}</td>
                                        <td>{{ $d ->MAP_IdProceso }}</td>
                                        <td>{{ $d ->cantparroquias }}</td>
                                        <td>{{ $d ->Nombre }}</td>
                                        <td>{{ $d ->INNombre }}</td>
                                        <td>{{ $d ->fechadenuncia }}</td>
                                        <td>{{ $d ->MAP_Descripcion }}</td>
                                        <td>
                                        <div id="{{ $d ->MAP_IdDevelacion }}" aria-label="Button group with nested dropdown">
                                        <a type="button" class="btn btn-outline btn-info" href="{{ asset('/pastoral/listado/'.$d->IdFicha.'/editD') }}">
                                                <i class="fa fa-eye" title="Ver Fichas"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline btn-primary" onclick="ver_historial({{ $d ->MAP_RutAP }},{{ $d ->MAP_IdProceso}})">
                                            <i class="fa fa-book" title="Ver Historial"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline btn-warning" onclick="nuevo_estado({{ $d ->MAP_RutAP }},{{ $d ->MAP_INCodigo }},{{ $d ->MAP_NumeroNotificacion }},
                                                {{ $d ->MAP_InZona }},'{{ $d ->MAP_FechaDenuncia }}',{{ $d ->MAP_IdProceso }},{{ $d ->IdFicha }})">
                                            <i class="fa fa-pencil-square-o" title="Cambiar Estado"></i>
                                            </button>
                                        </div>
                                        </td>
                                    </tr>  
                                    @php
                                        $rut_apactual=$d->MAP_RutAP;
                                        $idprocesoactual=$d->MAP_IdProceso;
                                    @endphp
                                @endif
                            @elseif($d ->MAP_IdEstado==1)
                                @if ($rut_apactual == $d->MAP_RutAP and $idprocesoactual == $d->MAP_IdProceso)
                                    {{--  no muestro nada por que es el mismo proceso y rut del anterior  --}}
                                @else
                                    <tr class="gradeX">
                                        <td>{{ $d ->MAP_RutAP }}</td>
                                        <td>{{ $d ->MAP_NumeroNotificacion }}</td>
                                        <td>{{ $d ->MAP_IdProceso }}</td>
                                        <td>{{ $d ->cantparroquias }}</td>
                                        <td>{{ $d ->Nombre }}</td>
                                        <td>{{ $d ->INNombre }}</td>
                                        <td>{{ $d ->fechadenuncia }}</td>
                                        <td>{{ $d ->MAP_Descripcion }}</td>
                                        <td>
                                        <div id="{{ $d ->MAP_IdDevelacion }}" aria-label="Button group with nested dropdown">
                                            <a type="button" class="btn btn-outline btn-info" href="{{ asset('/pastoral/listado/'.$d->IdFicha.'/editD') }}">
                                                <i class="fa fa-eye" title="Ver Fichas"></i>
                                            </a>
                                            <button type="button" class="btn btn-outline btn-primary" onclick="ver_historial({{ $d ->MAP_RutAP }},{{ $d ->MAP_IdProceso}})">
                                            <i class="fa fa-book" title="Ver Historial"></i>
                                            </button>
                                            <button type="button" class="btn btn-outline btn-warning" onclick="nuevo_estado({{ $d ->MAP_RutAP }},{{ $d ->MAP_INCodigo }},{{ $d ->MAP_NumeroNotificacion }},
                                                {{ $d ->MAP_InZona }},'{{ $d ->MAP_FechaDenuncia }}',{{ $d ->MAP_IdProceso }},{{ $d ->IdFicha }})">
                                            <i class="fa fa-pencil-square-o" title="Cambiar Estado"></i>
                                            </button>
                                        </div>
                                        </td>
                                    </tr>  
                                    @php
                                        $rut_apactual=$d->MAP_RutAP;
                                        $idprocesoactual=$d->MAP_IdProceso;
                                    @endphp
                                @endif
                            @endif  
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Fin data table -->
    </div>
</div>  

<div class="modal fade inmodal" id="Modalhistorial" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h5 class="modal-title" id="staticBackdropLabel"><Strong><i class="fa fa-info"></i> Información Proceso Actual</Strong></h5>
                    
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="input-group-prepend">
                                <div class="col-md-12">
                                    <textarea class="form-control rounded" rows="10" name="histo" id="histo" readonly></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tabla Historial cantidad Denuncias -->
                    <div class="col-md-12">
                        <label for="recipient-name" class="col-form-label"><strong>Historial Denuncias Anteriores</strong></label>
                        <!-- Inicio data table -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="listadodenuncias">
                                <thead>
                                    <tr>
                                        <th>Zona</th>
                                        <th>Parroquia</th>
                                        <th>Fecha Notificación</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody id="datosdenuncias">
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
            <!-- FIN Tabla Historial cantidad Denuncias -->
                </div>
            </div>
        </div> 
    </div>

  <!-- Modal Observación-->
    <div class="modal fade inmodal" id="Modalobservacion" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><Strong><i class="fa fa-pencil"></i> Cambiar Estado</Strong></h5>
                </div>
                <form id="formobservacion">
                    <div class="modal-body">
                    {{ csrf_field() }}
                        <div class="col-md-12">
                            <div class="alert alert-warning" role="alert">
                                Los estados deshabilitados ya fueron usados, por lo tanto no pueden volver a seleccionarse!
                              </div>
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label">Seleccione Estado</label>
                                <div class="input-group-prepend">
                                    <select class="form-control m-b rounded" name="estado" id="estado">
                                        <option value="{{ null }}">--Estado-- </option>
                                            @foreach ($estado as $es)
                                                <option value="{{ $es->MAP_IdTipoEstado }}" id="estado_{{ $es->MAP_IdTipoEstado }}">{{ trim($es->MAP_Descripcion) }}</option>  
                                            @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="d-none"><input type="text" name="rut" id="rut"></div>
                            <div class="d-none"><input type="text" name="zona" id="zona"></div>
                            <div class="d-none"><input type="text" name="parroquia" id="parroquia"></div>
                            <div class="d-none"><input type="text" name="nnotificacion" id="nnotificacion"></div>
                            <div class="d-none"><input type="text" name="fdenuncia" id="fdenuncia"></div>
                            <div class="d-none"><input type="text" name="idproceso" id="idproceso"></div>
                            <div class="d-none"><input type="text" name="idficha" id="idficha"></div>

                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label"><strong>Observación</strong></label>
                                <div class="input-group-prepend">
                                    <textarea class="form-control rounded" name="observacion" id="observacion"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button class="btn btn-primary" id="NuevaObservacion"><i class="fa fa-check-square-o"></i> Guardar</button>
                    </div>
                </form>
            </div>
        </div> 
    </div>
@endsection

@section('javascript')
    <script>
        $(document).ready(function(){
            $('.dataTables-Dev').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                "ordering":false,
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ListadoDev'},
                    {extend: 'pdf', title: 'ListadoDev'},

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
    $(document).ready(function () {
        limpiar();
        marcarfila(); 
    });

    function nuevo_estado(rut,parroquia,nnotificacion,zona,fdenuncia,idproceso,idficha){
        //alert(rut+' '+parroquia+' '+nnotificacion+' '+zona+' '+fdenuncia);
        habilitarestados();
        $('#rut').val(rut);
        $('#zona').val(zona);
        $('#parroquia').val(parroquia);
        $('#nnotificacion').val(nnotificacion);
        $('#fdenuncia').val(fdenuncia);
        $('#idproceso').val(idproceso);
        $('#idficha').val(idficha);
        var rut_e=rut;
        var idproceso_e=idproceso;
        @foreach  ($dev as $d)
                if(rut_e=={{$d->MAP_RutAP}} && idproceso_e=={{$d->MAP_IdProceso}}){
                    $('#estado_'+{{$d->MAP_IdEstado}}).prop( "disabled", true);

                    if({{$d->MAP_IdEstado}} == 1) // si esta ingresado 
                    {
                        $('#estado_3').prop( "disabled", true); // Se desactiva el estado bloqueado
                    }
                    else if({{$d->MAP_IdEstado}} == 2) // si esta suspendido
                    {
                        $('#estado_1').prop( "disabled", true); // Se desactiva el estado ingresado
                        $('#estado_3').prop( "disabled", false);
                    }
                    else if({{$d->MAP_IdEstado}} == 3) // si esta bloqueado
                    {
                        $('#estado_4').prop( "disabled", true);  //se desactiva el estado activado
                    }
                    else if({{$d->MAP_IdEstado}} == 4) // si esta activado
                    {
                        $('#estado_3').prop( "disabled", true); // se desactiva el estado bloqueado
                    }
                }
        @endforeach
        $('#Modalobservacion').modal('show');
    }
    $('#formobservacion').on('submit', function (e){
        e.preventDefault();
        var estado_ob =$('#estado').val();
        var observacion_ob=$('#observacion').val();

        if(estado_ob== null || estado_ob=="")
        {
            swal("Error!", "Debe ingresar un estado válido", "error");
        }
        else if(observacion_ob== null || observacion_ob.trim()=="")
        {
            swal("Error!", "Debe ingresar una observación", "error");
        }
        else{
            $.ajax({
                // envia informacion a DB
                type:"POST",
                url:"/estado",
                data: $('#formobservacion').serialize(),
                success: function(response){
                    console.log(response);
                    $('#Modalobservacion').modal('hide');
                    window.location.reload();
                    },
                error: function(error){
                    console.log(error);
                    alert("Hay un Error");
                }
            });
        }
    });     
    function limpiar(){
        $('#estado').val("");
        $('#observacion').val("");
    }
    //para dejar la fila seleccionada marcada.
    function marcarfila(){
    $('#listadodevelaciones tr').on('click', function() {  
        $('tr').removeClass('seleccionado');
       $(this).toggleClass('seleccionado');
      });
    }

    function habilitarestados(){
        @foreach($estado as $es)
            $('#estado_'+{{$es->MAP_IdTipoEstado}}).prop( "disabled", false);
        @endforeach
    }

</script>

<script type="text/javascript"> 
    
    function ver_historial(rut, idproceso){
        
        $.ajax({
            type:"GET",
            url:"/ver_nuevohistorial/"+rut +"/"+idproceso,
            success: function(response){ 
                var arreglohistorial = JSON.parse(response);
                console.log(arreglohistorial); 
                
                var textareahistorial="";
                var tablahistorial="";
                var procesoactual=0;
                var procesofor=0;
                var idproceso_ahora = idproceso;
                for(var x=0;x<arreglohistorial.length;x++){
                    procesofor=arreglohistorial[x].MAP_IdProceso; //le asignamos el id proceso del for
                  
                    if(idproceso_ahora==procesofor ){ //si el idproceso del for es igual al idproceso actual
                        fecha_creat=arreglohistorial[x].fechacreated;
                        fecha_denuncia=arreglohistorial[x].fechadenuncia;
    
                        textareahistorial+="Fecha: "+fecha_creat+" - Usuario: "+arreglohistorial[x].NombreUsuario+" - Estado: "+arreglohistorial[x].MAP_Descripcion+" - Comentario: "+arreglohistorial[x].MAP_Observacion+"\n";
                        
                    } else if (idproceso_ahora != procesofor){ //si el idproceso actual es diferente del idproceso for 
                        if(arreglohistorial[x].MAP_IdEstado ==4 || arreglohistorial[x].MAP_IdEstado ==3){
                            fecha_creat=arreglohistorial[x].fechacreated;
                            fecha_denuncia=arreglohistorial[x].fechadenuncia;
                            tablahistorial+='<tr><td>'+arreglohistorial[x].Nombre+'</td>';
                            tablahistorial+='<td>'+arreglohistorial[x].INNombre+'</td>';
                            tablahistorial+='<td>'+fecha_denuncia+'</td>';
                            tablahistorial+='<td>'+arreglohistorial[x].MAP_Descripcion+'</td></tr>';
                        }
                    }
                }
                histo.value= textareahistorial;
                $('#datosdenuncias').html(tablahistorial);
                $('#Modalhistorial').modal('show');
            },
            error: function(error){
                console.log(error);
            }
        });
    }
</script>
@endsection