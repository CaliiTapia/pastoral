<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UnidadRecaudadora;
use App\Comuna;
use App\Contacto;
use App\Region;
use App\Ciudad;
use App\FormaPago;
use App\Helpers\Helpers;
use App\Banco;
use Illuminate\Support\Facades\Auth;

class ParroquiaController extends Controller
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
        //
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
        
        $UnidadRecaudadora = UnidadRecaudadora::select('IdUnidadRecaudadora','Codigo','Nombre','C_IdComuna','Direccion','Sector','Telefono1','Telefono2','Telefono3','Email','EmailUno','EmailDos','Rut','NroCuenta')
        ->where('IdUnidadRecaudadora',$id)
        ->first();

        $Comunas = Comuna::pluck('Nombre','IdComuna');
        //dd($id,$UnidadRecaudadora,$Comunas);

        return view('modulos.mantenedores.parroquias.form',
        ['UnidadRecaudadora'=> $UnidadRecaudadora,'Comunas'=>$Comunas]);
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
        
        try{
            $parroquia= UnidadRecaudadora::find($id);
            $parroquia->C_IdComuna = $request->Comunas;
            $parroquia->Direccion = mb_strtoupper($request->direccion);
            $parroquia->Telefono1 = $request->telefono;
            $parroquia->Telefono2 = $request->telefono2;
            $parroquia->Telefono3 = $request->telefono3;
            $parroquia->email = $request->email;
            $parroquia->emailUno = $request->email2;
            $parroquia->emailDos = $request->email3;
            $parroquia->updated_at = date('Y-m-d h:m:s');
            //dd($parroquia);
            $parroquia->save();
            $notificacion = Helpers::Notificaciones(true,'success','Exito!','Se han modificado los datos de la unidad recaudadora');
        }catch (\Exception $e){
            dd($e);
            $notificacion = Helpers::Notificaciones(true,'error','No se pudo guardar','Problemas al modificar la unidad recaudadora');
        }
        return redirect()->route("home")->with($notificacion);
        
            
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
    
    public function form_contacto()
    {
        return view('modulos.mantenedores.contacto.form');
    }
   
    public function editar_contacto_consulta($id)
    {
        $Contacto = Contacto::where('IdContacto',$id)->first();
        return view('parroquia.contacto_edit',compact('Contacto'));
    }

}
