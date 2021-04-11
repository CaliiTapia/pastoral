<?php

namespace App\Http\Controllers;

use App\Certificado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helpers;
use App\Http\Requests;
use App\Institucion;
use App\MapDevelacion;
use App\MapTipoEstado;
use App\Parroquia;
use App\Zona;
use App\Ficha;
use App\FichaUR;
use App\MapLogAP;
use App\Participacion;
class DevelacionController extends Controller
{

    public function __construc()
    {
        $this->middleware('auth');
    }
    public function index(){
        Auth::user()->Pagina='Develaciones';
        $estado=MapTipoEstado::all();
        $zona=Zona::all();
        $institucion=Institucion::all();
        $dev=DB::select(DB::raw("SELECT md.MAP_IdDevelacion,
                                        md.MAP_RutAP, f.IdFicha,
                                        md.MAP_NumeroNotificacion, 
                                        md.MAP_IdProceso, 
                                        md.MAP_InZona, z.Nombre,
                                        md.MAP_INCodigo, i.INNombre,
                                        DATE_FORMAT(md.MAP_FechaDenuncia, '%e-%m-%Y %H:%i') AS fechadenuncia, 
                                        md.MAP_IdEstado, mte.MAP_Descripcion,
                                        md.MAP_FechaDenuncia
                                        FROM MAP_develacion md
                                        INNER JOIN ficha f ON md.MAP_RutAP = f.NumeroDocumento
                                        INNER JOIN zona z ON md.MAP_InZona = z.IdZona
                                        INNER JOIN institucion i ON md.MAP_INCodigo = i.INcodigo
                                        INNER JOIN MAP_tipo_estado mte ON md.MAP_IdEstado = mte.MAP_IdTipoEstado
                                        "));
                                        //WHERE MAP_IdEstado = 1 OR MAP_IdEstado = 2

        $datostabla=DB::select(DB::raw("SELECT md.MAP_IdDevelacion,
                                        md.MAP_RutAP, f.IdFicha,
                                        md.MAP_NumeroNotificacion, 
                                        md.MAP_IdProceso, 
                                        md.MAP_InZona, z.Nombre,
                                        md.MAP_INCodigo, i.INNombre,
                                        (SELECT COUNT(mf.MAP_IdFichaUr) FROM ficha f, MAP_fichaur mf 
                                            WHERE mf.MAP_F_IdFicha = f.IdFicha 
                                            AND f.NumeroDocumento = md.MAP_RutAP AND mf.MAP_Estado = 1) AS cantparroquias, 
                                        DATE_FORMAT(md.MAP_FechaDenuncia, '%e-%m-%Y %H:%i') AS fechadenuncia, 
                                        md.MAP_IdEstado, mte.MAP_Descripcion,
                                        md.MAP_FechaDenuncia
                                        FROM MAP_develacion md
                                        INNER JOIN ficha f ON md.MAP_RutAP = f.NumeroDocumento
                                        INNER JOIN zona z ON md.MAP_InZona = z.IdZona
                                        INNER JOIN institucion i ON md.MAP_INCodigo = i.INcodigo
                                        INNER JOIN MAP_tipo_estado mte ON md.MAP_IdEstado = mte.MAP_IdTipoEstado
                                        -- WHERE MAP_IdEstado = 1 OR MAP_IdEstado = 2
                                        ORDER BY md.MAP_FechaDenuncia desc, MAP_RutAP, MAP_IdProceso desc, md.MAP_IdEstado desc"));
                                       

        return view('modulos.develaciones.index', compact('estado','dev','zona', 'institucion','datostabla'));
    }
    
    public function store(Request $request){
        $NuevoEstado = new MapDevelacion;
        $idusuario=Auth::user()->IdUsuario;
        $NuevoEstado->MAP_RutAP = $request->rut;
        $NuevoEstado->MAP_IdEstado = $request->estado;
        $NuevoEstado->MAP_Observacion = $request->observacion;
        $NuevoEstado->MAP_IdProceso = $request->idproceso;
        $NuevoEstado->MAP_InZona = $request->zona;
        $NuevoEstado->MAP_INCodigo = $request->parroquia;
        $numero_notificacion=$request->nnotificacion;
        $numero_notificacion=$numero_notificacion;
        $NuevoEstado->MAP_NumeroNotificacion = $numero_notificacion;
        $NuevoEstado->MAP_FechaDenuncia = $request->fdenuncia;
        $NuevoEstado->MAP_IdUsuario = $idusuario;
        $NuevoEstado->MAP_idFicha = $request->idficha;
        $NuevoEstado->created_at = date('Y-m-d H:i:s');
        $NuevoEstado->updated_at = date('Y-m-d H:i:s');
        $NuevoEstado->save();
        $idficha_eliminar = $request->idficha;
        if($request->estado == 3)
        {
            $eliminar_ficha = Ficha::find($idficha_eliminar);
            $eliminar_ficha->Estatus = 2;
            $eliminar_ficha->save();

            FichaUR::where('MAP_F_IdFicha', $idficha_eliminar)
            ->where('MAP_Estado', 1)
            ->update(['MAP_Estado' => 0]);

            $bloquearap = Ficha::find($idficha_eliminar);
            $nombrecampo='Direccion';
            $this->insertarlogAP($idficha_eliminar, $nombrecampo,$bloquearap->Direccion);
            $nombrecampo='TelefonoFijo';
            $this->insertarlogAP($idficha_eliminar, $nombrecampo,$bloquearap->TelefonoFijo);
            $nombrecampo='TelefonoMovil';
            $this->insertarlogAP($idficha_eliminar, $nombrecampo,$bloquearap->TelefonoMovil);
            $nombrecampo='Correo';
            $this->insertarlogAP($idficha_eliminar, $nombrecampo,$bloquearap->Correo);
            $nombrecampo='C_IdComuna';
            $this->insertarlogAP($idficha_eliminar, $nombrecampo,$bloquearap->C_IdComuna);
            $nombrecampo='R_IdRegion';
            $this->insertarlogAP($idficha_eliminar, $nombrecampo,$bloquearap->R_IdRegion);

            $nombrecampo='updated_at';
            $this->insertarlogAP($idficha_eliminar, $nombrecampo,$bloquearap->updated_at);
            $nombrecampo='created_at';
            $this->insertarlogAP($idficha_eliminar, $nombrecampo,$bloquearap->created_at);

            $c_fotoap = Certificado::select('*')
            ->where('MAP_TD_IdTipoDocumento', 1)
            ->where('MAP_F_IdFicha', $idficha_eliminar)
            ->first();
            if(strlen($c_fotoap) >= 5 ){
                $nombrecampo='MAP_certificado-MAP_Archivo-MAP_TD_IdTipoDocumento-1';
                $this->insertarlogAP($idficha_eliminar, $nombrecampo,$c_fotoap->MAP_Archivo);

                $cid_fotoapupdate=$c_fotoap->MAP_IdCertificado;
                $eliminar_certificadosnull = Certificado::find($cid_fotoapupdate);
                $eliminar_certificadosnull->delete();

            }
            
            $c_antecedentes = Certificado::select('*')
            ->where('MAP_TD_IdTipoDocumento', 2)
            ->where('MAP_F_IdFicha', $idficha_eliminar)
            ->first();

            if(strlen($c_antecedentes) >= 5 ){
                $nombrecampo='MAP_certificado-MAP_Archivo-MAP_TD_IdTipoDocumento-2';
                $this->insertarlogAP($idficha_eliminar, $nombrecampo,$c_antecedentes->MAP_Archivo);

                $cid_antecedentesupdate=$c_antecedentes->MAP_IdCertificado;
                $eliminar_certificadosnull = Certificado::find($cid_antecedentesupdate);
                $eliminar_certificadosnull->delete();

            }
            
            $c_fichaautorizacion = Certificado::select('*')
            ->where('MAP_TD_IdTipoDocumento', 4)
            ->where('MAP_F_IdFicha', $idficha_eliminar)
            ->first();

            if(strlen($c_fichaautorizacion) >= 5 ){
                $nombrecampo='MAP_certificado-MAP_Archivo-MAP_TD_IdTipoDocumento-4';
                $this->insertarlogAP($idficha_eliminar, $nombrecampo,$c_fichaautorizacion->MAP_Archivo);

                $cid_fichaautorizacionupdate=$c_fichaautorizacion->MAP_IdCertificado;
                $eliminar_certificadosnull = Certificado::find($cid_fichaautorizacionupdate);
                $eliminar_certificadosnull->delete();
            }

            $update_fichanull = Ficha::find($idficha_eliminar);
            $update_fichanull->Direccion = "";
            $update_fichanull->TelefonoFijo = null;
            $update_fichanull->TelefonoMovil = null;
            $update_fichanull->Correo = "";
            $update_fichanull->C_IdComuna = 349;
            $update_fichanull->R_IdRegion = 16;
            $update_fichanull->save();            

            Participacion::where('MAP_F_IdFicha', $idficha_eliminar)   
            ->where('MAP_FechaTermino', null) 
            ->update(['MAP_FechaTermino' => date('Y-m-d')]); 

            Helpers::Sweetalert(false, 'success', '¡EXITO!', 'Se ha bloqueado el Agente Pastoral!.');
        }  
        else{
            Helpers::Sweetalert(false, 'success', '¡EXITO!', 'Se cambió correctamente el estado.');
        }
    }

    private function insertarlogAP($idficha, $nombrecampo, $valorcampo){

            $insert_bloqAP = new MapLogAP();
            $insert_bloqAP->MAP_B_IdFicha               = $idficha;
            $insert_bloqAP->MAP_B_ValorModificado       = $valorcampo;
            $insert_bloqAP->MAP_B_CampoModificado       = $nombrecampo;
            $insert_bloqAP->MAP_B_IdUsuarioModifico   = Auth::user()->IdUsuario;
            $insert_bloqAP->MAP_B_Motivo                = 'Develación';
            $insert_bloqAP->updated_at                  = date('Y-m-d H:i:s');
            $insert_bloqAP->created_at                  = date('Y-m-d H:i:s');
            $insert_bloqAP->save();

    }
    
    public function AjaxGetDev($id){
        return response()->json(MapDevelacion::find($id));
    } 

    public function AjaxHistorial($rut, $idproceso){
        $sql = "SELECT md.MAP_IdDevelacion,
                md.MAP_RutAP, f.IdFicha,
                md.MAP_NumeroNotificacion, 
                md.MAP_IdProceso, 
                md.MAP_InZona, z.Nombre,
                md.MAP_INCodigo, i.INNombre,
                md.MAP_IdUsuario, CONCAT (u.Nombre, ' ',u.Apellidos) AS NombreUsuario, 
                DATE_FORMAT(md.MAP_FechaDenuncia, '%e-%m-%Y') AS fechadenuncia,
                DATE_FORMAT(md.created_at, '%e-%m-%Y %H:%i') AS fechacreated,  
                md.MAP_IdEstado, mte.MAP_Descripcion,
                md.MAP_Observacion
                FROM MAP_develacion md
                INNER JOIN ficha f ON md.MAP_RutAP = f.NumeroDocumento
                INNER JOIN zona z ON md.MAP_InZona = z.IdZona
                INNER JOIN institucion i ON md.MAP_INCodigo = i.INcodigo
                INNER JOIN MAP_tipo_estado mte ON md.MAP_IdEstado = mte.MAP_IdTipoEstado
                INNER JOIN usuario u ON md.MAP_IdUsuario = u.IdUsuario 
                WHERE md.MAP_RutAP= $rut 
                ORDER by md.MAP_IdProceso desc ,md.MAP_IdEstado";
        $historial = DB::select($sql);

        return response(json_encode($historial),200)->header('Content-type', 'text/plain');
    }     
}