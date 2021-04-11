
{{-- @php( $urAsignadas = Helper::ur_asignadas(Auth::user())) --}}
@php( $urSeleccionada = Helper::ur_seleccionada(Auth::user()))
{{-- @if(count($urAsignadas) == 1) --}}
    <span class="">{{$urSeleccionada['Nombre'] }}</span>
{{-- @else
    <select name="select_ur" id="select_ur" class="select2" >
            @foreach($urAsignadas as $registro)
                @if($registro['IdUnidadRecaudadora'] === $urSeleccionada['IdUnidadRecaudadora'])
                    <option  value="{{ $registro['IdUnidadRecaudadora'] }}" selected>{{$registro['Codigo']." - ".$registro['Nombre'] }}</option>
                @else
                    <option  value="{{ $registro['IdUnidadRecaudadora'] }}" >{{$registro['Codigo']." - ".$registro['Nombre'] }}</option>
                @endif
            @endforeach
    </select>
@endif --}}
{{-- <script src="{{ asset('/js/ajax/ajax_cambia_ccosto.js')}}"></script> --}}