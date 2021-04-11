@extends('layouts.admin')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-9">
        <h2>Reportes</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Reportes</strong>
            </li>
        </ol>
    </div> 
    <div class="col-lg-3">
            <div style="margin:40px 0px 0px 40px">
                <a class="btn btn-success" href="{{ URL::to('contaparroquial/mantenedores/reportes/downloadGeneral') }}" role="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Reporte General Parroquia</a>
            </div>
    </div>   
</div>
<br>
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                    <h3>Reporte detallado</h3>  
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <a class="btn btn-primary" href="{{ URL::to('contaparroquial/mantenedores/reportes/downloadAreaNegocio') }}" role="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Área de negocio</a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <a class="btn btn-primary" href="{{ URL::to('contaparroquial/mantenedores/reportes/downloadCentroCosto') }}" role="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Centro de costos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                <h3>Listado de tipos de documentos</h3>  
                    <hr>
                    <div class="row">
                    <div class="col-md-3">
                            <div class="form-group">
                                <a class="btn btn-primary" href="{{ URL::to('contaparroquial/mantenedores/reportes/downloadTipoDocumento') }}" role="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Tipo de documento</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                <h3>Listado de plan de cuentas</h3>  
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <a class="btn btn-primary" href="{{ URL::to('contaparroquial/mantenedores/reportes/downloadPlanDeCuentas') }}" role="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Plan de cuentas</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-content">
                <h3>Listado de auxiliares</h3>  
                    <hr>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <a class="btn btn-primary" href="{{ URL::to('contaparroquial/mantenedores/reportes/downloadAuxiliares') }}" role="button"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Auxiliares</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
    

@endsection