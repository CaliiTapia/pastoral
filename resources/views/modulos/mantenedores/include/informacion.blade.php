<div class="panel-body">  
    <div class="wrapper wrapper-content animated fadeInRight espacio">
        <div class="row">
            <div class="col-lg-12">
            {{ Form::open(['route' =>['parroquia.update','id' =>$institucion->INCodigo],'method' => 'PUT','enctype'=>'multipart/form-data']) }}
                <div class="ibox-title encabezado_box">
                    <h5><strong>INFORMACIÓN</strong></h5>
                    <div class="ibox-tools">
                        <button type="button" class="btn btn-success" id="habilitar"><i class="fa fa-edit"></i> Editar Información</button>
                        <button type="submit" class="btn btn-primary deshabilitar" onclick="coordenadasPa()" id="actualizar"><i class="fa fa-check-square-o"></i> Actualizar</button>
                    </div>
                </div>
                <div class="ibox-content">   
                        
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group">
                            <!-- imagen -->
                                <form id="form">
                                <label>Foto Frontis Parroquia </label>
                                <div>
                                    <div class="lightBoxGallery">
                                        <img name="imgPa"  id="imgPa" class="d-block w-100" src="{{asset ($urlImagen)}}" alt="Imagen Parroquia" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type='file' class="deshabilitar" name="imgInPa" id="imgInPa">
                                </div>
                            </div> 
                        </div> 
                        <div class="col-md-1 b-r"></div>
                        <div class="col-md-7">
                            <form id="form">
                                <div class="form-group">
                                    <label>Nombre Completo </label>
                                    <input type="text" name="nombre" id="nombre" class="form-control rounded deshabilitar" tabindex="1" value="{{trim($institucion->INNombre)}}" >
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Rut </label>
                                        <input type="text" name="rut" id="rut" class="form-control rounded deshabilitar" tabindex="2" value="{{ trim($institucion->INRut) !='' ? $institucion->INRut : 'Sin Información' }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label>N° Casillero </label>
                                        <input type="text" name="casillero" id="casillero" class="form-control rounded deshabilitar" value="Sin Información" tabindex="3">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label>Alias </label>
                                    <input type="text"  name="alias" id="alias" class="form-control rounded deshabilitar espacio-centro" value="{{
                                    trim($institucion->INNombre2) !='' ? $institucion->INNombre2 : 'Sin Información' }}" >
                                </div>

                                <div class="form-group">
                                    <label>Dirección </label>
                                    <input type="text"  name="direccion" id="direccion" class="form-control rounded deshabilitar espacio-centro" value="{{
                                    trim($institucion->INDireccion) !='' ? $institucion->INDireccion : 'Sin Información' }}">
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Comuna </label>
                                <input type="text"  name="comuna" id="comuna" class="form-control rounded deshabilitar"  value="{{ trim($comuna ->Nombre) !='' ? $comuna->Nombre : 'Sin Información'}}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Casilla </label>
                                <input type="text"  name="casilla" id="casilla" class="form-control rounded deshabilitar" value="{{
                                    trim($institucion->INCasilla) !='' ? $institucion->INCasilla : 'Sin Información' }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Telefono </label>
                                <input type="text"  name="telefono" id="telefono" class="form-control rounded deshabilitar fono" value="{{
                                    trim($institucion->INTelefono) !='' ? $institucion->INTelefono : 'Sin Información' }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Email </label>
                                <input type="text"  name="email" id="email" class="form-control rounded deshabilitar" value="{{
                                    trim($institucion->INEmail) !='' ? $institucion->INEmail : 'Sin Información' }}">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Diócesis </label>
                                <input type="text"  name="diocesis" id="diocesis" class="form-control rounded deshabilitar" value="{{ trim($diocesis[0]->INNombre) !='' ? $diocesis[0]->INNombre: 'Sin Información' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Zona </label>
                                <input type="text"  name="zona" id="zona" class="form-control rounded deshabilitar" 
                                value="{{ trim($zona[0]->Nombre) !='' ? $zona[0]->Nombre : 'Sin Información' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Decanato </label>
                                <input type="text"  name="decanato" id="decanato" class="form-control rounded deshabilitar" value="{{ trim($decanato[0]->INNombre) !='' ? $decanato[0]->INNombre: 'Sin Información' }}">
                            </div>
                        </div>
                       
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label>Fecha Creación </label>
                                    <input type="text"  name="fecha" id="fecha" class="form-control rounded deshabilitar" value="{{date('d-m-Y', strtotime($institucion->INFecCrea))}}">
                                </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Párroco o Adm. Parroquial </label>
                                <input type="text"  name="parroco" id="parroco" class="form-control rounded deshabilitar" value="{{trim ($parroco[0]->PENombre). ' '.trim($parroco[0]->PEApellidos) !='' ? trim($parroco[0]->PENombre). ' '. trim($parroco[0]->PEApellidos) : 'Sin Información' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>V. Parroquial </label>
                                <input type="text"  name="vicario" id="vicario" class="form-control rounded deshabilitar" value="Sin Información">
                            </div>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                <div class="row">
                    <div class="col-lg-5">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Diaconos Permanentes </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($diacono as $diac)
                                <tr class="diaconos">
                                    <td> 
                                        {{ trim($diac->PENombre). ' ' .trim($diac->PEApellidos) }}
                                    </td>
                                </tr>
                                 @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-1 b-r"></div>
                    <div class="col-md-6">
                        <label>Coordenadas Parroquia </label>
                        <form id="info">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="latitude">Latitud</label>
                                        <input type="text" name="latlng1" id="latlng1" class="form-control rounded deshabilitar coordenadas" placeholder="ingrese latitud" 
                                        value="{{ $latLng[0]->ITLatitud }}">
                                        <small>Ejemplo: -33.444322</small>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="longitude">Longitud</label>
                                        <div class="input-group">
                                            <input type="text" name="latlng2" id="latlng2" class="form-control rounded deshabilitar coordenadas" placeholder="ingrese longitud" value="{{ $latLng[0]->ITLongitud }}">
                                            <div class="input-group-append">
                                                <button id="submit" class="btn btn-primary deshabilitar" onclick="coordenadasPa()" type="button"><i class="fa fa-search" aria-hidden="true"></i></button>                                            
                                            </div>
                                        </div>
                                        <small>Ejemplo: -70.665952</small>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="google-map" id="infoPa"></div>
                        </div>
                    </div>
                </div> 
            {{ Form::close() }}  
            </div>
        </div>
    </div>
