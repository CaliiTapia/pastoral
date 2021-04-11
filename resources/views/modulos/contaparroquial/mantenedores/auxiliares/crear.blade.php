@extends('layouts.admin')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Auxiliar</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Auxiliar</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Nuevo auxiliar</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title espacio_encabezado">
                    <h2>Nuevo auxiliar</h2>  
                </div>    
                <div class="ibox-content">
                {!! Form::open(['action' => 'AuxiliarController@store', 'method' => 'POST']) !!}  
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">Rut</label></strong>
                            <input type="text" id="rutAux" name="rutAux" placeholder="-- Ingrese rut --" maxlength="12" class="form-control" required>
                        </div>
                        <div id="alerta" class="alert alert-info alert-dismissible fade show text-center" role="alert">
                            <span id="mensaje">Ingrese un RUT para validación</span>
                        </div>
                    </div> 
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">Código</label></strong>
                            <input type="text" id="codAux" name="codAux"  class="form-control" disabled>
                        </div>
                    </div>   
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">Nombre</label></strong>
                            <input type="text" id="nomAux" name="nomAux" placeholder="-- Ingrese nombre --"class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">Apellido</label></strong>
                            <input type="text" id="apllAux" name="apllAux" placeholder="-- Ingrese apellido --"class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                            <div class="form-group">
                                <strong><label class="col-form-label" for="product_name">Status</label></strong>
                                <select name="tipo" id="status" class="form-control select2" required >
                                    <option disabled selected>-- Seleccione una opción --</option>
                                    <option value="A">Habilitado</option>
                                    <option value="D">Deshabilitado</option>
                                </select>
                            </div>
                        </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">Teléfono</label></strong>
                            <input type="text" maxlength="12" id="fonoAux" name="fonoAux" placeholder="-- Ingrese número --"class="form-control" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">Teléfono 2</label></strong>
                            <input type="text" id="fono2Aux" maxlength="12" name="fono2Aux" placeholder="-- Ingrese número --" class="form-control" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">Correo</label></strong>
                            <input type="email" id="mailAux" name="mailAux" placeholder="-- Ingrese correo --"class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">País</label></strong>
                            <select name="paisAux" id="paisAux" class="form-control select2" required >
                                <option disabled selected>-- Seleccione una opción --</option>
                                @foreach($pais as $pa)
                                <option value="{{$pa->IdPais}}">{{$pa->Nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label"  for="product_name">Ciudad</label></strong>
                            <select name="ciuAux" id="ciuAux" class="form-control select2" >
                                <option disabled selected>-- Seleccione una opción --</option>
                                @foreach($ciudad as $ci)
                                <option value="{{$ci->IdCiudad}}">{{$ci->Nombre}}</option>
                                @endforeach
                            </select>
                            
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">Comuna</label></strong>
                            <select name="comAux" id="comAux" class="form-control select2" > 
                                <option disabled selected>-- Seleccione una opción --</option>
                                @foreach($comuna as $co)
                                <option value="{{$co->nombreComuna}}">{{$co->nombreComuna}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <strong><label class="col-form-label" for="product_name">Dirección</label></strong>
                            <input type="text" id="dirAux" name="dirAux" placeholder="-- Ingrese dirección --"class="form-control" required>
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
///Al cargar la pagina, consulta si el select debe bloquearse o quedar habiltiado
    var pais = $("#paisAux").val();
    this.validaPais(pais);

// Capturando el DIV alerta y mensaje
    var alerta = document.getElementById("alerta");
    var mensaje = document.getElementById("mensaje");

// Permitir sólo números en el imput
    function isNumber(evt) {
        var charCode = evt.which ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57) && charCode === 75) return false;
        return true;
    }
/////////////////////////////////////
    $("#rutAux").on('keyup',function(){
            var rut = this;
            if (rut.value.length <= 1) {
                alerta.classList.remove('alert-success', 'alert-danger');
                alerta.classList.add('alert-info');
                mensaje.innerHTML = 'Ingrese un RUT para validación';
            }
        // Obtiene el valor ingresado quitando puntos y guión.
        var valor = clean(rut.value);

        // Divide el valor ingresado en dígito verificador y resto del RUT.
        cuerpo = valor.slice(0, -1);
        dv = valor.slice(-1).toUpperCase();

        // Separa con un Guión el cuerpo del dígito verificador.
        rut.value = format(rut.value);

        // Si no cumple con el mínimo ej. (n.nnn.nnn)
        if (cuerpo.length < 7) {
            //rut.setCustomValidity("RUT Incompleto");
            alerta.classList.remove('alert-success', 'alert-danger');
            alerta.classList.add('alert-info');
            mensaje.innerHTML = 'Ingresó un RUT muy corto, el RUT debe ser mayor a 7 Dígitos. Ej: x.xxx.xxx-x';
            return false;
        }

        // Calcular Dígito Verificador "Método del Módulo 11"
        suma = 0;
        multiplo = 2;

        // Para cada dígito del Cuerpo
        for (i = 1; i <= cuerpo.length; i++) {
            // Obtener su Producto con el Múltiplo Correspondiente
            index = multiplo * valor.charAt(cuerpo.length - i);

            // Sumar al Contador General
            suma = suma + index;

            // Consolidar Múltiplo dentro del rango [2,7]
            if (multiplo < 7) {
            multiplo = multiplo + 1;
            } else {
            multiplo = 2;
            }
        }

        // Calcular Dígito Verificador en base al Módulo 11
        dvEsperado = 11 - (suma % 11);

        // Casos Especiales (0 y K)
        dv = dv == "K" ? 10 : dv;
        dv = dv == 0 ? 11 : dv;

        // Validar que el Cuerpo coincide con su Dígito Verificador
        if (dvEsperado != dv) {
            //rut.setCustomValidity("RUT Inválido");

            alerta.classList.remove('alert-info', 'alert-success');
            alerta.classList.add('alert-danger');
            mensaje.innerHTML = 'El RUT ingresado: ' + rut.value + ' <strong>NO VÁLIDO</strong>.';
            $("#codAux").val('');

            return false;
        } else {
            //rut.setCustomValidity("RUT Válido");

            $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:  {'rut':$(this).val()},
                    url:   '/ajax/validaExisteRut',
                    type : 'get',
                    dataType: 'json',
                }).done(function(data) {
                    if((data.length)==0) //Si no existe el rut en la bd
                    {
                        alerta.classList.remove('d-none', 'alert-danger');
                        alerta.classList.add('alert-success');
                        mensaje.innerHTML = 'El RUT ingresado: ' + rut.value + ' <strong>VÁLIDO</strong>.';
                        $("#codAux").val($("#rutAux").val());
                        var codigoAux = $("#codAux").val();

                        var formatoCodigoAux = codigoAux.substring(0,10);
                        formatoCodigoAux = formatoCodigoAux.replace('-','');
                        formatoCodigoAux = formatoCodigoAux.replace('.','');
                        formatoCodigoAux = formatoCodigoAux.replace('.','');
                        $("#codAux").val(formatoCodigoAux);
                        return true;
                    }
                    else
                    {
                        alerta.classList.remove('alert-info', 'alert-success');
                        alerta.classList.add('alert-danger');
                        mensaje.innerHTML = 'El RUT del auxiliar ingresado: ' + rut.value + ' <strong>YA EXISTE</strong>.';
                        $("#codAux").val('');

                    }
                });   
        }
    });
    
    function format (rut) {
    rut = clean(rut)

    var result = rut.slice(-4, -1) + '-' + rut.substr(rut.length - 1)
    for (var i = 4; i < rut.length; i += 3) {
        result = rut.slice(-3 - i, -i) + '.' + result
    }

    return result
    }

    function clean (rut) {
    return typeof rut === 'string'
        ? rut.replace(/^0+|[^0-9kK]+/g, '').toUpperCase()
        : ''
    }


/////////////////////////////////////////////////////////////////////////////////
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