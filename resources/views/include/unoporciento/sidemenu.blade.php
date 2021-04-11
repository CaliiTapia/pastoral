<li {!! (Request::is('unoporciento/*') ? 'class="active"' : '') !!}>
    
    <a href="#"><i class="fa fa-percent"></i> <span class="nav-label">1% Parroquial</span><span class="fa arrow"></span></a>

    <ul class="nav nav-second-level collapse">
        
        <li {!! (Request::is('unoporciento/contribuyentes*') ? 'class="active"' : '') !!}>
            <a href="#">Contribuyentes <span class="fa arrow"></span></a>

            <ul class="nav nav-third-level">
                <li {!! (Request::is('unoporciento/contribuyentes') ? 'class="active"' : '') !!}><a href="{{asset('/unoporciento/contribuyentes')}}"><i class="fa fa-list"></i> Listado</a></li>
                <li {!! (Request::is('unoporciento/contribuyentes/crear-contribuyente') ? 'class="active"' : '') !!}><a href="{{asset('/unoporciento/contribuyentes/crear-contribuyente')}}"><i class="fa fa-plus"></i> Crear Contribuyente</a></li>
            </ul>

        </li>

        <li {!! (Request::is('unoporciento/cartas*') ? 'class="active"' : '') !!}>
            <a href="#">Cartas y Etiquetas <span class="fa arrow"></span></a>

            <ul class="nav nav-third-level">
                <li {!! (Request::is('unoporciento/cartas/carta-cobranza') ? 'class="active"' : '') !!}><a href="{{asset('/unoporciento/cartas/carta-cobranza')}}"><i class="fa fa-envelope"></i> Carta Cobranza</a></li>
                <li {!! (Request::is('unoporciento/cartas/carta-resumen') ? 'class="active"' : '') !!}><a href="{{asset('/unoporciento/cartas/carta-resumen')}}"><i class="fa fa-envelope"></i> Carta Resumen</a></li>
                <li {!! (Request::is('unoporciento/cartas/etiquetas') ? 'class="active"' : '') !!}><a href="{{asset('/unoporciento/cartas/etiquetas')}}"><i class="fa fa-tag"></i> Etiquetas</a></li>
            </ul>

        </li>

        <li {!! (Request::is('unoporciento/pagos*') ? 'class="active"' : '') !!}>
            <a href="#">Pagos <span class="fa arrow"></span></a>

            <ul class="nav nav-third-level">
                <li {!! (Request::is('unoporciento/pagos/comprobantes') ? 'class="active"' : '') !!}><a href="{{asset('/unoporciento/pagos/comprobantes')}}"><i class="fa fa-money"></i> Comprobantes</a></li>
                <li {!! (Request::is('unoporciento/pagos/comprobantes/ingreso-comprobante') ? 'class="active"' : '') !!}><a href="{{asset('/unoporciento/pagos/comprobantes/ingreso-comprobante')}}"><i class="fa fa-plus"></i> Ingreso Comprobante</a></li>
                <li {!! (Request::is('unoporciento/pagos/mandatos') ? 'class="active"' : '') !!}><a href="{{asset('/unoporciento/pagos/mandatos')}}"><i class="fa fa-file"></i> Mandatos</a></li>
                <li {!! (Request::is('unoporciento/pagos/mandatos/captura') ? 'class="active"' : '') !!}><a href="{{asset('/unoporciento/pagos/mandatos/captura')}}"><i class="fa fa-upload"></i> Captura Mandatos</a></li>
            </ul>

        </li>
        
        <!--<li><a href="{{asset('/porciento-parroquial/pagos')}}">Pagos</a></li>-->
        <li {!! (Request::is('unoporciento/rendicion') ? 'class="active"' : '') !!}><a href="{{asset('/unoporciento/rendicion')}}">Rendición de Cuentas</a></li>

    </ul>

</li>