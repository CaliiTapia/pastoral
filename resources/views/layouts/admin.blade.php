<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Gestión Parroquial') }}</title>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- fullCalendar -->
    <link href="{{ asset('fullcalendar/core/main.css')}}" rel='stylesheet' />
    <link href="{{ asset('fullcalendar/daygrid/main.css')}}" rel='stylesheet' />
    <link href="{{ asset('fullcalendar/timegrid/main.css')}}" rel='stylesheet' />
    <link href="{{ asset('fullcalendar/list/main.css ')}}" rel='stylesheet' />
    <link href="{{ asset('fullcalendar/bootstrap/main.css')}}" rel='stylesheet' />

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css') }}" rel="stylesheet">

    <!-- Morris -->
    <link href="{{ asset('css/plugins/morris/morris-0.4.3.min.css') }}" rel="stylesheet">

    <!-- Morris -->
    <link href="{{ asset('css/plugins/sweetalert/sweetalert.css') }}" rel="stylesheet">

    <!-- select 2 -->
    <link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/select2/select2-bootstrap4.min.css') }}" rel="stylesheet">

    <!-- Steps CSS-->
    <link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/steps/main.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/plugins/steps/normalize.css') }}" rel="stylesheet"> --}}

    <!-- Toastr -->
    <link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <!-- Estilos personalizados -->
    <link href="{{ asset('css/custom/estilos.css') }}" rel="stylesheet">

    @yield('header')

    <style>
        [v-cloak] {
            display: none;
        }

    </style>
</head>

