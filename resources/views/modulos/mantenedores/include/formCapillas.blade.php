@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')
@include('ValidaNotificacion')

@section('javascript')
<script src="{{ asset('js/ValidarInput.js')}}"></script>
<script type="text/javascript">
    function coordenadasCa(){
        var regexlat = /^(-?[1-8]?\d(?:\.\d{1,18})?|90(?:\.0{1,18})?)$/;
        var regexlng = /^(-?(?:1[0-7]|[1-9])?\d(?:\.\d{1,18})?|180(?:\.0{1,18})?)$/;
        if (regexlat.test(document.getElementById("latlng3").value) && regexlng.test(document.getElementById("latlng4").value)) { 
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('Ajax/update/'.$id)}}",
                type:"PUT",
                data: $('#info').serialize()
            });      
            swal("¡ÉXITO!", "Se actualizó correctamente la información.", "success");
        }else{
            swal("Error!", "Una de las Coordendas fue mal Ingresada.", "error");
        }
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        limpiar();
        $('#formAgregarCA').on('submit', function (e){
            e.preventDefault();

            $.ajax({
                // envia informacion a DB
                type:"POST",
                url:"/horaC",
                data: $('#formAgregarCA').serialize(),
                success: function(response){
                    console.log(response);
                    // cierra modal y actualiza calendario con el evento agregado
                    $('#ModalAgregarHorariosCA').modal('hide');
                    swal("Correcto", "Misa Agendada ", "success");
                    location.reload();
                    },
                error: function(error){
                    console.log(error);
                    alert("Hay un Error");
                }
            });
        });
    });
    function limpiar(){
        $('#diaC').val("");
        $('#horaC').val("");
        $('#descripcionC').val("");
    }
</script>
<script type="text/javascript">
    function eliminar(id){
        $('#ModalEliminarHorariosCA').modal('show');

        $('#formEliminarCa').on('submit', function (e){
            e.preventDefault();

            $.ajax({
                // envia informacion a DB
                type:"GET",
                url:"/horaeliminarC/"+id,
                data: $('#formEliminarCa').serialize(),
                success: function(response){
                    console.log(response);
                    // cierra modal y actualiza calendario con el evento agregado
                    $('#ModalEliminarHorariosCA').modal('hide');
                    document.getElementById(id).remove();
                    //location.reload();
                    },
                error: function(error){
                    console.log(error);
                    alert("Hay un Error");
                }
            });
        });
    }
</script>

<script type="text/javascript">
    function editar(id){
        $('#ModalEditarHorariosCA').modal('show');
        let descripcion = document.getElementById('descripcion');
        let hora = document.getElementById('hora');
        let tipo = document.getElementById('dia');
        $.ajax({
            // Consulta informacion desde DB
            type:"GET",
            url:"/get/horarioC/"+id,
            success: function(response){
                descripcion.value = response.MAP_Observacion;
                hora.value = response.MAP_Hora;
                tipo.value = response.MAP_IdTipoDia;
            },
            error: function(error){
                console.log(error);
            }
        });

        $('#ModalEditarHorariosCA').on('submit', function (e){
            e.preventDefault();

            $.ajax({
                // envia informacion a DB
                type:"PUT",
                url:"/horaactualizarC/"+id,
                data: $('#formEditarCA').serialize(),
                success: function(response){
                    // cierra modal y actualiza calendario con el evento agregado
                    $('#ModalEditarHorariosCA').modal('hide');
                    //alert("actualizado");
                    location.reload();
                    },
                error: function(error){
                    console.log(error);
                }
            });
        });
    }
</script>
@endsection

