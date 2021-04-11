@extends('layouts.admin')

@section('header')
<link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/footable/footable.core.css') }}" rel="stylesheet">

<link href="{{ asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<style>
    .footable-row-detail-cell {
        background-color: #f3f3f4;
    }

    .center {
        text-align: center;
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
                    <a href="#">Comprobante Tipo</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Listar</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
            <div class="">
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight ecommerce" style="padding-bottom: 0px;">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title espacio_encabezado">
                        <h2>Comprobantes tipo</h2>
                        <div class="ibox-tools encabezado_tabs" style="margin-top: 10px;">
                            <button class="btn btn-success" type="button" @click="modalNuevoComprobanteTipo()">
                                <i class="fa fa-plus-circle"></i>
                                <span class="bold">Nuevo comprobante tipo</span>
                            </button>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table id="footable" class="footable table table-stripped toggle-arrow-tiny"
                            data-page-size="10">
                            <thead>
                                <tr>
                                    <th data-toggle="true">Id</th>
                                    <th data-hide="">Nombre</th>
                                    <th data-hide="">Tipo de comprobante</th>
                                    <th data-hide="">Glosa</th>
                                    <th data-hide="">Institucion</th>
                                    <th data-hide="">Estado</th>
                                    <th data-hide="">Creado el</th>
                                    <th data-hide="">Actualizado el</th>
                                    <th data-hide="all"></th>
                                    <th class="text-right" data-sort-ignore="true">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comprobantesTipo as $cpbteTipo)
                                <tr>
                                    <td>
                                        {{ $cpbteTipo->id }}
                                    </td>
                                    <td>
                                        {{ $cpbteTipo->alias }}
                                    </td>
                                    <td>
                                        @if ($cpbteTipo->cpbTip === 'I')
                                        Ingreso
                                        @elseif ($cpbteTipo->cpbTip === 'E')
                                        Egreso
                                        @elseif ($cpbteTipo->cpbTip === 'T')
                                        Traspaso
                                        @else
                                        Tipo no registrado
                                        @endif
                                    </td>
                                    <td>
                                        {{ $cpbteTipo->glosa }}
                                    </td>
                                    <td>
                                        {{ $cpbteTipo->institucion->INNombre }}
                                    </td>
                                    <td>
                                        @if ($cpbteTipo->isActive)
                                        <span class="label label-primary">Activo</span>
                                        @else
                                        <span class="label label-warning">Desactivado</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ date("d/m/Y", strtotime($cpbteTipo->created_at)) }}
                                    </td>
                                    <td>
                                        {{ date("d/m/Y", strtotime($cpbteTipo->updated_at)) }}
                                    </td>
                                    <td>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Cuenta</th>
                                                    <th>Debe</th>
                                                    <th>Haber</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($cpbteTipo->detalle as $detalle)
                                                <tr>
                                                    <td>{{ $detalle->cuenta->pctCod . " " . $detalle->cuenta->pctNombre }}
                                                    </td>
                                                    <td class="center">
                                                        @if ($detalle->setDebe)
                                                        <span class="label label-primary">
                                                            <i class="fa fa-check" aria-hidden="true"></i>
                                                        </span>
                                                        @endif
                                                    </td>
                                                    <td class="center">
                                                        @if ($detalle->setHaber)
                                                        <span class="label label-primary">
                                                            <i class="fa fa-check" aria-hidden="true"></i>
                                                        </span>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="text-right">
                                        <div class="btn-group">
                                            <button class="btn-white btn btn-xs"
                                                @click="editarComprobanteTipo({{ $cpbteTipo }})">Editar
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="9">
                                        <ul class="pagination float-right"></ul>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- modal para creacion de comprobante tipo --}}
    <div class="modal inmodal" id="modalCrearComprobanteTipo" tabindex="-1" role="dialog" aria-hidden="true"
        data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content animated fadeIn">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <i class="fa fa-file-text-o modal-icon"></i>
                    <h4 class="modal-title">Ingreso de comprobante tipo</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label" for="nombre">Nombre (alias)</label>
                                <input type="text" id="nombre" value="" v-model="nuevoComprobanteTipo.alias"
                                    placeholder="" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label" for="tipo_comprobante">Tipo comprobante</label>
                                <select class="form-control" id="tipo_comprobante" v-model="nuevoComprobanteTipo.tipo"
                                    v-select2>
                                    <option value="I">Ingreso</option>
                                    <option value="E">Egreso</option>
                                    <option value="T">Traspaso</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label" for="glosa">Glosa</label>
                                <input type="text" id="glosa" value="" v-model="nuevoComprobanteTipo.glosa"
                                    placeholder="..." class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="col-form-label" for="cuenta_contable">Cuenta Contable</label>
                                <select class="form-control" id="cuenta_contable" v-model="cuentaContableTemp.cuenta"
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
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="i-checks">
                                    <label>
                                        <input type="radio" value="debe" name="cuentaDebeHaber"
                                            v-model="cuentaContableTemp.cuentaDebeHaber"> <i></i> Debe
                                    </label>
                                </div>
                                <div class="i-checks">
                                    <label>
                                        <input type="radio" value="haber" name="cuentaDebeHaber"
                                            v-model="cuentaContableTemp.cuentaDebeHaber"> <i></i> Haber
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <button class="btn btn-success pull-right" type="button" style="margin-top: 10px;"
                                    @click="addRow()">
                                    <i class="fa fa-plus"></i>
                                    Agregar cuenta contable
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cuenta Contable</th>
                                        <th>Debe</th>
                                        <th>Haber</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(movim, m) in nuevoComprobanteTipo.detalleMovimientos" :key="m">
                                        <td>@{{ m + 1 }}</td>
                                        <td> @{{ movim.cuenta }} </td>
                                        <td>
                                            <span class="label label-primary" v-show="movim.debe">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="label label-primary" v-show="movim.haber">
                                                <i class="fa fa-check" aria-hidden="true"></i>
                                            </span>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-sm" type="button"
                                                @click="deleteRow(m, movim)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-10">
                            <p>Estado de comprobante tipo (desactivado / activado)</p>
                        </div>
                        <div class="col-md-2">
                            <div class="switch">
                                <div class="onoffswitch">
                                    <input type="checkbox" checked class="onoffswitch-checkbox" id="switch_status"
                                        v-model="nuevoComprobanteTipo.isActive">
                                    <label class="onoffswitch-label" for="switch_status">
                                        <span class="onoffswitch-inner"></span>
                                        <span class="onoffswitch-switch"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-w-m btn-primary" v-if="!comprobanteTipoEnviado"
                        @click="saveComprobanteTipo">Guardar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/vue/vue.js') }}"></script>
