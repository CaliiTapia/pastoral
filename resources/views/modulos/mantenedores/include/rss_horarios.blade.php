
<script type="text/javascript">
    function eliminar(id){
        $('#ModalEliminarHorarios').modal('show');

        $('#formEliminar').on('submit', function (e){
            e.preventDefault();

            $.ajax({
                // envia informacion a DB
                type:"GET",
                url:"/horaeliminar/"+id,
                data: $('#formEliminar').serialize(),
                success: function(response){
                    console.log(response);
                    // cierra modal y actualiza calendario con el evento agregado
                    $('#ModalEliminarHorarios').modal('hide');
                    document.getElementById(id).remove();

                    //location.reload();
                    },
                error: function(error){
                    console.log(error);
                    alert("Hay un Error");
                }
            });
        });
    }

    function guardar_misa(){
        var diamisa = $('#diaAgre').val(); 
        var horamisa = $('#horaAgre').val(); 
        var obsmisa = $('#descripcionAgre').val(); 
        var instimisa = $('#institu').val(); 

        if(diamisa != "" || horamisa != "" || obsmisa != ""){

            var parametros = {
                "diaAgre" : diamisa,
                "horaAgre" : horamisa,
                "descripcionAgre" : obsmisa,
                "institu" : instimisa,
                "_token" : "{{ csrf_token() }}" 
        };
        $.ajax({
            // envia informacion a DB
            type:"POST",
            url:"/hora",
            data: parametros,
            success: function(response){
                console.log(response);
                // cierra modal y actualiza calendario con el evento agregado
                $('#ModalAgregarHorarios').modal('hide');
                swal("Correcto", "Misa Agendada ", "success");
                window.location.reload();
                },
            error: function(error){
                console.log(error);
                alert("Hay un Error");
            }
        });
        }
        else {
            swal("Error!", "Faltan datos por ingresar ", "error");
        }

    }
    function limpiar(){
        $('#diaAgre').val("");
        $('#horaAgre').val("");
        $('#descripcionAgre').val("");
    }
</script>

<script type="text/javascript">
    function editar(id){
        $('#ModalEditarHorarios').modal('show');
        let descripcion = document.getElementById('descripcion');
        let hora = document.getElementById('hora');
        let tipo = document.getElementById('dia');
        $.ajax({
            // Consulta informacion desde DB
            type:"GET",
            url:"/get/horario/"+id,
            success: function(response){
                descripcion.value = response.MAP_Observacion;
                hora.value = response.MAP_Hora;
                tipo.value = response.MAP_IdTipoDia;
            },
            error: function(error){
                console.log(error);
            }
        });

        $('#ModalEditarHorarios').on('submit', function (e){
            e.preventDefault();

            $.ajax({
                // envia informacion a DB
                type:"PUT",
                url:"/horaactualizar/"+id,
                data: $('#formEditar').serialize(),
                success: function(response){
                    // cierra modal y actualiza calendario con el evento agregado
                    $('#ModalEditarHorarios').modal('hide');
                    location.replace(location.href + 'tab-2');
                    window.location.reload();
                    },
                error: function(error){
                    console.log(error);
                }
            });
        });
    }
</script>

