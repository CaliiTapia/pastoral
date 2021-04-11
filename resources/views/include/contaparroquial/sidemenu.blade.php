<li @if(Request::is('contaparroquial/*') ) class="active" @endif>
  <a href="#"><i class="fa fa-calculator"></i> <span class="nav-label">Conta. Parroquial</span><span
      class="fa arrow"></span></a>
  <ul class="nav nav-second-level collapse">
    <li @if(Request::is('contaparroquial/contabilidad/*') ) class="active" @endif>
      <a href="#">Contabilidad <span class="fa arrow"></span></a>
      <ul class="nav nav-third-level">
        <li @if(Request::is('contaparroquial/contabilidad/comprobantes*') ) class="active" @endif>
          <a href="{{ route('contaparroquial.contabilidad.comprobantes') }}"><i class="fa fa-file-text-o"></i><span
              class="nav-label">Comprobantes</span></a>
        </li>
        <li @if(Request::is('contaparroquial/contabilidad/ingreso-masivo*') ) class="active" @endif>
          <a href="{{ route('contaparroquial.contabilidad.ingreso-masivo') }}"><i class="fa fa-files-o"></i><span
              class="nav-label">Ingreso Masivo</span></a>
        </li>
        <li @if(Request::is('contaparroquial/contabilidad/comprobante-tipo*') ) class="active" @endif>
          <a href="{{ route('contaparroquial.contabilidad.comprobante-tipo') }}">
            <i class="fa fa-file-o"></i><span class="nav-label">Comprobante Tipo</span>
          </a>
        </li>
        <li @if(Request::is('contaparroquial/contabilidad/libro-diario*') ) class="active" @endif>
          <a href="{{ route('contaparroquial.contabilidad.libro-diario') }}">
            <i class="fa fa-book"></i><span class="nav-label">Libro Diario</span>
          </a>
        </li>
        <li @if(Request::is('contaparroquial/contabilidad/libro-mayor*') ) class="active" @endif>
          <a href="{{ route('contaparroquial.contabilidad.libro-mayor') }}">
            <i class="fa fa-book"></i><span class="nav-label">Libro Mayor</span>
          </a>
        </li>
      </ul>
    </li>
    <li @if(Request::is('contaparroquial/mantenedores/*') ) class="active" @endif>
      <a href="#">Digitaci&oacute;n <span class="fa arrow"></span></a>
      <ul class="nav nav-third-level">
        <li @if(Request::is('contaparroquial/mantenedores/areaNegocio*') ) class="active" @endif>
          <a href="{{ asset('contaparroquial/mantenedores/areaNegocio') }}"><i class="fa fa-money"
              aria-hidden="true"></i><span class="nav-label">&Aacute;rea de Negocios</span></a>
        </li>
        <li @if(Request::is('contaparroquial/mantenedores/auxiliares*') ) class="active" @endif>
          <a href="{{ asset('contaparroquial/mantenedores/auxiliares') }}"><i class="fa fa-users"
              aria-hidden="true"></i><span class="nav-label">Auxiliares</span></a>
        </li>
        <li @if(Request::is('contaparroquial/mantenedores/centroCosto*') ) class="active" @endif>
          <a href="{{ asset('contaparroquial/mantenedores/centroCosto') }}"><i class="fa fa-cc"
              aria-hidden="true"></i><span class="nav-label">Centro de Costos</span></a>
        </li>
        <li @if(Request::is('contaparroquial/mantenedores/periodo*') ) class="active" @endif>
          <a href="{{ asset('contaparroquial/mantenedores/periodo') }}"><i class="fa fa-clock-o"
              aria-hidden="true"></i><span class="nav-label">Periodo</span></a>
        </li>
        <li @if(Request::is('contaparroquial/mantenedores/planDeCuentas*') ) class="active" @endif>
          <a href="{{ asset('contaparroquial/mantenedores/planDeCuentas') }}"><i class="fa fa-bars"
              aria-hidden="true"></i><span class="nav-label">Plan de cuentas</span></a>
        </li>
        <li @if(Request::is('contaparroquial/mantenedores/tipoDocumento*') ) class="active" @endif>
          <a href="{{ asset('contaparroquial/mantenedores/tipoDocumento') }}"><i class="fa fa-file-code-o"
              aria-hidden="true"></i><span class="nav-label">Tipo documento</span></a>
        </li>
        <li @if(Request::is('contaparroquial/mantenedores/reportes*') ) class="active" @endif>
          <a href="{{ asset('contaparroquial/mantenedores/reportes') }}"><i class="fa fa-file-excel-o" aria-hidden="true"></i><span class="nav-label">Reportes</span></a>
        </li>
      </ul>
    </li>
  </ul>
</li>
