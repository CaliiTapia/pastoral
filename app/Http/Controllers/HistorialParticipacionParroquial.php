<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ParticipacionParroquial;
use App\Helpers\Helpers;
use Auth;

class HistorialParticipacionParroquial extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( Helpers::VerificaAccesoUR($request->MAP_I_INCodigo) ){
            
            if($request->MAP_I_INCodigoCapilla == null){
                $request->MAP_I_INCodigoCapilla = 0;
            }
            $participacion = new ParticipacionParroquial();
            $participacion->MAP_FechaInicio = $request->MAP_FechaInicio;
            $participacion->MAP_FechaTermino = $request->MAP_FechaTermino;
            $participacion->MAP_I_INCodigo = $request->MAP_I_INCodigo;
            $participacion->MAP_I_INCodigoCapilla = $request->MAP_I_INCodigoCapilla;
            $participacion->MAP_A_IdArea = $request->MAP_A_IdArea;
            $participacion->MAP_C_IdCargo = $request->MAP_C_IdCargo;
            $participacion->MAP_Z_IdZona = $request->MAP_Z_IdZona;
            $participacion->MAP_F_IdFicha = $request->MAP_F_IdFicha;
            $participacion->save();
        }else{
            return response()->json(['error' => 'Sin autorizacion'],403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        if( Helpers::VerificaAccesoUR($request->MAP_I_INCodigo) ){
            $participacion = ParticipacionParroquial::find($id);
            $participacion->MAP_FechaInicio = $request->MAP_FechaInicio;
            $participacion->MAP_FechaTermino = $request->MAP_FechaTermino;
            $participacion->MAP_I_INCodigo = $request->MAP_I_INCodigo;
            $participacion->MAP_I_INCodigoCapilla = $request->MAP_I_INCodigoCapilla;
            $participacion->MAP_A_IdArea = $request->MAP_A_IdArea;
            $participacion->MAP_C_IdCargo = $request->MAP_C_IdCargo;
            $participacion->MAP_Z_IdZona = $request->MAP_Z_IdZona;
            
            $participacion->save();
        }else{
            return response()->json(['error' => 'Sin autorizacion'],403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deshabilitar($id)
    {
        //Buscar participacion
        $participacion = ParticipacionParroquial::find($id);
        if( Helpers::VerificaAccesoUR($participacion->MAP_I_INCodigo) ){
            $participacion->MAP_Estatus = 0;
            $participacion->save();
            return 1;
        }else{
            return 0;
        }
    }
}