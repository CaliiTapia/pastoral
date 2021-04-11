<div class="panel-body">
    <div class="ibox-title">
        <h5>Formación</h5>
    </div>
    <div class="ibox-content">
        <div class="tabs-container">
            <div class="tabs-left">
                <ul class="nav nav-tabs">
                    <li><a class="nav-link active" data-toggle="tab" href="#tab-3-1"> Formación Pastoral</a></li>
                    <li><a class="nav-link" data-toggle="tab" href="#tab-3-2">Cursos y Diplomados</a></li>
                </ul>
                <div class="tab-content ">
                    <div id="tab-3-1" class="tab-pane active">
                        @include('modulos.agentespastorales.include.ServicioPastoral')
                    </div>
                    <div id="tab-3-2" class="tab-pane">
                        @include('modulos.agentespastorales.include.CursosDiplomados')
                    </div>
                </div>
            </div>              
        </div>
    </div>
</div>