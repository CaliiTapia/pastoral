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
                <strong>Editar tipo de documento</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title espacio_encabezado">
                    <h4>Editar tipo de documento</h4>  
                </div>    
                <div class="ibox-content">
                @foreach($datos as $td)
                {!! Form::open(['action' => ['TipoDocumentoController@edit',$td->TipDoc], 'method' => 'POST']) !!} 
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label" for="product_name">Código</label>
                                <input type="text" id="codTD"  maxlength="2" name="codTD" value="{{ $td->TipDoc }}" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"  id="datepicker">
                                <label class="col-form-label">Nombre área de negocio</label>
                                <input type="text" id="nomTD" name="nomTD" maxlength="18" value="{{ $td->DesTipDoc }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label" for="status">Status</label>
                                <select name="statusTD" id="statusTD" class="form-control select2" required > 
                                    <option disabled>-- Seleccione una opción --</option>
                                    @if($td->TipDocStatus=='A')
                                        <option value="A" selected>Habilitado</option>
                                        <option value="I">Deshabilitado</option>
                                    @else
                                        <option value="A" >Habilitado</option>
                                        <option value="I" selected>Deshabilitado</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div>
                        <div class="text-right" >
                            <button type="submit" id="btnEditar" class="btn btn-primary" ><i class="fa fa-save"></i> Guardar</button>     
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
    $('#codTD').on('keyup',function(){
        var codTd = $("#codTD").val();        
        codTd = codTd.toUpperCase();
        $("#codTD").val(codTd);
    });
</script>
@endsection