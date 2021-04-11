<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Comprobante;
use App\Movimientos;
use App\Cuentas;
use App\AreaNegocio;
use App\Helpers\Helpers;

class AreaNegocioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institucion = Helpers::codigo_inst_seleccionada();
        $areaNegocio= \DB::table('CP_areaN')
        ->select('areaCod', 'areaNom', 'areaStatus', 'codAin')
        ->where('INCodigo',$institucion)
        ->get();

        return view('modulos.contaparroquial.mantenedores.areaNegocio.index', compact('areaNegocio'));
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function crear(){
        $institucion = Helpers::codigo_inst_seleccionada();
        $ultimoId = $this->INAreaNegocio($institucion);
        $idMasUno = count($ultimoId)+1;
        
        return view('modulos.contaparroquial.mantenedores.areaNegocio.crear', compact('idMasUno'));
    }

    public function store(Request $request){   
        
        $institucion = Helpers::codigo_inst_seleccionada();

        $ultimoId = $this->INAreaNegocio($institucion);
        $idMasUno = count($ultimoId)+1;

        $ultimoIdCorr = $this->codCorrelativo();
        $codMasUno = count($ultimoIdCorr)+1;

        try{
            $areaNegocio = new AreaNegocio();

            
            $areaNegocio->areaCod = $codMasUno;
            $areaNegocio->areaNom = $request->nomANe;
            $areaNegocio->areaStatus = $request->statusANe;
            $areaNegocio->INCodigo = $institucion;
            $areaNegocio->codAin =$idMasUno;            


            $areaNegocio->save();
           
            $notificacion=Helpers::Notificaciones(true, 'success', '¡Exito!', 'Su área de negocio se creo con éxito');

        }catch(Exception $e){
            $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'Su área de negocio no se registro con éxito.');
        }
        return redirect()->action('AreaNegocioController@index')->with($notificacion);

    }

    public function INAreaNegocio($institucion){
        $ultimoCod = \DB::table('CP_areaN')
        ->select('codAin')
        ->where('INCodigo', $institucion)
        ->orderBy('INCodigo', 'desc')
        ->get();

        return $ultimoCod;
    }

    public function codCorrelativo(){
        $codCorr = \DB::table('CP_areaN')
        ->select('areaCod')
        ->orderBy('INCodigo', 'desc')
        ->get();

        return $codCorr;
    }

    public function editar($codANe)
    {
        $institucion = Helpers::codigo_inst_seleccionada();

        $datos = \DB::table('CP_areaN')
        ->select('*')
        ->where('codAin', $codANe)
        ->where('INCodigo', $institucion)
        ->get();       
               
        return view('modulos.contaparroquial.mantenedores.areaNegocio.editar', compact('codANe', 'datos'));

    }

    public function edit(Request $request, $cod){ 
        try{
            $areaNegocio= AreaNegocio::find($cod);
            $areaNegocio->areaNom = $request->nomANe;
            $areaNegocio->areaStatus = $request->statusANe;

            $areaNegocio->save();

            $notificacion=Helpers::Notificaciones(true, 'success', '¡Exito!', 'Su área de negocio se modificó con éxito');

        }catch (\Exception $e){
            $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'Su área de negocio no se modificó con éxito.');
        }
        return redirect()->action('AreaNegocioController@index')->with($notificacion);
    }

    public function eliminar($id){
         //dd($id);
         try{
            $areaNegocio = AreaNegocio::find($id);
            $areaNegocio->areaStatus = 'I';
            $areaNegocio->save();
            $notificacion=Helpers::Notificaciones(true, 'success', '¡Exito!', 'El área de negocio se deshabilitó con éxito');
        }catch(Exception $e){
            $notificacion=Helpers::Notificaciones(true, 'error', 'Error!', 'El área de negocio no se deshabilitó con éxito');
        }
        return redirect()->action('AreaNegocioController@index')->with($notificacion);
    }

}
