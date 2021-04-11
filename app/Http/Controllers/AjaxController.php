<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Zona;
use App\Cargo;
use App\ParticipacionParroquial;
use App\Referencia;
use Auth;
use App\Acceso;
use App\Area;
use App\Ciudad;
use App\AreaCargo;
use App\AreaNegocio;
use App\CentroCostos;
use App\Periodo;
use App\TipoDocumento;
use App\UnidadRecaudadora;
use App\Ficha;
use App\PlanDeCuentas;
use App\Comuna;
use App\Auxiliar;
use App\Region;
use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Collection;
use Cookie;
use App\Institucion;
use App\InstitucionDepen;

class AjaxController extends Controller
{
    
    public function ListarTodo($IdFicha){
        $ur_accesos = Acceso::where('EnUso', 'true')->where('U_IdUsuario', Auth::user()->IdUsuario)->pluck('I_INCodigo');
        if($ur_accesos->isEmpty()){
            $response = ['status'=>'ERROR','route'=>route('urSeleccionar')];
            //se crea la cookie para saber su pagina de origen
            $rutaOrigen = asset('/pastoral/listado/'.$IdFicha.'/edit');
            $minutes = 1;
            Cookie::queue('BackPage', $rutaOrigen, $minutes);
            return response()->json($response);
        }
        $collection = new Collection();
        $capillas = new Collection();

        //Listar Participacion
        if(Auth::user()->hasRole('Parroco')){
            $participacion = ParticipacionParroquial::with([
                'capilla',
                'area' => function($q){ $q->select('MAP_Descripcion','MAP_IdArea'); }, 
                'cargo' => function($q){ $q->select('MAP_Descripcion','MAP_IdCargo'); }, 
                'zona' => function($q){ $q->select('Nombre', 'IdZona'); }, 
                'institucion' => function($q) { $q->select('INCodigo', 'INNombre', 'INZona'); },
                'referencias' => function($q) { $q->where('MAP_Estatus', 1); }
                ])
                ->where('MAP_Estatus', 1)
                ->where('MAP_F_IdFicha', $IdFicha)
                ->orderBy('MAP_FechaInicio','desc')
                ->get();
        }else{
            $participacion = ParticipacionParroquial::with([
                'capilla',
                'area' => function($q){ $q->select('MAP_Descripcion','MAP_IdArea'); }, 
                'cargo' => function($q){ $q->select('MAP_Descripcion','MAP_IdCargo'); }, 
                'zona' => function($q){ $q->select('Nombre', 'IdZona'); }, 
                'institucion' => function($q) { $q->select('INCodigo', 'INNombre', 'INZona'); }
            ])
                ->where('MAP_Estatus', 1)
                ->where('MAP_F_IdFicha', $IdFicha)
                ->orderBy('MAP_FechaInicio','desc')
                ->get();
        }
        //guarda Participacion
        $collection->push($participacion);
        //Lista de zonas
        // $zona = Institucion::with('zona')->where('INCodigo', $ur_accesos)->select('INCodigo')->get();
        $zona = Institucion::select('IdZona','Codigo','Nombre')
                ->join('zona','zona.IdZona','institucion.INZona')
                ->where('INCodigo',$ur_accesos)
            ->get();
        
        $collection->push($zona);

        //Lista areas
        $areas = Area::with(['cargos'=> function($q){$q->orderBy('MAP_Descripcion');}])->orderBy('MAP_Descripcion')->get();
        $collection->push($areas);

        //Lista Consulta parroquia 
        $parroquia = Institucion::whereIn('INCodigo', $ur_accesos)->select('INNombre', 'INCodDiocesano', 'INCodigo')->parroquia()->get();
        $collection->push($parroquia);
        //lista las capillas dependientes
        $parrDepen = InstitucionDepen::with(['info'=> function($q){$q->capilla()->orderBy('INNombre');}])->where('IDInstSup',$ur_accesos)->get();
        //se obtiene el nombre de las capillas
        foreach($parrDepen as $dependencia){
            $capillas->push($dependencia->info);
        }
        //guarda las capillas
        $collection->push($capillas);
        return response()->json($collection);
    }

