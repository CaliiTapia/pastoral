@extends('layouts.admin')

@section('header')
<link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
@endsection

@section('content')
<style>
    .text-info {
        color: #1ab394 !important;
    }

</style>

<div id="vue-app">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-10">
            <h2>Contabilidad Parroquial</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('contaparroquial.contabilidad.comprobantes') }}">Comprobantes</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Editar</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2"></div>
    </div>
    <div class="wrapper wrapper-content animated fadeInRight" id="nuevoCbte">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title espacio_encabezado">
                        <h2>
                            Editar comprobante nº {{ $comprobante->cpbNum }}

                            @if ($comprobante->cpbEst === 'V')
                            <span class="label label-primary">Vigente</span>
                            @elseif ($comprobante->cpbEst === 'P')
                            <span class="label label-warning">Pendiente</span>
                            @elseif ($comprobante->cpbEst === 'A')
                            <span class="label label-danger">Anulado</span>
                            @else
                            <span class="label label-info">Estado Invalido</span>
                            @endif
                        </h2>
                        <div class="ibox-tools encabezado_tabs">

                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="row">

                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label" for="product_name">N° comprobante</label>
                                    <input type="text" v-model="Cabecera.Ncbte" disabled class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group" id="datepicker" onkeydown="return false">
                                    <label class="col-form-label" for="cpbFec">Fecha comprobante</label>
                                    <div class="input-group date">
                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input
                                            type="text" v-model="Cabecera.Fecha" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label" for="status">Tipo</label>
                                    <select name="tipo" class="form-control select2" v-model="Cabecera.Tipo" v-select2
                                        disabled>
                                        <option value="I">Ingreso</option>
                                        <option value="E">Egreso</option>
                                        <option value="T">Traspaso</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="col-form-label" for="">Area negocio</label>
                                    <select name="areaNegocio" class="form-control select2"
                                        v-model="Cabecera.areaNegocio" v-select2>
                                        <option value="{{ null }}">Seleccione una opción</option>
                                        @foreach($areaNegocio as $aneg)
                                        <option value="{{ $aneg->areaCod }}">
                                            {!! $aneg->areaCod . " " . $aneg->areaNom !!}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label" for="product_name">Detalle comprobante</label>
                                    <input type="text" v-model="Cabecera.Glosa" class="form-control">
                                </div>
                            </div>
                        </div>

                        <div v-show="CabeceraEsValida">
                            <hr>
                            <h2>Agregar movimientos</h2>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label" for="product_name">Cuenta Contable</label>
                                        <select class="form-control" id="select-cuenta-contable" v-model="addMov.Cuenta"
                                            v-select2>
                                            <option value="{{ null }}">Seleccione una opción</option>
                                            @foreach($cuentas as $cuenta)
                                            <option value="{{ $cuenta->pctCod }}">
                                                {!! $cuenta->pctCod . " " . $cuenta->pctNombre !!}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-form-label" for="product_name">Descripción movimiento</label>
                                        <input type="text" v-model="addMov.Descripcion" value="" placeholder=""
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group" id="datepicker">
                                        <label class="col-form-label">Debe</label>
                                        <div class="input-group m-b">
                                            <div class="input-group-prepend">
                                                <span class="input-group-addon">$</span>
                                            </div>
                                            <input class="form-control text-right" type="text" id="movDebe" v-model="addMov.Debe" v-on:change="separadorDeMiles('movDebe')"
                                                min="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-form-label" for="status">Haber</label>
                                        <div class="input-group m-b">
                                            <div class="input-group-prepend">
                                                <span class="input-group-addon">$</span>
                                            </div>
                                            <input class="form-control text-right" type="text" id="movHaber" v-on:change="separadorDeMiles('movHaber')" v-model="addMov.Haber"
                                                min="0">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-success dim" type="button" @click="addRow()"
                                        style="margin-top: 30px;"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>

                        <div v-if="ExistenMovimientos">
                            <hr>
                            <h2>Movimientos</h2>
                            <input class="form-control text-right" type="hidden" v-model="ctascontables" />
                            <table class="table table-striped toggle-arrow-tiny">
                                <thead>
                                    <tr>
                                        <th>N° Mov.</th>
                                        <th>Cuenta</th>
                                        <th>Detalle de Cuenta</th>
                                        <th>Descripción</th>
                                        <th>Debe</th>
                                        <th>Haber</th>
                                        <th class="text-right">Editar</th>
                                        <th class="text-right">Remover</th>
                                    </tr>
                                </thead>
                                <template>
                                    <tbody>
                                        <tr v-for="(movim, m) in Movimientos" :key="m">
                                            <td>
                                                @{{ movim.NMov }}
                                            </td>
                                            <td>
                                                @{{ movim.CuentaText }}
                                            </td>
                                            <td>
                                                <button class="btn btn-info btn-sm"
                                                    v-bind:class="{ 'btn-danger': movim.DetalleCuenta.pctCcos.value == '' }"
                                                    type="button" @click="openCentroDeCostos(m, movim.Cuenta)"
                                                    v-if="movim.DetalleCuenta.pctCcos.required == 'S'">
                                                    <i class="fa fa-building-o"></i>
                                                </button>

                                                <button class="btn btn-info btn-sm" type="button"
                                                    v-bind:class="{ 'btn-danger': movim.DetalleCuenta.pctAux.value == '' }"
                                                    @click="openIngresoDeAuxiliar(m, movim.Cuenta)"
                                                    v-if="movim.DetalleCuenta.pctAux.required == 'S'">
                                                    <i class="fa fa-address-book-o"></i>
                                                </button>

                                                <button class="btn btn-info btn-sm" type="button"
                                                    v-bind:class="{ 'btn-danger': (movim.DetalleCuenta.pctDoc.required == 'S' && (movim.DetalleCuenta.pctDoc.numDoc == '' || movim.DetalleCuenta.pctDoc.tipoDoc == '')) || (movim.DetalleCuenta.pctEDoc.required == 'S' && movim.DetalleCuenta.pctEDoc.validado != true)   }"
                                                    @click="openIngresoDeDocumento(m, movim.Cuenta)"
                                                    v-if="movim.DetalleCuenta.pctDoc.required == 'S'">
                                                    <i class="fa fa-file-text-o"></i>
                                                    <i class="fa fa-exclamation"
                                                        v-if="movim.DetalleCuenta.pctEDoc.required == 'S'"></i>
                                                </button>
                                            </td>
                                            <td>
                                                @{{ movim.Descripcion }}
                                            </td>
                                            <td>
                                            
                                                @{{ separadorDeMilesEstatico(movim.Debe) }}
                                            </td>
                                            <td>
                                                @{{ separadorDeMilesEstatico(movim.Haber) }}
                                            </td>
                                            <td scope="row" class="editIconContainer text-right">
                                                <button class="btn btn-info btn-sm" type="button"
                                                @click="editRow(movim)"><i class="fa fa-edit"></i></button>
                                            </td>
                                            <td scope="row" class="trashIconContainer text-right">
                                                <button class="btn btn-danger btn-sm" type="button"
                                                    @click="deleteRow(m, movim)"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr
                                            v-bind:class="{ 'text-danger': !TotalesValidos, 'text-info': TotalesValidos }">
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Total:</th>
                                            <th>@{{ separadorDeMilesEstatico(Cabecera.totalDebe) }}</th>
                                            <th>@{{ separadorDeMilesEstatico(Cabecera.totalHaber) }}</th>
                                            <th></th>
                                        </tr>
                                    </tfoot>
                                </template>
                            </table>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class=" row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-primary float-right" v-if="ComprobanteValido"
                                    @click="guardarComprobante">
                                    <i class="fa fa-save"></i> Actualizar Comprobante
                                </button>

                                <button type="button" class="btn btn-warning float-right" style="margin-right: 20px;"
                                    v-show="(comprobante.total_debe == comprobante.total_haber) && (comprobante.total_debe > 0 &&
                                    comprobante.total_haber > 0)"
                                    @click="imprimirComprobante({{ $comprobante->cpbNum }})">
                                    <i class="fa fa-print"></i> Imprimir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal para editar movimiento --}}
    <div class="modal inmodal" id="modalEditarMov" tabindex="-1" role="dialog" aria-hidden="true"
        data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Editar movimiento</h4>
                </div>
                <div class="modal-body">
                <input  id="hdnIdMovimiento" type="hidden" value="">

                    <div class="row">
                        <div class="col-md-6">
                            <label class="col-form-label" for="product_name">Debe</label>
                            <input class="form-control text-right" id="Debe" type="text" v-on:change="separadorDeMiles('Debe')" >
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="product_name">Haber</label>
                            <input class="form-control text-right" id="Haber" type="text" v-on:change="separadorDeMiles('Haber')" >
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label" for="product_name">Descripción movimiento</label>
                            <input type="text" id="Descripcion" value="" placeholder="" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-w-m btn-primary" @click="actualizarMov">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal para validar ingreso de centro de costos --}}
    <div class="modal inmodal" id="modalCentroDeCostos" tabindex="-1" role="dialog" aria-hidden="true"
        data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-building-o modal-icon"></i>
                    <h4 class="modal-title">Ingreso de Centro de Costos</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label" for="select-centro-costo">Centro de Costos</label>
                                <select class="form-control" id="select-centro-costo" v-select2>
                                    <option value="{{ null }}">Seleccione una opción</option>
                                    @foreach($centrosDeCostos as $cc)
                                    <option value="{{ $cc->id }}">
                                        {{ $cc->ccDesc }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-w-m btn-primary" @click="saveCentroDeCostos">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal para validar ingreso de auxiliar --}}
    <div class="modal inmodal" id="modalIngresoAuxiliar" tabindex="-1" role="dialog" aria-hidden="true"
        data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-address-book-o modal-icon"></i>
                    <h4 class="modal-title">Ingreso de Auxiliar</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label" for="select-auxiliares">Auxiliares</label>
                                <select class="form-control" id="select-auxiliares" v-select2>
                                    <option value="{{ null }}">Seleccione una opción</option>
                                    @foreach($auxiliares as $aux)
                                    <option value="{{ $aux->codAux }}">
                                        {{ $aux->rutAux . ' - ' . $aux->nomAux . ' ' . $aux->apllAux }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-w-m btn-primary" @click="saveAuxiliar">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- modal para validar documento de comprobante --}}
    <div class="modal inmodal" id="modalDocComprobante" tabindex="-1" role="dialog" aria-hidden="true"
        data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-file-text-o modal-icon"></i>
                    <h4 class="modal-title">Ingreso de Documento</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label" for="select-tipoDoc">Tipo de Documento</label>
                                <select class="form-control" id="select-tipoDoc" v-select2>
                                    <option value="{{ null }}">Seleccione una opción</option>
                                    @foreach($tipoDoc as $td)
                                    <option value="{{ $td->TipDoc }}">
                                        {{ $td->TipDoc . ' - ' . $td->DesTipDoc }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label" for="numero_documento">Nro de Documento</label>
                                <input type="text" id="numero_documento" value=""
                                    placeholder="ingrese numero de documento" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input id="adjunto_documento" type="file" ref="file" class="custom-file-input"
                                        accept=".pdf" @change="onFileChange">
                                    <label class=" custom-file-label" for="adjunto_documento">Sube aqui el
                                        documento</label>
                                </div>
                            </div>
                            <p class="text-warning"><i class="fa fa-exclamation"></i> Al editar,
                                reingrese el documento</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-w-m btn-primary" @click="saveDocumento">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.es.js') }}"></script>
<script src="{{ asset('js/plugins/bs-custom-file/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('js/vue/vue.js') }}"></script>
<script src="{{ asset('js/vue/axios.js') }}"></script>

<script>
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
</script>

<script>
    Vue.directive('select2', {
        inserted(el) {
            $(el).on('select2:select', () => {
                const event = new Event('change', { bubbles: true, cancelable: true });
                el.dispatchEvent(event);
            });

            $(el).on('select2:unselect', () => {
                const event = new Event('change', {bubbles: true, cancelable: true})
                el.dispatchEvent(event)
            });
        },
    });

    const vm = new Vue({
        // Donde se ejecuta el script
        el: '#vue-app',
        data() {
            return {
                periodoActivo: {!! json_encode($periodoActivo) !!},
                errors: [],
                Cabecera: {
                    'Ncbte': '{{ $comprobante->cpbNum }}',
                    'Fecha': '{{ $comprobante->formatted_cpbfec }}',
                    'Tipo': '{{ $comprobante->cpbTip }}',
                    'areaNegocio': '{{ $comprobante->movimientos[0]->areaNegocio->areaCod }}',
                    'Glosa': '{{ $comprobante->cpbGlo }}',
                    'totalDebe': 0,
                    'totalHaber': 0,
                },
                addMov: {
                    'Cuenta': '',
                    'CuentaText': '',
                    'DetalleCuenta': {},
                    'Debe': 0,
                    'Haber': 0,
                    'Descripcion': '',
                },
                
                tmpIndexMov: null,
                addCentroDeCostos: null,
                addAuxiliar: null,
                addDocComprobante: {},
                Movimientos: {!! json_encode($comprobante->detalleMovimientos) !!},
                file: '',
                comprobanteEnviado: false,
                ctascontables: {!! json_encode($cuentas) !!},
                centrosDeCostos: {!! json_encode($centrosDeCostos) !!},
                
                comprobante: {!! json_encode($comprobante) !!},
            }
        },
        beforeUpdate() {
            $("#select-cuenta-contable").select2({
                theme: 'bootstrap4',
                width:'100%',
                placeholder: "Seleccione una opcion",
            });
        },
        mounted() {
            $("#datepicker .input-group.date").datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                language: "es",
                startDate: "01/01/{!! $periodoActivo !!}",
                endDate: "31/12/{!! $periodoActivo !!}"
            }).on(
                "changeDate", () => { this.Cabecera.Fecha = $("#datepicker .input-group.date").datepicker('getFormattedDate') }
            );

            $("#select-centro-costo").select2({
                theme: 'bootstrap4',
                width:'100%',
                placeholder: "Seleccione una opcion",
                dropdownParent: $('#modalCentroDeCostos > div > div > div.modal-body')
            });

            $("#select-auxiliares").select2({
                theme: 'bootstrap4',
                width:'100%',
                placeholder: "Seleccione una opcion",
                dropdownParent: $('#modalIngresoAuxiliar > div > div > div.modal-body')
            });

            $("#select-tipoDoc").select2({
                theme: 'bootstrap4',
                width:'100%',
                placeholder: "Seleccione una opcion",
                dropdownParent: $('#modalDocComprobante > div > div > div.modal-body')
            });

            this.calcularTotalDebeHaber();
        },
        computed: {
            CabeceraEsValida() {
                return this.Cabecera.Ncbte != "" && this.Cabecera.Fecha != "" && this.Cabecera.Tipo != "" && this.Cabecera.areaNegocio != ""  && this.Cabecera.Glosa != "";
            },
            ExistenMovimientos() {
                return this.Movimientos.length > 0;
            },
            TotalesValidos() {
                return this.Cabecera.totalDebe == this.Cabecera.totalHaber;
            },
            verificarDetalles() {
                let check = true;
                this.Movimientos.forEach( function(valor, indice, array) {
                    let i = valor.DetalleCuenta
                    if (
                        (i.pctCcos.required == 'S' && i.pctCcos.value == '') ||
                        (i.pctAux.required == 'S' && i.pctAux.value == '') ||
                        (i.pctDoc.required == 'S' && (i.pctDoc.numDoc == '' || i.pctDoc.tipoDoc == '')) ||
                        (i.pctEDoc.required == 'S' && i.pctEDoc.validado != true)
                    ) {
                        check = false;
                    }
                });
                return check;
            },
            ComprobanteValido() {
                return this.CabeceraEsValida && this.ExistenMovimientos && this.Movimientos.length > 1 && this.verificarDetalles && !this.comprobanteEnviado;
            }
        },
        methods: {
            guardarComprobante: function(){
                let formData = new FormData();
                formData.append('cabecera', JSON.stringify(this.Cabecera));
                formData.append('movimientos', JSON.stringify(this.Movimientos));
                var self = this;
                axios.post("{{route('contaparroquial.contabilidad.comprobantes.edit.store')}}", formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(function(response) {
                    console.log('SUCCESS!!', response.data);
                    if (response.data.error) {
                        return toastr['error'](response.data.message, "Advertencia");
                    }
                    self.comprobanteEnviado = true;
                    self.siteReload(3000);
                    return toastr['success'](response.data.message, 'Guardado');
                })
                .catch(function(error) {
                    console.log('FAILURE!!', error.response);
                    return toastr['error']('Detectamos un error en su navegador, intente nuevamente mas tarde', "Advertencia");
                });
            },

            openCentroDeCostos: function(indexMovim, cuenta) {
                vm.tmpIndexMov = indexMovim;
                $("#select-centro-costo").val(vm.Movimientos[vm.tmpIndexMov].DetalleCuenta.pctCcos.value).trigger('change');
                $('#modalCentroDeCostos').modal('toggle');
            },
            saveCentroDeCostos: function() {
                if ($("#select-centro-costo").val() == '') {
                    return toastr['error']("Debe seleccionar un Centro de Costos para continuar", "Advertencia");
                }
                this.Movimientos[this.tmpIndexMov].DetalleCuenta.pctCcos.value = $("#select-centro-costo").val();
                $("#select-centro-costo").val('').trigger('change');
                $('#modalCentroDeCostos').modal('toggle');
                return toastr['success']('Centro de Costos ingresado correctamente', 'Guardado');
            },

            openIngresoDeAuxiliar: (indexMovim, cuenta) => {
                vm.tmpIndexMov = indexMovim;
                $("#select-auxiliares").val(vm.Movimientos[vm.tmpIndexMov].DetalleCuenta.pctAux.value).trigger('change');
                $('#modalIngresoAuxiliar').modal('toggle');
            },
            saveAuxiliar: function() {
                if ($("#select-auxiliares").val() == '') {
                    return toastr['error']("Debe seleccionar un Auxiliar para continuar", "Advertencia");
                }
                this.Movimientos[this.tmpIndexMov].DetalleCuenta.pctAux.value = $("#select-auxiliares").val();
                $("#select-auxiliares").val('').trigger('change');
                $('#modalIngresoAuxiliar').modal('toggle');
                return toastr['success']('Auxiliar ingresado correctamente', 'Guardado');
            },

            openIngresoDeDocumento: (indexMovim, cuenta) => {
                vm.tmpIndexMov = indexMovim;
                $("#select-tipoDoc").val(vm.Movimientos[vm.tmpIndexMov].DetalleCuenta.pctDoc.tipoDoc).trigger('change');
                $("#numero_documento").val(vm.Movimientos[vm.tmpIndexMov].DetalleCuenta.pctDoc.numDoc || '');
                $("#adjunto_documento").val('');
                $('#adjunto_documento').next('label').html('Sube aqui el documento');
                if (vm.Movimientos[vm.tmpIndexMov].DetalleCuenta.pctDoc.file != '') {
                    $('#adjunto_documento').next('label').html(vm.Movimientos[vm.tmpIndexMov].DetalleCuenta.pctDoc.file.name);
                }
                $('#modalDocComprobante').modal('toggle');
            },
            saveDocumento: function() {
                if ($("#select-tipoDoc").val() == '') {
                    return toastr['error']("Debe seleccionar un Tipo de Documento para continuar", "Advertencia");
                }
                if ($("#numero_documento").val().trim() == '') {
                    return toastr['error']("Debe ingresar un Numero de Documento para continuar", "Advertencia");
                }
                if (this.Movimientos[this.tmpIndexMov].DetalleCuenta.pctEDoc.required == 'S' && $("#adjunto_documento")[0].files[0] == undefined ) {
                    return toastr['error']("Debe ingresar un Documento para continuar", "Advertencia");
                }
                this.Movimientos[this.tmpIndexMov].DetalleCuenta.pctDoc.tipoDoc = $("#select-tipoDoc").val();
                this.Movimientos[this.tmpIndexMov].DetalleCuenta.pctDoc.numDoc = $("#numero_documento").val().trim();
                this.Movimientos[this.tmpIndexMov].DetalleCuenta.pctDoc.file = $("#adjunto_documento")[0].files[0] || '';
                this.Movimientos[this.tmpIndexMov].DetalleCuenta.pctEDoc.validado = true;
                $("#select-tipoDoc").val('').trigger('change');
                $("#numero_documento").val('');
                $('#modalDocComprobante').modal('toggle');
                return toastr['success']('Documento ingresado correctamente', 'Guardado');
            },

            onFileChange: function(){
                this.file = $("#adjunto_documento")[0].files[0];
            },

            addRow: function(){
                if ($("#select-cuenta-contable").select2('data')[0].id == "") {
                    return toastr['error']("Debe seleccionar una Cuenta Contable para continuar", "Advertencia");
                }
                if (parseFloat(this.addMov.Debe) != 0 && parseFloat(this.addMov.Haber) != 0) {
                    return toastr['error']("Ingrese un valor en Debe o Haber para continuar (solo uno de los dos)", "Advertencia");
                }
                if (this.addMov.Descripcion == "" && this.Cabecera.Glosa == "") {
                    return toastr['error']("Si no desea ingresar una descripcion, se usara el valor proporcionado en la Glosa, favor ingrese una Glosa o Descripcion para continuar", "Advertencia");
                }

                let cuentaSeleccionada = this.ctascontables.filter((item) => {
                    return item.pctCod == this.addMov.Cuenta;
                });
                
                this.Movimientos.push({
                    NMov: this.Movimientos.length +1,
                    Cuenta: this.addMov.Cuenta,
                    CuentaText: $("#select-cuenta-contable").select2('data')[0].text.trim(),
                    DetalleCuenta: {
                        pctCcos: {
                            required: cuentaSeleccionada[0].pctCcos,
                            value: '',
                        },
                        pctAux: {
                            required: cuentaSeleccionada[0].pctAux,
                            value: '',
                        },
                        pctDoc: {
                            required: cuentaSeleccionada[0].pctDoc,
                            tipoDoc: '',
                            numDoc: '',
                            file: '',
                        },
                        pctEDoc: {
                            required: cuentaSeleccionada[0].pctEDoc,
                            validado: false,
                        },
                    },
                    Debe: parseFloat(this.addMov.Debe),
                    Haber: parseFloat(this.addMov.Haber),
                    Descripcion: this.addMov.Descripcion || this.Cabecera.Glosa,
                });
                this.addMov.Cuenta = '';
                this.addMov.CuentaText = '';
                this.addMov.DetalleCuenta = {};
                this.addMov.Debe = 0;
                this.addMov.Haber = 0;
                this.addMov.Descripcion = '';
                
                $("#select-cuenta-contable").val('').trigger('change');
                
                this.calcularTotalDebeHaber();
            },

            deleteRow: function(index,movim){
                var idx = this.Movimientos.indexOf(movim);
                if (idx > -1) {
                    this.Movimientos.splice(idx, 1);
                }
                this.calcularTotalDebeHaber();
            },
            
            editRow: function(movim){
                console.log(movim);
                $('#modalEditarMov').modal('toggle');
                $("#Debe").val(movim.Debe);
                $("#Haber").val(movim.Haber);
                $("#Descripcion").val(movim.Descripcion);
                $("#hdnIdMovimiento").val(movim.NMov);

            },

            actualizarMov: function(){
                let formData = new FormData();
                formData.append('Debe', JSON.stringify($("#Debe").val()));
                formData.append('Haber', JSON.stringify($("#Haber").val()));
                formData.append('Descripcion', JSON.stringify($("#Descripcion").val()));
                formData.append('NMov', JSON.stringify($("#hdnIdMovimiento").val()));
                formData.append('Comprobante', JSON.stringify(this.Cabecera.Ncbte));

                var self = this;
                axios.post("{{route('contaparroquial.contabilidad.comprobantes.editMov')}}", formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(function(response) {
                    
                    //console.log('SUCCESS!!', response.data);
                    if (response.data.error) {
                        return toastr['error'](response.data.message, "Advertencia");
                    }
                   
                    self.comprobanteEnviado = true;
                    self.siteReload(3000);
                    return toastr['success'](response.data.message, 'Guardado');
                })
                .catch(function(error) {
                    //console.log('FAILURE!!', error.response);
                    return toastr['error']('Detectamos un error en su navegador, intente nuevamente mas tarde', "Advertencia");
                });
            },
            

            calcularTotalDebeHaber: function(){
                let Debe = 0;
                let Haber = 0;
                this.Movimientos.forEach((movimiento, index, array) => {
                    Debe = parseFloat(Debe + movimiento.Debe);
                    Haber = parseFloat(Haber + movimiento.Haber);
                });
                this.Cabecera.totalDebe = Debe;
                this.Cabecera.totalHaber = Haber;
            },
            separadorDeMiles: function(idInput){

                var num = $("#"+idInput).val();
                
                
                if (!num || num == 'NaN') return '-';
                    if (num == 'Infinity') return '&#x221e;';
                    num = num.toString().replace(/\$|\,/g, '');
                    if (isNaN(num))
                        num = "0";
                    sign = (num == (num = Math.abs(num)));
                    num = Math.floor(num * 100 + 0.50000000001);
                    //cents = num % 100;
                    num = Math.floor(num / 100).toString();
                    //if (cents < 10)
                        //cents = "0" + cents;
                    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3) ; i++)
                        num = num.substring(0, num.length - (4 * i + 3)) + '.' + num.substring(num.length - (4 * i + 3));
                       // $("#"+idInput).val((((sign) ? '' : '-') + num))
                       $("#"+idInput).val( (((sign) ? '' : '-') + num));

            },
            
            separadorDeMilesEstatico: function(num){


            if (!num || num == 'NaN') return '0';
                if (num == 'Infinity') return '&#x221e;';
                num = num.toString().replace(/\$|\,/g, '');
                if (isNaN(num))
                    num = "0";
                sign = (num == (num = Math.abs(num)));
                num = Math.floor(num * 100 + 0.50000000001);
                //cents = num % 100;
                num = Math.floor(num / 100).toString();
                //if (cents < 10)
                    //cents = "0" + cents;
                for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3) ; i++)
                    num = num.substring(0, num.length - (4 * i + 3)) + '.' + num.substring(num.length - (4 * i + 3));
                return num;

            },
            siteReload: function(time) {
                setTimeout(function(){
                    this.window.location.reload();
                }, time || 3000);
            },

            imprimirComprobante: function(cpbNum) {
                setTimeout(function(){
                    let url = "{{ route('contaparroquial.contabilidad.comprobantes.print') }}";
                    window.open(url + '/' + cpbNum, '_blank');
                }, 3000);
                return toastr['info']('Generando comprobante', "Info");
            }
        }
    });
</script>
@endsection