<body class="v-cloak">

    <div id="wrapper">

        <!-- Sidebar -->
        @include('include.sidebar')

        <!-- Wrapper -->
        <div id="page-wrapper" class="gray-bg">

            <!-- Navbar -->
            @include('include.navbar')


            <!-- Contenido del dashboard -->
            @yield('content')

            <br>
            <br>
            <hr>

            <!-- Footer -->
            @include('include.footer')

        </div> <!-- End wrapper -->

        <!-- Right Sidebar -->
        @include('include.rightsidebar')

    </div>


    <!-- Scripts -->

    <!-- Mainly scripts -->
    <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

    <!-- Flot -->
    <script src="{{ asset('js/plugins/flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.tooltip.min.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.spline.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/jquery.flot.symbol.js') }}"></script>
    <script src="{{ asset('js/plugins/flot/curvedLines.js') }}"></script>

    <!-- Peity -->
    <script src="{{ asset('js/plugins/peity/jquery.peity.min.js') }}"></script>
    <script src="{{ asset('js/demo/peity-demo.js') }}"></script>

    <!-- Custom and plugin javascript -->
    <script src="{{ asset('js/inspinia.js') }}"></script>
    <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('js/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Jvectormap -->
    <script src="{{ asset('js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>

    <!-- Sparkline -->
    <script src="{{ asset('js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>

    <!-- Sparkline demo data  -->
    <script src="{{ asset('js/demo/sparkline-demo.js') }}"></script>

    <!-- ChartJS-->
    <script src="{{ asset('js/plugins/chartJs/Chart.min.js') }}"></script>

    <!-- Data Table-->
    <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/plugins/footable/footable.all.min.js') }}"></script>
    <!--  Toastr -->
    <script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
    <!--  Sweet Alert -->
    <script src="{{ asset('js/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <!--  Select2-->
    <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
    <!-- Steps -->
    <script src="{{ asset('js/plugins/steps/jquery.steps.js') }}"></script>
    <script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>
    <!-- Jquery Validate -->
    <script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>
    <!-- fullCalendar -->
    <script src="{{ asset('fullcalendar/core/main.js')}}"></script>
    <script src="{{ asset('fullcalendar/interaction/main.js')}}"></script>
    <script src="{{ asset('fullcalendar/daygrid/main.js')}}"></script>
    <script src="{{ asset('fullcalendar/timegrid/main.js')}}"></script>
    <script src="{{ asset('fullcalendar/core/locales/es.js')}}"></script>
    <script src="{{ asset('fullcalendar/bootstrap/main.js')}}"></script>

    <!-- Google Maps MiParroquiaKey -->
    <!-- <script type="text/javascript" 
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAHoRds5PCqSwoeVkJkxS1G_PfHzbfwuok&callback=initMap&libraries=&v=weekly" 
    defer
    ></script> -->

    <script type="text/javascript">
        $(document).ready(function(){
            
            $("select.select2").select2({
                theme: 'bootstrap4',
                width:'100%',
                placeholder: "Seleccione una opcion",
            });
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            }); 
        });
    </script>
    <script type="text/javascript">
        toastr.options.closeButton = true;
        toastr.options.debug = false;
        toastr.options.newestOnTop = false;
        toastr.options.progressBar = true;
        toastr.options.positionClass = "toast-middle-center";
        toastr.options.preventDuplicates = true;
        toastr.options.onclick = null;
        toastr.options.showDuration = "450";
        toastr.options.hideDuration = "1000";
        toastr.options.timeOut = "5000";
        toastr.options.extendedTimeOut = "1000";
        toastr.options.showEasing = "swing";
        toastr.options.hideEasing = "linear";
        toastr.options.showMethod = "fadeIn";
        toastr.options.hideMethod = "fadeOut";

    </script>

    <script type="text/javascript">
        // Sesion expira a los 120 min (120 min x 60 seg x 1000 miliseg = 7500000)
        var tiempo = 7500000,
            i = 0;
        // URL base de la aplicacion
        var url = window.location.origin + "/validaSesion" ;

        function loop(){
            i++;
            var d = new Date();
            $.get(url, function(data, status){
                //console.log(data, i, d.getHours() + ":" + d.getMinutes()); contador de consultas
                if(data.estado == 'inactiva'){
                    swal({
                        title: "Sesion caducada",
                        text: "El sistema le pedira reiniciar sesion!",
                        type: "warning",
                        //showCancelButton: true,
                        cancelButtonText: "Mas tiempo",
                        confirmButtonColor: "#f8ac59",
                        confirmButtonText: "Refrescar ahora!",
                        closeOnConfirm: true,
                        // Confirm si la notificacion es warning
                    }, function (isConfirm) {
                       // Selecciono "Refrescar"
                        if (isConfirm){
                            // Recargar pagina
                            location.reload(true);
                        // Dar 10 min si selecciono "Mas tiempo"
                        }else{
                            // Esperar en la pagina durante 10 min (10 min x 60 seg x 1000 miliseg = 600000)
                            tiempo = 900000;
                            // Lanzar alert sesion expirada en 10 min
                            window.setTimeout(loop, tiempo);
                        }
                    });
                // Si la sesion no esta vencida consultar nuevamente en 120 min mas
                }else{
                    window.setTimeout(loop, tiempo);
                }
            });
        }

        // Iniciar funcion recursiva
        loop();

    </script>

    <script>
        // Imagen Parroquia
        function readImage (input) {
            if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#imgPa').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imgInPa").change(function () {
            readImage(this);
        });
        $("#imgInCa").change(function () {
            readImage(this);
        });
        // Fin Imagen Parroquia
    </script>

    <script type="text/javascript">
        // HABILITAR EDICION EN FORMULARIOS!!
        $(".deshabilitar").prop('disabled', true);

        $('#habilitar').click(function(){
            // Informacion
            $("#alias").prop('disabled', false);
            $("#email").prop('disabled', false);
            $("#telefono").prop('disabled', false);
            $("#latlng1").prop('disabled', false);
            $("#latlng2").prop('disabled', false);
            $("#actualizar").prop('disabled', false);
            $("#submit").prop('disabled', false);
            $("#imgInPa").prop('disabled', false);
        });

        $('#habilitarRrss').click(function(){
            // RRSS
            $("#pagina").prop('disabled', false); 
            $("#fb").prop('disabled', false); 
            $("#ig").prop('disabled', false); 
            $("#twitter").prop('disabled', false); 
            $("#youtube").prop('disabled', false); 
            $("#actualizarRrss").prop('disabled', false); 
        });

        $('#habilitarCap').click(function(){
            // Capillas
            $("#aliasCap").prop('disabled', false);
            $("#correoCap").prop('disabled', false);
            $("#telefonoCap").prop('disabled', false);
            $("#latlng3").prop('disabled', false);
            $("#latlng4").prop('disabled', false);
            $("#actualizarCap").prop('disabled', false);
            $("#submit1").prop('disabled', false);
            $("#imgInCa").prop('disabled', false);
        });
        // FIN Habilitar
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.dataTables-capillas').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'ExampleFile'},
                    {extend: 'pdf', title: 'ExampleFile'},

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

    @yield('javascript')
</body>

@include('Notificaciones')

</html>
