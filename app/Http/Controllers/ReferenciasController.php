<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Referencia;
use App\ParticipacionParroquial;
use Auth;
use App\Helpers\Helpers;

class ReferenciasController extends Controller
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
        // Buscar participacion
        $participacion = ParticipacionParroquial::find($request->MAP_P_IdParticipacion) ? ParticipacionParroquial::find($request->MAP_P_IdParticipacion) : null ;
        // Consultar si existe participacion y tiene acceso a esa UR
        if( $participacion != null && Helpers::VerificaAccesoUR($participacion->MAP_I_INCodigo) ){
            // Guardar
            $referencia = new Referencia();
            $referencia->MAP_Observacion = $request->MAP_Observacion;
            $referencia->MAP_U_IdUsuario = Auth::user()->IdUsuario;
            $referencia->MAP_Nota = $request->MAP_Nota;
            $referencia->MAP_P_IdParticipacion = $request->MAP_P_IdParticipacion;
            $referencia->save();
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
        //
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

    public function deshabilitar($IdReferencia){
        //Buscar participacion
        $referencia = Referencia::find($IdReferencia);
        $participacion = $referencia->participacion;
        if( Helpers::VerificaAccesoUR($participacion->MAP_UR_IdUnidadRecaudadora) ){
            $referencia->MAP_Estatus = 0;
            $referencia->save();
        }else{
            return response()->json(['error' => 'Sin autorizacion'],403);
        }
    }
}
