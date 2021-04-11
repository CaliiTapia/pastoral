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
                    <a href="#">Comprobantes</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>Listar</strong>
                </li>
            </ol>
        </div>
        <div class="col-lg-2">
            <div class="">
                <a class="btn btn-success" type="button" style="margin-top: 40px;"
                    href="{{ route('contaparroquial.contabilidad.comprobantes.crear') }}"><i
                        class="fa fa-plus-circle"></i>
                    <span class="bold">Nuevo comprobante</span></a>
            </div>

        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight ecommerce" style="padding-bottom: 0px;">
        <div class="row">
            <div class="col-lg-2">
                <div class="ibox" style="margin-bottom: 0px;">
                    <div class="ibox-title">
                        <div class="ibox-tools">
                            <span class="label label-success float-right">Mes</span>
                        </div>
                        <h5>Total</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $cbtesVmes + $cbtesPmes }}</h1>
                        <small>Comprobantes</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="ibox" style="margin-bottom: 0px;">
                    <div class="ibox-title">
                        <div class="ibox-tools">
                            <span class="label label-success float-right">Mes</span>
                        </div>
                        <h5>Vigentes</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $cbtesVmes }}</h1>
                        <small>Comprobantes</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="ibox" style="margin-bottom: 0px;">
                    <div class="ibox-title">
                        <div class="ibox-tools">
                            <span class="label label-success float-right">Mes</span>
                        </div>
                        <h5>Pendientes</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $cbtesPmes }}</h1>
                        <small>Comprobantes</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-2">
                <div class="ibox" style="margin-bottom: 0px;">
                    <div class="ibox-title">
                        <div class="ibox-tools">
                            <span class="label label-success float-right">Actual</span>
                        </div>
                        <h5>Periodo</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $periodoActivo }}</h1>
                        <small>&nbsp;</small>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Institución</h5>
                        <div class="ibox-tools">
                            <span class="label label-primary">Seleccionada</span>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">{{ $institucion['Nombre'] }}</h1>
                        <small>{{ $institucion['Codigo'] }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight ecommerce">
        <div class="ibox-content m-b-md border-bottom">
            <h2>Buscar comprobantes</h2>
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="col-form-label" for="n_cbte">N° comprobante</label>
                        <input type="number" id="n_cbte" name="n_cbte" v-model="n_cbte" placeholder=""
                            class="form-control" min="1">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group" id="datepicker">
                        <label class="col-form-label">Desde/Hasta</label>
                        <div class="input-daterange input-group date">
                            <input type="text" class="form-control form-control" id="desde_cbte" name="desde_cbte"
                                v-model="desde_cbte" onkeydown="return false" />
                            <span class="input-group-addon"> - </span>
                            <input type="text" class="form-control form-control" id="hasta_cbte" name="hasta_cbte"
                                v-model="hasta_cbte" onkeydown="return false" />
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="col-form-label" for="tipo_cbte">Tipo</label>
                        <select name="tipo_cbte" id="tipo_cbte" class="form-control select2" v-model="tipo_cbte">
                            <option value="null">Cualquiera</option>
                            <option value="I">Ingreso</option>
                            <option value="E">Egreso</option>
                            <option value="T">Traspaso</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="col-form-label" for="glosa_cbte">Glosa</label>
                        <input type="text" id="glosa_cbte" name="glosa_cbte" class="form-control" v-model="glosa_cbte">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label class="col-form-label" for="status">Estado</label>
                        <select name="estado_cbte" id="estado_cbte" class="form-control select2" v-model="estado_cbte">
                            <option value="null">Cualquiera</option>
                            <option value="V">Vigente</option>
                            <option value="P">Pendiente</option>
                            <option value="A">Anulado</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-1 align-self-center">
                    <button class="ladda-button btn btn-success dim pull-right" type="button"
                        style="margin-right: 0px; margin-top: 25px;" data-style="zoom-in" @click="buscarComprobantes"><i
                            class="fa fa-search"></i></button>
                </div>
            </div>

            <div class="row" v-show="dataFiltrada.length > 0">
                <div class="col-lg-12">
                    <div class="ibox" id="ibox-data-filtrada">
                        <div class="ibox-content">
                            <div class="sk-spinner sk-spinner-double-bounce">
                                <div class="sk-double-bounce1"></div>
                                <div class="sk-double-bounce2"></div>
                            </div>
                            <table id="footable_busqueda" class="footable table table-stripped toggle-arrow-tiny"
                                data-page-size="5" style="margin-bottom: 0rem;">
                                <thead>
                                    <tr>
                                        <th data-toggle="true">Nº de Comprobante</th>
                                        <th data-hide="">Estado</th>
                                        <th data-hide="">Fecha</th>
                                        <th data-hide="">Tipo</th>
                                        <th data-hide="">Área negocio</th>
                                        <th data-hide="">Glosa</th>
                                        <th data-hide="all"></th>
                                        <th class="text-right" data-sort-ignore="true">Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(comprobante, m) in dataFiltrada" :key="m">
                                        <td>
                                            @{{ comprobante.cpbNum }}
                                        </td>
                                        <td>
                                            <span v-if="comprobante.cpbEst == 'V'"
                                                class="label label-primary">Vigente</span>
                                            <span v-else-if="comprobante.cpbEst == 'P'"
                                                class="label label-warning">Pendiente</span>
                                            <span v-else-if="comprobante.cpbEst == 'A'"
                                                class="label label-danger">Anulado</span>
                                            <span v-else class="label label-info">Estado Invalido</span>
                                        </td>
                                        <td>
                                            @{{ comprobante.formatted_cpbfec }}
                                        </td>
                                        <td>
                                            <p v-if="comprobante.cpbTip == 'I'">Ingreso</p>
                                            <p v-else-if="comprobante.cpbTip == 'E'">Egreso</p>
                                            <p v-else-if="comprobante.cpbTip == 'T'">Traspaso</p>
                                            <p v-else>Tipo no registrado</p>
                                        </td>
                                        <td>
                                            @{{ comprobante.movimientos[0].area_negocio.areaCod + " " + comprobante.movimientos[0].area_negocio.areaNom }}
                                        </td>
                                        <td>
                                            @{{ comprobante.cpbGlo }}
                                        </td>
                                        <td>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Nº Movimiento</th>
                                                        <th>Cuenta</th>
                                                        <th>Descripcion</th>
                                                        <th>Debe</th>
                                                        <th>Haber</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(movim, n) in comprobante.movimientos" :key="n">
                                                        <td>@{{ movim.movNum }}</td>
                                                        <td>@{{ movim.ctaCod + " " + movim.cuenta.pctNombre }}</td>
                                                        <td>@{{ movim.movGlosa }}</td>
                                                        <td>@{{ movim.movDebe }}</td>
                                                        <td>@{{ movim.movHaber }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                        <td class="text-right">
                                            <div class="btn-group" v-show="(comprobante.total_debe == comprobante.total_haber) && (comprobante.total_debe > 0 &&
                                                comprobante.total_haber > 0)">
                                                <button class="btn-white btn btn-xs"
                                                    @click="imprimirComprobante(comprobante.cpbNum)"><i
                                                        class="fa fa-print"></i> Imprimir</button>
                                            </div>
                                            <div class="btn-group"
                                                v-show="comprobante.periodo.anoPeriod == periodoActivo">
                                                <button class="btn-white btn btn-xs ladda-button" data-style="zoom-in"
                                                    @click="editarComprobante(comprobante.cpbNum)">Editar</button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="8">
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

        <div class="row">
            <div class="col-lg-12">
                <div class="ibox">
                    <div class="ibox-title espacio_encabezado">
                        <h2>Ultimos comprobantes</h2>
                        <div class="ibox-tools encabezado_tabs" style="margin-top: 10px;">
                            <button class="btn btn-success " type="button"><i class="fa fa-upload"></i> <span
                                    class="bold">Cargar</span></button>
                            <button class="btn btn-success " type="button"><i class="fa fa-download"></i> <span
                                    class="bold">Exportar</span></button>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <table id="footable" class="footable table table-stripped toggle-arrow-tiny"
                            data-page-size="10">
                            <thead>
                                <tr>
                                    <th data-toggle="true">Nº de Comprobante</th>
                                    <th data-hide="">Estado</th>
                                    <th data-hide="">Fecha</th>
                                    <th data-hide="">Tipo</th>
                                    <th data-hide="">Área negocio</th>
                                    <th data-hide="">Glosa</th>
                                    <th data-hide="all"></th>
                                    <th class="text-right" data-sort-ignore="true">Opciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($comprobantes as $cpbte)
                                <tr>
                                    <td>
                                        {{ $cpbte->cpbNum }}
                                    </td>
                                    <td>
                                        @if ($cpbte->cpbEst === 'V')
                                        <span class="label label-primary">Vigente</span>
                                        @elseif ($cpbte->cpbEst === 'P')
                                        <span class="label label-warning">Pendiente</span>
                                        @elseif ($cpbte->cpbEst === 'A')
                                        <span class="label label-danger">Anulado</span>
                                        @else
                                        <span class="label label-info">Estado Invalido</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ date("d/m/Y", strtotime($cpbte->cpbFec)) }}
                                    </td>
                                    <td>
                                        @if ($cpbte->cpbTip === 'I')
                                        Ingreso
                                        @elseif ($cpbte->cpbTip === 'E')
                                        Egreso
                                        @elseif ($cpbte->cpbTip === 'T')
                                        Traspaso
                                        @else
                                        Tipo no registrado
                                        @endif
                                    </td>
                                    <td>
                                        {{ $cpbte->movimientos[0]->areaNegocio->areaCod . " " . $cpbte->movimientos[0]->areaNegocio->areaNom }}
                                    </td>
                                    <td>
                                        {{ $cpbte->cpbGlo }}
                                    </td>
                                    <td>
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nº Movimiento</th>
                                                    <th>Cuenta</th>
                                                    <th>Descripcion</th>
                                                    <th>Debe</th>
                                                    <th>Haber</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($cpbte->movimientos as $movim)
                                                <tr>
                                                    <td>{{ $movim->movNum }}</td>
                                                    <td>{{ $movim->ctaCod . " " . $movim->cuenta->pctNombre }}</td>
                                                    <td>{{ $movim->movGlosa }}</td>
                                                    <td>{{ (float) $movim->movDebe }}</td>
                                                    <td>{{ (float) $movim->movHaber }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                    <td class="text-right">
                                        @if(($cpbte->total_debe == $cpbte->total_haber) && ($cpbte->total_debe > 0 &&
                                        $cpbte->total_haber > 0))
                                        <div class="btn-group">
                                            <button class="btn-white btn btn-xs"
                                                @click="imprimirComprobante({{ $cpbte->cpbNum }})"><i
                                                    class="fa fa-print"></i> Imprimir
                                            </button>
                                        </div>
                                        @endif

                                        @if($cpbte->periodo->anoPeriod == $periodoActivo)
                                        <div class="btn-group">
                                            <button class="btn-white btn btn-xs"
                                                @click="editarComprobante({{ $cpbte->cpbNum }})">Editar</button>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="8">
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
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.es.js') }}"></script>
<script src="{{ asset('js/vue/vue.js') }}"></script>
<script src="{{ asset('js/vue/axios.js') }}"></script>

<script src="{{ asset('js/plugins/ladda/spin.min.js') }}"></script>
<script src="{{ asset('js/plugins/ladda/ladda.min.js') }}"></script>
<script src="{{ asset('js/plugins/ladda/ladda.jquery.min.js') }}"></script>

<script>
    $(document).ready(function() {
        Ladda.bind( '.ladda-button',{ timeout: 1500 });
    });

    const vm = new Vue({
        // Donde se ejecuta el script
        el: '#vue-app',
        data() {
            return {
                periodoActivo: {!! json_encode($periodoActivo) !!},
                dataFiltrada: [],
                institucion: {!! json_encode($institucion) !!},
                n_cbte: '',
                desde_cbte: '',
                hasta_cbte: '',
                tipo_cbte: '',
                glosa_cbte: '',
                estado_cbte: '',
            }
        },
        beforeUpdate() {
            //
        },
        // Se ejecuta al iniciar la pagina
        mounted() {
            $("#tipo_cbte").select2({
                theme: 'bootstrap4',
                width:'100%',
                placeholder: "Seleccione",
            }).on('select2:select', function (e) {
                vm.tipo_cbte = e.params.data.id;
            });

            $("#estado_cbte").select2({
                theme: 'bootstrap4',
                width:'100%',
                placeholder: "Seleccione",
            }).on('select2:select', function (e) {
                vm.estado_cbte = e.params.data.id;
            });
            
            $("#datepicker .input-group.date").datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                language: "es",
                clearBtn: true,
            }).on(
                "changeDate", () => { 
                    vm.desde_cbte = $("input#desde_cbte").datepicker('getFormattedDate');
                    vm.hasta_cbte = $("input#hasta_cbte").datepicker('getFormattedDate');
                }
            );

            $(".footable").footable();

            this.periodoNulo();
        },
        computed: {
            //
        },
        methods: {
            // Guardar comprobante
            buscarComprobantes: function(){
                let formData = new FormData();
                formData.append('n_cbte', this.n_cbte);
                formData.append('desde_cbte', this.desde_cbte);
                formData.append('hasta_cbte', this.hasta_cbte);
                formData.append('tipo_cbte', this.tipo_cbte);
                formData.append('glosa_cbte', this.glosa_cbte);
                formData.append('estado_cbte', this.estado_cbte);
                var self = this;
                axios.post("{{route('contaparroquial.contabilidad.comprobantes.filter')}}", formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(function(response) {
                    console.log('SUCCESS!!', response.data);
                    if (response.data.comprobantes.length == 0) {
                        return toastr['info']('No se encontraron resultados', "Info");
                    }
                    self.dataFiltrada = response.data.comprobantes || [];
                    $('#ibox-data-filtrada').children('.ibox-content').toggleClass('sk-loading');
                    setTimeout(() => {
                        $('#footable_busqueda').trigger('footable_initialize');
                    }, 600);
                    setTimeout(() => {
                        $('#ibox-data-filtrada').children('.ibox-content').toggleClass('sk-loading');
                    }, 2000);
                })
                .catch(function(error) {
                    console.log('FAILURE!!', error.response);
                    return toastr['error']('Detectamos un error en su navegador, intente nuevamente mas tarde', "Advertencia");
                });
            },

            editarComprobante: function(cpbNum) {
                let url = "{{ route('contaparroquial.contabilidad.comprobantes.edit') }}";
                window.location.href = url + '/' + cpbNum;
            },

            periodoNulo: function() {
                if(this.periodoActivo == null) {
                    setTimeout(function(){
                        this.window.location.href = "{{ route('contaparroquial.mantenedores.periodo') }}";
                    }, 5000);
                    return toastr['error']('No existe un periodo activo, sera redirigido al mantenedor de periodos, para crear uno', "Advertencia");
                }
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
