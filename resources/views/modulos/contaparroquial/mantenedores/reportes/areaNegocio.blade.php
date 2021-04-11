<table>
    <thead>
        <tr>
            <th style="background-color: #D8E4BC;"><strong>Codigo</strong></th>
            <th style="background-color: #D8E4BC;"><strong>Nombre</strong></th>
            <th style="background-color: #D8E4BC;"><strong>Status</strong></th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $aN)
        <tr>
            <td>{{ $aN->codAin }}</td>
            <td>{{ $aN->areaNom }}</td>
            <td>{{ $aN->areaStatus =='A' ? 'Habilitado' : 'Deshabilitado' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
