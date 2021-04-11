@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')
@include('ValidaNotificacion') 
<header class="content__title">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <div>                
                <div class="col-lg-10">
                    <h2>@include('layouts.urSeleccionada') / Descargar Documentos</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ asset('/develacion') }}">Develación</a>
                        </li>
                        <li class="breadcrumb-item">
                            <strong>Listado</strong>
                        </li>
                    </ol>
                </div>
                <!-- <div class="col-lg-2"></div> -->
            </div>
        </div>
    </div>
</header>
<div class="wrapper wrapper-content espacio">

<!-- ININCIO SEGUNDA TABLA -->
       <div class="row">
        <div class="col-lg-12">
            <div class="ibox-title">
                <h5><strong>DESCARGAR FICHA</strong></h5><small class="m-l-sm"> Documentos disponibles para su descarga</small>
            </div>
        </div>
    </div>
        <div class="col-md-14">
            <!-- Inicio data table -->
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Descargar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Declaración y Autorización</td>
                                <td class="descripcion">"Es el documento que debe ser completado por el voluntario que quiere ser partícipe de la parroquia como agente pastoral. El documento permitirá el ingreso de antecedentes personales y de contacto, autorizando a la Arquidiócesis de Santiago para ingresar los datos en la base de datos de gestión parroquial. Además, el documento servirá como una declaración en donde se compromete y adhiere a las políticas de prevención aprobadas a nivel nacional por la conferencia episcopal de chile."</td>
                                <td><a target="_blank" href="{{ asset('pastoral/descarga/ficha') }}"><i class="fa fa-file-word-o fa-5x"></a></i></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
     
<!-- FIN SEGUNDA TABLA -->


    <div class="row">
        <div class="col-lg-12">
            <div class="ibox-title">
                <h5><strong>DOCUMENTOS DE DEVELACIÓN</strong></h5><small class="m-l-sm"> Documentos disponibles para su descarga</small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <!-- Inicio data table -->
            <div class="ibox-content">
                <div class="table-responsive">
                    <table class="table" >
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Descargar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Acta recepción del relato</td>
                                <td class="descripcion">"Es el documento que debe ser completado por el párroco y por quien relata los hechos, - afectado directo o un tercero- que podrían constituir abuso sexual en sentido amplio, con conductas tales como, relaciones sexuales –consentidas o no consentidas- contacto físico con intención sexual, exhibicionismo, masturbación, producción de pornografía, inducción a la prostitución, conversaciones y/o propuestas de carácter sexual incluso mediante medios de comunicación, entre otros. (ver instructivo)."</td>
                                <td><a target="_blank" href="{{ route('recepcionrelato') }}"><i class="fa fa-file-word-o fa-5x"></a></i></td>
                            </tr>
                            <tr>
                                <td>Comunicación al afectado</td>
                                <td class="descripcion">"Es el documento que debe ser completado por el párroco , una vez que ha conversado con los tutores legales del niño, niña o adolescente, -padres, padre o madre, abuelo, etc., conforme a la ley del Estado de Chile; les ha señalado que debe poner en conocimiento de estos hechos al Ministerio Público para su esclarecimiento; y que él o la agente pastoral involucrado quedará suspendido de sus funciones en ésta o cualquier otra parroquia y/o capilla mientras los hechos no sean esclarecidos."</td>
                                <td><a target="_blank" href="{{ route('comunicacionafectado') }}"><i class="fa fa-file-word-o fa-5x"></a></i></td>
                            </tr>
                            <tr>
                                <td>Comunicación al involucrado</td>
                                <td class="descripcion">"Es el documento que debe ser completado por el párroco, una vez que ha conversado con el involucrado, (señalado como victimario), si éste es mayor de edad, o sus tutores legales si es menor de edad; comunicándole que se ha recibido una develación donde se le involucra en ella y que por la gravedad de los antecedentes, se ve en la obligación de dar comunicación al Ministerio Público de los mismos, quedando suspendido de sus funciones como agente pastoral hasta que estos sean aclarados."</td>
                                <td><a target="_blank" href="{{ route('comunicacioninvolucrado') }}"><i class="fa fa-file-word-o fa-5x"></a></i></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

             


        </div>

        <!-- Fin data table -->

    </div>
</div>

@endsection

@section('javascript')

    <script>
        $(document).ready(function(){
            $('.dataTables-Fichas').DataTable({
                pageLength: 25,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ListadoFichas'},
                    {extend: 'pdf', title: 'ListadoFichas'},

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


@endsection