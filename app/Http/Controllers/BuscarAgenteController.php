<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\Helpers;
use Carbon\Carbon;
use Auth;
use App\Ficha;
use App\Zona;
use App\Institucion;
use App\MapDevelacion;
use App\MapLogAP;
use App\User;


class BuscarAgenteController extends Controller
{
    //
    public function __construc()
    {
        $this->middleware('auth');
    }
    public function index(Request $request){
        Auth::user()->Pagina='BuscarAP';
        $zona = Zona::Z();
        
        $institucion = DB::table('institucion')
        ->select('INCodigo','INNombre')
        ->where('INTICodigo', '=', 007)
        ->orderBy('INNombre','ASC')
        ->get();

        $motivo = MapLogAP::select('MAP_B_ValorModificado','MAP_B_IdFicha','MAP_B_INCodigo')
        ->where(function($query){ 
            $query-> where('MAP_B_Motivo','=','Cese Servicio')->orWhere('MAP_B_Motivo','=','Activación');   
        })
        ->where('MAP_B_Estatus',1)
        ->orderby('MAP_B_ValorModificado','DESC')
        ->get();

        $rut = $request->get('NumeroDocumento');
        $apepaterno = $request->get('ApellidoPaterno');
        $apematerno = $request->get('ApellidoMaterno');
        $zo = $request->get('IdZona');
        $in = $request->get('INCodigo');
        $agente = Ficha::with('fichaUR','instituciones','zonas')
                ->NumeroDocumento($rut)
                ->ApellidoPaterno($apepaterno)
                ->ApellidoMaterno($apematerno)
                ->IdZona($zo)
                ->INCodigo($in)
                ->join('MAP_fichaur', 'ficha.IdFicha', '=', 'MAP_fichaur.MAP_F_IdFicha')
                ->join('institucion', 'MAP_fichaur.MAP_I_INCodigo', '=', 'institucion.INCodigo')
                ->join('zona', 'institucion.INZona', '=', 'zona.IdZona')
                ->select('ficha.*','zona.IdZona','zona.Nombre AS Nom','institucion.*','MAP_fichaur.MAP_Estado')
                ->where('ficha.Estatus', 1)
                ->get();
        return view('modulos.develaciones.buscaragentepastoral', compact('agente', 'zona','institucion','motivo'));
    }

    public function getParro(Request $request, $id){
        if ($request->ajax()) {
            $parro = Institucion::parro($id);
            return response()->json($parro); 
        }
    }

    public function AjaxInicioDev(Request $request, $id){
        $in = $request->id;
        $pa = $request->parroquia;
        $existencia = DB::table('MAP_develacion')
                        ->select('MAP_IdFicha','MAP_IdProceso')
                        ->where('MAP_IdFicha', '=', $in)
                        ->orderBy('MAP_IdProceso','DESC')
                        ->first();
        $INExistencia = DB::table('MAP_develacion')
                        ->select('MAP_IdFicha','MAP_INCodigo','MAP_IdEstado')
                        ->where('MAP_IdFicha', '=', $in)
                        ->where('MAP_INCodigo', '=', $pa)
                        ->orderBy('MAP_IdProceso','DESC')
                        ->orderBy('MAP_IdEstado','DESC')
                        ->first();

        if (!empty($INExistencia)) {
            if($INExistencia->MAP_IdEstado==3 OR $INExistencia->MAP_IdEstado==4){
                $idusuario=Auth::user()->IdUsuario;
                $fechaDenuncia = Carbon::now();
                $Inicio = new MapDevelacion;
                $Inicio->MAP_IdFicha = $request->id;
                $Inicio->MAP_IdProceso=(!empty($existencia) ? $existencia->MAP_IdProceso+1 : 1);
                $Inicio->MAP_INCodigo = $request->parroquia;        
                $Inicio->MAP_RutAP = $request->ruti;
                $Inicio->MAP_InZona = $request->zona;
                $Inicio->MAP_FechaDenuncia = $fechaDenuncia;
                $Inicio->MAP_IdUsuario = $idusuario;
                $Inicio->MAP_Observacion = $request->observacionDev;
                $Inicio->MAP_IdEstado = 1;

                $Inicio->save();
                
                Helpers::Sweetalert(false, 'warning', '¡LISTO!', 'Se ha Iniciado el Proceso de Develación.');

                return response()->json();
            }
            else{
                Helpers::Sweetalert(false, 'warning', '¡AVISO!', 'El agente ya cuenta con un proceso de denuncia activa en esta parroquia.');
            }
        }elseif(empty($INExistencia)){
            $idusuario=Auth::user()->IdUsuario;
            $fechaDenuncia = Carbon::now();
            $Inicio = new MapDevelacion;
            $Inicio->MAP_IdFicha = $request->id;
            $Inicio->MAP_IdProceso=(!empty($existencia) ? $existencia->MAP_IdProceso+1 : 1);
            $Inicio->MAP_INCodigo = $request->parroquia;        
            $Inicio->MAP_RutAP = $request->ruti;
            $Inicio->MAP_InZona = $request->zona;
            $Inicio->MAP_FechaDenuncia = $fechaDenuncia;
            $Inicio->MAP_IdUsuario = $idusuario;
            $Inicio->MAP_Observacion = $request->observacionDev;
            $Inicio->MAP_IdEstado = 1;

            $Inicio->save();
            
            Helpers::Sweetalert(false, 'warning', '¡LISTO!', 'Se ha Iniciado el Proceso de Develación.');

            return response()->json();
        }
    }

}
