@extends('layouts.admin')

@section('content')
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2>Plan de cuentas</h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="breadcrumb-item active">
                <strong>Plan de cuentas</strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-6">
        <div class="pull-right" style="margin-top: 40px;">
            <a class="btn btn-success" style="margin-right:10px;"
                href="{{ asset('contaparroquial/mantenedores/planDeCuentas') }}" role="button"><i class="fa fa-refresh"
                    aria-hidden="true"></i> Refrescar tabla</a>

            <a class="btn btn-success" style="margin-right:10px; color: #fff;" type="button"
                onclick="modalCargaMasiva()"><i class="fa fa-cloud-upload" aria-hidden="true"></i> Carga masiva</a>

            <a class="btn btn-primary" style="margin-right:10px;"
                href="{{ asset('contaparroquial/mantenedores/planDeCuentas/crear') }}" role="button"><i
                    class="fa fa-plus-circle" aria-hidden="true"></i> Agregar cuenta contable</a>
        </div>
    </div>

</div>
<div class="wrapper wrapper-content animated fadeInRight ecommerce">
    <div class="ibox-content">
        <strong>
            <h2>Buscar plan de cuentas</h2>
        </strong>
        {!! Form::open(['action' => 'PlanDeCuentasController@buscar', 'method' => 'POST']) !!}
        <div class="row">
            <div class="col-md-2">
                <div class="form-group">
                    <input type="text" id="txtBuscar" name="txtBuscar" placeholder="Ingrese código o nombre"
                        class="form-control" min="0">
                </div>
            </div>
            <div class="col-md-1">
                <input type="submit" id="btnBuscar" value="Buscar" class="btn btn-info" name="btnBuscar"></input>
            </div>
        </div>
    </div>
    {{ Form::close() }}
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5>Lista de plan de cuentas</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="dataTables-centros"
                            class="table table-striped table-bordered table-hover dataTables-centros">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Nivel</th>
                                    <th>Nombre</th>
                                    <th>Tipo</th>
                                    <th>Edición</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($planCuentas as $pc)
                                <tr>
                                    <td>{{ trim($pc->pctCod) !='' ? $pc->pctCod : 'Sin Información' }}</td>
                                    <td>{{ trim($pc->pctNivel) !='' ? $pc->pctNivel : 'Sin Información' }}</td>
                                    <td>{{ trim($pc->pctNombre) !='' ? $pc->pctNombre : 'Sin Información' }}</td>
                                    <td>{{ trim($pc->pctTipo) !='' ? $pc->pctTipo : 'Sin Información' }}</td>
                                    <td>
                                        <a
                                            href="{{ asset('contaparroquial/mantenedores/planDeCuentas/editar/'.$pc->pctCod) }}"><i
                                                class="fa fa-edit"></i> <span class="bold"> Editar</span></a>
                                    </td>
                                    <td>
                                        <a class="actions__item zmdi zmdi-delete" href="#ModalConfirm"
                                            data-toggle="modal" value="" onclick="idPC('/{{ $pc->pctCod }}/') "><i
                                                class="fa fa-trash"></i> <span class="bold"> Eliminar</span></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="ModalConfirm" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="zmdi zmdi-delete animated infinite wobble"></i>
                </div>
                <h4 class="modal-title">¿Estás seguro?</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-footer">
                <a class="btn btn-info" data-dismiss="modal">Cancelar</a>
                <a id="btn_confirm_delete" class="btn btn-danger">Confirmar</a>
            </div>
        </div>
    </div>
</div>


{{-- modal para carga masiva --}}
<div class="modal inmodal" id="modalCargaMasiva" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content animated fadeIn">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                        class="sr-only">Close</span></button>
                <i class="fa fa-file-text-o modal-icon"></i>
                <h4 class="modal-title">Ingreso de documento para carga masiva</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="custom-file">
                                <input id="documento_adjunto" type="file" ref="file" class="custom-file-input"
                                    accept=".xlsx">
                                <label class=" custom-file-label" for="documento_adjunto">Sube aqui el
                                    documento</label>
                            </div>
                        </div>
                        <p class="text-warning"><i class="fa fa-exclamation"></i> Solo extensiones .xlsx</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <p id="carga_masiva_errores" class="text-danger">

                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-w-m btn-primary" onclick="subirCargaMasiva()">Subir</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
<script src="{{ asset('js/plugins/bs-custom-file/bs-custom-file-input.min.js') }}"></script>
<script src="{{ asset('js/vue/axios.js') }}"></script>

<script>
    $(document).ready(function() {
        bsCustomFileInput.init();
    });
</script>

<script>
    $(document).ready(function(){
        $('.dataTables-centros').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: [
                { extend: 'copy'},
                {extend: 'csv'},
                {extend: 'excel', title: 'Plan-de-Cuentas'},
                {extend: 'pdf', title: 'Plan-de-Cuentas'},
                {extend: 'print',
                    customize: function (win){
                        $(win.document.body).addClass('white-bg');
                        $(win.document.body).css('font-size', '10px');
                        $(win.document.body).find('table')
                            .addClass('compact')
                            .css('font-size', 'inherit');
                    }
                }
            ],
            language: {
                lengthMenu: "Mostrar _MENU_ entradas",
                info: "Mostrando desde _START_ hasta  _END_ de _TOTAL_ ",
                search: "Buscar:",
                buttons:  {
                    copy : "Copiar",
                    print : "Imprimir"
                },
                paginate: {
                    previous: "Anterior",
                    next: "Siguiente"
                }
            }
        });
    });

    function idPC(id){
        var a = id.replace('/','');
        id = a.replace('/','');

        $("#btn_confirm_delete").attr("href","/contaparroquial/planDeCuentas/eliminar/"+id);
    }

    function modalCargaMasiva() {
        $('#carga_masiva_errores').html('');
        $("#modalCargaMasiva").modal('toggle');
    }

    function subirCargaMasiva() {
        if (! $('input[type=file]')[0].files[0]) {
            return toastr['error']("Debe seleccionar un documento antes de continuar", "Advertencia");
        }

        $('#carga_masiva_errores').html('');

        let formData = new FormData();
        formData.append('file', $('input[type=file]')[0].files[0]);
        
        axios.post("{{route('contaparroquial.mantenedores.planDeCuentas.cargaMasiva')}}", formData,
            {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }
        ).then(function(response) {
            console.log('SUCCESS!!', response.data);
            if (response.data.error) {
                $('#carga_masiva_errores').append('<ul></ul>');
                response.data.error.forEach((item, index) => {
                    $('#carga_masiva_errores > ul').append('<li>' + item.error_message_formatted + '</li>');
                });
                return toastr['warning'](response.data.message, "Advertencia");
            }
            setTimeout(function(){
                this.window.location.reload();
            }, 3000);
            return toastr['success'](response.data.message, 'Guardado');
        })
        .catch(function(error) {
            console.log('FAILURE!!', error);
            return toastr['error']('Detectamos un error en su navegador, intente nuevamente mas tarde', "Advertencia");
        });
    }

</script>
@endsection