    public function ListarZonas(){
        $ur_accesos = Acceso::where('U_IdUsuario', Auth::user()->IdUsuario)->where('M_IdModulos', 2)->pluck('UR_IdUnidadRecaudadora');
        $id_zonas = UnidadRecaudadora::whereIn('IdUnidadRecaudadora', $ur_accesos)->select('Z_IdZona')->get();
        $zonas = Zona::whereIn('IdZona', $id_zonas)->get();
        return response()->json($zonas);
    }

    public function ListarAreas(){
        $areas = Area::with(['cargos'=> function($q){$q->orderBy('MAP_Descripcion');}])->orderBy('MAP_Descripcion')->get();
        // $areas = Area::with('cargos')->orderBy('MAP_Descripcion')->get();
        // dd($areas);
        return response()->json($areas);
    }

    public function ListarUR(){
        $ur_accesos = Acceso::where('U_IdUsuario', Auth::user()->IdUsuario)->where('M_IdModulos', 2)->pluck('UR_IdUnidadRecaudadora');
        $urs = UnidadRecaudadora::whereIn('IdUnidadRecaudadora', $ur_accesos)->select('Nombre', 'Codigo', 'IdUnidadRecaudadora', 'Z_IdZona')->get();
        return response()->json($urs);
    }

    public function ListarParticipacionesFicha($IdFicha){
        // $ur_accesos = Acceso::where('EnUso', 'true')->where('U_IdUsuario', Auth::user()->IdUsuario)->pluck('UR_IdUnidadRecaudadora');
        $ur_accesos = Acceso::where('EnUso', 'true')->where('U_IdUsuario', Auth::user()->IdUsuario)->pluck('I_INCodigo');
        if($ur_accesos->isEmpty()){
            $response = ['status'=>'ERROR','route'=>route('urSeleccionar')];
            //se crea la cookie para saber su pagina de origen
            $rutaOrigen = asset('/pastoral/listado/'.$IdFicha.'/edit');
            $minutes = 1;
            Cookie::queue('BackPage', $rutaOrigen, $minutes);
            return response()->json($response);
        }
        if(Auth::user()->hasRole('Parroco')){
            $participacion = ParticipacionParroquial::with([
                'capilla',
                'area' => function($q){ $q->select('MAP_Descripcion','MAP_IdArea'); }, 
                'cargo' => function($q){ $q->select('MAP_Descripcion','MAP_IdCargo'); }, 
                'zona' => function($q){ $q->select('Nombre', 'IdZona'); }, 
                'institucion' => function($q) { $q->select('INCodigo', 'INNombre', 'INZona'); },
                'referencias' => function($q) { $q->where('MAP_Estatus', 1); }
                ])
                ->where('MAP_Estatus', 1)
                ->where('MAP_F_IdFicha', $IdFicha)
                ->orderBy('MAP_FechaInicio','desc')
                ->get();
                //  dd($participacion,$ur_accesos);
        }else{
            $participacion = ParticipacionParroquial::with([
                'capilla',
                'area' => function($q){ $q->select('MAP_Descripcion','MAP_IdArea'); }, 
                'cargo' => function($q){ $q->select('MAP_Descripcion','MAP_IdCargo'); }, 
                'zona' => function($q){ $q->select('Nombre', 'IdZona'); }, 
                'institucion' => function($q) { $q->select('INCodigo', 'INNombre', 'INZona'); }
            ])
                ->where('MAP_Estatus', 1)
                ->where('MAP_F_IdFicha', $IdFicha)
                ->orderBy('MAP_FechaInicio','desc')
                ->get();
        }
        return response()->json($participacion);
    }
    public function getComunas(Request $request)
    {
        // $comunas = Region::with('comunas')->find($request->idregion);
        $comunas = Region::with(['comunas'=> function($q){
            $q->orderBy('Nombre');
        }])->find($request->idregion);
        // dd($comunas->comunas());
        return response()->json($comunas);
    }

    public function getComunasCiudad(Request $request)
    {
        $comunas = Comuna::select('IdComuna','Nombre')
        ->where('C_IdCiudad',$request->C_IdCiudad)
        ->get();
        return response()->json($comunas);
    }

