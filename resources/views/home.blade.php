@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')
@include('ValidaNotificacion') 
    <header class="content__title">
        <h1><a href="{{asset('home')}}" style="color: #000000">@include('layouts.urSeleccionada') / INICIO </a></h1>
    </header>

   <div class="row">
        <div class="col-md-4">
            <div class="ibox ">
                <div class="ibox-title text-center">
                    <h1>Mi parroquia</h1>
                    <p class="font-bold">Actualizar datos de parroquia</p>
                </div>
                <div class="ibox-content">
                    <div class="lightBoxGallery">
                        <img name="imgPa"  id="imgPa" class="d-block w-100" src="{{asset ($urlImagen)}}" alt="Tu imagen" />
                    </div>
                    <br>
                    <div>
                        <ul style="list-style:none;">
                            @foreach($parroco as $p)
                                <li><strong>Parroco: </strong>{{' '.trim($p->PENombre). ' '.trim($p->PEApellidos)}}</li>
                            @endforeach
                            @foreach($institucion as $i)
                                <li><strong>Teléfono: </strong>{{' '.$i->INTelefono}}</li>
                                <li><strong>Email: </strong>{{' '.$i->INEmail}}</li>  
                            
                            @endforeach
                            <strong>Horario de Atención: </strong>
                                <li>{{$institObser[0]->IBObserv}}</li>
                            
                        </ul>
                    </div>
                    <div class="text-center">
                        <a href="{{asset('/informacion/update/'.$institu.'/edit')}}" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Actualizar</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
                <div class="ibox">
                    <div class="ibox-content">
                        <div id="calendar"></div>
                    </div>
                </div>

        </div>
    </div>
    <br>
    <div class="wrapper wrapper-content">
        <div class="row">
            <!-- CAPILLAS -->
            @php($contador=0)
            @foreach($infoCapilla as $ic)
            <div class="col-md-4">
                <div class="ibox-title text-center">
                    <h3 style="list-style:none;"><li>Capilla {{ $ic->INNombre }}</li></h3>
                    <p class="font-bold"></p>
                </div>
                <div class="ibox-content">
                    <ul style="list-style:none;">
                        <li><strong>Dirección: </strong>{{ $ic->INDireccion }}</li>
                        <li><strong>Telefono: </strong>{{ $ic->INTelefono }}</li>
                        <li><strong>H. Atención: </strong>{{$institObser[0]->IBObserv}}</li>
                    </ul>
                    <div class="text-center">
                        <a class="btn btn-xs btn-warning" href="{{asset('/capilla/update/'.$ic->INCodigo.'/edit')}}"><i class="fa fa-pencil"></i> Actualizar</a>
                    </div>
                </div>
            </div>
            @php($contador++)
            @if($contador%3 == 0)
            </div>
            <br>
            <br>
            <div class="row">
            @endif
            @endforeach 
        </div>
    </div>

    <!-- Modal Horarios-->
    <div class="modal fade inmodal " id="ModalHorariosPa" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <h3 class="modal-title" id="staticBackdropLabel"><Strong><i class="fa fa-calendar-plus-o"></i> Horarios de Eventos </Strong></h3>
                </div>

                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label"><strong>Observación</strong></label>
                            <div class="input-group-prepend">
                                <textarea type="text" class="form-control rounded" name="mo" id="mo"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <label for="recipient-name" class="col-md-12"><strong>Seleccione Horario de Evento</strong></label>
                            <div class="col-md-4" style="padding-right: 0px;">
                                <label for="recipient-name" class="col-form-label">Fecha Inicio</label>
                                <input type="text" name="fechaInicio" id="fechaInicio"class="form-control rounded" disabled>
                            </div>
                            <div class="col-md-5">
                                <label for="recipient-name" class="col-form-label">Fecha Termino</label>
                                <input type="date" name="fechaTermino" id="fechaTermino" class="form-control rounded" min="{{date('Y-m-d')}}">
                            </div>   
                            <div class="col-md-3" style="padding-left: 0px;">
                                <label for="recipient-name" class="col-form-label">Hora</label>
                                <input type="time" name="horaMisa" id="horaMisa" class="form-control rounded">
                            </div>                            
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label"><strong>Seleccione Tipo de Evento</strong></label>
                            <div class="input-group-prepend">
                                <select class="form-control m-b rounded" name="misa" id="misa">
                                    <option value="{{ null }}">--Tipo de Evento-- </option>
                                        @foreach ($misas as $m)
                                            <option value="{{ $m->MAP_IdTipoMisa }}">{{ $m->MAP_DescripcionMisa }}</option>    
                                        @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="d-none"><input type="text" id="id"></div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button class="btn btn-success" id="guardar"><i class="fa fa-floppy-o"></i> Guardar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    
                </div>
            </div>
        </div> 
    </div>
    <!--Fin Modal Horarios-->

     <!-- Modal Horarios Eliminar-->
     <div class="modal fade inmodal " id="ModalHorariosPaEliminar" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content animated bounceInRight">
                <div class="modal-header">
                    <h3 class="modal-title" id="staticBackdropLabel"><Strong><i class="fa fa-calendar-plus-o"></i> Horarios de Eventos </Strong></h3>
                </div>

                <div class="modal-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label"><strong>Observación</strong></label>
                            <div class="input-group-prepend">
                                <textarea type="text" class="form-control rounded" name="mo_eliminar" id="mo_eliminar" disabled></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="row">
                            <label for="recipient-name" class="col-md-12"><strong>Seleccione Horario de Evento</strong></label>
                            <div class="col-md-4" style="padding-right: 0px;">
                                <label for="recipient-name" class="col-form-label">Fecha Inicio</label>
                                <input type="text" name="fechaInicio_eliminar" id="fechaInicio_eliminar"class="form-control rounded" disabled>
                            </div>
                            <div class="col-md-5">
                                <label for="recipient-name" class="col-form-label">Fecha Termino</label>
                                <input type="text" name="fechaTermino_eliminar" id="fechaTermino_eliminar" class="form-control rounded" disabled>
                            </div>   
                            <div class="col-md-3" style="padding-left: 0px;">
                                <label for="recipient-name" class="col-form-label">Hora</label>
                                <input type="time" name="horaMisa_eliminar" id="horaMisa_eliminar" class="form-control rounded" disabled>
                            </div>                            
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label"><strong>Seleccione Tipo de Evento</strong></label>
                            <div class="input-group-prepend">
                                <select class="form-control m-b rounded" name="misa_eliminar" id="misa_eliminar">
                                        @foreach ($misas as $m)
                                            <option value="{{ $m->MAP_IdTipoMisa }}" disabled>{{ $m->MAP_DescripcionMisa }}</option>    
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button class="btn btn-danger mr-auto" id="eliminar"><i class="fa fa-trash-o"></i> Eliminar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    
                </div>
            </div>
        </div> 
    </div>
    <!--Fin Modal Horarios Eliminar-->