<header class="content__title">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <div>
                <div class="col-lg-12">
                    <h2> INFORMACIÓN PARROQUIAL</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ asset('informacion/update/'.$institu.'/edit') }}">Información</a>
                        </li>
                        <li class="breadcrumb-item">
                            <strong>Capillas</strong>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="wrapper wrapper-content animated fadeInRight espacio">
    <div class="ibox-content ">
        <div class="row">
            <div class="col-md-12">
                <div class="ibox-title encabezado_box">
                    <h5><strong>HORARIOS MISAS</strong></h5>
                    <div class="ibox-tools">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalAgregarHorariosCA"><i class="fa fa-plus"></i> Agregar Horarios</button>
                    </div>
                </div>
                <div class="ibox-content">
                <table class="table table-striped horarios" id="horarios">
                        <thead style="background: #c6c6c6;">
                            <tr>
                                <th>Lunes</th>
                                <th>Martes</th>
                                <th>Miércoles</th>
                                <th>Jueves</th>
                                <th>Viernes</th>
                                <th>Sábado</th>
                                <th>Domingo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    @forelse($lunes as $lun)
                                        <div id="{{$lun->MAP_IdHorario}}">
                                            {{ $lun->MAP_Hora.' '.$lun->MAP_Observacion}}
                                            <div class="m-t-xs btn-group">
                                                <a class="btn btn-xs btn-outline-danger" onclick="eliminar({{$lun->MAP_IdHorario}})" href="#">Eliminar</a>
                                                <a class="btn btn-xs btn-outline-primary" onclick="editar({{$lun->MAP_IdHorario}})" href="#">Editar </a>
                                            </div>
                                        </div>
                                        <br>
                                        @empty
                                    @endforelse
                                </td>
                                <td>
                                    @forelse($martes as $mar)
                                        <div id="{{$mar->MAP_IdHorario}}">
                                            {{ $mar->MAP_Hora.' '.$mar->MAP_Observacion}}
                                            <div class="m-t-xs btn-group">
                                                <a class="btn btn-xs btn-outline-danger" onclick="eliminar({{$mar->MAP_IdHorario}})" href="#">Eliminar</a>
                                                <a class="btn btn-xs btn-outline-primary" onclick="editar({{$mar->MAP_IdHorario}})" href="#">Editar </a>
                                            </div>
                                        </div>
                                        <br>
                                        @empty
                                    @endforelse
                                </td>
                                <td>
                                    @forelse($miercoles as $mie)
                                        <div id="{{$mie->MAP_IdHorario}}">
                                            {{ $mie->MAP_Hora.' '.$mie->MAP_Observacion}}
                                            <div class="m-t-xs btn-group">
                                                <a class="btn btn-xs btn-outline-danger" onclick="eliminar({{$mie->MAP_IdHorario}})" href="#">Eliminar</a>
                                                <a class="btn btn-xs btn-outline-primary" onclick="editar({{$mie->MAP_IdHorario}})" href="#">Editar </a>
                                            </div>
                                        </div>
                                        <br>
                                        @empty
                                    @endforelse
                                </td>
                                <td>
                                    @forelse($jueves as $jue)
                                        <div id="{{$jue->MAP_IdHorario}}">
                                            {{ $jue->MAP_Hora.' '.$jue ->MAP_Observacion}}
                                            <div class="m-t-xs btn-group">
                                                <a class="btn btn-xs btn-outline-danger" onclick="eliminar({{$jue->MAP_IdHorario}})" href="#">Eliminar</a>
                                                <a class="btn btn-xs btn-outline-primary" onclick="editar({{$jue->MAP_IdHorario}})" href="#">Editar </a>
                                            </div>
                                        </div>
                                        <br>
                                        @empty
                                    @endforelse
                                </td>
                                <td>
                                    @forelse($viernes as $vie)
                                        <div id="{{$vie->MAP_IdHorario}}">
                                            {{ $vie->MAP_Hora.' '.$vie->MAP_Observacion}}
                                            <div class="m-t-xs btn-group">
                                                <a class="btn btn-xs btn-outline-danger" onclick="eliminar({{$vie->MAP_IdHorario}})" href="#">Eliminar</a>
                                                <a class="btn btn-xs btn-outline-primary" onclick="editar({{$vie->MAP_IdHorario}})" href="#">Editar </a>
                                            </div>
                                        </div>
                                        <br>
                                        @empty
                                    @endforelse
                                </td>
                                <td>
                                    @forelse($sabado as $sab)
                                        <div id="{{$sab->MAP_IdHorario}}">
                                            {{ $sab->MAP_Hora.' '.$sab->MAP_Observacion}}
                                            <div class="m-t-xs btn-group">
                                                <a class="btn btn-xs btn-outline-danger" onclick="eliminar({{$sab->MAP_IdHorario}})" href="#">Eliminar</a>
                                                <a class="btn btn-xs btn-outline-primary" onclick="editar({{$sab->MAP_IdHorario}})" href="#">Editar </a>
                                            </div>
                                        </div>
                                        <br>
                                        @empty
                                    @endforelse
                                </td>
                                <td>
                                    @forelse($domingo as $dom)
                                        <div id="{{$dom->MAP_IdHorario}}">
                                            {{ $dom->MAP_Hora.' '.$dom->MAP_Observacion}}
                                            <div class="m-t-xs btn-group">
                                                <a class="btn btn-xs btn-outline-danger" onclick="eliminar({{$dom->MAP_IdHorario}})" href="#">Eliminar</a>
                                                <a class="btn btn-xs btn-outline-primary" onclick="editar({{$dom->MAP_IdHorario}})" href="#">Editar </a>
                                            </div>
                                        </div>
                                        <br>
                                        @empty
                                    @endforelse    
                                </td>                     
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12">
            {{ Form::open(['route' =>['capilla.update','id' =>$editCapilla->INCodigo],'method' => 'PUT','enctype'=>'multipart/form-data']) }}
                <div class="ibox-title encabezado_box">
                    <h5><strong>CAPILLAS</strong></h5>
                    <div class="ibox-tools">
                        <button type="button" class="btn btn-success" id="habilitarCap"><i class="fa fa-edit"></i> Editar Información</button>
                        <button type="submit" class="btn btn-primary deshabilitar" onclick="coordenadasCa()" id="actualizarCap"><i class="fa fa-check-square-o"></i> Actualizar</button>
                    </div>
                </div>
                
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre Completo</label>
                               <input type="text" name="nombreCap" id="nombreCap" class="form-control rounded deshabilitar" value="{{ trim($editCapilla ->INNombre)  !='' ? $editCapilla->INNombre : 'Sin Información' }}">
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Alias </label>
                                <input type="text" name="aliasCap" id="aliasCap" class="form-control rounded deshabilitar espacio-centro" onblur="StringMax(this.id,this.value,50)"  value="{{ trim($editCapilla ->INNombre2) !='' ? $editCapilla->INNombre2 : 'Sin Información' }}">
                            </div>  
                        </div> 
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Correo </label>
                                <input type="text"  name="correoCap" id="correoCap" class="form-control rounded deshabilitar " value="{{ trim($editCapilla ->INEmail) !='' ? $editCapilla->INEmail : 'Sin Información' }}">
                            </div> 
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Dirección </label>
                                <input type="text" name="direccionCap" id="direccionCap" class="form-control rounded deshabilitar espacio-centro" value="{{ trim($editCapilla ->INDireccion) !='' ? $editCapilla->INDireccion : 'Sin Información'}}">
                            </div>  
                        </div> 
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Comuna </label>
                                <input type="text" name="comunaCap" id="comunaCap" class="form-control rounded deshabilitar " value="{{ trim($comuna ->Nombre) !='' ? $comuna->Nombre : 'Sin Información'}}">
                            </div> 
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Telefono </label>
                                <input type="text" name="telefonoCap" id="telefonoCap" class="form-control rounded deshabilitar fono" value="{{ trim($editCapilla ->INTelefono) !='' ? $editCapilla->INTelefono : 'Sin Información'}}">
                            </div>  
                        </div> 
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Fecha Creación </label>
                                <input type="text" name="fechaCap" id="fechaCap" class="form-control rounded deshabilitar " value="{{ date('d-m-Y', strtotime($editCapilla ->INFecCrea)) }}">
                            </div>  
                        </div> 
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                            <!-- imagen -->
                                <form id="form">
                                    <label>Foto Frontis Capilla </label>
                                    <div>
                                        <div class="lightBoxGallery">
                                            <img id="imgCa" class="d-block w-100" src="{{asset ($urlImagenCa)}}" alt="Imagen Capilla" height="320";/>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type='file' class="deshabilitar" name="imgInCa" id="imgInCa">
                                    </div>
                                </form>
                            </div> 
                        </div>
                        <div class="col-md-1 b-r"></div>
                        <div class="col-md-6">
                        <label>Coordenadas Capilla </label>
                        <form id="info">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="latitude">Latitud</label>
                                        <input type="text" name="latlng3" id="latlng3" class="coordenadas form-control rounded deshabilitar" placeholder="ingrese latitud" value="{{ $latLngC[0]->ITLatitud }}">
                                        {!! ($errors->has('latlng3') ? '<p class="text-danger">' . $errors->first('latlng3') . '</p>' : '') !!}
                                        <small>Ejemplo: -33.444322</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="longitude">Longitud</label>
                                        <div class="input-group coordenadas">
                                            <input type="text" name="latlng4" id="latlng4" class="coordenadas form-control rounded deshabilitar" placeholder="ingrese longitud" value="{{ $latLngC[0]->ITLongitud }}">
                                            {!! ($errors->has('latlng4') ? '<p class="text-danger">' . $errors->first('latlng4') . '</p>' : '') !!}
                                            <div class="input-group-append">
                                                <button id="submit1" class="btn btn-primary deshabilitar" onclick="coordenadasCa()" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>                                            
                                            </div>
                                        </div>
                                        <small>Ejemplo: -70.665952</small>
                                    </div>
                                </div>
                            </div>
                        </form>
                            <div class="google-map" id="infoCa"></div>
                        </div>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>

        <!-- Modal Agregar Horarios-->
        <div class="modal fade inmodal " id="ModalAgregarHorariosCA" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <h3 class="modal-title" id="staticBackdropLabel"><Strong><i class="fa fa-calendar-plus-o"></i>  Horarios de Misas</Strong></h3>
                    </div>
                    <form id="formAgregarCA">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Seleccione Día</label>
                                            <div class="input-group-prepend">
                                                <select class="form-control m-b rounded" name="diaC" id="diaC">
                                                    <option value="{{ null }}">--Dia de la Semana-- </option>
                                                        @foreach ($dia as $d)
                                                            <option value="{{ $d->MAP_IdTipoDia }}">{{ trim($d->MAP_Dia) }}</option>  
                                                        @endforeach
                                                </select>
                                            </div>
                                            <div class="d-none"><input type="text" name="institu" value="{{$id}}"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">Ingrese Hora</label>
                                        <input type="time" name="horaC" id="horaC" class="form-control rounded" >
                                    </div>                            
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label"><strong>Observación</strong></label>
                                    <div class="input-group-prepend">
                                        <textarea type="text" class="form-control rounded" name="descripcionC" id="descripcionC"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button class="btn btn-success" id="guardar"><i class="fa fa-floppy-o"></i> Guardar</button>                        
                        </div>
                    </form>
                </div>
            </div> 
        </div>
        <!--Fin Modal Horarios-->

        <!-- Modal EDITAR Horarios-->
        <div class="modal fade inmodal " id="ModalEditarHorariosCA" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <h3 class="modal-title" id="staticBackdropLabel"><Strong><i class="fa fa-calendar-plus-o"></i>  Horarios de Misas</Strong></h3>
                    </div>
                    <form id="formEditarCA">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="recipient-name" class="col-form-label">Seleccione Día</label>
                                            <div class="input-group-prepend">
                                                <select class="form-control m-b rounded" name="dia" id="dia">
                                                    <option value="{{ null }}">--Dia de la Semana-- </option>
                                                        @foreach ($dia as $d)
                                                            <option value="{{ $d->MAP_IdTipoDia }}">{{ trim($d->MAP_Dia) }}</option>  
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">Ingrese Hora</label>
                                        <input type="time" name="hora" id="hora" class="form-control rounded" >
                                    </div>                            
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="recipient-name" class="col-form-label"><strong>Observación</strong></label>
                                    <div class="input-group-prepend">
                                        <textarea type="text" class="form-control rounded" name="descripcion" id="descripcion"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button class="btn btn-primary" id="guardar"><i class="fa fa-check-square-o"></i> Actualizar</button>                        
                        </div>
                    </form>
                </div>
            </div> 
        </div>
        <!--Fin Modal Horarios-->

        <!-- Modal ELIMINAR Horarios-->
        <div class="modal fade inmodal" id="ModalEliminarHorariosCA" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content animated bounceInRight">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel"><Strong><i class="fa fa-exclamation-triangle"></i> ADVERTENCIA</Strong></h5>
                    </div>
                    <form id="formEliminarCa">
                        <div class="modal-body">
                            {{ csrf_field() }}
                            {{ method_field('get') }}
                            <div>
                                ¿Está Seguro que Desea Eliminar estos Datos <Strong>De Manera Permanente</Strong>?
                            </div>
                        </div>
                    
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i> Confirmar</button>
                        </div>
                    </form>
                </div>
            </div> 
        </div>
        <!--Fin Modal Horarios-->
    </div>
