<?php

namespace App\Helpers;

use Auth;
use App\Periodo;
use App\Comprobante;

// Permisos y roles
use App\Institucion;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;

class Helpers
{
    // PARROQUIA A USUARIO ASIGNADO
    public static function insti_seleccionada($usr)
    {
        // dd($usr->accesos);
        $usando = array();

        if ($usr->accesos->isEmpty()) {
            $usando[] = "USUARIO SIN PARROQUIA ASIGNADA";
        } else {
            foreach ($usr->accesos as $registro) {

                if ($registro->EnUso === "true") {
                    // $ur = UnidadRecaudadora::select('Nombre','Codigo')->where('IdUnidadRecaudadora',$registro->UR_IdUnidadRecaudadora)->first();
                    $ur = Institucion::select('INCodDiocesano', 'INNombre')->where('INCodigo', $registro->I_INCodigo)->parroquia()->first();
                    $usando['IdInstitucion'] = $registro->I_INCodigo;
                    $usando['Nombre'] = $ur->INNombre;
                    $usando['Codigo'] = $ur->INCodDiocesano;
                }
            }

            if (empty($usando)) {
                foreach ($usr->accesos as $registro) {
                    if ($registro->Defecto === "true") {
                        // $ur = UnidadRecaudadora::select('Nombre','Codigo')->where('IdUnidadRecaudadora',$registro->UR_IdUnidadRecaudadora)->first();
                        $ur = Institucion::select('INCodDiocesano', 'INNombre')->where('INCodigo', $registro->I_INCodigo)->parroquia()->first();
                        $usando['IdInstitucion'] = $registro->I_INCodigo;
                        $usando['Nombre'] = $ur->Nombre;
                        $usando['Codigo'] = $ur->Codigo;
                    }
                }
            }
            if (empty($usando)) {
                // $ur = UnidadRecaudadora::select('Nombre','Codigo')->where('IdUnidadRecaudadora',$usr->accesos[0]->UR_IdUnidadRecaudadora)->first();
                $ur = Institucion::select('INCodDiocesano', 'INNombre')->where('INCodigo', $usr->accesos[0]->I_INCodigo)->parroquia()->first();
                $usando['IdInstitucion'] = $usr->accesos[0]->I_INCodigo;
                $usando['Nombre'] = $ur->Nombre;
                $usando['Codigo'] = $ur->Codigo;
            }
        }
        return $usando;
    }

    public static function ur_asignadas($usr)
    {
        $asignados = array();
        foreach ($usr->accesos as $registro) {
            // $ur = UnidadRecaudadora::select('Nombre','Codigo')->where('IdUnidadRecaudadora',$registro->UR_IdUnidadRecaudadora)->first();
            $ur = Institucion::select('INCodDiocesano', 'INNombre')->where('INCodigo', $registro->I_INCodigo)->parroquia()->first();
            if ($registro->Defecto === "true") {
                $asignados[] = [
                    'Defecto' => 'true',
                    'IdInstitucion' => $registro->I_INCodigo,
                    'Codigo' => $ur->INCodDiocesano,
                    'Nombre' => $ur->INNombre
                ];
            } else {
                $asignados[] = [
                    'Defecto' => 'false',
                    'IdInstitucion' => $registro->I_INCodigo,
                    'Codigo' => $ur->INCodDiocesano,
                    'Nombre' => $ur->INNombre
                ];
            }
        }
        // dd($asignados);
        return $asignados;
    }
    public static function ur_seleccionada($usr)
    {
        // dd($usr->accesos);
        $usando = array();

        if ($usr->accesos->isEmpty()) {
            $usando[] = "USUARIO SIN UNIDAD RECAUDADORA";
        } else {
            foreach ($usr->accesos as $registro) {

                if ($registro->EnUso === "true") {
                    // $ur = UnidadRecaudadora::select('Nombre','Codigo')->where('IdUnidadRecaudadora',$registro->UR_IdUnidadRecaudadora)->first();
                    $ur = Institucion::select('INCodDiocesano', 'INNombre')->where('INCodigo', $registro->I_INCodigo)->parroquia()->first();
                    $usando['IdInstitucion'] = $registro->I_INCodigo;
                    $usando['Nombre'] = $ur->INNombre;
                    $usando['Codigo'] = $ur->INCodDiocesano;
                }
            }

            if (empty($usando)) {
                foreach ($usr->accesos as $registro) {
                    if ($registro->Defecto === "true") {
                        // $ur = UnidadRecaudadora::select('Nombre','Codigo')->where('IdUnidadRecaudadora',$registro->UR_IdUnidadRecaudadora)->first();
                        $ur = Institucion::select('INCodDiocesano', 'INNombre')->where('INCodigo', $registro->I_INCodigo)->parroquia()->first();
                        $usando['IdInstitucion'] = $registro->I_INCodigo;
                        $usando['Nombre'] = $ur->Nombre;
                        $usando['Codigo'] = $ur->Codigo;
                    }
                }
            }
            if (empty($usando)) {
                // $ur = UnidadRecaudadora::select('Nombre','Codigo')->where('IdUnidadRecaudadora',$usr->accesos[0]->UR_IdUnidadRecaudadora)->first();
                $ur = Institucion::select('INCodDiocesano', 'INNombre')->where('INCodigo', $usr->accesos[0]->I_INCodigo)->parroquia()->first();
                $usando['IdInstitucion'] = $usr->accesos[0]->I_INCodigo;
                $usando['Nombre'] = $ur->Nombre;
                $usando['Codigo'] = $ur->Codigo;
            }
        }
        return $usando;
    }
    public static function VerificaAccesoUR($IdUR)
    {

        if (in_array($IdUR, Auth::user()->accesos->pluck('I_INCodigo')->toArray())) {
            return true;
        } else {
            return false;
        }
    }

