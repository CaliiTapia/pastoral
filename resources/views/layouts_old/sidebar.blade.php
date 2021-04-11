<!-- Sidebar -->
<aside class="sidebar">
<div class="col-md-12" style="padding-left: 0px;  padding-right: 0px; padding-bottom:0px;">
                        <a href="{{asset('/home')}}"><img src="{{asset('img/logounoporciento.png')}}" alt="uno porciento" class="img-fluid"></a>
</div>

    <div class="scroll-wrapper scrollbar-inner">
        <!-- Card usuario -->
        <div class="user">
            <div class="user__info" data-toggle="dropdown">
                <img class="user__img" src="{{ asset('img/profile/perfil.jpg') }}" alt="">
                <div>
                    <div class="user__name">{{ strtoupper(\Illuminate\Support\Facades\Auth::user()->Nombre." ".\Illuminate\Support\Facades\Auth::user()->Apellidos)  }}</div>
                    <!--<div class="user__email">{{(\Illuminate\Support\Facades\Auth::user()->email) }}</div> -->
                </div>
            </div>

            <div class="dropdown-menu">
                <!-- <a class="dropdown-item" href="">Perfil</a>-->
                <a class="dropdown-item" href="{{ asset('mantenedores/cambiar-contraseña') }}">Cambiar contraseña</a>
                <a class="dropdown-item" href="{{ route('logout') }}">Salir</a>
            </div>
        </div>

        <!-- Listado menus -->
        <ul class="navigation">
            <li class=""><a href="{{asset('home')}}"><i class="zmdi zmdi-home"></i> Inicio </a></li>   

            <li class="navigation__sub"> 
                <a href=""><i class="zmdi zmdi-format-list-bulleted"></i> Parroquial </a>
                    <ul>
                        <li><a href="{{ asset('mantenedores/usuario') }}"><i class="zmdi zmdi-accounts"></i> Módulos</a></li>
                        <li><a href="{{ asset('mantenedores/roles') }}"><i class="zmdi zmdi-accounts-list"></i> Etiquetas</a></li>
                        <li><a href="{{ asset('mantenedores/Historial-solicitud') }}"><i class="zmdi zmdi-accounts-list-alt"></i> mantenedores</a></li>
                    </ul>  
                    <ul>
                        <li><a href="{{ asset('mantenedores/solicitud/create') }}"><i class="zmdi zmdi-assigit gnment"></i> Gestion de Contribuyentes</a></li>
                        <li><a href="{{ asset('mantenedores/solicitud') }}"><i class="zmdi zmdi-assignment-check"></i> Ingreso de Pagos</a></li>
                        <li><a href="{{ asset('/mantenedores/solicitudes/pre-aprobar') }}"><i class="zmdi zmdi-check-circle-u"></i> Tablas Anexas</a></li>
                    </ul> 
                    <a href=""><i class="zmdi zmdi-settings-square"></i> Configuración </a>
                    <ul>
                        
                        <li><a href="{{ asset('mantenedores/usuario') }}"><i class="zmdi zmdi-accounts"></i> Cartas</a></li>
                        <li><a href="{{ asset('mantenedores/roles') }}"><i class="zmdi zmdi-accounts-list"></i> Etiquetas</a></li>
                        <li><a href="{{ asset('mantenedores/Historial-solicitud') }}"><i class="zmdi zmdi-accounts-list-alt"></i> Sobres</a></li>
                    </ul>  
                    <a href="{{ asset('modulos/mantenedores/') }}"><i class="zmdi zmdi-format-list-bulleted"></i>Mantenedores </a>
                    <ul>
                        <li><a href="{{ asset('mantenedores/capilla') }}"><i class="zmdi zmdi-accounts"></i>  Capillas</a></li>
                        <li><a href="{{ asset('mantenedores/contribuyentes') }}"><i class="zmdi zmdi-accounts-list"></i>  Contribuyentes</a></li>
                        <li><a href="{{ asset('mantenedores/contacto') }}"><i class="zmdi zmdi-accounts"></i>  Contactos</a></li>
                        <li><a href="{{ asset('mantenedores/parroquia/editar/'.Auth::user()->id_unidad_recaudadora) }}"><i class="zmdi zmdi-accounts-list-alt"></i> Parroquias</a></li>
                        <li><a href="{{ asset('mantenedores/usuario/') }}"><i class="zmdi zmdi-accounts-list"></i>  Usuarios</a></li>
                        <li><a href="{{ asset('mantenedores/visitadores') }}"><i class="zmdi zmdi-accounts"></i>  Visitadores</a></li>
                    </ul>   
                </li>
            </li>
            <li class=""><a href="{{ asset('informes/') }}"><i class="zmdi zmdi-format-list-bulleted"></i> Informes </a></li>

        </ul>
    </div>
</aside>
