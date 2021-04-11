@extends('layouts.admin')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h1>Periodo</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Periodo</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Nuevo periodo</strong>
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
                    <h2>Nuevo periodo</h2>  
                </div>
                <div class="ibox-content">
                {!! Form::open(['action' => 'PeriodoController@store', 'method' => 'POST']) !!} 
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong><label class="col-form-label" for="product_name">Código</label></strong>
                                <input type="text" id="idC" value="{{ $idMasUno }}" placeholder="" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong><label class="col-form-label" for="product_name">Año periodo</label></strong>
                                <input type="text" id="anoPeriod" maxlength="4" value="" name="anoPeriod" placeholder="-- Ingrese año periodo --" class="form-control" min="0" size="4" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong><label class="col-form-label" for="product_name">Status</label></strong>
                                <select name="statusP" id="statusP" class="form-control select2" required>
                                    <option disabled selected>-- Seleccione una opción --</option>
                                    <option value="A">Habilitado</option>
                                    <option value="I">Deshabilitado</option>
                                </select>
                            </div>
                        </div>
                    </div>                  
                    <div class="text-right" >
                        <button type="submit" id="btnAgregar" class="btn btn-primary" ><i class="fa fa-save"></i> Guardar</button>
                    </div>
                {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
  

</script>
@endsection