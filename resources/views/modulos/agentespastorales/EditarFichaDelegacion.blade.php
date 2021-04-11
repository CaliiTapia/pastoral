@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')
<header class="content__title">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <div>
                <div class="col-lg-10">
                    <h2> Ficha Agente Pastoral</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ asset('pastoral/listado') }}">Agentes Pastorales</a>
                        </li>
                        <li class="breadcrumb-item">
                            <strong>Editar Ficha</strong>
                        </li>
                    </ol>
                </div>
                <!-- <div class="col-lg-2"></div> -->
            </div>
        </div>
    </div>
</header>
<div class="wrapper wrapper-content espacio">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-title">
                <h5><strong>FICHA AGENTE PASTORAL</strong></h5><small class="m-l-sm"> Campos obligatorios (*)</small>
            </div>
            
            <div class="ibox-content">
                <form class="wizard-big" id="form-steps">
                    <h1>Datos Personales</h1>
                    <div class="step-content">
                        <div class="content clearfix">
                        <h2>Información Personal</h2>

                        <div class="row " style="margin-top: 25px;">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <legend>
                                        Tipo de documento <small>(*)</small>
                                    </legend>
                                    <div class="form-check abc-radio abc-radio-info form-check-inline">
                                        <input class="form-check-input" type="radio" id="tpDocumentoR" value="rut" name="tpDocumento" @if($ficha->TipoDocumento == 'rut') checked @endif required disabled>
                                        <label class="form-check-label" for="tpDocumentoR"> Rut </label>
                                    </div>
                                    <div class="form-check abc-radio abc-radio-info form-check-inline">
                                        <input class="form-check-input" type="radio" id="tpDocumentoP" value="pasaporte" name="tpDocumento" @if($ficha->TipoDocumento == 'pasaporte') checked @endif required disabled>
                                        <label class="form-check-label" for="tpDocumentoP"> Pasaporte </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="rut">Rut/Pasaporte <small>(*) (Sin puntos ni guion)</small></label>
                                    <input type="text" id="rut" value="{{ $ficha->NumeroDocumento.$ficha->Dv }}" class="form-control rounded" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pais">País  de origen <small>(*)</small></label>
                                    <select class="form-control select2-steps rounded activFicha" name="pais" id="pais" required tabindex="1" disabled>
                                        <option value="{{ null }}">--Seleccione-- </option>
                                        @foreach ($paises as $pais)
                                            @if($pais->IdPais == $ficha->P_IdPais)
                                                <option  value="{{ $pais->IdPais }}" selected>{{ $pais->Nombre }}</option>
                                            @else
                                                <option  value="{{ $pais->IdPais }}">{{ $pais->Nombre }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre">Nombre <small>(*)</small></label>
                                    <input type="text" name="nombre" id="nombre" value="{{ $ficha->Nombre }}" class="form-control rounded solo-letras" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="apellidoPaterno">Apellido Paterno <small>(*)</small></label>
                                    <input type="text"  name="apellidoPaterno" id="apellidoPaterno" value="{{ $ficha->ApellidoPaterno }}" class="form-control rounded solo-letras" disabled>
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                    <label for="apellidoMaterno">Apellido Materno <small>(*)</small></label>
                                    <input type="text"  name="apellidoMaterno" id="apellidoMaterno" value="{{ $ficha->ApellidoMaterno }}" class="form-control rounded solo-letras" disabled>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for=nacimiento>Fecha de Nacimiento <small>(*)</small></label>
                                    <input type="date" name="nacimiento" value="{{ $ficha->FechaNacimiento }}" id="nacimiento"  class="form-control" required tabindex="5" disabled>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estadocivil">Estado Civil <small>(*)</small></label>
                                    <select class="form-control select2-steps rounded" name="estadocivil" id="estadocivil" required tabindex="6" disabled>
                                        <option value="{{ null }}">--Estado Civil-- </option>
                                        @foreach ($estadocivil as $e)
                                            @if($e->IdEstadoCivil == $ficha->EC_IdEstadoCivil)
                                                <option value="{{ $e->IdEstadoCivil }}" selected>{{ $e->EstadoCivil }}</option>  
                                            @else
                                                <option value="{{ $e->IdEstadoCivil }}">{{ $e->EstadoCivil }}</option>  
                                            @endif  
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <legend>
                                        Sexo <small>(*)</small>
                                    </legend>
                                    <div class="form-check abc-radio abc-radio-info form-check-inline">
                                        <input class="form-check-input" type="radio" id="sexoH" 
                                        @if($ficha->Sexo == 'M')
                                            checked 
                                        @endif
                                        value="M" name="sexo" required tabindex="7" disabled>
                                        <label class="form-check-label" for="sexoH"> Masculino </label>
                                    </div>
                                    <div class="form-check abc-radio abc-radio-info form-check-inline">
                                        <input class="form-check-input" type="radio" id="sexoM"
                                        @if($ficha->Sexo == 'F')
                                            checked
                                        @endif
                                         value="F" name="sexo" required tabindex="8" disabled>
                                        <label class="form-check-label" for="sexoM"> Femenino </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <legend>
                                        Sacramentos <small>(*)</small>
                                        <br><small>Puede Seleccionar más de una Opción</small>
                                    </legend>
                                    <div  class="form-check abc-checkbox abc-checkbox-info abc-checkbox-circle form-check-inline">
                                        <input type="checkbox" @if($ficha->FlgBautismo == 'S')checked @endif class="form-check-input" id="OpBautismo" value="S" name="bautismo" tabindex="9" disabled>
                                        <label class="form-check-label" for="OpBautismo"> Bautismo </label>
                                    </div>
                                    <div  class="form-check abc-checkbox abc-checkbox-info abc-checkbox-circle form-check-inline">
                                        <input type="checkbox" @if($ficha->FlgComunion == 'S')checked @endif class="form-check-input" id="OpComunion" value="S" name="comunion"tabindex="10" disabled>
                                        <label class="form-check-label" for="OpComunion"> Primera Comunión </label>
                                    </div>
                                    <div  class="form-check abc-checkbox abc-checkbox-info abc-checkbox-circle form-check-inline">
                                        <input type="checkbox" @if($ficha->FlgConfirmacion == 'S')checked @endif class="form-check-input" id="OpConfirmacion" value="S" name="confirmacion" tabindex="11" disabled>
                                        <label class="form-check-label" for="OpConfirmacion"> Confirmación </label>
                                    </div>
                                    <div  class="form-check abc-checkbox abc-checkbox-info abc-checkbox-circle form-check-inline">
                                        <input type="checkbox" @if($ficha->FlgMatrimonio == 'S')checked @endif class="form-check-input" id="OpMatrimonio" value="S" name="matrimonio" tabindex="12" disabled>
                                        <label class="form-check-label" for="OpMatrimonio"> Matrimonio </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <h1>Datos de Contacto</h1>
                <div class="step-content">
                    <div class="content clearfix">
                        <h2>Información de Contacto</h2>

                        <div class="row" style="margin-top: 25px;">
                            <div class="col-md-6">
                                    <div class="form-group">
                                    <label for="telefono">Teléfono Fijo </label>
                                    <input type="text"  placeholder="Ej: 298765432"  name="fijo" id="fijo" value="{{ $ficha->TelefonoFijo }}" class="form-control fono rounded"  tabindex="13" disabled>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono">Teléfono Celular <small>(*)</small></label>
                                    <input type="text"  placeholder="Ej: 998765432" name="celular" id="celular" value="{{ $ficha->TelefonoMovil }}" class="form-control fono rounded" tabindex="14" required disabled> 
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Correo Electrónico <small>(*)</small></label>
                                    <input type="email" placeholder="email@iglesiadesantiago.cl" name="correo" value="{{ $ficha->Correo }}" onblur="StringMax(this.id,this.value,50)" id="correo" class="form-control rounded" tabindex="15" required disabled>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="direccion">Dirección <small>(*)</small></label>
                                    <input type="text" name="direccion" id="direccion" class="form-control rounded espacio-centro" value="{{ $ficha->Direccion }}" onblur="StringMax(this.id,this.value,190)" required tabindex="16" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="region">Región <small>(*)</small></label>
                                    <select class="form-control select2-steps rounded" name="region" id="region" required tabindex="17" disabled>
                                        <option value="{{ null }}">--Selecciona Tu Región-- </option>
                                        @foreach ($regiones as $region)
                                            @if($ficha->R_IdRegion == $region->IdRegion)
                                            <option value="{{ $region->IdRegion }}" selected>{{ $region->Nombre }}</option>
                                            @else
                                            <option value="{{ $region->IdRegion }}">{{ $region->Nombre }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="comuna">Comuna <small>(*)</small></label>
                                    <select class="form-control select2-steps rounded" name="comuna" id="comuna" required tabindex="18" disabled>
                                        <option value="{{ null }}">--Seleccione-- </option>
                                        @foreach ($comunas as $comuna)
                                            @if($ficha->C_IdComuna == $comuna->IdComuna)
                                            <option value="{{ $comuna->IdComuna }}" selected>{{ $comuna->Nombre }}</option>
                                            @else
                                            <option value="{{ $comuna->IdComuna }}">{{ $comuna->Nombre }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeIn espacio">
    <div class="ibox-content ">
        <div class="tabs-container">
            <ul class="nav nav-tabs" role="tablist">
                <li><a class="nav-link active" data-toggle="tab" href="#tab-1">Historial Participación Parroquial</a></li>
                @role('Parroco')
                    <li><a class="nav-link" data-toggle="tab" href="#tab-2" hidden>Referencias</a></li>
                @endrole
                <li><a class="nav-link" data-toggle="tab" href="#tab-3">Formación</a></li>
            </ul>
        
            <div class="tab-content" id="tabs">
                <div role="tabpanel" id="tab-1" class="tab-pane active">
                    @include('modulos.agentespastorales.include.ParticipacionPDel')
                </div>
                @role('Parroco')
                <div role="tabpanel" id="tab-2" class="tab-pane">
                    @include('modulos.agentespastorales.include.Referencias')
                </div>
                @endrole
                <div role="tabpanel" id="tab-3" class="tab-pane">
                    @include('modulos.agentespastorales.include.Formacion')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/AgentePastoral.conf.js')}}"></script>
<script src="{{ asset('js/ValidarInput.js')}}"></script>

<script src="{{ asset('js/vue/vue.js') }}"></script>
<script src="{{ asset('js/vue/axios.js') }}"></script>
<script src="{{ asset('js/vue/participacion.js')}}"></script>
@endsection

