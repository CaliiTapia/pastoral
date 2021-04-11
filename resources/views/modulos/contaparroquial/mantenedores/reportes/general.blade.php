
<table>
    <thead>
        <tr>
            <th style="background-color: #92a8d1;"><strong>Codigo area de negocio</strong></th>
            <th style="background-color: #92a8d1;"><strong>Nombre area de negocio</strong></th>
            <th style="background-color: #92a8d1;"><strong>Status area de negocio</strong></th>
        </tr>
    </thead>
    <tbody>
        @foreach($areaNegocio as $aN)
            <tr>
                <td>{{ $aN->codAin != null ? $aN->codAin : '' }}</td>
                <td>{{ $aN->areaNom != null ? $aN->areaNom : '' }}</td>
                <td>{{ $aN->areaStatus =='A' ? 'Habilitado' : 'Deshabilitado' }}</td>
            </tr>
        @endforeach
  </tbody>
</table>

<table>
    <thead>
        <tr>
            <th style="background-color: #D8E4BC;"><strong>Codigo centro de costo</strong></th>
            <th style="background-color: #D8E4BC;"><strong>Nombre centro de costo</strong></th>
            <th style="background-color: #D8E4BC;"><strong>Status centro de costo</strong></th>
        </tr>
    </thead>
    <tbody>
        @foreach($centroCosto as $cc)
            <tr>
                <td>{{ $cc->ccCod != null ? $cc->ccCod : '' }}</td>
                <td>{{ $cc->ccDesc != null ? $cc->ccDesc : '' }}</td>
                <td>{{ $cc->estatus =='A' ? 'Habilitado' : 'Deshabilitado' }}</td>
            </tr>
        @endforeach
  </tbody>
</table>
