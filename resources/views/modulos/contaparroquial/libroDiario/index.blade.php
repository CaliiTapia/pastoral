@extends('layouts.admin')

@section('header')
<link href="{{ asset('css/plugins/footable/footable.core.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
@endsection

@section('content')
<style>
  .text-info {
    color: #1ab394 !important;
  }

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
        <li class="breadcrumb-item active">
          <strong>Libro diario</strong>
        </li>
      </ol>
    </div>
    <div class="col-lg-2">

    </div>
  </div>
  <div class="wrapper wrapper-content animated fadeInRight" id="nuevoCbte">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox">
          <div class="ibox-title espacio_encabezado">
            <h2>Generar libro diario</h2>
            <div class="ibox-tools encabezado_tabs">
            </div>
          </div>
          <div class="ibox-content">
            <div class="row">

              <div class="col-md-2">
                <div class="form-group">
                  <label class="col-form-label" for="">Periodo</label>
                  <select id="filtro_periodo" class="form-control select-2" v-model="filtro.periodo" v-select2>
                    @foreach($periodos as $per)
                    <option value="{{ $per->idPeriod }}">
                      {!! $per->anoPeriod !!}
                    </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label class="col-form-label" for="">Tipo comprobante</label>
                  <select id="filtro_tipo" class="form-control select-2" v-model="filtro.tipo" v-select2>
                    <option value="all" selected="selected">Todos</option>
                    <option value="I">Ingreso</option>
                    <option value="E">Egreso</option>
                    <option value="T">Traspaso</option>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="col-form-label">Comprobante n° desde / hasta</label>
                  <div class="input-group">
                    <input type="number" class="form-control" v-model="filtro.desde" min="1" />
                    <span class="input-group-addon"> a </span>
                    <input type="number" class="form-control" v-model="filtro.hasta" min="1" />
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label class="col-form-label" for="">Area de negocio</label>
                  <select id="filtro_areaNegocio" class="form-control select-2" v-model="filtro.areaNegocio" v-select2>
                    <option value="all" selected="selected">Todos</option>
                    @foreach($areaNegocio as $aneg)
                    <option value="{{ $aneg->areaCod }}">
                      {!! $aneg->areaCod . " " . $aneg->areaNom !!}
                    </option>
                    @endforeach
                  </select>
                </div>
              </div>

              <div class="col-md-3">
                <button class="ladda-button btn btn-success pull-right" type="button" style="margin-top: 39px;"
                  @click="generarExcel()">
                  <i class="fa fa-cloud-download"></i>
                  <span class="bold">Buscar</span>
                </button>
              </div>
            </div>

          </div>
          <div class="ibox-content" v-show="comprobantes.length > 0">
            <div class="row">
              <div class="col-lg-6">
                <h2>Visualizacion previa</h2>
              </div>
              <div class="col-lg-6">
                <button type="button" class="ladda-button btn btn-warning float-right" @click="downloadExcel()">
                  <i class="fa fa-download"></i> Generar documento Excel
                </button>
              </div>
            </div>

            <div class="row">
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
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(comprobante, m) in comprobantes" :key="m">
                          <td>
                            @{{ comprobante.cpbNum }}
                          </td>
                          <td>
                            <span v-if="comprobante.cpbEst == 'V'" class="label label-primary">Vigente</span>
                            <span v-else-if="comprobante.cpbEst == 'P'" class="label label-warning">Pendiente</span>
                            <span v-else-if="comprobante.cpbEst == 'A'" class="label label-danger">Anulado</span>
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
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="7">
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
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};

    $(document).ready(function() {
        Ladda.bind( '.ladda-button',{ timeout: 1500 });
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
      el: '#vue-app',
      data() {
        return {
          periodoActivo: {!! json_encode($periodoActivo) !!},
          filtro: {
            periodo: {!! json_encode($periodoActivo) !!},
            tipo: 'all',
            desde: '',
            hasta: '',
            areaNegocio: 'all',
          },
          comprobantes: [],
        }
      },
      beforeUpdate() {
        //
      },
      mounted() {
        $(".select-2").select2({
          theme: 'bootstrap4',
          width:'100%',
          placeholder: "Seleccione una opcion"
        });

        $(".footable").footable();
        
        $('.select-2').trigger('change');
      },
      computed: {
        //
      },
      methods: {
        generarExcel: function() {
          if (this.filtro.desde != "" && this.filtro.hasta != "") {
            if (this.filtro.hasta < this.filtro.desde) {
              return toastr['error']("Hasta debe ser mayor que Desde", "Advertencia");
            }
          }
          vm.comprobantes = [];

          let formData = new FormData();
          formData.append('filtros', JSON.stringify(this.filtro));
          var self = this;
          axios.post("{{route('contaparroquial.contabilidad.libro-diario.preview')}}",
            formData,
          ).then(function(response) {
            console.log('SUCCESS!!', response.data);
            if (response.data.data.length == 0) {
              return toastr['error']('No se encontraron comprobantes segun sus criterios de busqueda', 'Advertencia');
            }
            vm.comprobantes = response.data.data;
            $('#ibox-data-filtrada').children('.ibox-content').toggleClass('sk-loading');
            setTimeout(() => {
              $('#footable_busqueda').trigger('footable_initialize');
            }, 600);
            setTimeout(() => {
              $('#ibox-data-filtrada').children('.ibox-content').toggleClass('sk-loading');
            }, 1500);
          })
          .catch(function(error) {
            console.log('FAILURE!!', error.response);
            return toastr['error']('Detectamos un error en su navegador, intente nuevamente mas tarde', "Advertencia");
          });
        },

        downloadExcel: function() {
          toastr['success']('Procesando documento para descargar', 'Procesando');

          var query = {
            periodo: this.filtro.periodo,
            tipo: this.filtro.tipo,
            desde: this.filtro.desde,
            hasta: this.filtro.hasta,
            areaNegocio: this.filtro.areaNegocio,
          }

          var url = "{{route('contaparroquial.contabilidad.libro-diario.download')}}?" + $.param(query)
          return window.open(url, '_blank');
        }
      }
    });
  </script>
  @endsection
