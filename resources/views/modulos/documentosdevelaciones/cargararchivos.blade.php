@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')
@include('ValidaNotificacion')
<header class="content__title">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <div>
                <div class="col-lg-10">
                    <h2> DOCUMENTOS DEVELACIONES</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="#">Subir Archivos Develaciones</a>
                        </li>
                        <li class="breadcrumb-item">
                            <strong>Cargar Archivos</strong>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="wrapper wrapper-content espacio">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-title">
                <h3><strong>Subida de Archivos</strong></h3>
            </div>
        </div>
    </div>
    <div class="ibox-content ">
        <form enctype="multipart/form-data" id="formarchivo"  method="POST">
            <div class="row">
                <div class="col-md-5">
                    <div class="form-group">
                        <label><b>Descripción del Archivo </b></label>
                        <input type="text" class="form-control rounded" id="descripcion" name="descripcion" required> 
                    </div>
                </div>
                {{ csrf_field() }}
                <div class="col-md-5">
                    <div class="form-group">
                        <label><b>Selccione Archivo</b></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="subirarchivo" name="subirarchivo" accept=".doc, .docx, .pdf, .image/*" required>
                            <label for="logo" class="custom-file-label">No se ha seleccionado</label>
                        </div> 
                        <label>Solo formatos: doc, docx, pdf, jpeg, jpg, png</label>
                    </div>
                </div>
                <div class="col-md-2" style="padding-top: 7px;">
                    <div class="form-group">
                        <br>
                        <button type="submmit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="wrapper wrapper-content espacio">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox-title">
                <h3><strong>Listado de Archivos</strong></h3>
            </div>
            <!-- Inicio data table -->
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table table-striped table-hover dataTables-Dev" id="listadescargas">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Descripción</th>
                                <th>Nombre Archivo</th>
                                <th>Usuario</th>
                                <th style="text-align: right">Fecha Subida</th>
                                <th style="text-align: center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $contadordatos = 1;
                            @endphp
                        @foreach($devarchivos as $da)
                            <tr class="gradeX">
                                <td>{{ $contadordatos }}</td>
                                <td>{{ $da ->MAP_Descripcion }}</td>
                                <td>{{ $da ->MAP_Nombre_Archivo }}</td>
                                <td>{{ $da ->Nombre." ".$da ->Apellidos}}</td>
                                <td align="right">{{ $da ->fechadesubida }}</td>
                                <td align="center"><a href="storage/archivosdevelaciones/{{ $da ->MAP_Nombre_Archivo }}" download="{{ $da ->MAP_Nombre_Archivo }}" class="btn btn-outline btn-primary"><i class="fa fa-download" title="Descargar"></i></a>
                                 <button type="button" class="btn btn-outline btn-danger" onclick="eliminar_logico({{ $da ->MAP_IdArchivo }})">
                                    <i class="fa fa-window-close" title="Eliminar"></i>
                                    </button></td>
                            </tr>
                            @php
                                $contadordatos ++;
                            @endphp
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Fin data table -->
    </div>
</div>

@endsection


@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
        $(document).ready(function(){
            $('.dataTables-Dev').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ListadoDev'},
                    {extend: 'pdf', title: 'ListadoDev'},

                    {extend: 'print',
                        customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                .addClass('compact')
                                .css('font-size', 'inherit');
                        }
                    }
                ],
                language: {
                    lengthMenu: "Mostrar _MENU_ entradas",
                    info: "Mostrando desde _START_ hasta  _END_ de _TOTAL_ ",
                    search: "Buscar:",

                    buttons:  {
                     copy : "Copiar",
                     print : "Imprimir"
                    },

                    paginate: {
                        previous: "Anterior",
                        next: "Siguiente"
                    }
                } 
            });
      });  
</script>
<script>
    $('#formarchivo').on('submit', function (e){
        e.preventDefault();
        /* Creamos un nuevo objeto FormData. Este sustituye al 
        atributo enctype = "multipart/form-data" que, tradicionalmente, se 
        incluía en los formularios (y que aún se incluye, cuando son enviados 
        desde HTML. */
        var paqueteDeDatos = new FormData();
        /* Todos los campos deben ser añadidos al objeto FormData. Para ello 
        usamos el método append. Los argumentos son el nombre con el que se mandará el 
        dato al script que lo reciba, y el valor del dato.
        Presta especial atención a la forma en que agregamos el contenido 
        del campo de fichero, con el nombre 'archivo'. */
        paqueteDeDatos.append('archivo', $('#subirarchivo')[0].files[0]);
        paqueteDeDatos.append('descripcion', $('#descripcion').prop('value'));
        paqueteDeDatos.append('_token', $("input[name=_token]").val());

        var archivo=  $('#subirarchivo').val();
        var extension=(archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
        if(extension=='.doc' || extension=='.docx' || extension=='.pdf' || extension=='.jpeg' || extension=='.jpg' || extension=='.png'){

            $.ajax({
                // envia informacion a DB
                type:"POST",
                url:"/guardararchivodenuncia",
                data: paqueteDeDatos,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response){
                    console.log(response);
                    Swal.fire(
                            'Exito',
                            'Se ha ingresado el archivo de la denuncia.',
                            'success'
                            )
                            setTimeout('document.location.reload()', 3000);
                    
                    },
                error: function(error){
                    console.log(error);
                    alert("Hay un Error");
                }
            });
        }else {
            swal("Error!", "Tipo de Archivo no admitido, favor intente con otro", "error");
        }
        
    }); 
</script>

<script type="text/javascript"> 
    
    function eliminar_logico(idarchivo){
        Swal.fire({
            title: 'Atención!!',
            text: "Esta seguro que desea eliminar el archivo?",
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonText: 'Cancelar',
            confirmButtonText: 'Si, eliminar'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type:"GET",
                    url:"/eliminar_logico/"+idarchivo,
                    success: function(response){ 
                        if(response == 1){
                            Swal.fire(
                            'Exito',
                            'El documento ha sido eliminado correctamente',
                            'success'
                            )
                            setTimeout('document.location.reload()', 2200);
                        }
                        else{
                            swal("Error", 'Ocurrio un error al eliminar!', "error");
                        }
                        
                    },
                    error: function(error){
                        console.log(error);
                    }
                });
            }
        });
            
    }
</script>

@endsection