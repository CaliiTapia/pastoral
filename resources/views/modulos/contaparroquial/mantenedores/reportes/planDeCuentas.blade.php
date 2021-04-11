<table>
    <thead>
        <tr>
            <th style="background-color: #D8E4BC;"><strong>Codigo</strong></th>
            <th style="background-color: #D8E4BC;"><strong>Nivel</strong></th>
            <th style="background-color: #D8E4BC;"><strong>Nombre</strong></th>
            <th style="background-color: #D8E4BC;"><strong>Tipo</strong></th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $pC)
        <tr>
            <td>{{ $pC->pctCod }}</td>
            <td>{{ $pC->pctNivel }}</td>
            <td>{{ $pC->pctNombre  }}</td>
            <td>
            {{ $pC->pctTipo == 'G' ?  'Gasto' : ''}}
            {{ $pC->pctTipo == 'A' ?  'Activo' : ''}}
            {{ $pC->pctTipo == 'P' ?  'Pasivo' : ''}}
            </td>
        </tr>
    @endforeach
    </tbody>
</table>