</div>
@endsection
<script type="text/javascript">
// GoogleMaps
    var map;
    var markers = @json($markers);
    function initMap() {
        for(var i=0;i<markers.length;i++){
            var data=markers[i];
            map = new google.maps.Map(document.getElementById("infoCa"), {
                zoom: 15,
                center: {lat: data.ITLatitud, lng: data.ITLongitud},            
            });
            var marker = new google.maps.Marker({
                position: {lat: data.ITLatitud, lng: data.ITLongitud},
                map : map
            });       
        }
        const geocoder = new google.maps.Geocoder();
        const infowindow = new google.maps.InfoWindow();
        document.getElementById("submit1").addEventListener("click", () => {
            geocodeLatLng(geocoder, map, infowindow);
        });
    }

        function geocodeLatLng(geocoder, map, infowindow) {
            const input = document.getElementById("latlng3").value + ',' + document.getElementById("latlng4").value;
            const latlngStr = input.split(",", 2);
            const latlng = {
                lat: parseFloat(latlngStr[0]),
                lng: parseFloat(latlngStr[1]),
        };
        
        geocoder.geocode({ location: latlng }, (results, status) => {
            if (status === "OK") {
                if (results[0]) {
                    map.setZoom(18);
                    const marker = new google.maps.Marker({
                    position: latlng,
                    map: map,
                    });
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, marker);
                } else {
                    window.alert("No Se Encontró!");
                }
            } else {
            window.alert("Ha ocurrido un error!\nDebe ingresar Latitud y Longitud en los campos\n" + "(" + status + ")");
        }
        });
    }
// FinGoogleMaps
</script>
<script type="text/javascript" 
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAAQe5T2DHwucXHLLQwNPkOelcTUlO_A9c&callback=initMap&libraries=&v=weekly" defer>
</script>


