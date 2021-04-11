<div class="panel-body">  
    <div class="wrapper wrapper-content animated fadeInRight espacio">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox-title">
                    <h5><strong>CAPILLAS</strong></h5>
                </div>
                
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-capillas" >
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Dirección</th>
                                    <th>Teléfono</th>
                                    <th>Ver</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($infoCapilla as $info)
                                    <tr class="gradeX">
                                        <td>{{ $info ->INNombre }}</td>
                                        <td>{{ $info ->INDireccion }}</td>
                                        <td>{{ $info ->INTelefono }}</td>
                                        <td><a class="btn btn-outline btn-info" href="{{asset('/capilla/update/'.$info->INCodigo.'/edit')}}"><i class="fa fa-eye"></i></a></td>
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