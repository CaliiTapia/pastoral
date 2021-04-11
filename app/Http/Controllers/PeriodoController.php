<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comprobante;
use App\Movimientos;
use App\Cuentas;
use App\Cp_areaN;
use App\Periodo;
use App\Helpers\Helpers;

class PeriodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institucion = Helpers::codigo_inst_seleccionada();
        $periodo= \DB::table('CP_periodo')
        ->select('idPeriod', 'anoStatus', 'INCodigo', 'anoPeriod')
        ->where('INCodigo',$institucion)
        ->get();

        return view('modulos.contaparroquial.mantenedores.periodo.index', compact('periodo'));
    }
    
    public function crear(){
        $institucion = Helpers::codigo_inst_seleccionada();

        $ultimoCod = \DB::table('CP_periodo')
        ->select('idPeriod')
        ->orderBy('idPeriod', 'desc')
        ->get();

        $idMasUno = count($ultimoCod)+1;
        
        return view('modulos.contaparroquial.mantenedores.periodo.crear', compact('idMasUno'));
    }

    public function store(Request $request){      

        $institucion = Helpers::codigo_inst_seleccionada();
        
        $ultimoCod = \DB::table('CP_periodo')
        ->select('idPeriod')
        ->orderBy('idPeriod', 'desc')
        ->get();

        $idMasUno = count($ultimoCod)+1;

        $PeriodoExiste= Periodo::select('idPeriod')
        ->where('idPeriod',$idMasUno)
        ->get();

        if($PeriodoExiste->isEmpty()){
            try{
                //inserta
                $periodo = new Periodo();
                
                $periodo->idPeriod = $idMasUno;
                $periodo->anoPeriod = $request->anoPeriod;
                $periodo->anoStatus = $request->statusP;
                $periodo->INCOdigo = $institucion;          

                $periodo->save();

                if($request->statusP=='A'){
                    Periodo::where('idPeriod','!=',$idMasUno)
                    ->where('INCOdigo', $institucion)
                    ->update(['anoStatus' => 'I']);
                }
                
                
                $notificacion=Helpers::Notificaciones(true, 'success', '¡Exito!', 'Su periodo se creo con éxito');

            }catch(Exception $e){
                $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'Su periodo no se registro con éxito.');
            }
        }else{
            $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'El periodo ya existe.');
        }
        
        return redirect()->action('PeriodoController@index')->with($notificacion);

    }

    public function editar($codP)
    {
        $institucion = Helpers::codigo_inst_seleccionada();

        $datos = \DB::table('CP_periodo')
        ->select('*')
        ->where('idPeriod', $codP)
        ->where('INCodigo', $institucion)
        ->get();       
               
        return view('modulos.contaparroquial.mantenedores.periodo.editar', compact('codP', 'datos'));

    }

    public function edit(Request $request, $cod){
        try{
            $periodo= Periodo::find($cod);
            $periodo->anoPeriod = $request->anoP;
            $periodo->anoStatus = $request->statusP;

            $periodo->save();

            Periodo::where('idPeriod','!=',$cod)
            ->update(['anoStatus' => 'I']);

            $notificacion=Helpers::Notificaciones(true, 'success', '¡Exito!', 'Su periodo se modificó con éxito');

        }catch (\Exception $e){
            $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'Su periodo no se modificó con éxito.');
        }
        return redirect()->action('PeriodoController@index')->with($notificacion);
    }

    public function eliminar($id){
         //dd($id);
         try{
            $periodo = Periodo::find($id);
            $periodo->anoStatus = 'I';

            $periodo->save();

            $notificacion=Helpers::Notificaciones(true, 'success', '¡Exito!', 'El periodo se deshabilitó con éxito');
        }catch(Exception $e){
            $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'El periodo no se deshabilitó con éxito');
        }
        return redirect()->action('PeriodoController@index')->with($notificacion);
    }

}
