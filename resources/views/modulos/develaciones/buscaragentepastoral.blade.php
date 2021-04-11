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
                            <strong>Busqueda AP</strong>
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
                <h5><strong>BUSQUEDA DE AGENTE PASTORAL</strong></h5>
            </div>
        </div>
    </div>
    <div class="ibox-content ">
        {{ Form::open(['route' => 'agentes', 'method' => 'GET'])}}
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label><b>Rut/Pasaporte</b></label>
                        {{ Form::text('NumeroDocumento', null, ['class' => 'form-control rounded'])}}
                        <small>Sin puntos ni dígito verificador</small>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label><b>Apellido Paterno</b></label>
                        {{ Form::text('ApellidoPaterno', null, ['class' => 'form-control rounded'])}}
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label><b>Apellido Materno</b></label>
                        {{ Form::text('ApellidoMaterno', null, ['class' => 'form-control rounded'])}}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label><b>Zona</b></label>
                        <select class="form-control select2 rounded" name="IdZona" id="Zona">
                            <option value="{{ null }}">--Seleccionar Zona--</option>
                            @foreach ($zona as $z)
                                <option value="{{ $z->IdZona }}">{{ trim($z->Nombre) }}</option>  
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <label><b>Parroquia</b></label>
                        <select class="form-control select2 rounded" name="INCodigo" id="Parroquia">
                            <option value="{{ null }}">--Seleccionar Parroquia--</option>
                        </select>
                    </div>
                </div>
                </br>
                <div>
                    <div class="form-group col-1">
                        <button type="submit" class="btn btn-success" id="buscardato">Buscar</button>
                    </div>
                </div>
            </div>
        {{ Form::close() }}
        <div class="row">
            <div class="col-md-12">
                <!-- Inicio data table -->
                    <div class="table-responsive">
                        <table class="footable table table-striped table-hover" id="buscarAp">
                            <thead>
                                <tr>
                                    <th>Rut</th>
                                    <th>Nombre</th>
                                    <th>Apellido Paterno</th>
                                    <th>Apellido Materno</th>
                                    <th>Zona</th>
                                    <th>Parroquia</th>
                                    <th>Estado</th>
                                    <th>Motivo</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="datostabla">
                                @foreach($agente as $f)
                                    <tr  class="gradeX">          
                                        <td>{{ $f->NumeroDocumento.'-'.$f->Dv}}</td>
                                        <td>{{ $f->Nombre }}</td>
                                        <td>{{ $f->ApellidoPaterno }}</td>
                                        <td>{{ $f->ApellidoMaterno }}</td>
                                        <td>{{ $f->Nom }}</td>
                                        <td>{{ $f->INNombre }}</td>
                                        <td>{{$f->MAP_Estado === 1 ? 'Activo' : 'Inactivo'}}</td>
                                        <td>
                                        @foreach($motivo as $m)
                                            @if($m->MAP_B_IdFicha == $f->IdFicha && $m->MAP_B_INCodigo == $f->INCodigo)
                                                {{trim($m->MAP_B_ValorModificado)}}
                                            @endif 
                                        @endforeach
                                        </td>
                                        <td> 
                                            <div aria-label="Button group with nested dropdown">
                                            <a class="btn btn-outline btn-info" href="{{ asset('/pastoral/listado/'.$f->IdFicha.'/editD') }}"><i class="fa fa-eye" title="Ver Fichas"></i></a> 
                                                @can('dev_iniciar_proceso_develcion')
                                                    @if($f->MAP_Estado === 1)
                                                        <a class="btn btn-outline btn-warning" onclick="iniciarDev({{ $f->IdFicha }},{{ $f->NumeroDocumento }},{{ $f->INCodigo }},{{ $f->IdZona }})" href="#"><i class="fa fa-exclamation-triangle" title="Inicio Develación"></i></a>
                                                    @elseif($f->MAP_Estado === 0)
                                                        <a class="btn btn-outline btn-warning" title="Inicio Develación" disabled><i class="fa fa-exclamation-triangle" title="Inicio Develación"></i></a> 
                                                    @endif
                                                @endcan
                                                @if($f->MAP_Estado === 1)
                                                    <button class="btn btn-outline btn-danger" onclick="mostrarmodalbloqueo({{$f->IdFicha}},'{{ $f ->Nombre }}','{{ $f ->ApellidoPaterno }}','{{ $f ->ApellidoMaterno }}',{{ $f->INCodigo }})" title="Cese servicios">
                                                    <i class="fa fa-ban"></i>
                                                @elseif($f->MAP_Estado === 0)                                                
                                                    <a class="btn btn-outline btn-primary" onclick="mostrarmodalAct({{$f->IdFicha}},{{$f->INCodigo}},'{{ $f ->Nombre }}','{{ $f ->ApellidoPaterno }}','{{ $f ->ApellidoMaterno }}')" href="#"><i class="fa fa-check" title="Activar"></i></a> 
                                                @endif
                                            </div>
                                        </td>                                        
                                    </tr>                                
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="9">
                                        <ul class="pagination float-left"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                <!-- Fin data table -->
        </div>
    </div>
    <!-- Modal Develacion-->
    <div class="modal fade inmodal" id="ModalDevelacion" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel"><Strong><i class="fa fa-exclamation"></i> Inicio Proceso Develación</Strong></h5>
                </div>
                <form id="formDevelacion">
                    <div class="modal-body">
                    {{ csrf_field() }}
                        <div class="col-md-12">
                            <div class="d-none"><input type="text" name="id" id="id"></div>
                            <div class="d-none"><input type="text" name="ruti" id="ruti"></div>                            
                            <div class="d-none"><input type="text" name="parroquia" id="parroquia"></div>
                            <div class="d-none"><input type="text" name="zona" id="zona"></div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label"><strong>Añadir Observación</strong></label>
                                <div class="input-group-prepend">
                                    <textarea class="form-control rounded" name="observacionDev" id="observacionDev" placeholder="Escribe una Breve Observación (Opcional)"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-warning"><i class="fa fa-exclamation-triangle"></i> Iniciar Proceso Develación</button>
                    </div>
                </form>
            </div>
        </div> 
    </div>

    <!-- Modal Bloqueo-->
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
                                <input type="hidden" name="parroquiabloq" id="parroquiabloq">
                                <input type="hidden" name="vista" id="vista" value="1"><!-- variable que indica que es la vista buscar agente pastoral-->
                                <input type="hidden" name="mot" id="mot" value="1"> 
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

    <!-- Modal Activación-->
    <div class="modal fade inmodal" id="ModalActivacionAp" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <h4 class="modal-title" id="staticBackdropLabel"><Strong><i class="fa fa-pencil"></i> Activar Agente Pastoral</Strong></h4>
                    <label id="nombre"> </label>
                </div>
                <form id="formActivar">
                    <div class="modal-body">
                    {{ csrf_field() }}
                        <div class="col-md-12">
                            <div class="form-group">
                                <input class="d-none" name="idficha" id="idficha">
                                <input class="d-none" name="idparroquia" id="idparroquia">
                                <input class="d-none" name="vista" id="vista" value="0">
                                <input class="d-none"  name="mot" id="mot" value="1"> 
                                <label for="recipient-name" class="col-form-label"><strong>Motivo Activación</strong></label>
                                <div class="input-group-prepend">
                                    <textarea class="form-control rounded" name="motivo" id="motivo" rows="4"></textarea>
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

