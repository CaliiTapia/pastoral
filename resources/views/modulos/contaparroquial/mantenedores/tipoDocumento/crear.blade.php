@extends('layouts.admin')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Tipo documento</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Tipo de documento</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Nuevo tipo de documento</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title espacio_encabezado">
                    <h4>Nuevo tipo de documento</h4>  
                </div>    
                <div class="ibox-content">
                {!! Form::open(['action' => 'TipoDocumentoController@store', 'method' => 'POST']) !!} 
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label" for="product_name">Código</label>
                                <input type="text" id="tipDoc" maxlength="2" value="" name="tipDoc" placeholder="-- Ingrese código --" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"  id="datepicker">
                                <label class="col-form-label">Descripción tipo de documento</label>
                                <input type="text" id="descTD" maxlength="18" value="" name="descTD" placeholder="-- Ingrese descripción --" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label" for="status">Status</label>
                                <select name="statusTD" id="statusTD" class="form-control select2" required>
                                    <option disabled selected>-- Seleccione una opción --</option>
                                    <option value="A">Habilitado</option>
                                    <option value="I">Deshabilitado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="text-right" >
                            <button type="submit" id="btnAgregar" class="btn btn-primary" ><i class="fa fa-save"></i> Guardar</button>     
                        </div>
                    </div> 
                    {!! Form::close() !!}                
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