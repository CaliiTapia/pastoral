<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Certificado;
use App\MapLogAP;
use DB;
use Auth;


class FileController extends Controller
{
    public function saveDocsAP($request,$idagente){
        try{            
            $ruta = '/app/public/Archivos/AgentesPastorales/Fichas/'.$idagente.'/';  // RUTA HACIA STORAGE APP PUBLIC PARA PODER ACCEDER A LA CARPETA DE LOS ARCHIVOS.
            $ruta_bd = '/Archivos/AgentesPastorales/Fichas/'.$idagente.'/';
            if(isset($idagente)){
                if($request->hasFile('fotoPerfil')){
                    $nombreFP = $request->fotoPerfil->getClientOriginalName();
                    $request->fotoPerfil->move(storage_path().$ruta,$nombreFP);
                    $FP = new Certificado;
                    $FP->MAP_Archivo = $ruta_bd.$nombreFP;
                    $FP->MAP_TD_IdTipoDocumento = 1;
                    $FP->MAP_F_IdFicha = $idagente;
                    $FP->save();

                }
                if($request->hasFile('certAntecedentes')){
                    $nombreCA = $request->certAntecedentes->getClientOriginalName();
                    $request->certAntecedentes->move(storage_path().$ruta,$nombreCA);
                    $CA = new Certificado;
                    $CA->MAP_Archivo = $ruta_bd.$nombreCA;
                    $CA->MAP_TD_IdTipoDocumento = 2;
                    $CA->MAP_F_IdFicha = $idagente;
                    $CA->save();

                }
                if($request->hasFile('autoCertAntecedentes')){
                    $nombreACA = $request->autoCertAntecedentes->getClientOriginalName();
                    $request->autoCertAntecedentes->move(storage_path().$ruta,$nombreACA);
                    $ACA = new Certificado;
                    $ACA->MAP_Archivo = $ruta_bd.$nombreACA;
                    $ACA->MAP_TD_IdTipoDocumento = 4;
                    $ACA->MAP_F_IdFicha = $idagente;
                    $ACA->save();

                }
                
            }else{
                dd('ERROR[FILE CONTROLLER]: NO SE GUARDARON LOS ARCHIVOS, YA QUE NO SE A ENCONTRO EL ID DEL AGENTE PASTORAL');
            }
        }catch(Exception $e){
            dd('ERROR[FILE CONTROLLER] :'.$e);
        }
    }

