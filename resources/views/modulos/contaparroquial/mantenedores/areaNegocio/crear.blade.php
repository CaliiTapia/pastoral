@extends('layouts.admin')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Área de negocio</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Área de negocio</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Crear área de negocio</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title espacio_encabezado">
                    <h4>Nueva área de negocio</h4>  
                </div>    
                <div class="ibox-content">
                {!! Form::open(['action' => 'AreaNegocioController@store', 'method' => 'POST']) !!} 
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label" for="product_name">Código</label>
                                <input type="text" id="codANe" name="codANe" value="{{ $idMasUno }}" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"  id="datepicker">
                                <label class="col-form-label">Nombre área de negocio</label>
                                <input type="text" id="nomANe" name="nomANe" placeholder="-- Ingrese nombre --" class="form-control" required>
                           </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label" for="status">Status</label>
                                <select name="statusANe" id="statusANe" class="form-control select2" required>
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