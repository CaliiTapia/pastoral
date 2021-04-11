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
        <li class="breadcrumb-item active">
          <strong>Ingreso Masivo</strong>
        </li>
      </ol>
    </div>
    <div class="col-lg-2">
      <a class="btn btn-success" type="button" style="margin-top: 40px;"
        href="{{ asset('downloads/ingreso-masivo-ejemplo.xlsx') }}" target="_blank"><i class="fa fa-file-excel-o"></i>
        <span class="bold">Plantilla ingreso masivo</span>
      </a>
    </div>
  </div>
  <div class="wrapper wrapper-content animated fadeInRight" id="nuevoCbte">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox">
          <div class="ibox-title espacio_encabezado">
            <h2>Nuevo ingreso masivo</h2>
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
                  <label class="col-form-label">Fecha comprobante</label>
                  <div class="input-group date">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text"
                      class="form-control">
                  </div>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label class="col-form-label" for="">Tipo</label>
                  <select name="tipo" class="form-control select2" v-model="Cabecera.Tipo" v-select2>
                    <option value="I">Ingreso</option>
                    <option value="E">Egreso</option>
                    <option value="T">Traspaso</option>
                  </select>
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label class="col-form-label" for="">Area negocio</label>
                  <select name="areaNegocio" class="form-control select2" v-model="Cabecera.areaNegocio" v-select2>
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
                  <label class="col-form-label" for="product_name">Glosa</label>
                  <input type="text" v-model="Cabecera.Glosa" class="form-control">
                </div>
              </div>
            </div>

            <div v-show="CabeceraEsValida">
              <hr>
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label class="col-form-label">Archivo ingreso masivo</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input id="adjunto_documento" type="file" ref="file" class="custom-file-input" accept=".xlsx"
                          v-on:change="onFileChange">
                        <label class=" custom-file-label" for="adjunto_documento">Sube aqui el documento</label>
                      </div>
                    </div>
                    <p class="text-warning">
                      <i class="fa fa-exclamation"></i>
                      utilice el excel de ejemplo.
                    </p>
                  </div>
                </div>
                <div class="col-md-1">
                  <button class="btn btn-success dim" type="button" @click="uploadMassiveIncome()"
                    style="margin-top: 30px;"><i class="fa fa-cloud-upload"></i></button>
                </div>
              </div>
            </div>

            <div v-show="ExistenMovimientos">
              <hr>
              <h2>Movimientos</h2>
              <table class="table table-striped toggle-arrow-tiny">
                <thead>
                  <tr>
                    <th>Codigo cuenta contable</th>
                    <th>Debe</th>
                    <th>Haber</th>
                    <th>Glosa</th>
                    <th>Centro de costos</th>
                    <th>Auxiliar</th>
                    <th>Tipo de documento</th>
                    <th>N° documento</th>
                    <th></th>
                  </tr>
                </thead>
                <template>
                  <tbody>
                    <tr v-for="(movim, m) in Movimientos" :key="m">
                      <td>
                        @{{ movim[0] }}
                      </td>
                      <td>
                        @{{ movim[1] }}
                      </td>
                      <td>
                        @{{ movim[2] }}
                      </td>
                      <td>
                        @{{ movim[3] }}
                      </td>
                      <td>
                        @{{ movim[4] }}
                      </td>
                      <td>
                        @{{ movim[5] }}
                      </td>
                      <td>
                        @{{ movim[6] }}
                      </td>
                      <td>
                        @{{ movim[7] }}
                      </td>
                      <td>
                        <p v-for="(error, n) in movim[8]" :key="n">
                          <i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i> @{{ error }}
                        </p>
                      </td>
                    </tr>
                  </tbody>
                  <tfoot>
                    <tr>
                      <th>Total:</th>
                      <th>@{{ Cabecera.totalDebe }}</th>
                      <th>@{{ Cabecera.totalHaber }}</th>
                      <th colspan="6">
                        <p v-show="( !TotalesValidos )">
                          <i class="fa fa-exclamation-circle text-danger" aria-hidden="true"></i> Los movimientos no se
                          encuentran cuadrados, rectifique antes de continuar.
                        </p>
                      </th>
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
                  @click="procesarIngresoMasivo">
                  <i class="fa fa-save"></i> Procesar ingreso masivo
                </button>
              </div>
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
        el: '#vue-app',
        data() {
            return {
                periodoActivo: {!! json_encode($periodoActivo) !!},
                Cabecera: {
                    'Ncbte': '{!! $nroComprobante !!}',
                    'Fecha': '',
                    'Tipo': '',
                    'areaNegocio': '',
                    'Glosa': '',
                    'totalDebe': 0,
                    'totalHaber': 0,
                },
                file: '',
                Movimientos: [],
                ingresoMasivoPassed: false,
            }
        },
        beforeUpdate() {
          //
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

            $("#select-tipoDoc").select2({
                theme: 'bootstrap4',
                width:'100%',
                placeholder: "Seleccione una opcion",
                dropdownParent: $('#modalDocComprobante > div > div > div.modal-body')
            });
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
            ComprobanteValido() {
                return this.CabeceraEsValida && this.ExistenMovimientos && this.ingresoMasivoPassed;
            }
        },
        methods: {
            uploadMassiveIncome: function() {
                let formData = new FormData();
                formData.append('cabecera', JSON.stringify(this.Cabecera));
                formData.append('file', this.file);
                var self = this;
                axios.post("{{route('contaparroquial.contabilidad.ingreso-masivo.check')}}", formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                ).then(function(response) {
                    console.log('SUCCESS!!', response.data);
                    if (response.data.passed) {
                      toastr['success']('El archivo se encuentra verificado, si lo desea puede procesarlo ahora', 'Archivo verificado');
                    } else {
                      toastr['error']((response.data.message != '' ? response.data.message : 'Compruebe el archivo, se encontraron errores al verificar'), "Advertencia");
                    }

                    vm.Movimientos = response.data.movimientos;
                    vm.Cabecera.totalDebe = response.data.totales.debe;
                    vm.Cabecera.totalHaber = response.data.totales.haber;
                    vm.ingresoMasivoPassed = response.data.passed;
                })
                .catch(function(error) {
                    console.log('FAILURE!!', error.response);
                    return toastr['error']('Detectamos un error en su navegador, intente nuevamente mas tarde', "Advertencia");
                });
            },

            procesarIngresoMasivo: function(){
              let formData = new FormData();
                formData.append('cabecera', JSON.stringify(this.Cabecera));
                formData.append('file', this.file);
                var self = this;
                axios.post("{{route('contaparroquial.contabilidad.ingreso-masivo.process')}}", formData,
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
                    self.siteReload(3000);
                    return toastr['success'](response.data.message, 'Guardado');
                })
                .catch(function(error) {
                    console.log('FAILURE!!', error.response);
                    return toastr['error']('Detectamos un error en su navegador, intente nuevamente mas tarde', "Advertencia");
                });
            },

            onFileChange: function(){
                this.file = this.$refs.file.files[0];
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