    public function saveDocsAPlog($request,$idagente,$inlogfichero){
                    
        $ruta = '/app/public/Archivos/AgentesPastorales/Fichas/'.$idagente.'/';  // RUTA HACIA STORAGE APP PUBLIC PARA PODER ACCEDER A LA CARPETA DE LOS ARCHIVOS.
        $ruta_bd = '/Archivos/AgentesPastorales/Fichas/'.$idagente.'/';
        if(isset($idagente)){
            if($request->hasFile('fotoPerfil')){
                $nombreFP = $request->fotoPerfil->getClientOriginalName();
                $request->fotoPerfil->move(storage_path().$ruta,$nombreFP);
                $fotoantigua = Certificado::where('MAP_F_IdFicha', $idagente)
                            ->where('MAP_TD_IdTipoDocumento', 1)
                            ->first();
                $rutaantigua="";
                if(strlen($fotoantigua) >=5)
                {
                    $rutaantigua = $fotoantigua->MAP_Archivo;
                    $nombrecampo= 'map_certificado-MAP_Archivo-MAP_TD_IdTipoDocumento-1';
                    $this->insertarlogAP($idagente, $nombrecampo,$rutaantigua);
                }
            
                if($inlogfichero == 1) // si se bloqueó por develación no tiene ficheros y se inserta nuevamente el dato.
                {
                    $FP = new Certificado;
                    $FP->MAP_Archivo = $ruta_bd.$nombreFP;
                    $FP->MAP_TD_IdTipoDocumento = 1;
                    $FP->MAP_F_IdFicha = $idagente;
                    $FP->save();
                    $nombrecampo='map_certificado-MAP_Archivo-MAP_TD_IdTipoDocumento-1';
                    $this->insertarlogAP($idagente, $nombrecampo,$ruta_bd.$nombreFP);

                }
                else{ //Solamente actualizo el dato
                    if($rutaantigua == ""){
                        $FP = new Certificado;
                        $FP->MAP_Archivo = $ruta_bd.$nombreFP;
                        $FP->MAP_TD_IdTipoDocumento = 1;
                        $FP->MAP_F_IdFicha = $idagente;
                        $FP->save();
                    }else{
                        Certificado::where('MAP_TD_IdTipoDocumento', 1)
                    ->where('MAP_F_IdFicha', $idagente)
                    ->update(['MAP_Archivo' => $ruta_bd.$nombreFP]);
                    }
                }
            }
            if($request->hasFile('certAntecedentes')){
                $nombreCA = $request->certAntecedentes->getClientOriginalName();
                $request->certAntecedentes->move(storage_path().$ruta,$nombreCA);
                $antecedenteantiguo = Certificado::where('MAP_F_IdFicha', $idagente)
                                    ->where('MAP_TD_IdTipoDocumento', 2)
                                    ->first();
                $rutaantigua="";
                if(strlen($antecedenteantiguo) >=5){
                    $rutaantigua = $antecedenteantiguo ->MAP_Archivo;
                    $nombrecampo='map_certificado-MAP_Archivo-MAP_TD_IdTipoDocumento-2';
                    $this->insertarlogAP($idagente, $nombrecampo,$rutaantigua);
                }

                if($inlogfichero == 1)
                {
                    $CA = new Certificado;
                    $CA->MAP_Archivo = $ruta_bd.$nombreCA;
                    $CA->MAP_TD_IdTipoDocumento = 2;
                    $CA->MAP_F_IdFicha = $idagente;
                    $CA->save();
                    $nombrecampo='map_certificado-MAP_Archivo-MAP_TD_IdTipoDocumento-2';
                    $this->insertarlogAP($idagente, $nombrecampo,$ruta_bd.$nombreCA);
                }
                else{ //Solamente actualizo el dato
                    if($rutaantigua == ""){
                        $CA = new Certificado;
                        $CA->MAP_Archivo = $ruta_bd.$nombreCA;
                        $CA->MAP_TD_IdTipoDocumento = 2;
                        $CA->MAP_F_IdFicha = $idagente;
                        $CA->save();
                    }else{
                    Certificado::where('MAP_TD_IdTipoDocumento', 2)
                    ->where('MAP_F_IdFicha', $idagente)
                    ->update(['MAP_Archivo' => $ruta_bd.$nombreCA]);
                    }
                }
            }
            if($request->hasFile('autoCertAntecedentes')){
                $nombreACA = $request->autoCertAntecedentes->getClientOriginalName();
                $request->autoCertAntecedentes->move(storage_path().$ruta,$nombreACA);
                $antecedentefichantiguo = Certificado::where('MAP_F_IdFicha', $idagente)
                                        ->where('MAP_TD_IdTipoDocumento', 4)
                                        ->first();
                $rutaantigua="";
                if(strlen($antecedentefichantiguo) >=5){
                    $rutaantigua = $antecedentefichantiguo ->MAP_Archivo;
                    $nombrecampo='map_certificado-MAP_Archivo-MAP_TD_IdTipoDocumento-4';
                    $this->insertarlogAP($idagente, $nombrecampo,$rutaantigua); 
                }
                
                if($inlogfichero == 1)
                {
                    $ACA = new Certificado;
                    $ACA->MAP_Archivo = $ruta_bd.$nombreACA;
                    $ACA->MAP_TD_IdTipoDocumento = 4;
                    $ACA->MAP_F_IdFicha = $idagente;
                    $ACA->save();
                    $nombrecampo='map_certificado-MAP_Archivo-MAP_TD_IdTipoDocumento-4';
                    $this->insertarlogAP($idagente, $nombrecampo,$ruta_bd.$nombreACA);
                }
                else{ //Solamente actualizo el dato
                    if($rutaantigua == ""){
                        $ACA = new Certificado;
                        $ACA->MAP_Archivo = $ruta_bd.$nombreACA;
                        $ACA->MAP_TD_IdTipoDocumento = 4;
                        $ACA->MAP_F_IdFicha = $idagente;
                        $ACA->save();
                    }else{
                    Certificado::where('MAP_TD_IdTipoDocumento', 4)
                    ->where('MAP_F_IdFicha', $idagente)
                    ->update(['MAP_Archivo' => $ruta_bd.$nombreACA]);
                    }
                }
            }
        }else{
            dd('ERROR[FILE CONTROLLER]: NO SE GUARDARON LOS ARCHIVOS, YA QUE NO SE HA ENCONTRADO EL ID DEL AGENTE PASTORAL');
        }
    }

    private function insertarlogAP($idficha, $nombrecampo, $valorcampo){

        $insert_bloqAP = new MapLogAP();
        $insert_bloqAP->MAP_B_IdFicha               = $idficha;
        $insert_bloqAP->MAP_B_ValorModificado       = $valorcampo;
        $insert_bloqAP->MAP_B_CampoModificado       = $nombrecampo;
        $insert_bloqAP->MAP_B_IdUsuarioModifico   = Auth::user()->IdUsuario;
        $insert_bloqAP->MAP_B_Motivo                = 'Modificación';
        $insert_bloqAP->updated_at                  = date('Y-m-d H:i:s');
        $insert_bloqAP->created_at                  = date('Y-m-d H:i:s');
        $insert_bloqAP->save();

    }
     
}