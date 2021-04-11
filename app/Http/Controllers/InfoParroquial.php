<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Comuna;
use App\Capilla;
use App\Acceso;
use App\InstitDireccion;
use App\InstitEstado;
use App\InstitFechas;
use App\InstitObser; 
use App\Institucion;
use App\InstitTerri;
use App\MapRedesSociales;
use App\MapHorario;
use App\MapTipoDia;
use App\Persona;
use App\PersonaCargo;
use App\Contacto;
use App\User;
use App\Region;
use App\Ciudad;
use App\Helpers\Helpers;


class InfoParroquial extends Controller
{
    //
    public function __construc()
    {
        $this->middleware('auth');
    }

    public function store(Request $request){
        $NuevoHoraio = new MapHorario;
        $NuevoHoraio->MAP_HINCodigo = $request->institu;
        $NuevoHoraio->MAP_IdTipoDia = $request->diaAgre;
        $NuevoHoraio->MAP_Hora = $request->horaAgre;
        $NuevoHoraio->MAP_Observacion = $request->descripcionAgre;
        $NuevoHoraio->save();
    }

    public function edit($id){
        $acceso = Helpers::insti_seleccionada(Auth::user());
        $institu = $acceso['IdInstitucion'];
        $dia = MapTipoDia::all();
        $institDirecciones= InstitDireccion::all();
        $institEstado= InstitEstado::all();
        $institFechas= InstitFechas::all();
        $institObser= InstitObser::all();
        $comuna= Comuna::all(); 
        $redes = MapRedesSociales::all();
        $institucion = Institucion::find($institu);
        

        $comuna = DB::table('institucion as i')
                            ->join('comuna as co','co.IdComuna','i.INCOCodigo')
                            ->where('i.INCodigo', $institu)
                            ->first();
                                
        $decanato = DB::select(DB::raw("SELECT ii.IDINCodigo, i.INCodigo, i.INTICodigo, i.INNombre, INNombre2 
                                        from instit_depen ii
                                        Inner JOIN institucion i ON  ii.IDInstSup = i.INCodigo
                                        where ii.IDINCodigo = $institu
                                        and INTICodigo = 006"));

        $parroco = DB::select(DB::raw("SELECT i.INCodigo, i.INNombre, p.PECodigo, p.PENombre, p.PEApellidos, pc.PCPECodigo, pc.PCCACodigo, pc.PCDEPeriodo, pc.pcstatus, pcd.CADescrip
                                        FROM institucion i
                                        INNER JOIN personas_cargo pc ON pc.PCINCodigo =  i.INCodigo
                                        INNER JOIN personas p ON p.PECodigo = pc.PCPECodigo
                                        INNER JOIN personas_cargo_desc pcd ON pcd.CACodigo = pc.PCCACodigo
                                        WHERE i.INCodigo = $institu 
                                        AND  pc.PCCACodigo = 006
                                        AND pc.PCStatus = 'A'"));
                            
        $diacono =  DB::select(DB::raw("SELECT i.INCodigo, i.INNombre, p.PECodigo, p.PENombre, p.PEApellidos, pc.PCPECodigo, pc.PCCACodigo, pc.PCDEPeriodo, pc.pcstatus, pcd.CADescrip
                                        FROM institucion i
                                        INNER JOIN personas_cargo pc ON pc.PCINCodigo =  i.INCodigo
                                        INNER JOIN personas p ON p.PECodigo = pc.PCPECodigo
                                        INNER JOIN personas_cargo_desc pcd ON pcd.CACodigo = pc.PCCACodigo
                                        WHERE i.INCodigo = $institu  
                                        AND pc.PCCACodigo = 062
                                        AND pc.PCStatus = 'A'"));
                            
        $zona= DB::select(DB::raw("SELECT i.INNombre, i.INZona, Nombre
                                    FROM institucion i
                                    INNER JOIN zona z ON z.IdZona = i.INZona
                                    WHERE i.INCodigo = $institu "));

        $dep_parroquia = DB::table('instit_depen')
                                ->select('IDInstSup')
                                ->where('IDINCodigo', $institu)
                                ->where('IDTipDep', 001)
                                ->first();

        $diocesis = DB::select(DB::raw("SELECT i.INCodigo, i.INNombre 
                                        from instit_depen ii
                                        Inner JOIN institucion i ON  ii.IDInstSup = i.INCodigo
                                        WHERE ii.IDINCodigo = $dep_parroquia->IDInstSup
                                        AND ii.IDTipDep = 001 "));  

     // PESTAÑA HORARIOS
        $institObser= InstitObser::where('IBINCodigo', $institu )->select('IBObserv')->get();
        $web= Institucion::where('INCodigo', $institu )->select('INWeb')->first();

        $infoCapilla = DB::table('instit_depen as id')
                                ->join('institucion as i','i.INCodigo','id.IDINCodigo')
                                ->where('id.idinstsup', $institu )
                                ->get();


        $latLng = DB::select(DB::raw("SELECT instit_terri.ITLatitud,instit_terri.ITLongitud,instit_terri.ITFotoInstit
                                      FROM instit_terri  
                                      INNER JOIN institucion 
                                      WHERE instit_terri.ITINCodigo= $institu limit 1"));
                                        
        $urlImagen="/img/fotoParroquia/".$latLng[0]->ITFotoInstit;

        $fb = DB::select(DB::raw("SELECT MAP_red_social.MAP_Link_Social 
                                  FROM MAP_red_social
                                  INNER JOIN institucion 
                                  WHERE MAP_red_social.INCodigo = $institu
                                  AND MAP_red_social.MAP_IdTipoRedSocial = 1"));

        $ig = DB::select(DB::raw("SELECT MAP_red_social.MAP_Link_Social 
                                  FROM MAP_red_social
                                  INNER JOIN institucion 
                                  WHERE MAP_red_social.INCodigo = $institu
                                  AND MAP_red_social.MAP_IdTipoRedSocial = 2"));

        $twitter = DB::select(DB::raw("SELECT MAP_red_social.MAP_Link_Social 
                                       FROM MAP_red_social
                                       INNER JOIN institucion 
                                       WHERE MAP_red_social.INCodigo = $institu
                                       AND MAP_red_social.MAP_IdTipoRedSocial = 3"));

        $youtube = DB::select(DB::raw("SELECT MAP_red_social.MAP_Link_Social 
                                       FROM MAP_red_social
                                       INNER JOIN institucion 
                                       WHERE MAP_red_social.INCodigo = $institu
                                       AND MAP_red_social.MAP_IdTipoRedSocial = 4"));  

        $lunes = DB::select(DB::raw("SELECT MAP_IdHorario, MAP_IdTipoDia, MAP_Hora, MAP_Observacion 
                                       FROM MAP_horario
                                       WHERE MAP_HINCodigo = $institu 
                                       AND MAP_IdTipoDia = 1")); 
        $martes = DB::select(DB::raw("SELECT MAP_IdHorario, MAP_IdTipoDia, MAP_Hora, MAP_Observacion 
                                        FROM MAP_horario
                                        WHERE MAP_HINCodigo = $institu 
                                        AND MAP_IdTipoDia = 2")); 
        $miercoles = DB::select(DB::raw("SELECT MAP_IdHorario, MAP_IdTipoDia, MAP_Hora, MAP_Observacion 
                                        FROM MAP_horario
                                        WHERE MAP_HINCodigo = $institu 
                                        AND MAP_IdTipoDia = 3")); 
        $jueves = DB::select(DB::raw("SELECT MAP_IdHorario, MAP_IdTipoDia, MAP_Hora, MAP_Observacion 
                                        FROM MAP_horario
                                        WHERE MAP_HINCodigo = $institu 
                                        AND MAP_IdTipoDia = 4")); 
        $viernes = DB::select(DB::raw("SELECT MAP_IdHorario, MAP_IdTipoDia, MAP_Hora, MAP_Observacion 
                                        FROM MAP_horario
                                        WHERE MAP_HINCodigo = $institu 
                                        AND MAP_IdTipoDia = 5")); 
        $sabado = DB::select(DB::raw("SELECT MAP_IdHorario, MAP_IdTipoDia, MAP_Hora, MAP_Observacion 
                                        FROM MAP_horario
                                        WHERE MAP_HINCodigo = $institu 
                                        AND MAP_IdTipoDia = 6")); 
        $domingo = DB::select(DB::raw("SELECT MAP_IdHorario, MAP_IdTipoDia, MAP_Hora, MAP_Observacion 
                                        FROM MAP_horario
                                        WHERE MAP_HINCodigo = $institu 
                                        AND MAP_IdTipoDia = 7"));   
        $mi = DB::select(DB::raw("SELECT MAP_IdHorario, MAP_IdTipoDia, MAP_Hora, MAP_Observacion 
                                            FROM MAP_horario
                                            WHERE MAP_HINCodigo = $institu"));  

                                            
        $markers = DB::select(DB::raw("SELECT ITLatitud, ITLongitud FROM instit_terri WHERE ITINCodigo = $id"));                            
    //  dd($markers);
        return view('modulos.mantenedores.info_parroquial.index', compact('institu','acceso','institucion','institDirecciones','institEstado','institFechas',
        'institObser','web','infoCapilla','comuna','decanato','parroco','diacono','zona','diocesis','latLng',
        'fb','ig','twitter','youtube','urlImagen','dia','lunes','martes','miercoles','jueves','viernes','sabado','domingo','mi','markers'));
    }

    public function update(Request $request, $id){
        $Parroquia = Institucion::where('INCodigo',$id)->first();
        if($request->alias){ $Parroquia->INNombre2 = $request->alias == '' ? 'Sin Información' : $request->alias; }
        if($request->telefono){ $Parroquia->INTelefono = $request->telefono == ''  ? 'Sin Información' : $request->telefono; }
        if($request->email){ $Parroquia->INEmail = $request->email == ''  ? 'Sin Información' : $request->email; }
        if($request->pagina){ $Parroquia->INWeb = $request->pagina == ''  ? 'Sin Información' : $request->pagina; }
        $Parroquia->save();

        $Img =  InstitTerri::where('ITINCodigo',$id)->first();            
        if ($request->file('imgInPa')!=null) {

            $archivo  = $request->file('imgInPa')  ;
            $foto = date('Y-m-d_His').$archivo->getClientOriginalName();

            $extensions = ['jpg' , 'jpeg', 'png'];
            $extension = $request->file('imgInPa')->getClientOriginalExtension();
    
            // Validar extension del archivo
            if ( in_array($extension , $extensions) ){
                \Storage::disk('fotoParroquia')->put($foto,  \File::get($archivo));
                $Img->ITFotoInstit = $foto;
            }else{
                return view('errors.500');
            }
        }
        $Img->save();

        $Fb = MapRedesSociales::where('INCodigo',$id)->where('MAP_IdTipoRedSocial',1)->first();
        if($request->fb){ $Fb->MAP_Link_Social = $request->fb == null  ? 'Sin Información' : $request->fb ; }
        $Fb->save();

        $Ig = MapRedesSociales::where('INCodigo',$id)->where('MAP_IdTipoRedSocial',2)->first();
        if($request->ig){ $Ig->MAP_Link_Social = $request->ig == ''  ? 'Sin Información' : $request->ig; }
        $Ig->save();

        $Twitter = MapRedesSociales::where('INCodigo',$id)->where('MAP_IdTipoRedSocial',3)->first();
        if($request->twitter){ $Twitter->MAP_Link_Social = $request->twitter == ''  ? 'Sin Información' : $request->twitter; }
        $Twitter->save();

        $Youtube = MapRedesSociales::where('INCodigo',$id)->where('MAP_IdTipoRedSocial',4)->first();
        if($request->youtube){ $Youtube->MAP_Link_Social = $request->youtube == ''  ? 'Sin Información' : $request->youtube; }
        $Youtube->save();

        return back();
    }

    public function AjaxCoordenadasPA(Request $request, $id){
        $Terri =  InstitTerri::where('ITINCodigo',$id)->first();
        $Terri->ITLatitud = $request->latlng1 ? $request->latlng1 : $Terri->ITLatitud;
        $Terri->ITLongitud = $request->latlng2 ? $request->latlng2 : $Terri->ITLatitud;

        $Terri->save(); 
    }
    public function AjaxActualizar(Request $request, $id){
        $ActualizarHoraio = MapHorario::find($id);

        $ActualizarHoraio->MAP_IdTipoDia = $request->dia;
        $ActualizarHoraio->MAP_Hora = $request->hora;
        $ActualizarHoraio->MAP_Observacion = $request->descripcion;

        $ActualizarHoraio->save();
    }
    public function AjaxEliminarH($id){
        $h=DB::select(DB::raw("DELETE FROM MAP_horario WHERE MAP_IdHorario = $id"));
    }
    public function AjaxGetHorario($id){
        return response()->json(MapHorario::find($id));
    } 
}