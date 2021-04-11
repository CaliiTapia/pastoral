<table>
    <thead>
        <tr>
            <th style="background-color: #D8E4BC;"><strong>Codigo</strong></th>
            <th style="background-color: #D8E4BC;"><strong>Nombre</strong></th>
            <th style="background-color: #D8E4BC;"><strong>Apellido</strong></th>
            <th style="background-color: #D8E4BC;"><strong>Rut</strong></th>
            <th style="background-color: #D8E4BC;"><strong>Fono</strong></th>
            <th style="background-color: #D8E4BC;"><strong>Mail</strong></th>
            <th style="background-color: #D8E4BC;"><strong>Direccion</strong></th>
            <th style="background-color: #D8E4BC;"><strong>Status</strong></th>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $au)
        <tr>
            <td >{{ $au->codAux }}</td>
            <td>{{ $au->nomAux }}</td>
            <td>{{ $au->apllAux }}</td>
            <td>{{ $au->rutAux }}</td>
            <td>{{ $au->fonoAux }}</td>
            <td>{{ $au->mailAux }}</td>
            <td>{{ $au->dirAux }}</td>
            <td>{{ $au->statusAux =='A' ? 'Habilitado' : 'Deshabilitado' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>