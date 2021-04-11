@extends('layouts.admin')
@section('title', 'Usuario')
@section('content')
@include('ValidaNotificacion')
    <header class="content__title">
        <h1><a href="{{asset('home')}}" style="color: #000000">INICIO </a></h1>
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
                    <a href="#" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Actualizar</a>
                </div>
            </div>
        </div>      
        <div class="col-md-4">
            <div class="ibox-content text-center">
                <h1>Contactos</h1>
                        <p class="font-bold">Gestionar contactos de la parroquia</p>
                <div class="text-center">
                    <a href="#" class="btn btn-xs btn-warning"><i class="fa fa-pencil"></i> Actualizar</a>
                </div>
            </div>
        </div>   
        <div class="col-md-4">
            <div class="ibox-content text-center">
                <h1>Pre boleta</h1>
                        <p class="font-bold">Calculo de boleta aporte 1%</p>
                <div class="text-center">
                    <a href="#" class="btn btn-xs btn-warning"><i class="fa fa-calculator"></i> Calcular</a>
                </div>
            </div>
        </div>  
    </div>
    @endsection