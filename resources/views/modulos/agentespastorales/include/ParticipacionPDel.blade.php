<div class="panel-body" id="panelParticipacion">

    <div class="ibox-title espacio_encabezado">
        <h5>Historial Participación Parroquial</h5>
    </div>

    <div class="ibox-content">
        <table class="table table-striped">
            <thead style="background: #c6c6c6;">
                <tr>
                    <th>Parroquia</th>
                    <th>Capilla</th>
                    <th>Zona</th>
                    <th>Area Pastoral</th>
                    <th>Servicio Pastoral</th>
                    <th>Período</th>
                </tr>
            </thead>
            <tbody>
                @foreach($participaciones as $p)
                    <tr>
                        <td>{{ $p->institucion->INNombre }}</td>
                        <td>{{ $p->capilla ? $p->capilla->INNombre : 'Participa en parroquia'}}</td>
                        <td>{{ $p->zona->Nombre }}</td>
                        <td>{{ $p->area->MAP_Descripcion }}</td>
                        <td>{{ $p->cargo->MAP_Descripcion }}</td>
                        <td>{{ date("d/m/Y",strtotime($p->MAP_FechaInicio)) }} 
                        @if($p->MAP_FechaTermino != null)
                            {{ ' - '.date("d/m/Y",strtotime($p->MAP_FechaTermino)) }}
                        @endif</td>
    
                    </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
</div>