<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Capilla;
use App\Parroquia;
use App\UnidadRecaudadora;
use App\Comuna;
use App\Contacto;
use App\Region;
use App\Ciudad;
use App\FormaPago;
use App\Helpers\Helpers;
use App\Banco;
use Illuminate\Support\Facades\Auth;

class CapillaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $capilla= DB::connection('dbsanjudas')->table('capilla as a')
        ->join('parroquia as b','a.P_IdParroquia','=','b.IdParroquia')
        ->join('decanato as c','b.D_IdDecanato','=','c.IdDecanato')
        ->join('zona as d','c.Z_Idzona','=','d.IdZona')
        ->join('diocesis as e','d.D_IdDiocesis','=','e.IdDiocesis')
        ->select('a.IdCapilla','a.Nombre','b.Nombre as Parroquia','c.Nombre as Decanato','d.Nombre as Zona','e.Nombre as Diocesis','a.Estatus')
        ->orderBy('a.IdCapilla','desc')
        ->get();

        return view('modulos.mantenedores.capillas.index', ['capilla' => $capilla]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('modulos.mantenedores.capillas.form'); 
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
        $validator = $this->validate(request(), [
            'capilla' => 'required|regex:/^[A-Za-z\s-_]+$/',
            'parroquia' => 'required'
              ],
              [
                'regex' => 'No ingrese simbolos'
              ]);  
    
            $capilla= new Capilla();
            $capilla-> Nombre=strtoupper($request->capilla);
            $capilla-> P_IdParroquia=$request->parroquia;
            $capilla->save();
    
            return redirect()->action('CapillaController@index');   
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
        $capilla = Capilla:: where('IdCapilla',$id)->orderBy('IdCapilla', 'desc')->first();
      return view('modulos.mantenedores.capillas.update',[
             'capilla'=>$capilla
         ]);
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
        $validator = $this->validate(request(), [
            'capilla' => 'required|regex:/^[A-Za-z\s-_]+$/',
            'parroquia' => 'required',
            'estatus'=> 'required'
              ]); 
    
       ///update tabla  capilla//
           $capilla=Capilla::where('IdCapilla',$id);
           $capilla->update(['Nombre'=>strtoupper($request->get('capilla')),
            'P_IdParroquia'=>$request->get('parroquia'),
            'Estatus'=>$request->get('estatus')
           ]);
          return redirect()->action('CapillaController@index');
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
}
