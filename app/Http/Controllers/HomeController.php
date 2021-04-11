<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Auth;
use App\Acceso;
use Illuminate\Support\Facades\DB;
use App\Ficha;
use App\ParticipacionParroquial;
use Cookie;
use App\Institucion;
use App\Comuna;
use App\Capilla;
use App\MapMisas;
use App\MapTipoMisa;
use App\InstitDireccion;
use App\InstitEstado;
use App\InstitFechas;
use App\InstitObser; 
use App\Persona;
use App\PersonaCargo;
use App\Contacto;
use App\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Auth::user()->hasPermissionTo('ap_home')){
            Auth::user()->Pagina='Inicio';
            $misas = MapTipoMisa::all();
            $acceso = Helpers::insti_seleccionada(Auth::user());
            $institu = $acceso['IdInstitucion'];
            $ur_acceso = Helpers::ur_seleccionada(Auth::user());
            $urAsignadas = Helpers::ur_asignadas(Auth::user());
            
            $fichas = DB::table('ficha as f')
                        ->join('MAP_fichaur as fur','fur.MAP_F_IdFicha','f.IdFicha')
                        ->where('fur.MAP_I_INCodigo', $ur_acceso['IdInstitucion'])
                        ->get();

            $institucion= Institucion::where('INCodigo', $institu)->select('INNombre','INEmail','INFecCrea','INTelefono')->get();
            $parroco = DB::select(DB::raw("SELECT i.INCodigo, i.INNombre, p.PECodigo, p.PENombre, p.PEApellidos, pc.PCPECodigo, pc.PCCACodigo, pc.PCDEPeriodo, pc.pcstatus, pcd.CADescrip
                                            FROM institucion i
                                            INNER JOIN personas_cargo pc ON pc.PCINCodigo =  i.INCodigo
                                            INNER JOIN personas p ON p.PECodigo = pc.PCPECodigo
                                            INNER JOIN personas_cargo_desc pcd ON pcd.CACodigo = pc.PCCACodigo
                                            WHERE i.INCodigo = $institu 
                                            AND  pc.PCCACodigo = 006
                                            AND pc.PCStatus = 'A'"));
            $institObser= InstitObser::where('IBINCodigo', $institu)->select('IBObserv')->get();

            //CAPILLAS
            $infoCapilla = DB::table('instit_depen as id')
                            ->join('institucion as i','i.INCodigo','id.IDINCodigo')
                            ->where('id.idinstsup', $institu)
                            ->get();

            $latLng = DB::select(DB::raw("SELECT instit_terri.ITLatitud,instit_terri.ITLongitud,instit_terri.ITFotoInstit
                                        FROM instit_terri  
                                        INNER JOIN institucion 
                                        where instit_terri.ITINCodigo= $institu limit 1"));
                            
            $urlImagen="/img/fotoParroquia/".$latLng[0]->ITFotoInstit;

            return view('home', compact('fichas', 'urAsignadas', 'ur_acceso', 'institucion','parroco','institObser', 'infoCapilla','institu','latLng','urlImagen','misas'));
        }else if (Auth::user()->hasPermissionTo('dev_delegacion')){
            return view('homeDelegacion');
        }
    }

    public function store(Request $request){
        $datosEvento=request()->except(['_token','_method']);
        MapMisas::insert($datosEvento);
        print_r($datosEvento);
    }

    public function AjaxDatos(){
        $acceso = Helpers::insti_seleccionada(Auth::user());
        $institu = $acceso['IdInstitucion'];
        $institucion = Institucion::find($institu);
        
        $fecha['misas']=DB::select(DB::raw("SELECT MAP_IdMisa,
                                            MAP_IdTipoMisa,
                                            MAP_Fecha_Hora_Inicio as start,
                                            MAP_Fecha_Termino as end,
                                            MAP_Modalidad as title
                                            FROM MAP_misas
                                            where INCodigo = $institucion->INCodigo"));
        return response()->json($fecha['misas']);
    }

    public function AjaxEliminar($id){
        $eventos=DB::select(DB::raw("DELETE FROM MAP_misas WHERE MAP_IdMisa = $id"));
    }

    public function listar_ur_asignadas(){
        $urAsignadas = Helpers::ur_asignadas(Auth::user());
        return view('auth.seleccionar_ur', compact('urAsignadas'));
    }

    public function seleccionarUR(Request $request){
            $idUsr = Auth::user()->IdUsuario;
            $ac = Acceso::where('U_idUsuario',$idUsr)->where('I_INCodigo',$request->insti)->first();
            
            if(! empty($ac)){    
                Acceso::where('U_idUsuario',$idUsr)->where('I_INCodigo',$request->insti)->update(['EnUso' => 'true']);
            }
            if(Cookie::get('BackPage') !== null ){
                //dd(Cookie::get('BackPage'));
                return redirect(Cookie::get('BackPage'));
            }
            
            return redirect()->route('home');
    }

    public function indexDevelacion(){
        Auth::user()->Pagina='Develacion';
        return view('modulos.develacion.index');
    }

    public function descargarActaReceocionRelato(){
        return redirect(asset('storage/develacion/acta recepción del relato.docx'));
    }

    public function descargarComunicacionAfectado(){
        return redirect(asset('storage/develacion/Comunicacion al afectado.docx'));
    }

    public function descargarComunicacionInvolucrado(){
        return redirect(asset('storage/develacion/Comunicación al Involucrado.docx'));
    }
    
}
