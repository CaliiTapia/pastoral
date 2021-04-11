<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header" style="padding: 25px 25px 15px;">
                <div class="dropdown profile-element">
                    <a href={{ route('home') }}><img alt="image" class="rounded-circle" width="140px" height="auto" style="margin: -18px auto 15px;" src="{{asset('img/profile/logo_arz.png')}}" /></a>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="block m-t-xs font-bold">{{ strtoupper(\Illuminate\Support\Facades\Auth::user()->Nombre." ".\Illuminate\Support\Facades\Auth::user()->Apellidos) }}</span>
                        <span class="text-muted text-xs block">Opciones <b class="caret"></b></span>
                    </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('logout') }}">Salir</a></li>
                    </ul>
                </div>
            </li>
            <li @if(Auth::user()->Pagina == 'Inicio') class="active" @endif>
                <a href="{{asset('home')}}"><i class="fa fa-home"></i><span class="nav-label">Inicio</span></a>
            </li>

            <li @if(Auth::user()->Pagina == 'Ficha' || Auth::user()->Pagina == 'Listado'|| Auth::user()->Pagina == 'Develacion' || Auth::user()->Pagina == 'Develaciones' ||
                Auth::user()->Pagina == 'BuscarAP' || Auth::user()->Pagina == 'ArchivoDev' || Auth::user()->Pagina == 'DArchivoDev') class="active" @endif>

                <a href=""><i class="fa fa-user-circle"></i> <span class="nav-label">Agentes Pastorales</span> <span class="fa arrow"></span></a>

                <ul class="nav nav-second-level" @if(Auth::user()->Pagina == 'Ficha' || Auth::user()->Pagina == 'Listado' || Auth::user()->Pagina == 'Develacion') @endif>
                    @can('ap_crear_ficha')
                        <li @if(Auth::user()->Pagina == 'Ficha') class="active" @endif><a href="{{ asset('pastoral/ficha') }}"><i class="fa fa-plus"></i> Crear Ficha Agente</a></li>
                    @endcan
                    @can('ap_listadoAp')
                        <li @if(Auth::user()->Pagina == 'Listado') class="active" @endif><a href="{{ asset('pastoral/listado') }}"><i class="fa fa-list-ul"></i> Listado Agentes</a></li>
                    @endcan
                    @can('ap_descargar_documentos')
                        <li @if(Auth::user()->Pagina == 'Develacion') class="active" @endif><a href="{{ asset('develacion/') }}"><i class="fa fa-download"></i> Descarga Documentos</a></li>
                    @endcan

                    <li @if(Auth::user()->Pagina == 'Develaciones' || Auth::user()->Pagina == 'BuscarAP') class="active" @endif>

                        @if(Auth::user()->hasPermissionTo('dev_buscarAp') || Auth::user()->hasPermissionTo('dev_proceso_develacion'))
                            <a href="#"><span class="nav-label">Develaciones</span> <span class="fa arrow"></span></a>
                        @endif
                        <ul class="nav nav-second-level" @if(Auth::user()->Pagina == 'Develaciones' || Auth::user()->Pagina == 'BuscarAP') @endif> 
                            @can('dev_buscarAp')
                                <li @if(Auth::user()->Pagina == 'BuscarAP' ) class="active" @endif><a href="{{asset('/buscar')}}"><i class="fa fa-search-plus"></i> Buscar AP</a></li>
                            @endcan
                            @can('dev_proceso_develacion')
                                <li @if(Auth::user()->Pagina == 'Develaciones') class="active" @endif><a href="{{asset('/develaciones')}}"><i class="fa fa-exclamation-circle"></i> Proceso Develación</a></li>
                            @endcan
                        </ul>
                    </li>

                    <li  @if(Auth::user()->Pagina == 'ArchivoDev' || Auth::user()->Pagina == 'DArchivoDev') class="active" @endif>

                        @if(Auth::user()->hasPermissionTo('dev_carga_develacion') || Auth::user()->hasPermissionTo('dev_descarga_develacion'))  
                            <a href="#"><span class="nav-label">Archivos Develación</span><span class="fa arrow"></span></a>
                        @endif
                        <ul class="nav nav-second-level" @if(Auth::user()->Pagina == 'ArchivoDev' || Auth::user()->Pagina == 'DArchivoDev') @endif>
                            @can('dev_carga_develacion')
                                <li @if(Auth::user()->Pagina == 'ArchivoDev') class="active" @endif><a href="{{asset('/documentosdevelaciones')}}"><i class="fa fa-upload"></i> Cargar Archivos</a></li>
                            @endcan
                            @can('dev_descarga_develacion')
                                <li @if(Auth::user()->Pagina == 'DArchivoDev') class="active" @endif><a href="{{asset('/descargararchivos')}}"><i class="fa fa-download"></i> Descarga de Documentos Develación</a></li>
                            @endcan
                        </ul>
                    </li>
                </ul>               
            </li> 

            <li @if(Auth::user()->Pagina == 'formacion') class="active" @endif>
                <a href=""><i class="fa fa-file-text"></i> <span class="nav-label">Formación</span> <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li @if(Auth::user()->Pagina == 'formacion') class="active" @endif><a href="{{ asset('/formacion/ingresar') }}"><i class="fa fa-plus"></i> Ingresar Formación</a></li>
                </ul>               
            </li> 

            {{-- Módulo 1% --}}
            @include('include.unoporciento.sidemenu')

            <!-- modulo contaparroquial -->
            @include('include.contaparroquial.sidemenu')

            <li class="">
                <a href="#"><i class="fa fa-check"></i> <span class="nav-label">Sacramentos</span></a>
            </li>
        </ul>

    </div>
</nav>