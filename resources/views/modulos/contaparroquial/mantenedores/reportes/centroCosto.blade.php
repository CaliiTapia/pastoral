<table>
    <thead>
        <tr>
            <th style="background-color: #D8E4BC;"><strong>Codigo</strong></th>
            <th style="background-color: #D8E4BC;"><strong>Nombre</strong></th>
            <th style="background-color: #D8E4BC;"><strong>Status</strong></th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $cc)
        <tr>
            <td>{{ $cc->ccCod }}</td>
            <td>{{ $cc->ccDesc }}</td>
            <td>{{  $cc->estatus =='A' ? 'Habilitado' : 'Deshabilitado' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>