<table>
  <thead>
    <tr>
      <th>LIBRO DIARIO</th>
    </tr>
    <tr>
      <th>Tipo de comprobante:
        @if ($filtros->tipo === 'I')
        Ingreso
        @elseif ($filtros->tipo === 'E')
        Egreso
        @elseif ($filtros->tipo === 'T')
        Traspaso
        @else
        Todos
        @endif
      </th>
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
      <th>Periodo: {{ $data[0]->periodo->anoPeriod }}</th>
    </tr>
    <tr>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Numero de comprobante</td>
      <td>Fecha</td>
      <td>Tipo</td>
      <td>Numero Interno</td>
      <td>Estado</td>
      <td>Glosa</td>
    </tr>
    <tr>
      <td>Codigo cuenta</td>
      <td>Centro de costos</td>
      <td>Código auxiliar</td>
      <td>Tipo de documento</td>
      <td>Numero de documento</td>
      <td>Debe</td>
      <td>Haber</td>
      <td>Glosa</td>
    </tr>
    <tr>
      <th></th>
    </tr>
    @foreach($data as $comprobante)
    <tr>
      <td style="background-color: #D8E4BC;">
        {{ $comprobante->cpbCorr != null ? $comprobante->cpbCorr : '' }}
      </td>
      <td style="background-color: #D8E4BC;">
        {{ date('d/m/Y', strtotime($comprobante->cpbFec)) }}
      </td>
      <td style="background-color: #D8E4BC;">
        {{ $comprobante->cpbTip != null ? $comprobante->cpbTip : '' }}
      </td>
      <td style="background-color: #D8E4BC;">
        {{ $comprobante->cpbNum != null ? $comprobante->cpbNum : '' }}
      </td>
      <td style="background-color: #D8E4BC;">
        {{ $comprobante->cpbEst != null ? $comprobante->cpbEst : '' }}
      </td>
      <td style="background-color: #D8E4BC;">
        {{ $comprobante->cpbGlo != null ? $comprobante->cpbGlo : '' }}
      </td>
    </tr>

    @foreach($comprobante->movimientos as $movimiento)
    <tr>
      <td style="background-color: #D9D9D9;">
        {{ $movimiento->cuenta->pctCod . ' ' . $movimiento->cuenta->pctNombre }}
      </td>
      <td style="background-color: #D9D9D9;">
        {{ $movimiento->centroCosto != null ? $movimiento->centroCosto->ccCod : '' }}
      </td>
      <td style="background-color: #D9D9D9;">
        {{ $movimiento->auxiliar != null ? $movimiento->auxiliar->codAux : '' }}
      </td>
      <td style="background-color: #D9D9D9;">
        {{ $movimiento->TipDocRef != null ? $movimiento->TipDocRef : '' }}
      </td>
      <td style="background-color: #D9D9D9;">
        {{ $movimiento->NumDocRef != null ? $movimiento->NumDocRef : '' }}
      </td>
      <td style="background-color: #D9D9D9;">
        {{ number_format(floor($movimiento->movDebe), ...[0, '', '.']) }}
      </td>
      <td style="background-color: #D9D9D9;">
        {{ number_format(floor($movimiento->movHaber), ...[0, '', '.']) }}
      </td>
      <td style="background-color: #D9D9D9;">
        {{ $movimiento->movGlosa }}
      </td>
    </tr>
    @endforeach
    <tr>
      <th></th>
    </tr>
    @endforeach
  </tbody>
</table>
