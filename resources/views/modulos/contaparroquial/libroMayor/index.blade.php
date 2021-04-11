@extends('layouts.admin')

@section('header')
<link href="{{ asset('css/plugins/footable/footable.core.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/datapicker/datepicker3.css') }}" rel="stylesheet">
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
          <strong>Libro mayor</strong>
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
            <h2>Generar libro mayor</h2>
            <div class="ibox-tools encabezado_tabs">
            </div>
          </div>
          <div class="ibox-content">
            <div class="row">

              <div class="col-md-2">
                <div class="form-group">
                  <label class="col-form-label" for="">Periodo</label>
                  <select id="filtro_periodo" class="form-control select-2" v-model="filtro.periodo" v-select2
                    @change="cambioDePeriodo()">
                    @foreach($periodos as $per)
                    <option value="{{ $per->idPeriod }}">
                      {!! $per->anoPeriod !!}
                    </option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label class="col-form-label" for="">Cuentas</label>
                  <select id="filtro_cuentas" class="form-control select-2" v-model="filtro.cuentas" multiple="multiple"
                    v-select2>
                    @foreach($cuentas as $cuenta)
                    <option value="{{ $cuenta->pctCod }}">
                      {!! $cuenta->pctCod .' '. $cuenta->pctNombre !!}
                    </option>
                    @endforeach
                  </select>
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
                <div class="form-group" id="datepicker">
                  <label class="col-form-label">Desde / Hasta</label>
                  <div class="input-daterange input-group date">
                    <input type="text" class="form-control" id="filtro_desde" v-model="filtro.desde"
                      onkeydown="return false" />
                    <span class="input-group-addon"> - </span>
                    <input type="text" class="form-control" id="filtro_hasta" v-model="filtro.hasta"
                      onkeydown="return false" />
                  </div>
                </div>
              </div>

              <div class="col-md-2">
                <button class="ladda-button btn btn-success pull-right" type="button" style="margin-top: 39px;"
                  @click="generarExcel()">
                  <i class="fa fa-cloud-download"></i>
                  <span class="bold">Buscar</span>
                </button>
              </div>
            </div>

          </div>
          <div class="ibox-content" v-show="movimientos.length > 0">
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
                          <th data-toggle="true">Cuenta</th>
                          <th>Fecha</th>
                          <th data-hide="all">N° comprobante</th>
                          <th data-hide="all">Tipo</th>
                          <th data-hide="all">N° interno</th>
                          <th>Centro de costos</th>
                          <th>Auxiliar</th>
                          <th>Tipo documento</th>
                          <th>Numero Doc</th>
                          <th>Debe</th>
                          <th>Haber</th>
                          <th>Glosa</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(movim, m) in movimientos" :key="m">
                          <td>@{{ movim.ctaCod + " " + movim.cuenta.pctNombre }}</td>
                          <td>@{{ movim.formatted_cpbfec }}</td>
                          <td>@{{ movim.comprobante.cpbCorr }}</td>
                          <td>@{{ movim.comprobante.cpbTip }}</td>
                          <td>@{{ movim.comprobante.cpbNum }}</td>
                          <td>
                            @{{ movim.centro_costo != null ? movim.centro_costo.ccCod + ' ' + movim.centro_costo.ccDesc : '' }}
                          </td>
                          <td>
                            @{{ movim.auxiliar != null ? movim.auxiliar.codAux + ' ' + movim.auxiliar.nomAux + ' ' + movim.auxiliar.apllAux : '' }}
                          </td>
                          <td>@{{ movim.TipDocRef }}</td>
                          <td>@{{ movim.NumDocRef }}</td>
                          <td>@{{ movim.movDebe }}</td>
                          <td>@{{ movim.movHaber }}</td>
                          <td>@{{ movim.movGlosa }}</td>
                        </tr>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="12">
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
  <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
  <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.es.js') }}"></script>

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
          periodoActivo: {!! json_encode($periodoActivo->idPeriod) !!},
          filtro: {
            periodo: {!! json_encode($periodoActivo->idPeriod) !!},
            cuentas: [],
            areaNegocio: 'all',
            desde: '',
            hasta: '',
          },
          movimientos: [],
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

        $("#datepicker .input-group.date").datepicker({
          todayBtn: "linked",
          keyboardNavigation: false,
          forceParse: false,
          calendarWeeks: true,
          autoclose: true,
          language: "es",
          clearBtn: true,
          startDate: "01/01/{!! $periodoActivo->anoPeriod !!}",
          endDate: "31/12/{!! $periodoActivo->anoPeriod !!}"
        }).on(
          "changeDate", () => {
            vm.filtro.desde = $("input#filtro_desde").datepicker('getFormattedDate');
            vm.filtro.hasta = $("input#filtro_hasta").datepicker('getFormattedDate');
          }
        );

        $(".footable").footable();
        
        $('.select-2').trigger('change');
      },
      computed: {
        //
      },
      methods: {
        generarExcel: function() {
          vm.movimientos = [];

          let formData = new FormData();
          formData.append('filtros', JSON.stringify(this.filtro));
          var self = this;
          axios.post("{{route('contaparroquial.contabilidad.libro-mayor.preview')}}",
            formData,
          ).then(function(response) {
            console.log('SUCCESS!!', response.data);
            if (response.data.data.length == 0) {
              return toastr['error']('No se encontraron movimientos segun sus criterios de busqueda', 'Advertencia');
            }
            vm.movimientos = response.data.data;
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
            cuentas: this.filtro.cuentas,
            areaNegocio: this.filtro.areaNegocio,
            desde: this.filtro.desde,
            hasta: this.filtro.hasta,
          }

          var url = "{{route('contaparroquial.contabilidad.libro-mayor.download')}}?" + $.param(query)
          return window.open(url, '_blank');
        },

        cambioDePeriodo: function() {
          let periodo = $('#filtro_periodo').select2('data')[0].text.trim();
          this.filtro.desde = '';
          this.filtro.hasta = '';

          $("input#filtro_desde")
            .datepicker('setStartDate', "01/01/"+periodo)
            .datepicker('setEndDate', "31/12/"+periodo);

          $("input#filtro_hasta")
            .datepicker('setStartDate', "01/01/"+periodo)
            .datepicker('setEndDate', "31/12/"+periodo);
          
            $("#datepicker .input-group.date").trigger('change');
        }
      }
    });
  </script>
  @endsection