    public static function Notificaciones($estado, $tipo, $titulo, $mensaje)
    {
        Session::flash('notificacion.titulo', $titulo);
        Session::flash('notificacion.tipo', $tipo);
        Session::flash('notificacion.mensaje', $mensaje);
    } //valida para generar notificacion segun estado

    public static function Sweetalert($estado, $tipo, $titulo, $mensaje)
    {
        Session::flash('sweetalert.titulo', $titulo);
        Session::flash('sweetalert.tipo', $tipo);
        Session::flash('sweetalert.mensaje', $mensaje);
        // dd(Session::get('titulo'));
    } //valida para generar sweetalert segun estado

    public static function eliminar_simbolos($string)
    {
        //elimina todo los caracteres especiales y mas
        $string = trim($string);

        $string = str_replace(['á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'], [
            'a',
            'a',
            'a',
            'a',
            'a',
            'A',
            'A',
            'A',
            'A',
        ], $string);

        $string = str_replace(['é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'], [
            'e',
            'e',
            'e',
            'e',
            'E',
            'E',
            'E',
            'E',
        ], $string);

        $string = str_replace(['í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'], [
            'i',
            'i',
            'i',
            'i',
            'I',
            'I',
            'I',
            'I',
        ], $string);

        $string = str_replace(['ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'], [
            'o',
            'o',
            'o',
            'o',
            'O',
            'O',
            'O',
            'O',
        ], $string);

        $string = str_replace(['ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'], [
            'u',
            'u',
            'u',
            'u',
            'U',
            'U',
            'U',
            'U',
        ], $string);

        $string = str_replace(['ñ', 'Ñ', 'ç', 'Ç'], ['n', 'N', 'c', 'C',], $string);

        $string = str_replace(['乙', '丕', '九', '乍', '付', '儿', '力', '令', '淲', '¤', '¥'], [
            'ÑA',
            'ÑA',
            'ÑE',
            'ÑE',
            'ÑI',
            'ÑI',
            'ÑO',
            'ÑO',
            'ÍA',
            'Ñ',
            'Ñ',
        ], $string);

        $string = str_replace([
            "\\",
            "¨",
            "º",
            "-",
            "~",
            "#",
            "@",
            "|",
            "!",
            "\"",
            "·",
            "$",
            "%",
            "&",
            "/",
            "(",
            ")",
            "?",
            "'",
            "¡",
            "¿",
            "[",
            "^",
            "]",
            "+",
            "}",
            "{",
            "¨",
            "´",
            ">",
            "< ",
            ",",
            ":",
            "¤",
            ".",
        ], '', $string);

        return $string;
    }