    public function existenciaAP(Request $request){
        if(strlen($request->rut) == 8){
            $cuerpo = substr($request->rut,0,7);
        }else{
            $cuerpo = substr($request->rut,0,8);
        }
        $dv = substr($request->rut,-1);
        $agente = Ficha::where('NumeroDocumento',$cuerpo)->where('Dv',$dv)->first();
        
        if($agente == null){
            $tmp = 0;
        }else{
            $tmp = $agente->IdFicha;
        }
        return response()->json($tmp);
    }

    //Validador de auxiliar rut en formulario
    public function getRutExiste(Request $request){
        $rutA = Auxiliar::select('rutAux')
        ->where('rutAux',$request->rut)
        ->get();

        return response()->json($rutA);
    }

    //area negocio deshabilitar habilitar
    public function getDesactivarAN($id){
        try{
            $aNegocio = AreaNegocio::find($id);
            $aNegocio->areaStatus = 'I';
            $aNegocio->save();
            $response = 'ok';
        }catch(\Exception $e){
            $response = $e;
        }
        return response()->json($response);
    }

    public function getActivarAN($id){
        try{
            $aNegocio = AreaNegocio::find($id);
            $aNegocio->areaStatus = 'A';
            $aNegocio->save();
            $response = 'ok';
        }catch(\Exception $e){
            $response = $e;
        }
        return response()->json($response);
    }

    //auxiliar deshabiliar habilitar
    public function getDesactivarAU($id){
        try{
            Auxiliar::where('codAux','=',$id)
            ->update(['statusAux' => 'I']);

            $response = 'ok';
        }catch(\Exception $e){
            $response = $e;
        }
        return response()->json($response);
    }

    public function getActivarAU($id){
        try{
            Auxiliar::where('codAux','=',$id)
            ->update(['statusAux' => 'A']);
            
            $response = 'ok';
        }catch(\Exception $e){
            $response = $e;
        }
        return response()->json($response);
    }
    
    //centro costo deshabiliar habilitar
    public function getDesactivarCC($id){
        try{
            $cc = CentroCostos::find($id);
            $cc->estatus = 'I';
            $cc->save();
            $response = 'ok';
        }catch(\Exception $e){
            $response = $e;
        }
        return response()->json($response);
    }

    public function getActivarCC($id){
        try{
            $cc = CentroCostos::find($id);
            $cc->estatus = 'A';
            $cc->save();
            $response = 'ok';
        }catch(\Exception $e){
            $response = $e;
        }
        return response()->json($response);
    }

    //PERIODO deshabiliar habilitar
    public function getDesactivarPE($id){
        try{
            $pe = Periodo::find($id);
            $pe->anoStatus = 'I';
            $pe->save();
            $response = 'ok';
        }catch(\Exception $e){
            $response = $e;
        }
        return response()->json($response);
    }

    public function getActivarPE($id){
        $institucion = Helpers::codigo_inst_seleccionada();
        
        try{
            $pe = Periodo::find($id);
            $pe->anoStatus = 'A';
            $pe->save();

            Periodo::where('idPeriod','!=',$id)
            ->where('INCOdigo', $institucion)
            ->update(['anoStatus' => 'I']);

            $response = 'ok';
        }catch(\Exception $e){
            $response = $e;
        }
        return response()->json($response);
    }

   //tipo documento deshabiliar habilitar
   public function getDesactivarTD($id){
    try{
        TipoDocumento::where('TipDoc','=',$id)
        ->update(['TipDocStatus' => 'I']);
       
        $response = 'ok';
    }catch(\Exception $e){
        $response = $e;
    }
    return response()->json($response);
    }

    public function getActivarTD($id){
        try{
            TipoDocumento::where('TipDoc','=',$id)
        ->update(['TipDocStatus' => 'A']);
            $response = 'ok';
        }catch(\Exception $e){
            $response = $e;
        }
        return response()->json($response);
    }

    //Validador de plan de cuentas en formulario
    public function getPlanCuentasExiste(Request $request){
        $cod = PlanDeCuentas::select('pctCod')
        ->where('pctCod',$request->cod)
        ->get();
    
        return response()->json($cod);
        
    }

}