</div>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {

        $('.footable').footable();

    });
</script>

<script>
    $(document).ready(function() {
        $("#Zona").change(function(event){
            $.get("/buscar/"+event.target.value+"",function(response,state){
                $("#Parroquia").empty();
                for (i = 0; i < response.length; i++) {
                    $("#Parroquia").append("<option value='"+response[i].INCodigo+"'>"+response[i].INNombre+"</option>");
                }
            });
        });
    });

</script>

<script>
    $(document).ready(function () {
        limpiar();
        marcarfila(); 
    });
    function iniciarDev(id,ruti,parroquia,zona){
        $('#id').val(id);
        $('#ruti').val(ruti);
        $('#parroquia').val(parroquia);
        $('#zona').val(zona);

        $('#ModalDevelacion').modal('show');


        $('#ModalDevelacion').on('submit', function (e){
            e.preventDefault();

            $.ajax({
                url:"Ajax/iniciar/"+id,
                type:"POST",
                data: $('#formDevelacion').serialize(),
                success: function(response){
                    $('#ModalDevelacion').modal('hide');
                    console.log(response);
                    window.location.reload();
                    },
                error: function(error){
                    console.log(error);
                    alert("Hay un Error en el post");
                }
            }); 
        }); 
    }
    function limpiar(){
        $('#observacionDev').val("");
    }

    function marcarfila(){
    $('#buscarAp tr').on('click', function() {  
        $('tr').removeClass('seleccionado');
       $(this).toggleClass('seleccionado');
      });
    }

</script>

<script type="text/javascript">
    function mostrarmodalbloqueo(idficha,nombre,apellidopaterno,apellidomaterno,incodigo){
        var nombreagente = nombre+' '+apellidopaterno+' '+apellidomaterno;
        $('#idfichabloq').val(idficha);
        $('#parroquiabloq').val(incodigo);
        $('#nombreap').html(nombreagente);
        $.ajax({
        // envia informacion a DB
            type:"GET",
            url:"/participacion_actual/"+idficha+"/"+incodigo,
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
                        url:"/bloqueoAgente",
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

<script type="text/javascript">
    $(document).ready(function () {
        limpiar();
    });

    function mostrarmodalAct(idficha,incodigo,nombre,apellidopaterno,apellidomaterno){
        var nombre = nombre+' '+apellidopaterno+' '+apellidomaterno;
        $('#idficha').val(idficha);
        $('#idparroquia').val(incodigo);
        $('#nombre').html(nombre);
        $('#ModalActivacionAp').modal('show');    
    }

    $('#formActivar').on('submit', function (e){
        e.preventDefault();
        var motivoactivacion =$('#motivo').val();

        if(motivoactivacion== null || motivoactivacion=="")
        {
            swal("Error!", "Debe ingresar un motivo", "error");
        }
        else{
            swal({
            title: "¿Está seguro que desea activar a este Agente?",
            text: "",
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
                        url:"/activarAgente",
                        data: $('#formActivar').serialize(),
                        success: function(response){
                            console.log(response);
                            $('#ModalActivacionAp').modal('hide');
                            window.location.reload();
                            },
                        error: function(error){
                            console.log(error);
                            alert("Hay un Error");
                        }
                     });
                }else{
                    swal("Atención.","El Agente Pastoral no ha sido activado.","error");
                    delay(2000);
                }
            });
        }
    }); 
    function limpiar(){
        $('#motivo').val(" ");
    }  
</script>
@endsection