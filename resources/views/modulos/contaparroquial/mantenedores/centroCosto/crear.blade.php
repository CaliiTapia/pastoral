@extends('layouts.admin')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h1>Centro de costo</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Centro de costo</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Nuevo centro de costo</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight" id="nuevoCbte">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title espacio_encabezado">
                    <h2>Nuevo centro de costo</h2>  
                </div>
                <div class="ibox-content">
                {!! Form::open(['action' => 'CentroCostoController@store', 'method' => 'POST']) !!} 
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong><label class="col-form-label" for="product_name">Código</label></strong>
                                <input type="text" id="id" value="{{ $idMasUno }}" placeholder="" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong><label class="col-form-label" for="product_name">Status</label></strong>
                                <select name="tipo" id="status" class="form-control select2" required >
                                    <option disabled selected>-- Seleccione una opción --</option>
                                    <option value="A">Habilitado</option>
                                    <option value="I">Deshabilitado</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong><label class="col-form-label" for="product_name">Descripción</label></strong>
                                <input type="text" id="descCC" name="descCC" placeholder="-- Ingrese descripción --" class="form-control" required >
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

@endsection

@section('javascript')
<script>
  

</script>
@endsection