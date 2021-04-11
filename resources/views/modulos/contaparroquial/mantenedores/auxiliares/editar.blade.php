@extends('layouts.admin')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Usuario</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Auxiliar</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Editar auxiliar</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title espacio_encabezado">
                    <h2>Editar auxiliar</h2>  
                </div>    
                <div class="ibox-content">
                @foreach($datos as $da)
                {!! Form::open(['action' => ['AuxiliarController@edit',$da->codAux], 'method' => 'POST']) !!}   
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">Rut</label></strong>
                            <input type="text" id="rutAux" name="rutAux" value="{{ $da->rutAux }}" class="form-control" disabled>
                        </div>
                    </div> 
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">Código</label></strong>
                            <input type="text" id="codAux" name="codAux" value="{{ $da->codAux }}" class="form-control" disabled>
                        </div>
                    </div>   
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">Nombre</label></strong>
                            <input type="text" id="nomAux" name="nomAux" value="{{ $da->nomAux }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">Apellido</label></strong>
                            <input type="text" id="apllAux" name="apllAux" value="{{ $da->apllAux }}" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                            <div class="form-group">
                                <strong><label class="col-form-label" for="product_name">Status</label></strong>
                                <select name="status" id="status" class="form-control select2" required >
                                    <option disabled >-- Seleccione una opción --</option>
                                   @if($da->statusAux=='A')
                                    
                                        <option value="A" selected>Habilitado</option>
                                        <option value="I">Deshabilitado</option>
                                    
                                    @else
                                    
                                        <option value="A" >Habilitado</option>
                                        <option value="I" selected>Deshabilitado</option>
                                    
                                   @endif
                                </select>
                            </div>
                    </div>

                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">Teléfono</label></strong>
                            <input type="text" id="fonoAux" maxlength="12" name="fonoAux" value="{{ $da->fonoAux }}" class="form-control" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">Teléfono 2</label></strong>
                            <input type="text" id="fono2Aux" maxlength="12" name="fono2Aux" value="{{ $da->fono2Aux }}" class="form-control" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" >
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">Correo</label></strong>
                            <input type="mail" id="mailAux" name="mailAux" value="{{ $da->mailAux }}" class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">

                <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">País</label></strong>
                            <select name="paisAux" id="paisAux" class="form-control select2" required >
                                <option disabled>-- Seleccione una opción --</option>
                                @foreach($pais as $pa)
                                @if($pa->IdPais == $da->IdPais)
                                <option value="{{$pa->IdPais}}" selected>{{$pa->Nombre}}</option>
                                @else
                                <option value="{{$pa->IdPais}}">{{$pa->Nombre}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label"  for="product_name">Ciudad</label></strong>
                            <select name="ciuAux" id="ciuAux" class="form-control select2" >
                                <option disabled>-- Seleccione una opción --</option>
                                @foreach($ciudad as $ciu)
                                @if($ciu->IdCiudad == $da->IdCiudad)
                                <option value="{{$ciu->IdCiudad}}" selected>{{$ciu->Nombre}}</option>
                                @else
                                <option value="{{$ciu->IdCiudad}}">{{$ciu->Nombre}}</option>
                                @endif
                                @endforeach
                            </select>
                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">Comuna</label></strong>
                            <select name="comAux" id="comAux" class="form-control select2" > 
                            <option disabled>-- Seleccione una opción --</option>
                                @foreach($comuna as $com)
                                @if($com->IdComuna == $da->IdComuna)
                                <option value="{{$com->IdComuna}}" selected>{{$com->Nombre}}</option>
                                @else
                                <option value="{{$com->IdComuna}}">{{$com->Nombre}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">Dirección</label></strong>
                            <input type="text" id="dirAux" name="dirAux" value="{{ $da->dirAux }}" class="form-control" required >
                        </div>
                    </div>
                    
                </div>
                @endforeach
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
///Al cargar la pagina, consulta si el select debe bloquearse o quedar habiltiado
    var pais = $("#paisAux").val();

    this.validaPais(pais);
//////////////////////////////////////////////

    //Evento on Change Jquery 
    var _this = this;
    $("#paisAux").on('change',function(){
        var pais = $("#paisAux").val();
        _this.validaPais(pais);
    
    })

    function validaPais(pais) {
        if(pais==38) //Si el País es Chile.
        {
            $('#ciuAux').prop('disabled', false);
            $('#comAux').prop('disabled', false);
        }
        else
        {
            $('#ciuAux').prop('disabled', 'disabled');
            $('#comAux').prop('disabled', 'disabled');
            //No pasa absolutamente nada.
            //bloquear campos
            
        }
    }

    

//CUIDAD COMUNA
    $("#ciuAux").on('change',function(){

    var id = $(this).val();
    $.ajax({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data:  {'C_IdCiudad':id},
        url:   '/ajax/comunaCiudad',
        type : 'get',
        dataType: 'json',
    }).done(function(data) {
        console.log(data);
        $('#comAux').select2('destroy');
        $('#comAux').html('');
        $('#comAux').append('<option value="0" disabled="true" selected="true">-- Seleccione una opción --</option>');
        $.each(data, function(index,comunasObj){
            // console.log(comunasObj.IdComuna);
            $('#comAux').append('<option value="'+comunasObj.IdComuna +'">'+ comunasObj.Nombre +'</option>');
        })
        $("#comAux").select2({
            theme: 'bootstrap4',
            width:'100%',
            placeholder: "Seleccione una opcion"
        });
    });
    })
</script>
@endsection