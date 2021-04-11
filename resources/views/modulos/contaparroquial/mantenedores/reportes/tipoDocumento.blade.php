<table>
    <thead>
        <tr>
            <th style="background-color: #D8E4BC;"><strong>Codigo</strong></th>
            <th style="background-color: #D8E4BC;"><strong>Descripcion</strong></th>
            <th style="background-color: #D8E4BC;"><strong>Status</strong></th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $tD)
        <tr>
            <td>{{ $tD->TipDoc }}</td>
            <td>{{ $tD->DesTipDoc }}</td>
            <td>{{ $tD->TipDocStatus =='A' ? 'Habilitado' : 'Deshabilitado' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>