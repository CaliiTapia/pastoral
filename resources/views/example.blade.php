@extends('layouts.admin')

@section('header')

@endsection

@section('content')
<style>

</style>

<div id="vue-app">
  <div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
      <h2>Modulo</h2>
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="{{ route('home') }}">Home</a>
        </li>
        <li class="breadcrumb-item active">
          <strong>Menu</strong>
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
            <h2>Descripcion del menu</h2>
            <div class="ibox-tools encabezado_tabs">
            </div>
          </div>
          <div class="ibox-content">
            <div class="row">


            </div>

          </div>
          <div class="ibox-content">
            <div class=" row">
              <div class="col-md-12">

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

  <script>
    const vm = new Vue({
      el: '#vue-app',
      data() {
        return {
          //
        }
      },
      beforeUpdate() {
        //
      },
      mounted() {
        //
      },
      computed: {
        //
      },
      methods: {
        //
      }
    });
  </script>
  @endsection
