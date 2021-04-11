@extends('layouts.admin')

@section('content')

<div id="vue-app">
  <div class="middle-box text-center animated fadeInDown">
    <h1>401</h1>
    <h3 class="font-bold">Error de acceso</h3>

    <div class="error-desc">
      <h2>
        {{ (isset($errorObject) && $errorObject['message'] != null) ? $errorObject['message'] : 'Error al acceder al contenido solicitado' }}
      </h2>

      <a class="btn btn-success" type="button" style="margin-top: 40px;"
        href="{{ (isset($errorObject) && $errorObject['returnTo'] != null) ? $errorObject['returnTo'] : route('home') }}">
        <i class="fa fa-long-arrow-left"></i>
        <span class="bold">Volver</span></a>
    </div>
  </div>
</div>
@endsection

@section('javascript')

<script>
  $(document).ready(function() {
    //
  });
</script>
@endsection
