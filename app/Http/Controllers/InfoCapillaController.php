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
use App\MapHorario;
use App\MapTipoDia;
use App\Persona;
use App\PersonaCargo;
use App\Contacto;
use App\User;
use App\Region;
use App\Ciudad;
use App\Helpers\Helpers;


class InfoCapillaController extends Controller
{
    //
    public function __construc()
    {
        $this->middleware('auth');
    }
    public function store(Request $request){
        $NuevoHoraioCApi = new MapHorario;
        $NuevoHoraioCApi->MAP_HINCodigo = $request->institu;
        $NuevoHoraioCApi->MAP_IdTipoDia = $request->diaC;
        $NuevoHoraioCApi->MAP_Hora = $request->horaC;
        $NuevoHoraioCApi->MAP_Observacion = $request->descripcionC;
        $NuevoHoraioCApi->save();
    }

    public function show($id){
        $acceso = Helpers::insti_seleccionada(Auth::user());
        $institu = $acceso['IdInstitucion'];
        $editCapilla = Institucion::find($id);
        
        $fecha['misas']=DB::select(DB::raw("SELECT MAP_IdMisa,
                                            MAP_IdTipoMisa,
                                            MAP_Fecha_Hora_Inicio as start,
                                            MAP_Fecha_Termino as end,
                                            MAP_Modalidad as title
                                            FROM MAP_misas
                                            where INCodigo = $id"));
        return response()->json($fecha['misas']);
    }
    
    public function edit($id)
    {
        $dia = MapTipoDia::all();
        $acceso = Helpers::insti_seleccionada(Auth::user());
        $institu = $acceso['IdInstitucion'];
        $editCapilla = Institucion::find($id);

            // Comuna
        $comuna = DB::table('institucion as i')
                    ->join('comuna as co','co.IdComuna','i.INCOCodigo')
                    ->where('i.INCodigo', $id )
                    ->first();
        
        $horarios = DB::select(DB::raw("SELECT MAP_misas.MAP_IdTipoMisa 
                                        FROM MAP_misas
                                        INNER JOIN institucion 
                                        where MAP_misas.INCodigo = $id"));
                                    
        $latLngC = DB::select(DB::raw("SELECT instit_terri.ITLatitud,instit_terri.ITLongitud,instit_terri.ITFotoInstit
                                        FROM instit_terri  
                                        INNER JOIN institucion 
                                        where instit_terri.ITINCodigo= $id limit 1"));
        //  dd($latLngC);
        $urlImagenCa="/img/fotoCapilla/".$latLngC[0]->ITFotoInstit;
    //   dd($urlImagenCa);
        $lunes = DB::select(DB::raw("SELECT MAP_IdHorario, MAP_IdTipoDia, MAP_Hora, MAP_Observacion 
                                    FROM MAP_horario
                                    WHERE MAP_HINCodigo = $id 
                                    AND MAP_IdTipoDia = 1")); 
        $martes = DB::select(DB::raw("SELECT MAP_IdHorario, MAP_IdTipoDia, MAP_Hora, MAP_Observacion 
                                    FROM MAP_horario
                                    WHERE MAP_HINCodigo = $id 
                                    AND MAP_IdTipoDia = 2")); 
        $miercoles = DB::select(DB::raw("SELECT MAP_IdHorario, MAP_IdTipoDia, MAP_Hora, MAP_Observacion 
                                        FROM MAP_horario
                                        WHERE MAP_HINCodigo = $id 
                                        AND MAP_IdTipoDia = 3")); 
        $jueves = DB::select(DB::raw("SELECT MAP_IdHorario, MAP_IdTipoDia, MAP_Hora, MAP_Observacion 
                                        FROM MAP_horario
                                        WHERE MAP_HINCodigo = $id 
                                        AND MAP_IdTipoDia = 4")); 
        $viernes = DB::select(DB::raw("SELECT MAP_IdHorario, MAP_IdTipoDia, MAP_Hora, MAP_Observacion 
                                        FROM MAP_horario
                                        WHERE MAP_HINCodigo = $id 
                                        AND MAP_IdTipoDia = 5")); 
        $sabado = DB::select(DB::raw("SELECT MAP_IdHorario, MAP_IdTipoDia, MAP_Hora, MAP_Observacion 
                                        FROM MAP_horario
                                        WHERE MAP_HINCodigo = $id 
                                        AND MAP_IdTipoDia = 6")); 
        $domingo = DB::select(DB::raw("SELECT MAP_IdHorario, MAP_IdTipoDia, MAP_Hora, MAP_Observacion 
                                        FROM MAP_horario
                                        WHERE MAP_HINCodigo = $id 
                                        AND MAP_IdTipoDia = 7"));

        $markers = DB::select(DB::raw("SELECT ITLatitud, ITLongitud FROM instit_terri WHERE ITINCodigo = $id"));                            
                                        
        // dd($markers);
        return view('modulos.mantenedores.include.formCapillas', compact('editCapilla','comuna', 'institu','latLngC','urlImagenCa','id',
        'dia','lunes','martes','miercoles','jueves','viernes','sabado','domingo','markers'));
    }

    public function update(Request $request, $id)
    {
        $Capilla=Institucion::where('INCodigo',$id);
        $Capilla->update([
            'INNombre2'=>$request->get('aliasCap'),
            'INEmail'=>$request->get('correoCap'),
            'INTelefono'=>$request->get('telefonoCap')
        ]);

        $img =  InstitTerri::where('ITINCodigo',$id)->first();
        
        if ($request->file('imgInCa')!=null) {
            $archivo  = $request->file('imgInCa');
            $foto = date('Y-m-d_His').$archivo->getClientOriginalName();

            $extensions = ['jpg' , 'jpeg', 'png'];
            $extension = $request->file('imgInCa')->getClientOriginalExtension();

            // Validar extension del archivo
            if ( in_array($extension , $extensions) ){
                \Storage::disk('fotoCapilla')->put($foto,  \File::get($archivo));
                $img->ITFotoInstit = $foto;
            }else{
                return view('errors.500');
            }
        }
        $img->save();
        
        return back();
    }
    
    public function AjaxCoordenadas(Request $request, $id){
        $TerriC =  InstitTerri::where('ITINCodigo',$id)->first();
        $TerriC->ITLatitud = $request->latlng3 ? $request->latlng3 : $TerriC->ITLatitud;
        $TerriC->ITLongitud = $request->latlng4 ? $request->latlng4 : $TerriC->ITLatitud;

        $TerriC->save();
    }

    public function AjaxActualizarc(Request $request, $id){
        $ActualizarHoraio = MapHorario::find($id);

        $ActualizarHoraio->MAP_IdTipoDia = $request->dia;
        $ActualizarHoraio->MAP_Hora = $request->hora;
        $ActualizarHoraio->MAP_Observacion = $request->descripcion;

        $ActualizarHoraio->save();
    }
    public function AjaxEliminar($id){
        $h=DB::select(DB::raw("DELETE FROM MAP_horario WHERE MAP_IdHorario = $id"));
    }
    public function AjaxGetHorario($id){
        return response()->json(MapHorario::find($id));
    } 
}
