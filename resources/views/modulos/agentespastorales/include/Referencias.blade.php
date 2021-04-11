<div class="panel-body">
    <div class="ibox-title">
        <h5>Referencias</h5>
        <p>Evalúa con nota donde: 1= malo; 2= regular; 3= neutro; 4= muy bueno; 5= excelente.</p>
        <div class="ibox-tools encabezado_tabs">
            <button data-toggle="modal" data-target="#ModalAgregarRef" type="button" class="btn btn-success btn_encabezado">Agregar</button>
        </div>
    </div>

    <!-- Modal Editar Referencia-->
    <div class="modal fade" id="ModalAgregarRef" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <form method="POST" action="#" v-on:submit.prevent="postCrearReferencia">
                <div class="modal-header d-block">
                    <div class="d-flex">
                        <h3 class="modal-title" id="staticBackdropLabel">Ingresar referencia</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <small class="modal-title"> Campos obligatorios (*)</small>
                </div>

                <div class="modal-body">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label"><strong>Servicio Pastoral  <small>(*)</small></strong></label>
                            <div class="input-group-prepend">
                                <select class="form-control m-b" name="account" v-model="nuevaReferencia.MAP_P_IdParticipacion" required>
                                    <option> --Seleccione-- </option>
                                    <option v-for="participacion in participaciones" :value="participacion.MAP_IdParticipacion"
                                    v-show="instituciones.find(institucion => institucion.INCodigo === participacion.institucion.INCodigo)">
                                        @{{ participacion.cargo.MAP_Descripcion }} - @{{ participacion.institucion.INNombre }}
                                        (@{{ participacion.MAP_FechaInicio }} - @{{ participacion.MAP_FechaTermino }})
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label"><strong>Observación  <small>(*)</small></strong></label>
                            <div class="input-group-prepend">
                                <textarea class="form-control" aria-label="With textarea" v-model="nuevaReferencia.MAP_Observacion" required ></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                        <label for="recipient-name" class="col-form-label"><strong>Nota  <small>(*)</small></strong></label>
                            <div class="form-check abc-radio abc-radio-info">                           

                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="nota1" value="1" name="nota" v-model="nuevaReferencia.MAP_Nota" required>
                                    <label class="custom-control-label" for="nota1">1= malo</label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="nota2" value="2" name="nota" v-model="nuevaReferencia.MAP_Nota" required>
                                    <label class="custom-control-label" for="nota2">2= Regular</label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="nota3" value="3" name="nota" v-model="nuevaReferencia.MAP_Nota" required>
                                    <label class="custom-control-label" for="nota3">3= Neutro</label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="nota4" value="4" name="nota" v-model="nuevaReferencia.MAP_Nota" required>
                                    <label class="custom-control-label" for="nota4">4= Muy Bueno</label>
                                </div>

                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="nota5" value="5" name="nota" v-model="nuevaReferencia.MAP_Nota" required>
                                    <label class="custom-control-label" for="nota5">5= Excelete</label>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar Referencia</button>
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
                <th>Zona</th>
                <th>Servicio Pastoral</th>
                <th>Observación</th>
                <th>Nota</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody  v-for="participacion in participaciones">
            <tr v-for="referencia in participacion.referencias">
                <form>
                    <td>@{{ participacion.institucion.INNombre }}</td>
                    <td>@{{ participacion.zona.Nombre }}</td>
                    <td>@{{ participacion.cargo.MAP_Descripcion }}</td>
                    <td>@{{ referencia.MAP_Observacion }}</td>
                    <td>
                        <div class="form-check abc-radio abc-radio-info form-check-inline">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" disabled id="nota1" value="1" :checked="referencia.MAP_Nota === 1">
                                <label class="custom-control-label" for="nota1">1</label>
                            </div>

                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" disabled id="nota2" value="2" :checked="referencia.MAP_Nota === 2">
                                <label class="custom-control-label" for="nota2">2</label>
                            </div>

                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" disabled id="nota3" value="3" :checked="referencia.MAP_Nota === 3">
                                <label class="custom-control-label" for="nota3">3</label>
                            </div>

                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" disabled id="nota4" value="4" :checked="referencia.MAP_Nota === 4">
                                <label class="custom-control-label" for="nota4">4</label>
                            </div>

                            <div class="custom-control custom-radio custom-control-inline">
                                <input class="custom-control-input" type="radio" disabled id="nota5" value="5" :checked="referencia.MAP_Nota === 5">
                                <label class="custom-control-label" for="nota5">5</label>
                            </div>
                        </div>
                    </td>
                    <th>
                        {{-- <button v-show="urs.find(ur => ur.IdUnidadRecaudadora === participacion.unidad_recaudadora.IdUnidadRecaudadora)"
                                v-on:click.prevent="deshabilitarReferencia(referencia.MAP_IdReferencia)" 
                                data-toggle="modal" data-target="#ModalEliminarReferencia" class="btn btn-outline btn-danger  dim" type="button">
                                <i class="fa fa-trash"></i>
                        </button> --}}
                    </th>
                </form>
            </tr>
            </tbody>
        </table>
    </div> 
    <!-- Modal Confirmacion Eliminar-->
    <div class="modal fade" id="ModalEliminarReferencia" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><Strong><i class="fa fa-exclamation-triangle"></i> ADVERTENCIA</Strong></h5>
                    </div>
                    <div class="modal-body">
                        <div>
                            ¿Está Seguro que Desea Eliminar estos Datos <Strong>De Manera Permanente</Strong>?
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button v-on:click.prevent="postDeshabilitarReferencia(referenciaDeshabilitar)" type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Confirmar</button>
                    </div>
                </div>
            </div> 
        </div>  
</div>
 