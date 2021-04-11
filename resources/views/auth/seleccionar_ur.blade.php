@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')    
<header class="content__title">
    <h1><a href="{{asset('home')}}" style="color: #000000"> INICIO </a></h1>
<style>
    span.select2-container {
        z-index:10050;
    }
</style>
</header>

   <div class="row">

        <div class="col-md-4">
            <div class="ibox-content text-center">
                <h1>Mi parroquia</h1>
                <!--div class="m-b-sm">
                        <img alt="image" class="rounded-circle" src="img/a8.jpg">
                </div-->
                        <p class="font-bold">Actualizar datos de parroquia</p>
                <div class="text-center">
                    <a href="{{ asset('mantenedores/parroquia/editar/'.Auth::user()->UR_idUnidadRecaudadora) }}" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Actualizar</a>
                </div>
            </div>
        </div>      
        <div class="col-md-4">
            <div class="ibox-content text-center">
                <h1>Contactos</h1>
                <!--div class="m-b-sm">
                        <img alt="image" class="rounded-circle" src="img/a8.jpg">
                </div-->
                        <p class="font-bold">Gestionar contactos de la parroquia</p>
                <div class="text-center">
                    <a href="{{asset('mantenedores/contacto')}}" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Actualizar</a>
                </div>
            </div>
        </div>   
        <div class="col-md-4">
            <div class="ibox-content text-center">
                <h1>Pre boleta</h1>
                <!--div class="m-b-sm">
                        <img alt="image" class="rounded-circle" src="img/a8.jpg">
                </div-->
                        <p class="font-bold">Calculo de boleta aporte 1%</p>
                <div class="text-center">
                    <a href="{{ asset('modulos/pre-calculadora') }}" class="btn btn-xs btn-warning"><i class="fa fa-calculator"></i> Calcular</a>
                </div>
            </div>
        </div>  

    </div>
<br>
<!-- Modal -->
<div class="modal fade" id="urmodal" tabindex="-1" role="dialog" aria-labelledby="titulo" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form method="GET" action="{{ route('urSeleccionada') }}">

            <div class="modal-header">
                <h5 class="modal-title" id="titulo">Seleccione una Unidad Recaudadora</h5>
            </div>
            <div class="modal-body">
                <select name="insti" id="UnidadRecaudadora" class="select2">
                    @foreach($urAsignadas as $registro)
                        @if($registro['Defecto'] == 'true')
                        <option  value="{{ $registro['IdInstitucion'] }}" selected>{{$registro['Codigo']." - ".$registro['Nombre'] }}</option>
                        @else
                        <option  value="{{ $registro['IdInstitucion'] }}" >{{$registro['Codigo']." - ".$registro['Nombre'] }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
                <div class="modal-footer">
                    <button type="summit" class="btn btn-primary">Seleccionar</button>
                </div>
        </form>

    </div>
  </div>
</div>

{{-- <script src="{{ asset('/js/ajax/ajax_cambia_ccosto.js')}}"></script> --}}
@endsection

@section('javascript')
<script type="text/javascript">
      $(document).ready(function()
      {
        $("#urmodal").modal({show:true,backdrop: 'static', keyboard: false});
      });
</script>
@endsection

