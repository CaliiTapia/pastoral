@extends('layouts.admin')
@section('title', 'Informes')
@section('content')
@include('ValidaNotificacion')
<header class="content__title">
     <h1><a href="{{asset('informes/')}}" style="color: #000000"> PARROQUIAL / INFORMES / CANCELACIONES DE CONTRIBUYENTES </a></h1>
          <div class="actions">
                <a class="btn boton" href="" role="button">Agregar</a>
                <div class="dropdown actions__item">
                    <i data-toggle="dropdown" class="zmdi zmdi-more-vert"></i>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a href="" class="dropdown-item boton">Refrescar</a>
                    </div>
                </div>
          </div>
</header>

<div class="card">
    <div class="card-body">
        <h3 class="card-title">Informe Cancelaciones Contribuyentes</h3>
            <form action="{{ route('detallePagoContribuyente') }}" method="post" name="reporte">
                {{ csrf_field() }}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
        
        <div class="row">
            <!--- SELECT PARA TIPO DE INFORME 
            <div class="col-lg-3 col-md-3 col-sm-6 col-sx-12 form-group">
                <label>Seleccione tipo informe:</label>
                    <select class="select2" name="SelTipoInforme" id="SelTipoInforme">
                        <option disabled selected>Tipo informe</option>
                        <option value="1">Estadistíco</option>
                        <option value="2">Contable</option>
                    </select>
            </div>-->
     
            <!-- SELECT PARA EL AÑO -->
            <div class="col-lg-3 col-md-3 col-sm-6 col-sx-12 form-group">
                <label>Seleccione Periodo:</label>
                    <select class="select2" name="SelAno" id="SelAno">
                        <option disabled selected>Año</option>
                            @for($i=2001; $i<=date("Y"); $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                    </select>
            </div> 
            <!-- SELECT DE CONTRIBUYENTE -->
            <div class="col-lg-3 col-md-3 col-sm-6 col-sx-12 form-group">
                <label>Seleccione Contribuyente:</label>
                    <select class="select2" name="SelContribuyente" id="SelContribuyente">
                        <option disabled selected>Contribuyente</option>
                            @foreach($contribuyentes as $contribuyente)
                                <option value="{{$contribuyente->IdContribuyente}}">
                                    {{$contribuyente->IdContribuyente}} - {{$contribuyente->Nombre}} {{$contribuyente->ApellidoPaterno}}
                                </option>
                            @endforeach
                    </select>
            </div>
</div>
</div>
</div>


        <div class="card">
        <div class="card-body">
            <h3 class="card-title">Contribuyentes</h3>
            <table id="data-table" class="table table-responsive">
                <thead>
                <tr>
                    <th></th>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>A. Paterno</th>
                    <th>Rut Contribuyente</th>
                    <th>Fecha</th>
                    <th>Monto</th>
                </tr>
                </thead>
                <tbody>
                @foreach($contribuyentes as $contribuyente)
                @foreach()
                    <tr>
                        <td></td>
                        <td>{{ $contribuyente->IdContribuyente }}</td>
                        <td>{{ $contribuyente->Nombre }}</td>
                        <td>{{ $contribuyente->ApellidoPaterno }}</td>
                        <td>{{ $contribuyente->Rut }}</td>
                        <td>{{ $contribuyente->FechaPago }}</td>
                        <td>{{ number_format($contribuyente->MontoPagado, 0 ,'.', '.') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        
        </div>

@endsection

