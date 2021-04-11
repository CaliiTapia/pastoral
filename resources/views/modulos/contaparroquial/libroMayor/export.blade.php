<table>
  <thead>
    <tr>
      <th>LIBRO MAYOR</th>
    </tr>
    <tr>
      <th>Rango:
        @if ($filtros->desde != '')
        {{ $filtros->desde }}
        @endif
        -
        @if ($filtros->hasta != '')
        {{ $filtros->hasta }}
        @endif
      </th>
    </tr>
    <tr>
      <th>Periodo: {{ $data[0]->comprobante->periodo->anoPeriod }}</th>
    </tr>
    <tr>
      <th>Area de Negocios: {{ ($filtros->areaNegocio == 'all') ? 'Todas' : $filtros->areaNegocio }}</th>
    </tr>
    <tr>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th style="background-color: #D8E4BC;">Cuenta</th>
      <th style="background-color: #D8E4BC;">Fecha</th>
      <th style="background-color: #D8E4BC;">N° comprobante</th>
      <th style="background-color: #D8E4BC;">Tipo</th>
      <th style="background-color: #D8E4BC;">N° interno</th>
      <th style="background-color: #D8E4BC;">Centro de costos</th>
      <th style="background-color: #D8E4BC;">Auxiliar</th>
      <th style="background-color: #D8E4BC;">Tipo documento</th>
      <th style="background-color: #D8E4BC;">Numero Doc</th>
      <th style="background-color: #D8E4BC;">Debe</th>
      <th style="background-color: #D8E4BC;">Haber</th>
      <th style="background-color: #D8E4BC;">Glosa</th>
    </tr>
    @foreach($data as $i => $movimiento)
      @if ($i > 0)
        @if ($movimiento->ctaCod != $data[$i - 1]->ctaCod)
          <tr>
            <td></td>
          </tr>
          <tr>
            <td>
              {{ $movimiento->ctaCod != null ? $movimiento->ctaCod . ' ' . $movimiento->cuenta->pctNombre : '' }}
            </td>
          </tr>
          
        @else
          
        @endif
      @else
        <tr>
          <td></td>
        </tr>
        <tr>
          <td>
            {{ $movimiento->ctaCod != null ? $movimiento->ctaCod . ' ' . $movimiento->cuenta->pctNombre : '' }}
          </td>
        </tr>
      @endif

    <tr>
      <td></td>
      <td>
        {{ date('d/m/Y', strtotime($movimiento->cpbFec)) }}
      </td>
      <td>{{ $movimiento->comprobante->cpbCorr }}</td>
      <td>{{ $movimiento->comprobante->cpbTip }}</td>
      <td>{{ $movimiento->comprobante->cpbNum }}</td>
      <td>
        {{ $movimiento->centroCosto != null ? $movimiento->centroCosto->ccCod . ' ' . $movimiento->centroCosto->ccDesc : '' }}
      </td>
      <td>
        {{ $movimiento->auxiliar != null ? $movimiento->auxiliar->codAux . ' ' . $movimiento->auxiliar->nomAux . ' ' . $movimiento->auxiliar->apllAux : '' }}
      </td>
      <td>{{ $movimiento->TipDocRef }}</td>
      <td>{{ $movimiento->NumDocRef }}</td>
      <td>{{ $movimiento->movDebe }}</td>
      <td>{{ $movimiento->movHaber }}</td>
      <td>{{ $movimiento->movGlosa }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