</div>
@section('javascript')
<script src="{{ asset('js/ValidarInput.js')}}"></script>
<script>
    function coordenadasPa(){
        var regexlat = /^(-?[1-8]?\d(?:\.\d{1,18})?|90(?:\.0{1,18})?)$/;
        var regexlng = /^(-?(?:1[0-7]|[1-9])?\d(?:\.\d{1,18})?|180(?:\.0{1,18})?)$/;
        if (regexlat.test(document.getElementById("latlng1").value) && regexlng.test(document.getElementById("latlng2").value)) { 
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ url('AjaxP/update/'.$institu)}}",
                type:"PUT",
                data: $('#info').serialize()
            });      
            swal("¡ÉXITO!", "Se actualizó correctamente la información.", "success");
        }else{
            swal("Error!", "Una de las Coordendas fue mal Ingresada.", "error");
        }
    }
</script>
@endsection
<script type="text/javascript">
// GoogleMaps 
    var map;
    var markers = @json($markers);
    function initMap() {
        for(var i=0;i<markers.length;i++){
            var data=markers[i];
            map = new google.maps.Map(document.getElementById("infoPa"), {
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
        document.getElementById("submit").addEventListener("click", () => {
            geocodeLatLng(geocoder, map, infowindow);
        });
    }

    function geocodeLatLng(geocoder, map, infowindow) {
        const input = document.getElementById("latlng1").value + ',' + document.getElementById("latlng2").value;
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