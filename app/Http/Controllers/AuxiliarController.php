<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Comprobante;
use App\Movimientos;
use App\Cuentas;
use App\Auxiliar;
use App\Comuna;
use App\Pais;
use App\Ciudad;
use App\Helpers\Helpers;
use App\Persona;
use App\PersonaCargo;
use App\Contacto;
use App\User;


class AuxiliarController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $auxi = DB::select("SELECT aux.codAux, aux.nomAux, aux.apllAux, aux.rutAux, aux.statusAux, aux.fonoAux, aux.fono2Aux, aux.mailAux, aux.mailAux, aux.dirAux, com.Nombre as nombreComuna, ciu.Nombre as nombreCiudad, pai.Nombre as nombrePais
                                        FROM CP_auxi aux
                                        left  JOIN comuna com ON com.IdComuna = aux.comAux
                                       left  JOIN ciudad ciu ON ciu.IdCiudad = aux.ciudadAux
                                        JOIN pais pai ON pai.IdPais = aux.paisAux
                                        ");

        return view('modulos.contaparroquial.mantenedores.auxiliares.index', compact('auxi'));
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear(){
        $pais = pais::select('IdPais', 'Nombre')->get();
        $ciudad = ciudad::select('IdCiudad', 'Nombre')->get();
        $comuna = DB::select(DB::raw("SELECT com.Nombre as nombreComuna
                            FROM ciudad ciu
                            JOIN comuna com ON com.C_IdCiudad = ciu.IdCiudad
                            WHERE com.C_IdCiudad = ciu.IdCiudad")) ;   

        return view('modulos.contaparroquial.mantenedores.auxiliares.crear', compact('pais', 'ciudad', 'comuna'));
    }

    public function rutSolo($rutAux){
        $rutSolo = str_replace('.','',$rutAux);

        return $rutSolo;
    }

    public function store(Request $request){        
           
        $auxiliarExiste= Auxiliar::select('codAux')
        ->where('rutAux',$request->rutAux)
        ->get();

        $rut = $this->rutSolo($request->rutAux);

        if($auxiliarExiste->isEmpty())
        {
            try{
                $auxiliar = new Auxiliar();
    
                $auxiliar->rutAux =$request->rutAux;
                $auxiliar->codAux = substr($rut, 0, -2);;
                $auxiliar->nomAux = $request->nomAux;
                $auxiliar->apllAux = $request->apllAux;
                $auxiliar->statusAux = $request->tipo;
                $auxiliar->fonoAux = $request->fonoAux;
                $auxiliar->fono2Aux = $request->fono2Aux;
                $auxiliar->mailAux = $request->mailAux;
                $auxiliar->paisAux = $request->paisAux;
                $auxiliar->ciudadAux = $request->ciuAux;
                $auxiliar->comAux = $request->comAux;
                $auxiliar->dirAux = $request->dirAux;
    
                $auxiliar->save();
               
                $notificacion=Helpers::Notificaciones(true, 'success', '¡Exito!', 'El auxiliar se creo con éxito');
    
            }catch(Exception $e){
                $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'El auxiliar no se registro con éxito.');
            }
        }else
        {
            $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'El auxiliar ya existe.');

        }
        
        
        return redirect()->action('AuxiliarController@index')->with($notificacion);

    }

    public function editar($codAu)
    {
        $datos = DB::select(DB::raw("SELECT aux.codAux, aux.nomAux, aux.apllAux, aux.rutAux, aux.statusAux, aux.fonoAux, aux.fono2Aux, aux.mailAux, aux.mailAux, aux.dirAux, com.Nombre as nombreComuna , com.IdComuna as IdComuna, ciu.IdCiudad as IdCiudad, ciu.Nombre as nombreCiudad, pai.IdPais AS IdPais, pai.Nombre as nombrePais
        FROM CP_auxi aux
        left JOIN comuna com ON com.IdComuna = aux.comAux
        left JOIN ciudad ciu ON ciu.IdCiudad = aux.ciudadAux
        JOIN pais pai ON pai.IdPais = aux.paisAux
        WHERE aux.codAux = $codAu")); 

        $pais = pais::select('IdPais', 'Nombre')->get();
        $ciudad = ciudad::select('IdCiudad', 'Nombre')->get();
        /*$comuna = DB::select(DB::raw("SELECT com.Nombre as nombreComuna
                            FROM ciudad ciu
                            JOIN comuna com ON com.C_IdCiudad = ciu.IdCiudad
                            WHERE com.C_IdCiudad = ciu.IdCiudad")) ;   */
        $comuna = comuna::select('IdComuna', 'Nombre')->get();
                       
        return view('modulos.contaparroquial.mantenedores.auxiliares.editar', compact('datos','pais','ciudad', 'comuna'));
    }

    public function edit(Request $request, $cod){
        
        try{
            Auxiliar::where('codAux','=',$cod)
            ->update(['nomAux' => $request->nomAux,
            'apllAux' =>  $request->apllAux,
            'statusAux' => $request->status,
            'fonoAux' =>  $request->fonoAux,
            'fono2Aux' =>  $request->fono2Aux,
            'mailAux' =>  $request->mailAux,
            'dirAux' =>  $request->dirAux,
            'comAux' =>  $request->comAux,
            'ciudadAux' =>  $request->ciudadAux,
            'paisAux' =>  $request->paisAux]);

            $notificacion=Helpers::Notificaciones(true, 'success', '¡Exito!', 'El auxiliar se modificó con éxito');

        }catch (\Exception $e){
            $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'El auxiliar no se modificó con éxito.');
        }
        return redirect()->action('AuxiliarController@index')->with($notificacion);
    }

    public function eliminar($id){
        //dd($id);
        try{
            Auxiliar::where('codAux','=',$id)
            ->update(['statusAux' => 'I']);

           $notificacion=Helpers::Notificaciones(true, 'success', '¡Exito!', 'El auxiliar se deshabilitó con éxito');
       }catch(Exception $e){
           $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'El auxiliar no se deshabilitó con éxito');
       }
       return redirect()->action('AuxiliarController@index')->with($notificacion);
   }

   

}