@endsection
@section('javascript')
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'bootstrap' ],
            themeSystem: 'bootstrap',
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            views: {
                dayGridMonth: {
                    titleFormat: {
                        year: 'numeric',
                        month: 'long', 
                        day: 'numeric'
                    }
                }
            },    
            defaultDate: Date.now(),
            dateClick:function(info){

                limpiar();
                $('#fechaInicio').val(info.dateStr);
                $('#guardar').prop("disabled",false);

                $('#ModalHorariosPa').modal();
            },
            eventClick:function(info){
                console.log(info.event.end);
                $('#eliminar').prop("disabled",false);
                $('#misa_eliminar').val(info.event.extendedProps.MAP_IdTipoMisa);
                $('#id').val(info.event.extendedProps.MAP_IdMisa);

                mes = (info.event.start.getMonth()+1);
                mes = (mes<10)?"0"+mes:mes;
                dia = (info.event.start.getDate());
                dia = (dia<10)?"0"+dia:dia;
                anio = (info.event.start.getFullYear());

                mes_termino = (info.event.end.getMonth()+1);
                mes_termino = (mes_termino<10)?"0"+mes_termino:mes_termino;
                dia_termino = (info.event.end.getDate());
                dia_termino = (dia_termino<10)?"0"+dia_termino:dia_termino;
                anio_termino = (info.event.end.getFullYear());
                
                minutos = (info.event.start.getMinutes());
                minutos = (minutos<10)?"0"+minutos:minutos;
                hora = (info.event.start.getHours());
                hora = (hora<10)?"0"+hora:hora;

                horario = (hora+":"+minutos);

                $('#fechaInicio_eliminar').val(dia+"-"+mes+"-"+anio);
                $('#horaMisa_eliminar').val(horario);
                $('#fechaTermino_eliminar').val(dia_termino+"-"+mes_termino+"-"+anio_termino);
                $('#mo_eliminar').val(info.event.title);
                $('#ModalHorariosPaEliminar').modal();
                
            },
            events:"{{ url('ajax/informacion/'.$institu) }}"
        });
        calendar.setOption('locale', 'es');
        calendar.render();
        
        
        $('#guardar').click(function(){
            objEvento=capturandoDatos("POST");
            if(objEvento == 1){
                swal("Error", 'Faltan datos por ingresar!', "error");
            }
            else{
                enviandoDatos('/',objEvento);
            }
        });
        $('#eliminar').click(function(){
            objEvento=capturandoDatos("GET");
            enviandoDatos('/informacion/eliminar/'+$('#id').val(),objEvento);
        });

        function capturandoDatos(method){
            fechahora_termino = $('#fechaTermino').val();
            fechahora_termino = fechahora_termino+" 23:59:00";
            nuevoHorario={
                INCodigo:{{$institu}},
                MAP_IdTipoMisa:$('#misa').val(),
                MAP_Fecha_Hora_Inicio:$('#fechaInicio').val()+" "+$('#horaMisa').val(),
                MAP_Fecha_Termino: fechahora_termino,
                MAP_Modalidad:$('#mo').val(),
                '_token':$("meta[name='csrf-token']").attr("content"),
                '_method':method
            }
            if($('#mo').val() == "" && method == 'POST'){
                return 1; // validación para identificar que falta ese dato
            }
            else{
                return (nuevoHorario);
            }
        }
        function enviandoDatos(accion,objEvento){
            $.ajax(
                {
                    // envia informacion a DB
                    type:"POST",
                    url:"{{ url('/')}}"+accion,
                    data:objEvento,
                    success:function(msg){
                        console.log(msg);
                        // cierra modal y actualiza calendario con el evento agregado
                        if(accion == '/'){
                            $('#ModalHorariosPa').modal('toggle');
                            swal("Correcto", 'El evento ha sido ingresado correctamente!', "success");
                        }
                        else{
                            $('#ModalHorariosPaEliminar').modal('toggle');
                            swal("Correcto", 'El evento ha sido eliminado correctamente!', "success");
                        }
                        calendar.refetchEvents();
                        },
                    error:function(){swal("Error", 'Faltan datos por ingresar!', "error");}

                }
            );
        }
        function limpiar(){
            $('#misa').val("");
            $('#id').val("");
            $('#fechaInicio').val("");
            $('#horaMisa').val("");
            $('#fechaTermino').val("");
            $('#mo').val("");
        }
    });
</script>
@endsection