<div class="panel-body" id="tabs-2">  
    <div class="wrapper wrapper-content  animated fadeInRight espacio">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox-title encabezado_box">
                    <h5><strong>HORARIOS MISAS</strong></h5>
                    <div class="ibox-tools">
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalAgregarHorarios"><i class="fa fa-plus"></i> Agregar Horarios</button>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="col-md-13">
                        <div class="widget navy-bg no-padding text-center">
                            <div class="p-m">
                                <h2 class="font-bold">Horarios Atención</h2>
                                @foreach ($institObser as $obser)
                                    <h3>{{ $obser->IBObserv }}</h3>
                                @endforeach
                            </div>
                        </div>
                    </div>    

                    <table class="table table-striped horarios" id="horarios">
                        <thead style="background: #c6c6c6;">
                            <tr>
                                <th>Lunes</th>
                                <th>Martes</th>
                                <th>Miércoles</th>
                                <th>Jueves</th>
                                <th>Viernes</th>
                                <th>Sábado</th>
                                <th>Domingo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @forelse($lunes as $lun)
                                        <div id="{{$lun->MAP_IdHorario}}">
                                            {{ $lun->MAP_Hora.' '.$lun->MAP_Observacion}}
                                            <div class="m-t-xs btn-group">
                                                <a class="btn btn-xs btn-outline-danger" onclick="eliminar({{$lun->MAP_IdHorario}})" href="#">Eliminar</a>
                                                <a class="btn btn-xs btn-outline-primary" onclick="editar({{$lun->MAP_IdHorario}})" href="#">Editar </a>
                                            </div>
                                        </div>
                                        <br>
                                        @empty
                                    @endforelse
                                </td>
                                <td>
                                    @forelse($martes as $mar)
                                        <div id="{{$mar->MAP_IdHorario}}">
                                            {{ $mar->MAP_Hora.' '.$mar->MAP_Observacion}}
                                            <div class="m-t-xs btn-group">
                                                <a class="btn btn-xs btn-outline-danger" onclick="eliminar({{$mar->MAP_IdHorario}})" href="#">Eliminar</a>
                                                <a class="btn btn-xs btn-outline-primary" onclick="editar({{$mar->MAP_IdHorario}})" href="#">Editar </a>
                                            </div>
                                        </div>
                                        <br>
                                        @empty
                                    @endforelse
                                </td>
                                <td>
                                    @forelse($miercoles as $mie)
                                        <div id="{{$mie->MAP_IdHorario}}">
                                            {{ $mie->MAP_Hora.' '.$mie->MAP_Observacion}}
                                            <div class="m-t-xs btn-group">
                                                <a class="btn btn-xs btn-outline-danger" onclick="eliminar({{$mie->MAP_IdHorario}})" href="#">Eliminar</a>
                                                <a class="btn btn-xs btn-outline-primary" onclick="editar({{$mie->MAP_IdHorario}})" href="#">Editar </a>
                                            </div>
                                        </div>
                                        <br>
                                        @empty
                                    @endforelse
                                </td>
                                <td>
                                    @forelse($jueves as $jue)
                                        <div id="{{$jue->MAP_IdHorario}}">
                                            {{ $jue->MAP_Hora.' '.$jue ->MAP_Observacion}}
                                            <div class="m-t-xs btn-group">
                                                <a class="btn btn-xs btn-outline-danger" onclick="eliminar({{$jue->MAP_IdHorario}})" href="#">Eliminar</a>
                                                <a class="btn btn-xs btn-outline-primary" onclick="editar({{$jue->MAP_IdHorario}})" href="#">Editar </a>
                                            </div>
                                        </div>
                                        <br>
                                        @empty
                                    @endforelse
                                </td>
                                <td>
                                    @forelse($viernes as $vie)
                                        <div id="{{$vie->MAP_IdHorario}}">
                                            {{ $vie->MAP_Hora.' '.$vie->MAP_Observacion}}
                                            <div class="m-t-xs btn-group">
                                                <a class="btn btn-xs btn-outline-danger" onclick="eliminar({{$vie->MAP_IdHorario}})" href="#">Eliminar</a>
                                                <a class="btn btn-xs btn-outline-primary" onclick="editar({{$vie->MAP_IdHorario}})" href="#">Editar </a>
                                            </div>
                                        </div>
                                        <br>
                                        @empty
                                    @endforelse
                                </td>
                                <td>
                                    @forelse($sabado as $sab)
                                        <div id="{{$sab->MAP_IdHorario}}">
                                            {{ $sab->MAP_Hora.' '.$sab->MAP_Observacion}}
                                            <div class="m-t-xs btn-group">
                                                <a class="btn btn-xs btn-outline-danger" onclick="eliminar({{$sab->MAP_IdHorario}})" href="#">Eliminar</a>
                                                <a class="btn btn-xs btn-outline-primary" onclick="editar({{$sab->MAP_IdHorario}})" href="#">Editar </a>
                                            </div>
                                        </div>
                                        <br>
                                        @empty
                                    @endforelse
                                </td>
                                <td>
                                    @forelse($domingo as $dom)
                                        <div id="{{$dom->MAP_IdHorario}}">
                                            {{ $dom->MAP_Hora.' '.$dom->MAP_Observacion}}
                                            <div class="m-t-xs btn-group">
                                                <a class="btn btn-xs btn-outline-danger" onclick="eliminar({{$dom->MAP_IdHorario}})" href="#">Eliminar</a>
                                                <a class="btn btn-xs btn-outline-primary" onclick="editar({{$dom->MAP_IdHorario}})" href="#">Editar </a>
                                            </div>
                                        </div>
                                        <br>
                                        @empty
                                    @endforelse    
                                </td>                     
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br/>
        <div class="row">        
            <div class="col-lg-12">
            {{ Form::open(['route' =>['parroquia.update','id' =>$institucion->INCodigo],'method' => 'PUT','enctype'=>'multipart/form-data']) }}
                <div class="ibox-title encabezado_box">
                    <h5><strong>REDES SOCIALES</strong></h5>
                    <div class="ibox-tools">
                        <button type="button" class="btn btn-success" id="habilitarRrss"><i class="fa fa-edit"></i> Editar Información</button>
                        <button type="submit" class="btn btn-primary deshabilitar" id="actualizarRrss"><i class="fa fa-check-square-o"></i> Actualizar</button>
                    </div>
                </div>
                
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <label>Pagina Web </label>
                            <div class="input-group mb-3">                        
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-rss"></i></span>
                                </div>
                                <input type="text"  name="pagina" id="pagina" class="form-control rounded deshabilitar" value="{{ trim($web->INWeb) !='' ? $web->INWeb : 'Sin Información' }}">
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label>Facebook </label>
                            <div class="input-group mb-3">                        
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-facebook"></i></span>
                                </div>
                                <input type="text"  name="fb" id="fb" class="form-control rounded deshabilitar" value="{{ trim($fb[0]->MAP_Link_Social) !='' ? $fb[0]->MAP_Link_Social: 'Sin Información'}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Instagram </label>
                            <div class="input-group mb-3">                        
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-instagram"></i></span>
                                </div>
                                <input type="text"  name="ig" id="ig" class="form-control rounded deshabilitar" value="{{ trim($ig[0]->MAP_Link_Social) !='' ? $ig[0]->MAP_Link_Social: 'Sin Información'}}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label>Twitter </label>
                            <div class="input-group mb-3">                        
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-twitter"></i></span>
                                </div>
                                <input type="text"  name="twitter" id="twitter" class="form-control rounded deshabilitar" value="{{ trim($twitter[0]->MAP_Link_Social) !='' ? $twitter[0]->MAP_Link_Social: 'Sin Información'}}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label>Youtube </label>
                            <div class="input-group mb-3">                        
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fa fa-youtube"></i></span>
                                </div>
                                <input type="text"  name="youtube" id="youtube" class="form-control rounded deshabilitar" value="{{ trim($youtube[0]->MAP_Link_Social) !='' ? $youtube[0]->MAP_Link_Social: 'Sin Información'}}">
                            </div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}  
            </div>            
        </div>
        <!-- Modal Agregar Horarios-->
        <div class="modal fade inmodal " id="ModalAgregarHorarios" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <h3 class="modal-title" id="staticBackdropLabel"><Strong><i class="fa fa-calendar-plus-o"></i>  Horarios de Misas</Strong></h3>
                    </div>
                    <form id="formAgregar">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Seleccione Día</label>
                                            <div class="input-group-prepend">
                                                <select class="form-control m-b rounded" name="diaAgre" id="diaAgre">
                                                    <option value="{{ null }}">--Dia de la Semana-- </option>
                                                        @foreach ($dia as $d)
                                                            <option value="{{ $d->MAP_IdTipoDia }}">{{ trim($d->MAP_Dia) }}</option>  
                                                        @endforeach
                                                </select>
                                            </div>
                                            <div class="d-none"><input type="text" name="institu" value="{{$institu}}" id="institu"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">Ingrese Hora</label>
                                        <input type="time" name="horaAgre" id="horaAgre" class="form-control rounded" >
                                    </div>                            
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label"><strong>Observación</strong></label>
                                    <div class="input-group-prepend">
                                        <textarea type="text" class="form-control rounded" name="descripcionAgre" id="descripcionAgre"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <input type="button" class="btn btn-success" onclick="guardar_misa();" value="guardar">                        
                        </div>
                    </form>
                </div>
            </div> 
        </div>
        <!--Fin Modal Horarios-->

        <!-- Modal EDITAR Horarios-->
        <div class="modal fade inmodal " id="ModalEditarHorarios" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <h3 class="modal-title" id="staticBackdropLabel"><Strong><i class="fa fa-calendar-plus-o"></i>  Horarios de Misas</Strong></h3>
                    </div>
                    <form id="formEditar">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Seleccione Día</label>
                                            <div class="input-group-prepend">
                                                <select class="form-control m-b rounded" name="dia" id="dia">
                                                    <option value="{{ null }}">--Dia de la Semana-- </option>
                                                        @foreach ($dia as $d)
                                                            <option value="{{ $d->MAP_IdTipoDia }}">{{ trim($d->MAP_Dia) }}</option>  
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">Ingrese Hora</label>
                                        <input type="time" name="hora" id="hora" class="form-control rounded" >
                                    </div>                            
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label"><strong>Observación</strong></label>
                                    <div class="input-group-prepend">
                                        <textarea type="text" class="form-control rounded" name="descripcion" id="descripcion"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button class="btn btn-primary" id="guardar"><i class="fa fa-check-square-o"></i> Actualizar</button>                        
                        </div>
                    </form>
                </div>
            </div> 
        </div>
        <!--Fin Modal Horarios-->

        <!-- Modal ELIMINAR Horarios-->
        <div class="modal fade inmodal" id="ModalEliminarHorarios" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><Strong><i class="fa fa-exclamation-triangle"></i> ADVERTENCIA</Strong></h5>
                    </div>
                    <form id="formEliminar">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            {{ method_field('get') }}
                            <div>
                                ¿Está Seguro que Desea Eliminar estos Datos <Strong>De Manera Permanente</Strong>?
                            </div>
                        </div>
                    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Confirmar</button>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
        <!--Fin Modal Horarios-->
    </div>
</div> 
