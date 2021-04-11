<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\DB;
use Auth;
use Mail;
use Session;
use Redirect;
use App\User;

class MailController extends Controller
{
    // Mail Parroco MAP_IdEstado = 3
    public function notificaReincidenciaP($datos) 
    {   
        $idusuario=Auth::user()->IdUsuario;        
        $destinatario = User::where('IdUsuario', '=', $idusuario)->get()->pluck('email')->toArray(); 
        // dd($idusuario, $destinatario);
        Mail::send('Mail.MailReincidenciaParroco', $datos, function($msj) use ($destinatario){
            $msj->subject('Ingreso de Agente Pastoral con sentencia por develación');
            $msj->to($destinatario);
        });
    }

    // Mail Generico MAP_IdEstado = 3
    public function notificaReincidenciaG($datos) 
    {       
        $INSelect = Helpers::codigo_inst_seleccionada();  
        $destinatario = DB::table('usuario as u')->join('accesos as a', 'a.U_IdUsuario', 'u.IdUsuario')->join('model_has_roles as mr', 'mr.model_id','u.IdUsuario')
        ->where('mr.role_id', 1)->where('a.I_INCodigo', $INSelect)->pluck('u.email')->toArray();
        // dd($INSelect, $destinatario);
        Mail::send('Mail.MailReincidenciaParroco', $datos, function($msj) use ($destinatario){
            $msj->subject('Ingreso de Agente Pastoral con sentencia por develación');
            $msj->to($destinatario);
        });
    }

    // Mail Delegacion MAP_IdEstado = 3
    public function notificaReincidenciaD($data) 
    {
        Mail::send('Mail.MailReincidenciaEDelegacion', $data, function($msj){
            $msj->subject('Ingreso de Agente Pastoral con sentencia por develación');
            $msj->to('denunciadelegacion@iglesiadesantiago.cl');        
        });
    }

    // Mail Parroco MAP_IdEstado = 1 o 2
    public function notificaActivaP($datos) 
    {   
        $idusuario=Auth::user()->IdUsuario;        
        $destinatario = User::where('IdUsuario', '=', $idusuario)->get()->pluck('email')->toArray(); 
        // dd($idusuario, $destinatario);
        Mail::send('Mail.MailReincidenciaParroco', $datos, function($msj) use ($destinatario){
            $msj->subject('Ingreso de Agente Pastoral con proceso de develación activa');
            $msj->to($destinatario);
        });
    }

    // Mail Generico MAP_IdEstado = 1 o 2
    public function notificaActivaG($datos) 
    {       
        $INSelect = Helpers::codigo_inst_seleccionada();  
        $destinatario = DB::table('usuario as u')->join('accesos as a', 'a.U_IdUsuario', 'u.IdUsuario')->join('model_has_roles as mr', 'mr.model_id','u.IdUsuario')
        ->where('mr.role_id', 1)->where('a.I_INCodigo', $INSelect)->pluck('u.email')->toArray();
        // dd($INSelect, $destinatario);
        Mail::send('Mail.MailReincidenciaParroco', $datos, function($msj) use ($destinatario){
            $msj->subject('Ingreso de Agente Pastoral con proceso de develación activa');
            $msj->to($destinatario);
        });
    }

    // Mail Delegacion MAP_IdEstado = 1 o 2
    public function notificaActivaD($data) 
    {
        Mail::send('Mail.MailReincidenciaEDelegacion', $data, function($msj){
            $msj->subject('Ingreso de Agente Pastoral con proceso de develación activa');
            $msj->to('denunciadelegacion@iglesiadesantiago.cl');   
        });
    }

    public function notificaCargaArchivo($Archivo) 
    {
        Mail::send('Mail.MailCargaArchivo', $Archivo, function($msj){
            $msj->subject('Ingreso de Agente Pastoral con proceso de develación activa');
            $msj->to('denunciadelegacion@iglesiadesantiago.cl');
        });
    }
}