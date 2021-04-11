<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\MapArchivosDevelacion;
use App\Helpers\Helpers;
use Auth;


class ArchivosDevelacionesController extends Controller
{
    public function indexsubida(){
        Auth::user()->Pagina='ArchivoDev';
        $devarchivos=DB::select(DB::raw("SELECT mad.MAP_IdArchivo,
                                                mad.MAP_Nombre_Archivo, 
                                                mad.MAP_Descripcion, 
                                                mad.MAP_RutaArchivo,
                                                u.Nombre, u.Apellidos,
                                                DATE_FORMAT(mad.MAP_FechaSubida, '%e-%m-%Y') AS fechadesubida, 
                                                mad.MAP_EstadoArchivo
                                                FROM MAP_archivos_develacion mad
                                                INNER JOIN usuario u ON mad.MAP_IdUsuario = u.IdUsuario
                                                INNER JOIN institucion i ON mad.MAP_A_INCodigo = i.INCodigo
                                                WHERE mad.MAP_EstadoArchivo = 1
                                                ORDER BY MAP_IdArchivo desc
                                                "));
        
        return view('modulos.documentosdevelaciones.cargararchivos', compact('devarchivos'));
    }

    public function store(Request $request){
        $archivo=$request->file('archivo');  //se recibe el archivo que viene del formulario
        $nombrearchivo=$archivo->getClientOriginalName(); //se obtiene el nombre y el tipo de archivo del documento
        $ruta=$request->file('archivo')->storeAs('public/archivosdevelaciones', $nombrearchivo); //se guarda el archivo en la ruta especificada.
        $idusuario=Auth::user()->IdUsuario;
        $CargarArchivo = new MapArchivosDevelacion;
        $CargarArchivo->MAP_Nombre_Archivo = $nombrearchivo;
        $CargarArchivo->MAP_Descripcion = $request->descripcion;
        $CargarArchivo->MAP_RutaArchivo = $ruta;
        $CargarArchivo->MAP_FechaSubida = date('Y-m-d H:i:s');
        $CargarArchivo->MAP_EstadoArchivo = 1;
        $CargarArchivo->created_at = date('Y-m-d H:i:s');
        $CargarArchivo->updated_at = date('Y-m-d H:i:s');

        $CargarArchivo->MAP_IdUsuario = $idusuario;
        $CargarArchivo->MAP_A_INCodigo = Helpers::ur_seleccionada(Auth::user())['IdInstitucion'];
        $CargarArchivo->save();
        
        Helpers::Sweetalert(false, 'warning', '¡EXITO!', 'Se ha ingresado el archivo de la denuncia.');

        $envio = new MailController();
        $coreo = DB::table('MAP_archivos_develacion as MAD')
                ->select('U.Nombre', 'I.INNombre', 'MAD.MAP_Nombre_Archivo', 'MAD.MAP_Descripcion', 'MAD.MAP_FechaSubida')                
                ->join('usuario as U', 'U.IdUsuario', '=', 'MAD.MAP_IdUsuario')
                ->join('institucion as I', 'I.INCodigo', '=', 'MAD.MAP_A_INCodigo')                
                ->orderby('MAD.MAP_IdArchivo','desc')
                ->first(); 

        $Archivo['nombre'] = $coreo->Nombre;
        $Archivo['institucion'] = $coreo->INNombre;
        $Archivo['archivo'] = $coreo->MAP_Nombre_Archivo;
        $Archivo['descripcion'] = $coreo->MAP_Descripcion;
        $Archivo['fecha'] = $coreo->MAP_FechaSubida;
        $envio->notificaCargaArchivo($Archivo);

        return response()->json();  
    }

    public function descargararchivos(){
        Auth::user()->Pagina='DArchivoDev';
        $devarchivosdes=DB::select(DB::raw("SELECT mad.MAP_IdArchivo,
                                                mad.MAP_Nombre_Archivo, 
                                                mad.MAP_Descripcion, 
                                                mad.MAP_RutaArchivo,
                                                z.Nombre as nombrezona,
                                                i.INNombre,
                                                u.Nombre, u.Apellidos,
                                                DATE_FORMAT(mad.MAP_FechaSubida, '%e-%m-%Y') AS fechadesubida, 
                                                mad.MAP_EstadoArchivo
                                                FROM MAP_archivos_develacion mad
                                                INNER JOIN usuario u ON mad.MAP_IdUsuario = u.IdUsuario
                                                INNER JOIN institucion i ON mad.MAP_A_INCodigo = i.INCodigo
                                                INNER JOIN zona z ON i.INZona = z.IdZona
                                                ORDER BY MAP_IdArchivo desc
                                                "));

        return view('modulos.documentosdevelaciones.descargararchivos', compact('devarchivosdes'));
    }

    public function eliminar_archivo($idarchivo){
        $eliarchivo = MapArchivosDevelacion::find($idarchivo);
            $eliarchivo->MAP_EstadoArchivo = 0;
            $eliarchivo->save();
            
        return 1;
    }
}
