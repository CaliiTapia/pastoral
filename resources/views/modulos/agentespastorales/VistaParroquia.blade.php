@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')

<header class="content__title">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <div>
                
                <div class="col-lg-10">
                    <h2>@include('layouts.urSeleccionada') / Ficha Agente Pastoral</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ asset('pastoral/listado') }}">Agentes Pastorales</a>
                        </li>
                        <li class="breadcrumb-item">
                            <strong>Ficha</strong>
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
                <h5><strong>NUEVO AGENTE PASTORAL</strong></h5><small class="m-l-sm"> Campos obligatorios (*)</small>
            </div>
            <div class="ibox-content">
                {{ Form::open(['action' => 'AgentePastoralController@store', 'method' => 'POST','enctype'=>'multipart/form-data','id'=>'form-steps','class'=>'wizard-big']) }}
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
                                        <input class="form-check-input" type="radio" id="tpDocumentoR" value="rut" name="tpDocumento" checked required>
                                        <label class="form-check-label" for="tpDocumentoR"> Rut </label>
                                    </div>
                                    <div class="form-check abc-radio abc-radio-info form-check-inline">
                                        <input class="form-check-input" type="radio" id="tpDocumentoP" value="pasaporte" name="tpDocumento" required tabindex="1">
                                        <label class="form-check-label" for="tpDocumentoP"> Pasaporte </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="rut">Rut/Pasaporte <small>(*) (Sin puntos ni guion)</small></label>
                                    <input type="text"  name="rut" id="rut" onblur="comprobar(this.value)" class="form-control solo-rut rounded" required tabindex="2">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="pais">País de origen <small>(*)</small></label>
                                    <select class="form-control select2-steps rounded" name="pais" id="pais" required tabindex="3">
                                        <option value="{{ null }}">--Seleccione-- </option>
                                        @foreach ($paises as $pais)
                                            <option  value="{{ $pais->IdPais }}">{{ $pais->Nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="nombre">Nombre <small>(*)</small></label>
                                    <input type="text" name="nombre" id="nombre"   class="form-control rounded solo-letras" onblur="StringMax(this.id,this.value,50)" required tabindex="4">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="apellidoPaterno">Apellido Paterno <small>(*)</small></label>
                                    <input type="text"  name="apellidoPaterno" id="apellidoPaterno"  class="form-control rounded solo-letras" onblur="StringMax(this.id,this.value,50)" tabindex="5" required>
                                </div>
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                    <label for="apellidoMaterno">Apellido Materno <small>(*)</small></label>
                                    <input type="text"  name="apellidoMaterno" id="apellidoMaterno"  class="form-control rounded solo-letras" onblur="StringMax(this.id,this.value,50)" required tabindex="6">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for=nacimiento>Fecha de Nacimiento <small>(*)</small></label>
                                    <input type="date" name="nacimiento" id="nacimiento" onblur="ValidaFecha(this.value,'P','NACIMIENTO',this.id)" class="form-control" required tabindex="7">
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="estadocivil">Estado Civil <small>(*)</small></label>
                                    <select class="form-control select2-steps rounded" name="estadocivil" id="estadocivil" required tabindex="8">
                                        <option value="{{ null }}">--Estado Civil-- </option>
                                        @foreach ($estadocivil as $e)
                                            <option value="{{ $e->IdEstadoCivil }}">{{ $e->EstadoCivil }}</option>    
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
                                        <input class="form-check-input" type="radio" id="sexoM" value="M" name="sexo" required tabindex="9">
                                        <label class="form-check-label" for="sexoM"> Masculino </label>
                                    </div>
                                    <div class="form-check abc-radio abc-radio-info form-check-inline">
                                        <input class="form-check-input" type="radio" id="sexoF" value="F" name="sexo" required tabindex="10">
                                        <label class="form-check-label" for="sexoF"> Femenino </label>
                                    </div>
                                    <label id="sexo-error" class="error" for="sexo" ></label>
                                </div>
                                
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <legend>
                                        Sacramentos <small>(*)</small>
                                        <br><small>Puede Seleccionar más de una Opción</small>
                                    </legend>
                                    <div class="form-check abc-checkbox abc-checkbox-info abc-checkbox-circle form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="OpBautismo" value="S" name="bautismo" required>
                                        <label class="form-check-label" for="OpBautismo"> Bautismo </label>
                                    </div>
                                    <div class="form-check abc-checkbox abc-checkbox-info abc-checkbox-circle form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="OpComunion" value="S" name="comunion">
                                        <label class="form-check-label" for="OpComunion"> Primera Comunión </label>
                                    </div>
                                    <div class="form-check abc-checkbox abc-checkbox-info abc-checkbox-circle form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="OpConfirmacion" value="S" name="confirmacion">
                                        <label class="form-check-label" for="OpConfirmacion"> Confirmación </label>
                                    </div>
                                    <div class="form-check abc-checkbox abc-checkbox-info abc-checkbox-circle form-check-inline">
                                        <input type="checkbox" class="form-check-input" id="OpMatrimonio" value="S" name="matrimonio">
                                        <label class="form-check-label" for="OpMatrimonio"> Matrimonio </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label id="bautismo-error" class="error" for="bautismo"></label>
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
                                    <input type="text"  placeholder="Ej: 298765432"  name="fijo" id="fijo" class="form-control fono rounded"  tabindex="11">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="telefono">Teléfono Celular <small>(*)</small></label>
                                    <input type="text"  placeholder="Ej: 998765432" name="celular" id="celular" class="form-control fono rounded" tabindex="12" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Correo Electrónico <small>(*)</small></label>
                                    <input type="email" placeholder="email@iglesiadesantiago.cl" name="correo" id="correo" class="form-control rounded" onblur="StringMax(this.id,this.value,50)" tabindex="13" required>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="direccion">Dirección <small>(*)</small></label>
                                    <input type="text" name="direccion" id="direccion" class="form-control rounded espacio-centro" onblur="StringMax(this.id,this.value,190)" required tabindex="14">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="region">Región <small>(*)</small></label>
                                    <select class="form-control select2-steps rounded" name="region" id="region" required tabindex="15">
                                        <option value="{{ null }}">--Selecciona Tu Región-- </option>
                                        @foreach ($regiones as $region)
                                            <option value="{{ $region->IdRegion }}">{{ $region->Nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="comuna">Comuna <small>(*)</small></label>
                                    <select class="form-control select2-steps rounded" name="comuna" id="comuna" required tabindex="16">
                                        <option value="{{ null }}">--Selecciona Tu Comuna--</option>
                                        <option value="{{ null }}">--Debe seleccionar una region--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>

                <h1>Archivos</h1>
                <div class="step-content">
                    <div class="content clearfix">
                    <h2>Adjuntar Documentos</h2>
                    <h5> Tamaño máximo por archivo : 15MB</h5>
                    <h5> Formatos permitidos: JPG, JPEG, PNG, PDF</h5>
                        <div class="row" style="margin-top: 25px;">
                            <div class="col-md-4">
                                <div class="form-group col-md-12">
                                    <label>Foto Agente Pastoral <small></small></label>
                                    <div class="custom-file">
                                        <input id="fotoPerfil" type="file" name="fotoPerfil" onchange="file(this,'lb_fotoperfil')" class="custom-file-input file" tabindex="17" accept="image/*">
                                        <label for="fotoPerfil" id="lb_fotoperfil" class="custom-file-label">Subir Archivo...</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group col-md-12">
                                    <label>Certificado de antedecentes <small>(*)</small></label>
                                    <div class="custom-file">
                                        <input id="certAntecedentes" type="file" onchange="previewFileAntecedentes()" name="certAntecedentes" name="certAntecedentes" class="custom-file-input file" required tabindex="18" accept=".pdf">
                                        <label for="certAntecedentes" id="lb_certAntecedentes" class="custom-file-label">Subir Archivo...</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group col-md-12">
                                    <label>Ficha Autorización Agente Pastoral <small>(*)</small></label>
                                    <div class="custom-file">
                                        <input id="autoCertAntecedentes" type="file" name="autoCertAntecedentes" onchange="previewFileAutorizacion()" class="custom-file-input file" required tabindex="19" accept=".pdf" style="width: 100%">
                                        <label for="autoCertAntecedentes" id="lb_autoCertAntecedentes" class="custom-file-label">Subir Archivo...</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                            <div class="col-md-4" align="center"><input type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalFotoperfil" value="Previsualizar Foto Perfil"></div>
                            <div class="col-md-4" align="center"><input type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalAntecedentes" value="Previsualizar C. Antecedente"></div>
                            <div class="col-md-4" align="center"><input type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalAutorizacion" value="Previsualizar F. Autorización"></div>
        
                        <!-- Modal Foto Perfil-->
                        <div class="modal fade inmodal" id="ModalFotoperfil" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                <div class="modal-content animated bounceInRight">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="staticBackdropLabel"><Strong> Foto Perfil </Strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        <center><output id="preview"></output></center>
                                    </div>
                                    <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <!--Fin Modal -->
        
                         <!-- Modal C. Antecedentes-->
                         <div class="modal fade inmodal" id="ModalAntecedentes" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content animated bounceInRight">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="staticBackdropLabel"><Strong> Certificado Antecedentes </Strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        <center><iframe src="" id="iframe-pdfantecedentes" width="700px" height="500px"></iframe></center>
                                    </div>
                                    <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <!--Fin Modal -->
        
                         <!-- Modal F. Autorizacion-->
                         <div class="modal fade inmodal" id="ModalAutorizacion" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content animated bounceInRight">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="staticBackdropLabel"><Strong> Ficha Autorización </Strong></h4>
                                    </div>
                                    <div class="modal-body">
                                        <center><iframe src="" id="iframe-pdfautorizacion" width="700px" height="500px"></iframe></center>
                                    </div>
                                    <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <!--Fin Modal -->
                    </div>
                </div>
            {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script src="{{ asset('js/AgentePastoral.conf.js')}}"></script>
<script src="{{ asset('js/ajax/RegionComuna.js')}}"></script>
<script src="{{ asset('js/ValidarInput.js')}}"></script>


<script type="text/javascript"> 
    $(document).ready(function(){
    
        document.getElementById('fotoPerfil').addEventListener('change', archivo, false);
    });
        // otra funcion 
        function archivo(evt) {
          var files = evt.target.files; // FileList object
           
            //Obtenemos la imagen del campo "file". 
           for (var i = 0, f; f = files[i]; i++) {         
               //Solo admitimos imágenes.
              if (!f.type.match('image.*')) {
                    continue;
               }
               var reader = new FileReader();
               
               reader.onload = (function(theFile) {
                   return function(e) {
                   // Creamos la imagen.
                          
                          document.getElementById("preview").innerHTML = ['<img class="thumb" src="', e.target.result,'" title="', escape(theFile.name), '"/>'].join('');
                   };
               })(f);
     
               reader.readAsDataURL(f);
           }
    }  
    </script>
    
    <script type="text/javascript"> 
    
            function previewFileAutorizacion() {
                const preview = document.querySelector('#iframe-pdfautorizacion');
                const file = document.querySelector('#autoCertAntecedentes').files[0];
                const reader = new FileReader();
                var filename = file.name;
    
                reader.addEventListener("load", function () {
                // convert file to base64 string
                preview.src = reader.result;
                }, false);
    
                if (file) {
                reader.readAsDataURL(file);
                }
                $('#lb_autoCertAntecedentes').html(filename);
    
          }
    
          function previewFileAntecedentes() {
                const preview = document.querySelector('#iframe-pdfantecedentes');
                const file = document.querySelector('#certAntecedentes').files[0];
                const reader = new FileReader();
                var filename = file.name;
    
                reader.addEventListener("load", function () {
                // convert file to base64 string
                preview.src = reader.result;
                }, false);
    
                if (file) {
                reader.readAsDataURL(file);
                }
                $('#lb_certAntecedentes').html(filename);
          }
    </script>
@endsection