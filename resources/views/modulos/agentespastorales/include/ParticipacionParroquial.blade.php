<div class="panel-body" id="panelParticipacion">

    <input type="text" name="" value="{{ $ficha->IdFicha }}" id="IdFicha" hidden>

    <div class="ibox-title espacio_encabezado">
        <h5>Historial Participación Parroquial</h5>
        @can('ap_crear_participacion')
        <div class="ibox-tools encabezado_tabs">
            <button data-toggle="modal" data-target="#ModalAgregarHistorial" type="button" class="btn btn-success btn_encabezado">Agregar</button>
        </div>
        @endcan
    </div>

    <!-- Modal Agregar Historial-->
    <div class="modal fade" id="ModalAgregarHistorial" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="#" v-on:submit.prevent="postCrearParticipacion">
                <div class="modal-header d-block">
                    <div class="d-flex">
                        <h3 class="modal-title" id="staticBackdropLabel">Agregar Nuevo Servicio Pastoral</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <small class="modal-title"> Campos obligatorios (*)</small>
                </div>

                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label"><strong>Parroquia</strong></label>
                                <div class="input-group-prepend">
                                    <select class="form-control m-b" name="account" v-model="nuevaParticipacion.MAP_I_INCodigo" readonly>
                                        <option  v-for="institucion in instituciones" :value="institucion.INCodigo">
                                            @{{ institucion.INNombre }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" v-show="capillas.find(capilla => capilla.INCodigo != null)">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label"><strong>Capilla </strong></label>
                                <div class="input-group-prepend">
                                    <select class="form-control m-b " name="account" v-model="nuevaParticipacion.MAP_I_INCodigoCapilla" readonly>
                                    <option value="" selected disabled>Seleccione una opción</option>
                                    <option value="0">Participación en parroquia</option>
                                        <option v-for="capilla in capillas" :value="capilla.INCodigo">
                                            @{{ capilla.INNombre }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="display:none;">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label"><strong>Zona</strong></label>
                                <div class="input-group-prepend">
                                    <select class="form-control m-b " name="account" v-model="nuevaParticipacion.MAP_Z_IdZona" readonly>
                                        <option v-for="zona in zonas" :value="zona.IdZona">
                                            @{{ zona.Nombre }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label"><strong>Area Pastoral <small>(*)</small></strong></label>
                                <div class="input-group-prepend">
                                    <select class="form-control " name="account" @change="seleccionaAreaIngreso()" v-model="nuevaParticipacion.MAP_A_IdArea" required>
                                        <option value="" disabled selected>Seleccione una opción</option>
                                        <option v-for="area in areas" :value="area.MAP_IdArea">
                                            @{{ area.MAP_Descripcion }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="recipient-name" class="col-form-label"><strong>Servicio Pastoral <small>(*)</small></strong></label>
                                <div class="input-group-prepend">
                                    <select class="form-control m-b" name="account" v-model="nuevaParticipacion.MAP_C_IdCargo" required>
                                        
                                        <option value="" disabled selected>Seleccione una opción</option>
                                        <option v-for="cargo in cargos" :value="cargo.MAP_IdCargo">
                                            @{{ cargo.MAP_Descripcion }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                            <label for="recipient-name" class="col-md-12"><strong>Período</strong></label>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Inicio <small>(*)</small></label>
                                        <div class="input-group-prepend">
                                            <input type="date" class="form-control" v-model="nuevaParticipacion.MAP_FechaInicio" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="recipient-name" class="col-form-label">Termino</label>
                                        <div class="input-group-prepend">
                                            <input type="date" class="form-control" v-model="nuevaParticipacion.MAP_FechaTermino">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Cambios</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="ibox-content">
        <table class="table table-striped">
            <thead style="background: #c6c6c6;">
            <tr>
                <th>Parroquia</th>
                <th>Capilla</th>
                <th>Zona</th>
                <th>Area Pastoral</th>
                <th>Servicio Pastoral</th>
                <th>Período</th>
                @can('ap_modificar_participacion')
                <th>Acciones</th>
                @endcan
            </tr>
            </thead>
            <tbody>
            <tr v-for="participacion in participaciones">
                <td>@{{ participacion.institucion.INNombre }}</td>
                <td>@{{ participacion.capilla ? participacion.capilla.INNombre : 'Participa en parroquia' }}</td>
                <td>@{{ participacion.zona.Nombre }}</td>
                <td>@{{ participacion.area.MAP_Descripcion }}</td>
                <td>@{{ participacion.cargo.MAP_Descripcion }}</td>
                <td>@{{ participacion.MAP_FechaInicio.substr(8,2) }}/@{{ participacion.MAP_FechaInicio.substr(5,2) }}/@{{ participacion.MAP_FechaInicio.substr(0,4) }}-<div v-if="participacion.MAP_FechaTermino">@{{ participacion.MAP_FechaTermino.substr(8,2) }}/@{{ participacion.MAP_FechaTermino.substr(5,2) }}/@{{ participacion.MAP_FechaTermino.substr(0,4) }}</div></td>
                @can('ap_modificar_participacion')
                <td  class="acciones">
                    <button v-show="instituciones.find(institucion => institucion.INCodigo === participacion.institucion.INCodigo)"
                            v-on:click.prevent="editarParticipacion(participacion)" 
                            data-toggle="modal" data-target="#ModalEditar" class="btn btn-outline btn-success" type="button">
                            <i class="fa fa-pencil-square-o" title="Editar"></i>
                    </button>
                    <button v-show="instituciones.find(institucion => institucion.INCodigo === participacion.institucion.INCodigo)"
                            v-on:click.prevent="postDeshabilitarParticipacion(participacion.MAP_IdParticipacion)" 
                             class="btn btn-outline btn-danger" type="button">
                            <i class="fa fa-window-close" title="Eliminar"></i>
                    </button>
                </td>
                @endcan
            </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal Editar Historial-->
    <div class="modal fade" id="ModalEditar" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <form method="POST" action="#" v-on:submit.prevent="postEditarParticipacion(datosParticipacion.MAP_IdParticipacion)">
                    @csrf
                    <div class="modal-header d-block">
                        <div class="d-flex">
                            <h3 class="modal-title" id="staticBackdropLabel">Editar Participación Pastoral</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <small class="modal-title"> Campos obligatorios (*)</small>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label"><strong>Parroquia</strong></label>
                                    <div class="input-group-prepend">
                                        <select v-model="datosParticipacion.MAP_I_INCodigo" class="form-control m-b " name="account">
                                            <option v-for="institucion in instituciones" :value="institucion.INCodigo">
                                                @{{ institucion.INNombre }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" v-show="capillas.find(capilla => capilla.INCodigo != null)">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label"><strong><strong>Capilla </strong></label></strong></label></strong></label>
                                    <div class="input-group-prepend">
                                        <select class="form-control m-b " name="account" v-model="datosParticipacion.MAP_I_INCodigoCapilla" readonly>
                                        <option value="0" selected>Participación en parroquia</option>
                                            <option v-for="capilla in capillas" :value="capilla.INCodigo">
                                                @{{ capilla.INNombre }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="display:none;">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label"><strong>Zona</strong></label>
                                    <div class="input-group-prepend">
                                        <select v-model="datosParticipacion.MAP_Z_IdZona" class="form-control m-b " name="account">
                                            <option v-for="zona in zonas" :value="zona.IdZona">
                                                @{{ zona.Nombre }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label"><strong>Area Pastoral <small>(*)</small></strong></label>
                                    <div class="input-group-prepend">
                                        <select class="form-control " name="account" @click="seleccionaAreaEdicion()" v-model="datosParticipacion.MAP_A_IdArea" required>
                                            <option selected value="0"> --Seleccione-- </option>
                                            <option v-for="area in areas" :value="area.MAP_IdArea">
                                                @{{ area.MAP_Descripcion }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label"><strong>Servicio Pastoral <small>(*)</small></strong></label>
                                    <div class="input-group-prepend">
                                        <select v-model="datosParticipacion.MAP_C_IdCargo" class="form-control m-b " name="account" required>
                                            <option value="" disabled selected>Seleccione una opción</option>
                                            <option v-for="cargo in cargos" :value="cargo.MAP_IdCargo">
                                                @{{ cargo.MAP_Descripcion }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <label for="recipient-name" class="col-md-12"><strong>Período</strong></label>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Inicio <small>(*)</small></label>
                                            <div class="input-group-prepend">
                                                <input v-model="datosParticipacion.MAP_FechaInicio" type="date" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Termino</label>
                                            <div class="input-group-prepend">
                                                <input v-model="datosParticipacion.MAP_FechaTermino" type="date" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script type="text/javascript"> 
    
    function eliminar_participacion(IdParticipacion){
        Swal.fire({
            title: 'Atención!!',
            text: "Esta seguro que desea eliminar estos datos de Manera Permanente?",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, eliminar'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type:"GET",
                    url:"/historial/participacion/parroquial/deshabilitar/"+IdParticipacion,
                    success: function(response){ 
                        if(response == 1){
                            Swal.fire(
                            'Exito',
                            'La Participación ha sido eliminada correctamente',
                            'success'
                            )
                            setTimeout('document.location.reload()', 2200);
                        }
                        else{
                            swal("Error", 'Ocurrio un error al eliminar!', "error");
                        }
                        
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
        });  
    }
</script>