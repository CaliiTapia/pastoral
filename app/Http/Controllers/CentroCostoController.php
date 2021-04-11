<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Comprobante;
use App\Helpers\Helpers;
use App\Movimientos;
use App\Cuentas;
use App\Institucion;
use App\Cp_auxi;
use App\Comuna;
use App\CentroCostos;


class CentroCostoController extends Controller
{
    public function index(){
        $institucion = Helpers::codigo_inst_seleccionada();
        $centroCosto= \DB::table('CP_ccostos')
        ->select('id','INCodigo','ccCod', 'ccDesc', 'estatus')
        ->where('INCodigo',$institucion)
        ->get();

        return view('modulos.contaparroquial.mantenedores.centroCosto.index', compact('centroCosto'));
    }

    public function crear(){
        $institucion = Helpers::codigo_inst_seleccionada();
        $ultimoId = $this->INCentroCosto($institucion);
        $idMasUno = count($ultimoId)+1;
        
        return view('modulos.contaparroquial.mantenedores.centroCosto.crear', compact('idMasUno'));
    }

      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){       
        $institucion = Helpers::codigo_inst_seleccionada();

        $ultimoId = $this->INCentroCosto($institucion);
        $idMasUno = count($ultimoId)+1;

        $ultimoIdCorr = $this->codCorrelativo();
        $codMasUno = count($ultimoIdCorr)+1;
        try{
            $centroCosto = new CentroCostos();
            
            $centroCosto->id = $codMasUno;
            $centroCosto->ccDesc =$request->descCC;
            $centroCosto->estatus = $request->tipo;
            $centroCosto->INCodigo = $institucion;
            $centroCosto->ccCod =$idMasUno;         

            $centroCosto->save();
           
            $notificacion=Helpers::Notificaciones(true, 'success', '¡Exito!', 'El centro de costo se creo con éxito');

        }catch(Exception $e){
            $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'El centro de costo no se registro con éxito.');
        }
        return redirect()->action('CentroCostoController@index')->with($notificacion);

    }

    public function INCentroCosto($institucion){
        $ultimoCod = \DB::table('CP_ccostos')
        ->select('ccCod')
        ->where('INCodigo', $institucion)
        ->orderBy('INCodigo', 'desc')
        ->get();

        return $ultimoCod;
    }

    public function codCorrelativo(){
        $codCorr = \DB::table('CP_ccostos')
        ->select('id')
        ->orderBy('INCodigo', 'desc')
        ->get();

        return $codCorr;
    }

    public function editar($codCC)
    {
        $institucion = Helpers::codigo_inst_seleccionada();

        $datos = \DB::table('CP_ccostos')
        ->select('*')
        ->where('ccCod', $codCC)
        ->where('INCodigo', $institucion)
        ->get();       
               
        return view('modulos.contaparroquial.mantenedores.centroCosto.editar', compact('codCC', 'datos'));

    }

    public function edit(Request $request, $cod){
        try{
            $centroCosto= CentroCostos::find($cod);
            $centroCosto->ccDesc = $request->descCC;
            $centroCosto->estatus = $request->statusCC;

            $centroCosto->save();

            $notificacion=Helpers::Notificaciones(true, 'success', '¡Exito!', 'Su centro de costo se modificó con éxito');

        }catch (\Exception $e){
            $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'Su centro de costo no se modificó con éxito.');
        }
        return redirect()->action('CentroCostoController@index')->with($notificacion);
    }

    public function eliminar($id){
        try{
           $centroCosto= CentroCostos::find($id);
           $centroCosto->estatus = 'I';

           $centroCosto->save();

           $notificacion=Helpers::Notificaciones(true, 'success', '¡Exito!', 'El centro de costo se deshabilitó con éxito');
       }catch(Exception $e){
           $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'El centro de costo no se deshabilitó con éxito');
       }
       return redirect()->action('CentroCostoController@index')->with($notificacion);
   }

}
