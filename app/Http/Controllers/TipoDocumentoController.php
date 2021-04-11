<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comprobante;
use App\Movimientos;
use App\Cuentas;
use App\Cp_areaN;
use App\TipoDocumento;
use App\Helpers\Helpers;

class TipoDocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipoDocumento= \DB::table('CP_tipdoc')
        ->select('TipDoc', 'DesTipDoc', 'TipDocStatus')
        ->get();

        return view('modulos.contaparroquial.mantenedores.tipoDocumento.index', compact('tipoDocumento'));
    }
    
    public function crear(){        
        return view('modulos.contaparroquial.mantenedores.tipoDocumento.crear');
    }

    public function store(Request $request){     
        
        $tipoDocumentoExiste= TipoDocumento::select('TipDoc')
        ->where('TipDoc',$request->tipDoc)
        ->get();
        
        if($tipoDocumentoExiste->isEmpty())
        {
            try{
                $tipoDocumento = new TipoDocumento();

                $tipoDocumento->TipDoc = strToUpper($request->tipDoc);
                $tipoDocumento->DesTipDoc = strToUpper($request->descTD);
                $tipoDocumento->TipDocStatus = $request->statusTD;           

                $tipoDocumento->save();
            
                $notificacion=Helpers::Notificaciones(true, 'success', '¡Exito!', 'Su tipo de documento se creo con éxito');

            }catch(Exception $e){
                $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'Su tipo de documento no se registro con éxito.');
            }
        }else
        {
            $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'El código del tipo de documento ya existe.');

        }
        
        return redirect()->action('TipoDocumentoController@index')->with($notificacion);
    }

    public function editar($codTD){
        $datos = \DB::table('CP_tipdoc')
        ->select('*')
        ->where('TipDoc', $codTD)
        ->get();       
               
        return view('modulos.contaparroquial.mantenedores.tipoDocumento.editar', compact('codTD', 'datos'));
    }

    public function edit(Request $request, $cod){

        try{
            TipoDocumento::where('TipDoc','=',$cod)
            ->update(['DesTipDoc' =>  strToUpper($request->nomTD),
            'TipDocStatus' => $request->statusTD]);

            $notificacion=Helpers::Notificaciones(true, 'success', '¡Exito!', 'Su tipo de documento se modificó con éxito');

        }catch (\Exception $e){
            $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'Su tipo de documento no se modificó con éxito.');
        }
    
    return redirect()->action('TipoDocumentoController@index')->with($notificacion);
    }

    public function eliminar($id){
        try{
        TipoDocumento::where('TipDoc','=',$id)
        ->update(['TipDocStatus' => 'I']);

        $notificacion=Helpers::Notificaciones(true, 'success', '¡Exito!', 'El tipo de documento se deshabilitó con éxito');
    }catch(Exception $e){
        $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'El tipo de documento no se deshabilitó con éxito');
    }
    return redirect()->action('TipoDocumentoController@index')->with($notificacion);
    }

}
