@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')
@include('ValidaNotificacion')
<header class="content__title">
    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-lg-12">
            <div>
                <div class="col-lg-10">
                    <h2>@include('layouts.urSeleccionada') / INFORMACIÓN PARROQUIAL</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <strong>Información</strong>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="wrapper wrapper-content animated fadeIn espacio">
    <div class="ibox-content ">
        <div class="tabs-container">
            <ul class="nav nav-tabs" role="tablist">
                <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> Información </a></li>
                
                <li><a class="nav-link" data-toggle="tab" href="#tab-2"> Horarios y Redes Sociales</a></li>
                
                <li><a class="nav-link" data-toggle="tab" href="#tab-3"> Capillas </a></li>
            </ul>
        
            <div class="tab-content" id="tabsInfo">
                <div role="tabpanel" id="tab-1" class="tab-pane active">
                    @include('modulos.mantenedores.include.informacion')
                </div>
                
                <div role="tabpanel" id="tab-2" class="tab-pane">
                    @include('modulos.mantenedores.include.rss_horarios')
                </div>
         
                <div role="tabpanel" id="tab-3" class="tab-pane">
                    @include('modulos.mantenedores.include.capillas')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection