@extends('layouts.admin')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>Plan de cuentas</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a href="#">Plan de cuentas</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Editar plan de cuentas</strong>
            </li>
        </ol>
    </div>
</div>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="ibox-title espacio_encabezado">
                    <h4>Editar plan de cuentas</h4>  
                </div>    
                <div class="ibox-content">
                @foreach($datos as $da)
                {!! Form::open(['action' => ['PlanDeCuentasController@edit',$da->pctCod], 'method' => 'POST']) !!} 
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <strong><label class="col-form-label" for="product_name">Código</label></strong>
                                <input type="text" id="idPC" name="idPC" placeholder="" value="{{$da->pctCod}}" class="form-control" disabled>
                            </div>
                        </div>
                        <div class="col-md-1">
                            <div class="form-group">
                                <strong><label class="col-form-label" for="product_name">Nivel</label></strong>
                                <input type="text" id="nivelPC"  name="nivelPC" value="{{$da->pctNivel}}" class="form-control" disabled >
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong><label class="col-form-label" for="product_name">Nombre</label></strong>
                                <input type="text" id="nombrePC" name="nombrePC" class="form-control" value="{{$da->pctNombre}}" onkeypress="return soloLetras(event)" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <strong><label class="col-form-label" for="product_name">Tipo</label></strong>
                                <select name="tipoPC" id="tipoPC" class="form-control select2" required >
                                    <option disabled>-- Seleccione una opción --</option>
                                    @if($da->pctTipo=='A')
                                    <option value="A" selected>Activo</option>
                                    <option value="P">Pasivo</option>
                                    <option value="G">Gasto</option>
                                    @elseif($da->pctTipo=='P')
                                    <option value="A" >Activo</option>
                                    <option value="P" selected>Pasivo</option>
                                    <option value="G">Gasto</option>
                                    @elseif($da->pctTipo=='G')
                                    <option value="A" >Activo</option>
                                    <option value="P" >Pasivo</option>
                                    <option value="G" selected>Gasto</option>
                                    @endif
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
                                                        @if($da->pctCcos=='S')
                                                        <td><input type="radio" value="S" id="siCC" name="cc" class="radio-inline" checked>  Si</td>
                                                        <td><input type="radio" value="N" id="noCC" name="cc" class="radio-inline" >  No</td>
                                                        @else
                                                        <td><input type="radio" value="S" id="siCC" name="cc" class="radio-inline" >  Si</td>
                                                        <td><input type="radio" value="N" id="noCC" name="cc" class="radio-inline" checked>  No</td>
                                                        @endif                                            
                                                    </tr>
                                                    <tr>
                                                        <td data-hide="true" >Auxiliar</td>
                                                        @if($da->pctAux=='S')
                                                        <td><input type="radio" value="S" id="siAU" name="au" class="radio-inline" checked> Si</td>
                                                        <td><input type="radio" value="N" id="noAU" name="au" class="radio-inline" > No</td>
                                                        @else
                                                        <td><input type="radio" value="S" id="siAU" name="au" class="radio-inline" > Si</td>
                                                        <td><input type="radio" value="N" id="noAU" name="au" class="radio-inline" checked> No</td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td ddata-hide="true">Documento</td>
                                                        @if($da->pctDoc=='S') 
                                                        <td><input type="radio" value="S" id="siDO" name="do" class="radio-inline" checked> Si</td>
                                                        <td><input type="radio" value="N" id="noDO" name="do" class="radio-inline" > No</td>
                                                        @else
                                                        <td><input type="radio" value="S" id="siDO" name="do" class="radio-inline" > Si</td>
                                                        <td><input type="radio" value="N" id="noDO" name="do" class="radio-inline" checked> No</td>
                                                        @endif
                                                    </tr>
                                                        <tr style="display:none;background-color:#bee5eb;" id="trAdjunto">
                                                        <td data-hide="true">Archivo adjunto</td>
                                                        @if($da->pctEDoc=='S')
                                                        <td><input type="radio" value="S" id="siAA" name="aa" class="radio-inline" checked> Si</td>
                                                        <td><input type="radio" value="N" id="noAA" name="aa" class="radio-inline" > No</td>
                                                        @else
                                                        <td><input type="radio" value="S" id="siAA" name="aa" class="radio-inline" > Si</td>
                                                        <td><input type="radio" value="N" id="noAA" name="aa" class="radio-inline" checked> No</td>
                                                        @endif
                                                        </tr>
                                                    <tr>
                                                        <td data-hide="true">Conciliación bancaria</td>
                                                        @if($da->pctConb=='S')
                                                        <td><input type="radio" value="S" id="siCB" name="cb" class="radio-inline" checked> Si</td>
                                                        <td><input type="radio" value="N" id="noCB" name="cb" class="radio-inline" > No</td>
                                                        @else
                                                        <td><input type="radio" value="S" id="siCB" name="cb" class="radio-inline" > Si</td>
                                                        <td><input type="radio" value="N" id="noCB" name="cb" class="radio-inline" checked> No</td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td data-hide="true">Moneda adicional</td>
                                                        @if($da->pctMonAd=='S')
                                                        <td><input type="radio" value="S" id="siMA" name="ma" class="radio-inline" checked> Si</td>
                                                        <td><input type="radio" value="N" id="noMA" name="ma" class="radio-inline" > No</td>
                                                        @else
                                                        <td><input type="radio" value="S" id="siMA" name="ma" class="radio-inline" > Si</td>
                                                        <td><input type="radio" value="N" id="noMA" name="ma" class="radio-inline" checked> No</td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td data-hide="true">Detalle de gasto</td>
                                                        @if($da->pctDetG=='S')
                                                        <td><input type="radio" value="S" id="siDG" name="dg" class="radio-inline" checked> Si</td>
                                                        <td><input type="radio" value="N" id="noDG" name="dg" class="radio-inline" > No</td>
                                                        @else
                                                        <td><input type="radio" value="S" id="siDG" name="dg" class="radio-inline" > Si</td>
                                                        <td><input type="radio" value="N" id="noDG" name="dg" class="radio-inline" checked> No</td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td data-hide="true">Presupuesto de caja</td>
                                                        @if($da->pctPptoCaja=='S')
                                                        <td><input type="radio" value="S" id="siPC" name="pc" class="radio-inline" checked> Si</td>
                                                        <td><input type="radio" value="N" id="noPC" name="pc" class="radio-inline" > No</td>
                                                        @else
                                                        <td><input type="radio" value="S" id="siPC" name="pc" class="radio-inline" > Si</td>
                                                        <td><input type="radio" value="N" id="noPC" name="pc" class="radio-inline" checked> No</td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td data-hide="true">Instrumento financiero</td>
                                                        @if($da->pctInFin=='S') 
                                                        <td><input type="radio" value="S" id="siIF" name="if" class="radio-inline" checked> Si</td>
                                                        <td><input type="radio" value="N" id="noIF" name="if" class="radio-inline" > No</td>
                                                        @else
                                                        <td><input type="radio" value="S" id="siIF" name="if" class="radio-inline" > Si</td>
                                                        <td><input type="radio" value="N" id="noIF" name="if" class="radio-inline" checked> No</td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td data-hide="true">Libros y balances</td>
                                                        @if($da->pctDetLi=='S')
                                                        <td><input type="radio" value="S" id="siLB" name="lb" class="radio-inline" checked> Si</td>
                                                        <td><input type="radio" value="N" id="noLB" name="lb" class="radio-inline" > No</td>
                                                        @else
                                                        <td><input type="radio" value="S" id="siLB" name="lb" class="radio-inline" > Si</td>
                                                        <td><input type="radio" value="N" id="noLB" name="lb" class="radio-inline" checked> No</td>
                                                        @endif
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
                    @endforeach
                    {!! Form::close() !!}                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script> 
 

 
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

</script>
@endsection