<script src="{{ asset('js/vue/axios.js') }}"></script>

<script src="{{ asset('js/plugins/ladda/spin.min.js') }}"></script>
<script src="{{ asset('js/plugins/ladda/ladda.min.js') }}"></script>
<script src="{{ asset('js/plugins/ladda/ladda.jquery.min.js') }}"></script>

<script>
    $(document).ready(function() {
        Ladda.bind( '.ladda-button',{ timeout: 1500 });
    });

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
                nuevoComprobanteTipo: {
                    alias: '',
                    tipo: '',
                    glosa: '',
                    isActive: true,
                    detalleMovimientos: [],
                },
                cuentaContableTemp: {
                    cuenta: '',
                    cuentaDebeHaber: '',
                },
                comprobanteTipoEnviado: false,
                editingId: null,
            }
        },
        beforeUpdate() {
            //
        },
        // Se ejecuta al iniciar la pagina
        mounted() {
            $("#cuenta_contable").select2({
                theme: 'bootstrap4',
                width:'100%',
                placeholder: "Seleccione una opcion",
                dropdownParent: $('#modalCrearComprobanteTipo > div > div > div.modal-body')
            });
            
            $("#tipo_comprobante").select2({
                theme: 'bootstrap4',
                width:'100%',
                placeholder: "Seleccione una opcion",
                dropdownParent: $('#modalCrearComprobanteTipo > div > div > div.modal-body')
            });
            
            $(".footable").footable();
        },
        computed: {
            checkDebeIsPresent() {
                let isPresent =  this.nuevoComprobanteTipo.detalleMovimientos.some(function (item) {
                    return item.debe;
                });
                return isPresent;
            },

            checkHaberIsPresent() {
                let isPresent =  this.nuevoComprobanteTipo.detalleMovimientos.some(function (item) {
                    return item.haber;
                });
                return isPresent;
            },
        },
        methods: {
            modalNuevoComprobanteTipo: function() {
                this.cleanModalNuevoComprobanteTipo();
                $('#modalCrearComprobanteTipo').modal('toggle');
            },

            addRow: function() {
                if (this.cuentaContableTemp.cuenta == "") {
                    return toastr['error']("Debe seleccionar una cuenta contable", "Advertencia");
                }
                if (this.cuentaContableTemp.cuentaDebeHaber == "") {
                    return toastr['error']("Debe seleccionar si la cuenta contable es al debe o al haber", "Advertencia");
                }
                this.nuevoComprobanteTipo.detalleMovimientos.push({
                    cuenta: this.cuentaContableTemp.cuenta,
                    debe: this.cuentaContableTemp.cuentaDebeHaber == "debe" ? true : false,
                    haber: this.cuentaContableTemp.cuentaDebeHaber == "haber" ? true : false,
                });
                this.cuentaContableTemp.cuenta = '';
                this.cuentaContableTemp.cuentaDebeHaber = '';
                $("#cuenta_contable").val('').trigger('change');
            },

            deleteRow: function(index, movim){
                var idx = this.nuevoComprobanteTipo.detalleMovimientos.indexOf(movim);
                if (idx > -1) {
                    this.nuevoComprobanteTipo.detalleMovimientos.splice(index, 1);
                }
            },

            saveComprobanteTipo: function() {
                if (this.nuevoComprobanteTipo.alias.trim() == "") {
                    return toastr['error']("Debe indicar un nombre o alias para el comprobante tipo", "Advertencia");
                }
                if (this.nuevoComprobanteTipo.tipo == "") {
                    return toastr['error']("Debe indicar un tipo de comprobante para continuar", "Advertencia");
                }
                if (this.nuevoComprobanteTipo.glosa.trim() == "") {
                    return toastr['error']("Debe indicar una glosa para continuar", "Advertencia");
                }
                if (this.nuevoComprobanteTipo.detalleMovimientos.length < 2) {
                    return toastr['error']("Debe agregar al menos 2 cuentas contables para continuar", "Advertencia");
                }
                if (!this.checkDebeIsPresent || !this.checkHaberIsPresent) {
                    return toastr['error']("Debe tener al menos un debe y un haber para continuar", "Advertencia");
                }

                let formData = new FormData();
                formData.append('comprobanteTipo', JSON.stringify(this.nuevoComprobanteTipo));
                formData.append('editingId', this.editingId || null);
                var self = this;

                axios.post("{{route('contaparroquial.contabilidad.comprobante-tipo.store')}}", 
                    formData
                ).then(function(response) {
                    console.log('SUCCESS!!', response.data);
                    if (response.data.error) {
                        return toastr['error'](response.data.message, "Advertencia");
                    }
                    self.comprobanteTipoEnviado = true;
                    self.siteReload(3000);
                    return toastr['success'](response.data.message, 'Guardado');
                })
                .catch(function(error) {
                    console.log('FAILURE!!', error.response);
                    return toastr['error']('Detectamos un error en su navegador, intente nuevamente mas tarde', "Advertencia");
                });
            },

            editarComprobanteTipo: function(data) {
                this.modalNuevoComprobanteTipo();
                this.nuevoComprobanteTipo.alias = data.alias;
                this.nuevoComprobanteTipo.tipo = data.cpbTip;
                $("#tipo_comprobante").val(data.cpbTip).trigger('change');
                this.nuevoComprobanteTipo.glosa = data.glosa;
                this.nuevoComprobanteTipo.isActive = data.isActive ? true : false;

                data.detalle.forEach(item => {
                    this.nuevoComprobanteTipo.detalleMovimientos.push({
                        'cuenta': item.codCuenta,
                        'debe': item.setDebe ? true : false,
                        'haber': item.setHaber ? true : false,
                    })
                });
                this.editingId = data.id;
            },

            cleanModalNuevoComprobanteTipo: function() {
                this.editingId = null;
                this.nuevoComprobanteTipo.alias = '';
                this.nuevoComprobanteTipo.tipo = '';
                this.nuevoComprobanteTipo.glosa = '';
                this.nuevoComprobanteTipo.isActive = true;
                this.nuevoComprobanteTipo.detalleMovimientos = [];

                this.cuentaContableTemp.cuenta = '';
                this.cuentaContableTemp.cuentaDebeHaber = '';
                $("#cuenta_contable").val('').trigger('change');
                $("#tipo_comprobante").val('').trigger('change');
            },

            siteReload: function(time) {
                setTimeout(function(){
                    this.window.location.reload();
                }, time || 3000);
            }
        }
    });
</script>
@endsection
