@extends('layouts.admin')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Periodo</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Periodo</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Editar periodo</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title espacio_encabezado">
                    <h4>Editar periodo</h4>  
                </div>    
                <div class="ibox-content">
                @foreach($datos as $da)
                {!! Form::open(['action' => ['PeriodoController@edit',$da->idPeriod], 'method' => 'POST']) !!} 
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label" for="product_name">Código</label>
                                <input type="text" id="codP" name="codP" value="{{ $da->idPeriod }}" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group"  id="datepicker">
                                <label class="col-form-label">Año periodo</label>
                                <input type="text" id="anoP" maxlength="4" value="{{ $da->anoPeriod }}" name="anoP" class="form-control" min="0" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label" for="status">Status</label>
                                <select name="statusP" id="statusP" class="form-control select2" required> 
                                    <option disabled>-- Seleccione una opción --</option>
                                    @if($da->anoStatus=='A')
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

</script>
@endsection