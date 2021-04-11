<!--Formulario de Preboleta  -->
@extends('layouts.admin')
@section('title', 'Preboleta')
@section('content')
@include('ValidaNotificacion')
 <div class="content__inner">
 <header class="content__title">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <div>
                <div class="float-right col-lg-4">
                    <button hidden type="submit" class="btn btn-success btn-lg btn-block" id="NuevoAgente">Agregar Agente Pastoral</button> 
                </div>
                
                <div class="col-lg-10">
                    <h2>@include('layouts.urSeleccionada') / Ficha Agente Pastoral</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        {{-- <li class="breadcrumb-item">
                            <a href="{{ asset('pastoral/listado') }}">Agentes Pastorales</a>
                        </li> --}}
                        <li class="breadcrumb-item">
                            <strong>Preboleta</strong>
                        </li>
                    </ol>
                </div>
                <!-- <div class="col-lg-2"></div> -->
            </div>
        </div>
    </div>
</header>


<div class="wrapper wrapper-content espacio">
    <div class="card">
        <div class="card-body">
            <h3 class="card-body__title">REGISTRAR DATOS</h3>
            <hr>
            <form action="{{ route('PdfPreboleta') }}" target="_blank" method="POST">
            @csrf
                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                            <?php
                            $fecha = date('Y-m');
                            $fecha_e = strtotime('-1 month', strtotime($fecha));
                            $fecha_e = date('Y/m', $fecha_e);
                            ?>
                            <input type="text" style="display:none;" value="12" id="p_parroquial">
                            
                            <label>Fecha Estadística (*)</label>
                            <input type="text" name="fecha_estadistica" id="fecha_estadistica" class="form-control"
                                data-mask="0000-00" placeholder="Fecha Estadística" title="Fecha Estadística"
                                value="{{ $fecha_e }}" tabindex="11" required>
                            <i class="form-group__bar"></i>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Tipo Pago</label>
                            {{ Form::select('tipo_pago',$tipo_pago, 1,['class'=>'form-control select2','id'=>'tipo_pago','name'=>'tipo_pago', 'tabindex'=>'12']) }}
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>N° Contribuyente</label>
                            {!! Form::number('nro_contribuyente',null,['class'=>'form-control solo-numero','placeholder'=>'N° Contribuyente','name'=>'nro_contribuyente', 'id'=>'nro_contribuyente', 'tabindex'=>'13']) !!}
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>N° Cuotas</label>
                            {!! Form::number('n_cuotas', $value = '0' , ['class' =>'form-control solo-numero','placeholder'=>'1', 'name'=>'n_cuotas','id'=>'n_cuotas', 'tabindex'=>'14']) !!}
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>N° Visitadores</label>
                            {!! Form::number('n_visitadores', null,['class' =>'form-control solo-numero','placeholder'=> '0','name'=>'n_visitadores','id'=>'n_visitadores', 'tabindex'=>'15']) !!}
                        </div>
                    </div>

                </div>

                <!-- Javascript id row datos -->
                <div id="row_datos">
                    <div class="row">
                        <div class="col-sm-4">
                                <h5><span class="badge badge-pill badge-secondary"> Contribución : </span></h5>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-7">
                            <div class="input-group m-b">
                                <div class="input-group-prepend">
                                    <span class="input-group-addon">$</span>
                                </div>
                                {!! Form::text('monto_aporte', null,['class' =>'form-control input-mask','placeholder'=> '0','id'=>'monto_aporte','name'=>'monto_aporte','required', 'tabindex'=>'16']) !!}
                            </div>
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                            <label>Comisión</label>
                            </div>
                        </div>
                        
                        <div class="col-sm-3">
                            <div class="input-group m-b">
                                <div class="input-group-prepend">
                                    <input id="comision" type="text" class="form-control" tabindex="17" value="10" readonly name="comision" maxlength="3">
                                </div>
                                <span class="input-group-addon">%</span>
                            </div>
                        </div>

                        <div class="col-sm-5">
                            <div class="input-group m-b">
                                <div class="input-group-prepend">
                                    <span class="input-group-addon">$</span>
                                </div>
                                {!! Form::text('recaudacion', null,['class' =>'form-control','placeholder'=> '0','id'=>'recaudacion','name'=>'recaudacion', 'required', 'tabindex'=>'18', 'required','readonly']) !!}
                            </div>
                        </div>

                    </div>

                </div>
                <!-- Fin Javascript id row datos -->


                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Otros gastos</label>
                        </div>
                    </div>

                    <div class="col-sm-5">
                        <div class="input-group m-b">
                            <div class="input-group-prepend">
                                <span class="input-group-addon">$</span>
                            </div>
                            {!! Form::number('c_gasos', '0',['value' => 0,'class' =>'form-control','placeholder'=> '0','id'=>'c_gastos','name'=>'c_gastos', 'tabindex'=>'19']) !!}
                        </div>
                    </div>
                </div>
                <div class="row">

                    <div class="col-sm-4">
                        <div class="form-group">
                        <label>Part. Parroquial</label>
                        </div>
                    </div>

                    <div class="col-sm-5">
                        <div class="input-group m-b">
                            <div class="input-group-prepend">
                                <span class="input-group-addon">$</span>
                            </div>
                            {!! Form::text('m_parroquial', null,['class' =>'form-control solo-numero','placeholder'=> '0', 'id'=>'m_parroquial','name'=>'m_parroquial', 'tabindex'=>'20', 'required','readonly']) !!}
                        </div>
                    </div>

                </div>


                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>1% Aporte Papal</label>
                            {!! Form::text('aporte_papal', 1,['class' =>'form-control','placeholder'=> '0','required','name'=>'aporte_papal','id'=>'aporte_papal','readonly']) !!}
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Part. Diocesano</label>
                            {!! Form::text('m_diocesano', null,['class' =>'form-control','placeholder'=> '0','id'=>'m_diocesano','name'=>'m_diocesano', 'required', 'readonly', 'tabindex'=>'22']) !!}
                            <i class="form-group__bar"></i>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label>Total a cancelar</label>
                            <br>
                            <label id="valor_tesoreria">$ 0</label>
                            <i class="form-group__bar"></i>
                        </div>
                    </div>
                </div>

                <div class="row">
                    
                    <div class="col-sm-4" style="display:none;" id="div_tesoreria">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <div class="form-group">
                                {!! Form::text('tesoreria', null,['class' =>'form-control','placeholder'=> '0','id'=>'tesoreria','name'=>'tesoreria', 'tabindex'=>'21']) !!}
                                <i class="form-group__bar"></i>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="modal-footer">
                    <button type="submit" id="GuardarBoleta" class="btn btn-outline-success">Generar documento </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('javascript')       
<script src="{{ asset('vendors/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script src="{{ asset('js/ValidarInput.js')}}"></script>
<script src="{{ asset('js/unoporciento/preboleta.js')}}"></script>    
@endsection
