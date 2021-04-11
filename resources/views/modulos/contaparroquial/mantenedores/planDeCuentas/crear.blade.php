@extends('layouts.admin')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h1>Plan de cuentas</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Plan de cuentas</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Nueva cuenta contable</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content animated fadeInRight" id="nuevoCbte">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title espacio_encabezado">
                    <h2>Nueva cuenta contable</h2>  
                </div>
                <div class="ibox-content">
                {!! Form::open(['action' => 'PlanDeCuentasController@store', 'method' => 'POST']) !!} 
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong><label class="col-form-label" for="product_name">Código</label></strong>
                                <input type="text" id="idPC" name="idPC" placeholder="" class="form-control" maxlength="14" onkeypress="return valideKey(event);" required>
                            </div>
                            <div id="alerta" class="alert alert-info alert-dismissible fade show text-center" role="alert">
                                <span id="mensaje">Ingrese un código para validación</span>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <strong><label class="col-form-label" for="product_name">Nivel</label></strong>
                                <input type="text" id="nivelPC"  name="nivelPC" class="form-control" disabled >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong><label class="col-form-label" for="product_name">Nombre</label></strong>
                                <input type="text" id="nombrePC" name="nombrePC" placeholder="Ingrese nombre" class="form-control"  onkeypress="return soloLetras(event)" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong><label class="col-form-label" for="product_name">Tipo</label></strong>
                                <select name="tipoPC" id="tipoPC" class="form-control select2" required >
                                    <option disabled selected>-- Seleccione una opción --</option>
                                    <option value="A">Activo</option>
                                    <option value="P">Pasivo</option>
                                    <option value="G">Gasto</option>
                                </select>
                            </div>
                        </div>
                    </div>    

                    <div class="wrapper wrapper-content animated fadeInRight">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="ibox ">
                                    <div class="ibox-title">
                                        <h5>Atributos</h5>
                                        <div class="ibox-tools">
                                            <a class="collapse-link">
                                                <i class="fa fa-chevron-up"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="ibox-content" >
                                        <div class="table-responsive" >
                                            <table id="dataTables-centros" class="table table-striped table-bordered table-hover dataTables-centros" >
                                                <thead>
                                                    <tr>
                                                        <th data-hide="" >Nombre de atributo</th>
                                                        <th data-hide=""><i class="fa fa-check" aria-hidden="true"></i></th>
                                                        <th data-hide="" ><i class="fa fa-times" aria-hidden="true"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td data-hide="true" >Centro de costos</td>
                                                        <td><input type="radio" value="S" id="siCC" name="cc" class="radio-inline" required>  Si</td>
                                                        <td><input type="radio" value="N" id="noCC" name="cc" class="radio-inline" >  No</td>                                            
                                                    </tr>
                                                    <tr>
                                                        <td data-hide="true" >Auxiliar</td>
                                                        <td><input type="radio" value="S" id="siAU" name="au" class="radio-inline" required> Si</td>
                                                        <td><input type="radio" value="N" id="noAU" name="au" class="radio-inline" > No</td>
                                                    </tr>
                                                    <tr>
                                                        <td ddata-hide="true">Documento</td>
                                                        <td><input type="radio" value="S" id="siDO" name="do" class="radio-inline" required> Si</td>
                                                        <td><input type="radio" value="N" id="noDO" name="do" class="radio-inline" > No</td>
                                                    </tr>
                                                        <tr style="display:none;background-color:#bee5eb;" id="trAdjunto">
                                                        <td data-hide="true">Archivo adjunto</td>
                                                        <td><input type="radio" value="S" id="siAA" name="aa" class="radio-inline" > Si</td>
                                                        <td><input type="radio" value="N" id="noAA" name="aa" class="radio-inline" > No</td>
                                                        </tr>
                                                    <tr>
                                                        <td data-hide="true">Conciliación bancaria</td>
                                                        <td><input type="radio" value="S" id="siCB" name="cb" class="radio-inline" required> Si</td>
                                                        <td><input type="radio" value="N" id="noCB" name="cb" class="radio-inline" > No</td>
                                                    </tr>
                                                    <tr>
                                                        <td data-hide="true">Moneda adicional</td>
                                                        <td><input type="radio" value="S" id="siMA" name="ma" class="radio-inline" required> Si</td>
                                                        <td><input type="radio" value="N" id="noMA" name="ma" class="radio-inline" > No</td>
                                                    </tr>
                                                    <tr>
                                                        <td data-hide="true">Detalle de gasto</td>
                                                        <td><input type="radio" value="S" id="siDG" name="dg" class="radio-inline" required> Si</td>
                                                        <td><input type="radio" value="N" id="noDG" name="dg" class="radio-inline" > No</td>
                                                    </tr>
                                                    <tr>
                                                        <td data-hide="true">Presupuesto de caja</td>
                                                        <td><input type="radio" value="S" id="siPC" name="pc" class="radio-inline" required> Si</td>
                                                        <td><input type="radio" value="N" id="noPC" name="pc" class="radio-inline" > No</td>
                                                    </tr>
                                                    <tr>
                                                        <td data-hide="true">Instrumento financiero</td>
                                                        <td><input type="radio" value="S" id="siIF" name="if" class="radio-inline" required> Si</td>
                                                        <td><input type="radio" value="N" id="noIF" name="if" class="radio-inline" > No</td>
                                                    </tr>
                                                    <tr>
                                                        <td data-hide="true">Libros y balances</td>
                                                        <td><input type="radio" value="S" id="siLB" name="lb" class="radio-inline" required> Si</td>
                                                        <td><input type="radio" value="N" id="noLB" name="lb" class="radio-inline" > No</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-right" >
                            <button type="submit" id="btnAgregar" class="btn btn-primary" ><i class="fa fa-save"></i> Guardar</button>
                        </div>
                    </div>
                {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script>
    //Funcion evento de cambio radio button
    $("input[type=radio][name=do]").on('change',function(){
        if($(this).val()=="S")
        {
            $("#trAdjunto").show();
        }
        else
        {
            $("#trAdjunto").hide();

        }
    });
$('.collapse-link').closest('div.ibox');
    function soloLetras(e) {
        key = e.keyCode || e.which;
        tecla = String.fromCharCode(key).toLowerCase();
        letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
        especiales = [8, 37, 39, 46];
  
        tecla_especial = false
        for(var i in especiales) {
            if(key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla) == -1 && !tecla_especial)
            return false;
    }

    function valideKey(evt){
		var code = (evt.which) ? evt.which : evt.keyCode;
		if(code==8) { 
			return true;
		} else if(code>=48 && code<=57) { // is a number.
			return true;
		} else{ // other keys.
			return false;
		}
	}



    
    $('#idPC').on('keyup',function(){  
        var div1, div2, div3, div4, div5;
        var nivel=0;
        var codigo =0;
        
        cod=$(this).val();

        var res = cod.replace(/\D/g, "");

        if(res.length <= 1){
            alerta.classList.remove('alert-success', 'alert-danger');
            alerta.classList.add('alert-info');
            mensaje.innerHTML = 'Ingrese un código para validación';
            $("#nivelPC").val('');
        }

       if(res.length<9){
            
            alerta.classList.remove('alert-success', 'alert-danger');
            alerta.classList.add('alert-info');
            mensaje.innerHTML = 'Ingresó un código muy <strong>CORTO</strong>, el código debe ser igual a 10 Dígitos. Ej: x-x-xx-xxx-xxx';
            $("#nivelPC").val('');
        }

        if(res.length>10){
            
            alerta.classList.remove('alert-success', 'alert-danger');
            alerta.classList.add('alert-info');
            mensaje.innerHTML = 'Ingresó un código muy <strong>LARGO</strong>, el código debe ser igual a 10 Dígitos. Ej: x-x-xx-xxx-xxx';
            $("#nivelPC").val('');
        }

        if(res.length==10){   
            div1=res.slice(0,1);
            div2=res.slice(1,2);
            div3=res.slice(2,4);
            div4=res.slice(4,7);
            div5=res.slice(7,10);

            if(div1>0){
                nivel=1;
            }

            if(div2>0){
                nivel=2;
            }

            if(div3>0){
                nivel=3;
            }

            if(div4>0){
                nivel=4;
            }

            if(div5>0){
                nivel=5;
            }
            
            $("#nivelPC").val(nivel);

            $(this).val(div1 + "-" + div2 + "-" + div3 + "-" + div4 + "-" + div5);
            codi = $(this).val();

            $.ajax({
                    headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data:  {'cod':$(this).val()},
                    url:   '/ajax/validaExistePlanCuentas',
                    type : 'get',
                    dataType: 'json',
                }).done(function(data) {

                    if(data.length==0)
                    {
                        alerta.classList.remove('d-none', 'alert-danger');
                        alerta.classList.add('alert-success');
                        mensaje.innerHTML = 'El código ingresado: ' + codi + ' <strong>VÁLIDO</strong>.';
                    }
                    else
                    {
                        alerta.classList.remove('d-none', 'alert-danger');
                        alerta.classList.add('alert-danger');
                        mensaje.innerHTML = 'El código ingresado: ' + codi + ' <strong>YA EXISTE</strong>.';
                        $("#nivelPC").val('');
                    }
                });


        }
    });
                   
</script>
@endsection