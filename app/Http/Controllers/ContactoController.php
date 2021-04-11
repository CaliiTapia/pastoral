<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Contacto;
use App\Cargo;
use App\Ficha;
use Illuminate\Support\Facades\Auth;

class ContactoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Contactos = Contacto::joinFicha()
            ->where('fichas.Estado',1)
            ->get();
        //dd($Contactos);
        return view('modulos.mantenedores.contacto.index',compact('Contactos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        //Estatus = 1 : Activo
        //Estatus = 2 : Desactivado
        $Cargos = Cargo::where('Estatus',1)->pluck('Descripcion','IdCargo');
       
        return view('modulos.mantenedores.contacto.form',['Cargos'=>$Cargos]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $this->validate(request(), [
            'rut_contacto' => 'required',
            'dv_contacto' => 'required',
            'nombre_contacto' => 'required',
            'paterno_contacto' => 'required',
            'materno_contacto' => 'required',
            'nacimiento_contacto' => 'required',
            'cargo_contacto' => 'required'
            
        ],
            [
                'rut_contacto.required' => 'El rut es un campo requerido',
                'dv_contacto.required' => 'Ingrese el digito verificador',
                'nombre_contacto.required' => 'El nombre es un campo requerido',
                'paterno_contacto.required' => 'El apellido paterno es un campo requerido',
                'materno_contacto.required' => 'El apellido materno es un campo requerido',
                'nacimiento_contacto.required' => 'Debe ingresar la fecha de nacimiento',
                'cargo_contacto.required' => 'Debe seleccionar el cargo'
            ]);
       
        try{
            //dd($request);
            $contacto = new Contacto();
            $ficha = new Ficha();
            
            //llena la ficha de personas
            $ficha->Rut = $request->rut_contacto;
            $ficha->Dv =  $request->dv_contacto;
            $ficha->Nombres = $request->nombre_contacto;
            $ficha->ApellidoPaterno = $request->paterno_contacto;
            $ficha->ApellidoMaterno = $request->materno_contacto;
            $ficha->Celular = $request->celular_contacto;
            $ficha->Fijo = $request->fijo_contacto;
            $ficha->Email = $request->email_contacto;
            $ficha->C_IdCargo = $request->cargo_contacto;
            $ficha->Direccion = $request->direccion_contacto;
            $ficha->C_IdComuna = null;
            $ficha->Sexo = $request->sexo;
            $ficha->FechaNac = $request->nacimiento_contacto;
            $ficha->created_at = date("Y-m-d H:i:s");
            $ficha->updated_at = date("Y-m-d H:i:s");
            $ficha->save();
            
            //Datos en la tabla contacto
            $contacto->UR_IdUnidadRecaudadora = Auth::user()->UR_idUnidadRecaudadora;
            $contacto->updated_at = date("Y-m-d H:i:s");
            $contacto->created_at = date("Y-m-d H:i:s");
            $contacto->F_IdFichas = $ficha->IdFichas;
            $contacto->save();
            //dd($ficha->IdFichas,$ficha,$contacto);
            $notificacion=Helpers::Notificaciones(true, 'success', '¡Exito!', 'El contacto se creo con exito');
        }catch(Exception $e){
            $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'La solicitud no se registro con exito.');
        }
        
        return redirect()->action('ContactoController@index')->with($notificacion);
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
        $ficha = Ficha::where('IdFichas',$id)->first();
        $Cargos = Cargo::where('Estatus',1)->pluck('Descripcion','IdCargo');
        //dd($Contacto);
        return view('modulos.mantenedores.contacto.edit',compact('ficha','Cargos'));
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
        //dd($id,$request);
        $validator = $this->validate(request(), [
            'nombre_contacto' => 'required',
            'paterno_contacto' => 'required',
            'materno_contacto' => 'required',
            'cargo_contacto' => 'required',
            'celular_contacto' => 'required',
            'email_contacto' =>'required'
        ],
            [
                'nombre_contacto.required' => 'El nombre es un campo requerido',
                'paterno_contacto.required' => 'El apellido paterno es un campo requerido',
                'materno_contacto.required' => 'El apellido materno es un campo requerido',
                'cargo_contacto.required' => 'Debe seleccionar el cargo',
                'celular_contacto.required' => 'Debe ingresar un número de telefono',
                'email_contacto.required' => 'Debe ingresar un email'

            ]);
       
        try{
            //dd($request);
            $ficha =  Ficha::find($id);
            $ficha->C_IdCargo = $request->cargo_contacto;
            $ficha->Nombres = $request->nombre_contacto;
            $ficha->ApellidoPaterno = $request->paterno_contacto;
            $ficha->ApellidoMaterno = $request->materno_contacto;
            $ficha->Direccion = $request->direccion_contacto;
            $ficha->Fijo = $request->fijo_contacto;
            $ficha->Celular = $request->celular_contacto;
            $ficha->Email = $request->email_contacto;
            $ficha->updated_at = date("Y-m-d H:i:s");
            $ficha->save();
            $notificacion=Helpers::Notificaciones(true, 'success', '¡Exito!', 'El contacto se modifico con exito');
        }catch(Exception $e){
            $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'La solicitud no se registro con exito.');
        }
        
        return redirect()->action('ContactoController@index')->with($notificacion);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //dd($id);
        try{
            $ficha = Ficha::find($id);
            $ficha->Estado = 2;
            $ficha->save();
            $notificacion=Helpers::Notificaciones(true, 'success', '¡Exito!', 'El contacto se elimno con exito');
        }catch(Exception $e){
            $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'La solicitud no se registro con exito.');
        }
        
        return redirect()->action('ContactoController@index')->with($notificacion);
        
    }
}