    public static function CrearPermisosAP(){
        // Datos de roles y permisos
        $permisos = [
            'ap_ver_participacion', 
            'ap_modificar_participacion', 
            'ap_crear_participacion', 
            'ap_crear_referencia', 
            'ap_ver_referencia', 
            'ap_modificar_referencia', 
            'ap_ver_modulo_agentes_pastorales', 
            'ap_crear_ficha', 
            'ap_ver_ficha', 
            'ap_modificar_ficha',
            'ap_listadoAp',
            'ap_descargar_documentos',
            'ap_home',
            'dev_buscarAp',
            'dev_proceso_develacion',
            'dev_carga_develacion',
            'dev_descarga_develacion',
            'dev_delegacion',
            'dev_iniciar_proceso_develcion'
        ];
        
        $roles = [
            'Parroco' => [
                'ap_ver_participacion', 
                'ap_modificar_participacion', 
                'ap_crear_participacion', 
                'ap_crear_referencia', 
                'ap_ver_referencia', 
                'ap_modificar_referencia', 
                'ap_ver_modulo_agentes_pastorales', 
                'ap_crear_ficha', 
                'ap_ver_ficha', 
                'ap_modificar_ficha',
                'ap_listadoAp',
                'ap_descargar_documentos',
                'ap_home',
                'dev_carga_develacion'
            ],
            'Generico' => [
                'ap_ver_participacion',
                'ap_modificar_participacion', 
                'ap_crear_participacion',
                'ap_ver_modulo_agentes_pastorales',
                'ap_crear_ficha',
                'ap_listadoAp',
                'ap_descargar_documentos',
                'ap_home'
            ],
            'Coordinador' => [
                'ap_crear_ficha',
                'ap_listadoAp',
                'ap_home'
            ],
            'Delegado' => [
                'ap_ver_modulo_agentes_pastorales',
                'dev_buscarAp',
                'dev_proceso_develacion',
                'dev_descarga_develacion',
                'dev_delegacion',
                'dev_iniciar_proceso_develcion'
            ],
            'Encargada Prevencion' => [
                'ap_ver_modulo_agentes_pastorales',
                'dev_buscarAp',
                'dev_proceso_develacion',
                'dev_delegacion'
            ],
            'Usuario Delegacion' => [
                'ap_ver_modulo_agentes_pastorales',
                'dev_buscarAp',
                'dev_delegacion'
            ]
        ];

        // Crear Permisos
        foreach ($permisos as $permiso) {
            // Verificar que no exista
            if (Permission::where('name', $permiso)->count() == 0) {
                Permission::create(['name' => $permiso]);
            }
        }
        // Crear Roles y asignar permisos (Los echo son para probar la asignacion)
        foreach ($roles as $role => $permisos_role) {
            // Verificar que no exista
            if (Role::where('name', $role)->count() == 0) {
                $nuevo_role = Role::create(['name' => $role]);
                //echo $role.'->';
                foreach ($permisos_role as $permiso_role) {
                    $nuevo_role->givePermissionTo($permiso_role);
                    //echo $permiso_role.' - ';
                }
            }
        }
    }

    // retorna el codigo de la institucion seleccionada por el usuario actual
    public static function codigo_inst_seleccionada()
    {
        $institucionSeleccionada = self::insti_seleccionada(Auth::user());
        return $institucionSeleccionada ? $institucionSeleccionada['IdInstitucion'] : null;
    }

    // retorna info de la institucion seleccionada por el usuario actual
    public static function info_inst_seleccionada()
    {
        $institucionSeleccionada = self::insti_seleccionada(Auth::user());
        return $institucionSeleccionada ? $institucionSeleccionada : null;
    }

    // retorna numero de comprobante correlativo
    public static function nuevo_numero_comprobante()
    {
        $nroComprobante = Comprobante::latest('cpbNum')->first();
        return $nroComprobante != null ? $nroComprobante->cpbNum + 1 : 1;
    }

    // retorna periodo activo o null en caso contrario
    public static function periodo_actual()
    {
        $periodoActivo = Periodo::where('anoStatus', 'A')
            ->where('INCOdigo', Self::codigo_inst_seleccionada())
            ->first();
        return $periodoActivo != null ? $periodoActivo : null;
    }
}
