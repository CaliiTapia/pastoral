<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ficha;
use App\Region;
use App\Pais;
use App\EstadoCivil;
use App\PertenenciaReligiosa;
use App\Http\Controllers\FileController;
use App\Helpers\Helpers;
use Auth;
use DB;
use App\Certificado;
use Illuminate\Support\Collection as Collection;
use App\ParticipacionParroquial;
use App\FichaUR;
use App\MapLogAP;
use App\MapDevelacion;
use App\Institucion;
use App\Participacion;


class AgentePastoralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Auth::user()->Pagina='Listado';
        $ur_acceso = Helpers::ur_seleccionada(Auth::user());
        
        $fichas = DB::table('ficha as f')
                    ->join('MAP_fichaur as fur','fur.MAP_F_IdFicha','f.IdFicha')
                    ->where('fur.MAP_I_INCodigo',$ur_acceso['IdInstitucion'])
                    ->where(function($query){  //esto es un parentesis para la consulta
                        $query-> where('f.Estatus', 1) 
                                ->orWhere('f.Estatus', 2);   
                    })
                    ->where('fur.Map_Estado', 1)
                    ->get();
                    
        
        return view('modulos.agentespastorales.Listado', compact('fichas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Auth::user()->Pagina='Ficha';
        $regiones = Region::orderBy('Nombre')->get();
        $paises = Pais::orderBy('Nombre')->get();
        $estadocivil = EstadoCivil::orderBy('EstadoCivil')->get();

        return view('modulos.agentespastorales.VistaParroquia',compact('regiones','paises','estadocivil'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) //función que crea el agente pastoral
    {
            $nuevoAgente = new Ficha;
            $archivo = new FileController();
            $fichaUR = new FichaUR;
            if(strlen($request->rut) == 8){
                $nuevoAgente->NumeroDocumento = substr($request->rut,0,7);
            }else{
                $nuevoAgente->NumeroDocumento = substr($request->rut,0,8);
            }
            $nuevoAgente->Dv =  substr($request->rut,-1);
            $nuevoAgente->TipoDocumento = $request->tpDocumento;
            $nuevoAgente->Nombre = $request->nombre;
            $nuevoAgente->ApellidoPaterno = $request->apellidoPaterno;
            $nuevoAgente->ApellidoMaterno = $request->apellidoMaterno;
            $nuevoAgente->FechaNacimiento = $request->nacimiento;
            $nuevoAgente->Direccion = $request->direccion;
            $nuevoAgente->TelefonoFijo = $request->fijo;
            $nuevoAgente->TelefonoMovil = $request->celular;
            $nuevoAgente->Correo = $request->correo;
            $nuevoAgente->Sexo = $request->sexo;
            $nuevoAgente->FlgBautismo = $request->bautismo;
            $nuevoAgente->FlgComunion = $request->comunion;
            $nuevoAgente->FlgConfirmacion = $request->confirmacion;
            $nuevoAgente->FlgMatrimonio = $request->matrimonio;
            $nuevoAgente->Estatus = 1;
            $nuevoAgente->R_IdRegion = $request->region;
            $nuevoAgente->C_IdComuna = $request->comuna;
            $nuevoAgente->PR_IdPertenenciaReligiosa = 1;
            $nuevoAgente->EC_IdEstadoCivil = $request->estadocivil;
            $nuevoAgente->P_IdPais = $request->pais;
            $nuevoAgente->C_IdComuna = $request->comuna;
            $nuevoAgente->save();
            
            $archivo->saveDocsAP($request,$nuevoAgente->IdFicha);
            
            $fichaUR->MAP_F_IdFicha = $nuevoAgente->IdFicha;
            $fichaUR->MAP_I_INCodigo = Helpers::ur_seleccionada(Auth::user())['IdInstitucion'];
            $fichaUR->save();
            Helpers::Sweetalert(true, 'success', '¡ÉXITO!', 'Se creo el agente pastoral con éxito');
            
        return redirect()->route('listado.edit', ['pastoral' => $nuevoAgente->IdFicha]);
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Auth::user()->Pagina='Listado';
        $ficha = Ficha::find($id);
        $paises = Pais::orderBy('Nombre')->get();
        $regiones = Region::orderBy('Nombre')->get();
        $estadocivil = EstadoCivil::orderBy('EstadoCivil')->get();
        $getComunas = Region::with(['comunas'=> function($q){
            $q->orderBy('Nombre');
        }])->find($ficha->R_IdRegion);
        $comunas = $getComunas->comunas;
        $files = Certificado::where('MAP_F_IdFicha',$id)->get();
        $archivos['idficha_'] = $id;
        foreach($files as $f){
            $tmp = explode($ficha->IdFicha."/",$f->MAP_Archivo);
            
            switch($f->MAP_TD_IdTipoDocumento){
                case 1:
                    $archivos['FotoPerfil'] = $tmp[1];
                    $archivos['FotoPerfil_url'] = $f->MAP_Archivo;
                break;
                case 2;
                    $archivos['CertAntecedentes'] = $tmp[1];
                    $archivos['CertAntecedentes_url'] = $f->MAP_Archivo;
                break;
                case 4:
                    $archivos['CertAutorizacion'] = $tmp[1];
                    $archivos['CertAutorizacion_url'] = $f->MAP_Archivo;
                break;
                
            }
        }
        return view('modulos.agentespastorales.EditarFicha', compact('ficha', 'regiones', 'paises', 'estadocivil','comunas','archivos'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
            $verificaruserparroquia = FichaUR::select('*')
            ->where('MAP_I_INCodigo', Helpers::ur_seleccionada(Auth::user())['IdInstitucion'])
            ->where('MAP_F_IdFicha', $id)
            ->first();

            if(strlen($verificaruserparroquia) < 5)
            {
                $nuevaparroquiaur = new FichaUR();
                $nuevaparroquiaur->MAP_I_INCodigo  = Helpers::ur_seleccionada(Auth::user())['IdInstitucion'];
                $nuevaparroquiaur->MAP_F_IdFicha   = $id;
                $nuevaparroquiaur->MAP_Estado   = 1;
                $nuevaparroquiaur->save();
            }
            
            $notificacion = DB::table('ficha as f')
            ->join('MAP_develacion as m','m.MAP_IdFicha','f.IdFicha','f.NumeroDocumento')
            ->where('f.IdFicha', '=', $id)
            ->where('m.MAP_INCodigo', '=', Helpers::ur_seleccionada(Auth::user())['IdInstitucion']) 
            ->orderBy('MAP_IdEstado','DESC')->first();
            $Agente = Ficha::find($id);
            $motivo = 'Modificación';
            $insertarlogfichero = 0; //variable que será usada para decidir insertar los documentos en la tabla log.
            if($Agente->Direccion == "") //significa que se está actualizando por haber sido bloqueado desde develación.
            { 
                $insertarlogfichero =1; //se le asigna el valor 1 que significa que se eliminaron los ficheros en develación
            }
            if($Agente->Nombre != $request->nombre and trim($Agente->Nombre) != ""){
                $nombrecampo='Nombre';
                $this->insertarlogAP($id, $nombrecampo,$Agente->Nombre, $motivo, Helpers::ur_seleccionada(Auth::user())['IdInstitucion'], 1);
            }
            if($Agente->ApellidoPaterno != $request->apellidoPaterno and trim($Agente->ApellidoPaterno) != ""){
                $nombrecampo='ApellidoPaterno';
                $this->insertarlogAP($id, $nombrecampo,$Agente->ApellidoPaterno, $motivo, Helpers::ur_seleccionada(Auth::user())['IdInstitucion'], 1);
            }
            if($Agente->ApellidoMaterno != $request->apellidoMaterno and trim($Agente->ApellidoMaterno) != ""){
                $nombrecampo='ApellidoMaterno';
                $this->insertarlogAP($id, $nombrecampo,$Agente->ApellidoMaterno, $motivo, Helpers::ur_seleccionada(Auth::user())['IdInstitucion'], 1);
            }
            if($Agente->FechaNacimiento != $request->nacimiento and trim($Agente->FechaNacimiento) != ""){
                $nombrecampo='FechaNacimiento';
                $this->insertarlogAP($id, $nombrecampo,$Agente->FechaNacimiento, $motivo, Helpers::ur_seleccionada(Auth::user())['IdInstitucion'], 1);
            }
            if($Agente->Direccion != $request->direccion and trim($Agente->Direccion) != ""){
                $nombrecampo='Direccion';
                $this->insertarlogAP($id, $nombrecampo,$Agente->Direccion, $motivo, Helpers::ur_seleccionada(Auth::user())['IdInstitucion'], 1);
            }
            if($Agente->TelefonoFijo != $request->fijo and trim($Agente->TelefonoFijo) != ""){
                $nombrecampo='TelefonoFijo';
                $this->insertarlogAP($id, $nombrecampo,$Agente->TelefonoFijo, $motivo, Helpers::ur_seleccionada(Auth::user())['IdInstitucion'], 1);
            }
            if($Agente->TelefonoMovil != $request->celular and trim($Agente->TelefonoMovil) != ""){
                $nombrecampo='TelefonoMovil';
                $this->insertarlogAP($id, $nombrecampo,$Agente->TelefonoMovil, $motivo, Helpers::ur_seleccionada(Auth::user())['IdInstitucion'], 1);
            }
            if($Agente->Correo != $request->correo and trim($Agente->Correo) != ""){
                $nombrecampo='Correo';
                $this->insertarlogAP($id, $nombrecampo,$Agente->Correo, $motivo, Helpers::ur_seleccionada(Auth::user())['IdInstitucion'], 1);
            }
            if($Agente->C_IdComuna != $request->comuna and trim($Agente->C_IdComuna) != "" and $Agente->C_IdComuna != 349){
                $nombrecampo='C_IdComuna';
                $this->insertarlogAP($id, $nombrecampo,$Agente->C_IdComuna, $motivo, Helpers::ur_seleccionada(Auth::user())['IdInstitucion'], 1);
            }
            if($Agente->R_IdRegion != $request->region and trim($Agente->R_IdRegion, Helpers::ur_seleccionada(Auth::user())['IdInstitucion']) != "" and $Agente->R_IdRegion != 16){
                $nombrecampo='R_IdRegion';
                $this->insertarlogAP($id, $nombrecampo,$Agente->R_IdRegion, $motivo, Helpers::ur_seleccionada(Auth::user())['IdInstitucion'], 1);
            }

            if (!empty($notificacion)) {
                if ($notificacion->MAP_IdEstado == 3) {
                    $Agente = Ficha::find($id);
                    $Agente->Nombre = $request->nombre;
                    $Agente->ApellidoPaterno = $request->apellidoPaterno;
                    $Agente->ApellidoMaterno = $request->apellidoMaterno;
                    $Agente->FechaNacimiento = $request->nacimiento;
                    $Agente->Direccion = $request->direccion;
                    $Agente->TelefonoFijo = $request->fijo;
                    $Agente->TelefonoMovil = $request->celular;
                    $Agente->Correo = $request->correo;
                    $Agente->Sexo = $request->sexo;
                    $Agente->FlgBautismo = $request->bautismo;
                    $Agente->FlgComunion = $request->comunion;
                    $Agente->FlgConfirmacion = $request->confirmacion;
                    $Agente->FlgMatrimonio = $request->matrimonio;
                    $Agente->Estatus = 1;
                    $Agente->R_IdRegion = $request->region;
                    $Agente->C_IdComuna = $request->comuna;
                    $Agente->PR_IdPertenenciaReligiosa = 1;
                    $Agente->EC_IdEstadoCivil = $request->estadocivil;
                    $Agente->P_IdPais = $request->pais;
                    $Agente->C_IdComuna = $request->comuna;
                    $Agente->save();
                    $archivo = new FileController();
                    $archivo->saveDocsAPlog($request,$id,$insertarlogfichero);

                    FichaUR::where('MAP_F_IdFicha', $id)
                    ->where('MAP_I_INCodigo', Helpers::ur_seleccionada(Auth::user())['IdInstitucion'])
                    ->update(['MAP_Estado' => 1]);           

                    $Mail = Ficha::select('NumeroDocumento', 'Dv')->where('IdFicha', $id)->first();    
                    $datos['Rut'] = $Mail->NumeroDocumento;  
                    $datos['Dv'] = $Mail->Dv; 
                    if(Auth::user()->hasPermissionTo('dev_notificacion')){
                        Helpers::Sweetalert(true, 'warning', '¡Aviso!', 'Se debe contactar con la encargada de Delegación por el \n Rut: '.$notificacion->NumeroDocumento.'-'.$notificacion->Dv.'  \n Al número de contacto: +5698765432  \n o al correo de contacto: lcarrasco@iglesiadesantiago.cl');
                        $send = new MailController();   
                        $send->notificaReincidenciaP($datos);
                    }else{
                        Helpers::Sweetalert(true, 'success', '¡ÉXITO!', 'Se modificó el agente pastoral con éxito');
                        $send = new MailController();  
                        $send->notificaReincidenciaG($datos);
                    }               

                    $send = new MailController();
                    $Mail = DB::table('ficha as f')->select('f.NumeroDocumento', 'f.Dv','z.Nombre', 'i.INNombre', 'u.Nombre AS nomUser', 'u.Apellidos', 'd.MAP_IdEstado')->join('MAP_develacion as d', 'd.MAP_IdFicha', '=', 'f.IdFicha')
                    ->join('usuario as u', 'u.IdUsuario', '=', 'd.MAP_IdUsuario')->join('institucion as i', 'i.INCodigo', '=', 'd.MAP_INCodigo')->join('zona as z', 'z.IdZona', '=', 'd.MAP_InZona')->where('f.IdFicha', '=', $id)->first();
                    $data['Rut'] = $Mail->NumeroDocumento;  
                    $data['Dv'] = $Mail->Dv; 
                    $data['Zona'] = $Mail->Nombre;  
                    $data['Parroquia'] = $Mail->INNombre; 
                    $data['Nombre'] = $Mail->nomUser;
                    $data['Apellido'] = $Mail->Apellidos;
                    $send->notificaReincidenciaD($data);

                    return redirect()->route('listado.edit', ['pastoral' => $id]);

                }elseif ($notificacion->MAP_IdEstado == 1 OR $notificacion->MAP_IdEstado == 2) {
                    $Agente = Ficha::find($id);
                    $Agente->Nombre = $request->nombre;
                    $Agente->ApellidoPaterno = $request->apellidoPaterno;
                    $Agente->ApellidoMaterno = $request->apellidoMaterno;
                    $Agente->FechaNacimiento = $request->nacimiento;
                    $Agente->Direccion = $request->direccion;
                    $Agente->TelefonoFijo = $request->fijo;
                    $Agente->TelefonoMovil = $request->celular;
                    $Agente->Correo = $request->correo;
                    $Agente->Sexo = $request->sexo;
                    $Agente->FlgBautismo = $request->bautismo;
                    $Agente->FlgComunion = $request->comunion;
                    $Agente->FlgConfirmacion = $request->confirmacion;
                    $Agente->FlgMatrimonio = $request->matrimonio;
                    $Agente->Estatus = 1;
                    $Agente->R_IdRegion = $request->region;
                    $Agente->C_IdComuna = $request->comuna;
                    $Agente->PR_IdPertenenciaReligiosa = 1;
                    $Agente->EC_IdEstadoCivil = $request->estadocivil;
                    $Agente->P_IdPais = $request->pais;
                    $Agente->C_IdComuna = $request->comuna;
                    $Agente->save();
                    $archivo = new FileController();
                    $archivo->saveDocsAPlog($request,$id,$insertarlogfichero);

                    FichaUR::where('MAP_F_IdFicha', $id)
                    ->where('MAP_I_INCodigo', Helpers::ur_seleccionada(Auth::user())['IdInstitucion'])
                    ->update(['MAP_Estado' => 1]);

                    DB::table('MAP_develacion')->where('MAP_IdFicha', $id)->update(['MAP_NumeroNotificacion' => $notificacion->MAP_NumeroNotificacion+1]); 

                    $Mail = Ficha::select('NumeroDocumento', 'Dv')->where('IdFicha', $id)->first();    
                    $datos['Rut'] = $Mail->NumeroDocumento;  
                    $datos['Dv'] = $Mail->Dv; 
                    if(Auth::user()->hasPermissionTo('dev_notificacion')){
                        Helpers::Sweetalert(true, 'warning', '¡Aviso!', 'Se debe contactar con la encargada de Delegación por el \n Rut: '.$notificacion->NumeroDocumento.'-'.$notificacion->Dv.'  \n Al número de contacto: +5698765432  \n o al correo de contacto: lcarrasco@iglesiadesantiago.cl');
                        $send = new MailController();
                        $send->notificaActivaP($datos);
                    }else{
                        Helpers::Sweetalert(true, 'success', '¡ÉXITO!', 'Se modificó el agente pastoral con éxito');
                        $send = new MailController();
                        $send->notificaActivaG($datos);
                    }  
                    
                    $send = new MailController();
                    $Mail = DB::table('ficha as f')->select('f.NumeroDocumento', 'f.Dv','z.Nombre', 'i.INNombre', 'u.Nombre AS nomUser', 'u.Apellidos', 'd.MAP_IdEstado')->join('MAP_develacion as d', 'd.MAP_IdFicha', '=', 'f.IdFicha')
                    ->join('usuario as u', 'u.IdUsuario', '=', 'd.MAP_IdUsuario')->join('institucion as i', 'i.INCodigo', '=', 'd.MAP_INCodigo')->join('zona as z', 'z.IdZona', '=', 'd.MAP_InZona')->where('f.IdFicha', '=', $id)->first();
                    $data['Rut'] = $Mail->NumeroDocumento;  
                    $data['Dv'] = $Mail->Dv; 
                    $data['Zona'] = $Mail->Nombre;  
                    $data['Parroquia'] = $Mail->INNombre; 
                    $data['Nombre'] = $Mail->nomUser;
                    $data['Apellido'] = $Mail->Apellidos;
                    $send->notificaActivaD($data);

                    return redirect()->route('listado.edit', ['pastoral' => $id]);

                }elseif ($notificacion->MAP_IdEstado == 4) {
                    $Agente = Ficha::find($id);
                    $Agente->Nombre = $request->nombre;
                    $Agente->ApellidoPaterno = $request->apellidoPaterno;
                    $Agente->ApellidoMaterno = $request->apellidoMaterno;
                    $Agente->FechaNacimiento = $request->nacimiento;
                    $Agente->Direccion = $request->direccion;
                    $Agente->TelefonoFijo = $request->fijo;
                    $Agente->TelefonoMovil = $request->celular;
                    $Agente->Correo = $request->correo;
                    $Agente->Sexo = $request->sexo;
                    $Agente->FlgBautismo = $request->bautismo;
                    $Agente->FlgComunion = $request->comunion;
                    $Agente->FlgConfirmacion = $request->confirmacion;
                    $Agente->FlgMatrimonio = $request->matrimonio;
                    $Agente->Estatus = 1;
                    $Agente->R_IdRegion = $request->region;
                    $Agente->C_IdComuna = $request->comuna;
                    $Agente->PR_IdPertenenciaReligiosa = 1;
                    $Agente->EC_IdEstadoCivil = $request->estadocivil;
                    $Agente->P_IdPais = $request->pais;
                    $Agente->C_IdComuna = $request->comuna;
                    $Agente->save();
                    $archivo = new FileController();
                    $archivo->saveDocsAPlog($request,$id,$insertarlogfichero);

                    FichaUR::where('MAP_F_IdFicha', $id)
                    ->where('MAP_I_INCodigo', Helpers::ur_seleccionada(Auth::user())['IdInstitucion'])
                    ->update(['MAP_Estado' => 1]);
    
                    Helpers::Sweetalert(true, 'success', '¡ÉXITO!', 'Se modificó el agente pastoral con éxito');
        
                    return redirect()->route('listado.edit', ['pastoral' => $id]);
                }
            }elseif(empty($notificacion)){
                $Agente = Ficha::find($id);
                $Agente->Nombre = $request->nombre;
                $Agente->ApellidoPaterno = $request->apellidoPaterno;
                $Agente->ApellidoMaterno = $request->apellidoMaterno;
                $Agente->FechaNacimiento = $request->nacimiento;
                $Agente->Direccion = $request->direccion;
                $Agente->TelefonoFijo = $request->fijo;
                $Agente->TelefonoMovil = $request->celular;
                $Agente->Correo = $request->correo;
                $Agente->Sexo = $request->sexo;
                $Agente->FlgBautismo = $request->bautismo;
                $Agente->FlgComunion = $request->comunion;
                $Agente->FlgConfirmacion = $request->confirmacion;
                $Agente->FlgMatrimonio = $request->matrimonio;
                $Agente->Estatus = 1;
                $Agente->R_IdRegion = $request->region;
                $Agente->C_IdComuna = $request->comuna;
                $Agente->PR_IdPertenenciaReligiosa = 1;
                $Agente->EC_IdEstadoCivil = $request->estadocivil;
                $Agente->P_IdPais = $request->pais;
                $Agente->C_IdComuna = $request->comuna;
                $Agente->save();
                $archivo = new FileController();
                $archivo->saveDocsAPlog($request,$id,$insertarlogfichero);

                FichaUR::where('MAP_F_IdFicha', $id)
                ->where('MAP_I_INCodigo', Helpers::ur_seleccionada(Auth::user())['IdInstitucion'])
                ->update(['MAP_Estado' => 1]);

                Helpers::Sweetalert(true, 'success', '¡ÉXITO!', 'Se modificó el agente pastoral con éxito');
    
                return redirect()->route('listado.edit', ['pastoral' => $id]);
            }
        
        return redirect()->route('listado.edit', ['pastoral' => $id]);
    }

    public function editDel($id)
    {
        Auth::user()->Pagina='Listado';
        $ficha = Ficha::find($id);
        $paises = Pais::orderBy('Nombre')->get();
        $regiones = Region::orderBy('Nombre')->get();
        $estadocivil = EstadoCivil::orderBy('EstadoCivil')->get();
        $getComunas = Region::with(['comunas'=> function($q){
            $q->orderBy('Nombre');
        }])->find($ficha->R_IdRegion);
        $comunas = $getComunas->comunas;
        $participaciones = ParticipacionParroquial::with([
            'capilla',
            'area' => function($q){ $q->select('MAP_Descripcion','MAP_IdArea'); }, 
            'cargo' => function($q){ $q->select('MAP_Descripcion','MAP_IdCargo'); }, 
            'zona' => function($q){ $q->select('Nombre', 'IdZona'); }, 
            'institucion' => function($q) { $q->select('INCodigo', 'INNombre', 'INZona'); }
        ])
            ->where('MAP_Estatus', 1)
            ->where('MAP_F_IdFicha', $id)
            ->orderBy('MAP_FechaInicio','desc')
            ->get();

        return view('modulos.agentespastorales.EditarFichaDelegacion', compact('ficha', 'regiones', 'paises', 'estadocivil','comunas','participaciones'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function descargarFicha(){
        return redirect(asset('storage/map/FichaImprimible.docx'));
    }


    private function insertarlogAP($idficha, $nombrecampo, $valorcampo, $motivo, $incodigo, $es){

        $insert_bloqAP = new MapLogAP();
        $insert_bloqAP->MAP_B_IdFicha               = $idficha;
        $insert_bloqAP->MAP_B_ValorModificado       = $valorcampo;
        $insert_bloqAP->MAP_B_CampoModificado       = $nombrecampo;
        $insert_bloqAP->MAP_B_IdUsuarioModifico     = Auth::user()->IdUsuario;
        $insert_bloqAP->MAP_B_Motivo                = $motivo;
        $insert_bloqAP->MAP_B_INCodigo              = $incodigo;
        $insert_bloqAP->MAP_B_Estatus               = $es;
        $insert_bloqAP->save();

    }

    public function bloquearBuscar(Request $request)
    {
        if($request->vista == 1){
            FichaUR::where('MAP_F_IdFicha', $request->idfichabloq)
            ->where('MAP_I_INCodigo', $request->parroquiabloq)
            ->update(['MAP_Estado' => 0]);

            Participacion::where('MAP_F_IdFicha', $request->idfichabloq)  
            ->where('MAP_I_INCodigo', $request->parroquiabloq) 
            ->where('MAP_FechaTermino', null) 
            ->update(['MAP_FechaTermino' => date('Y-m-d')]); 
        }

        if($request->mot == 1){
            MapLogAP::where('MAP_B_IdFicha', $request->idfichabloq)
            ->where('MAP_B_INCodigo', $request->parroquiabloq)
            ->where(function($query){ 
                $query-> where('MAP_B_Motivo','=','Cese Servicio')->orWhere('MAP_B_Motivo','=','Activación')
                ->orderby('updated_at','DESC'); 
            })
            ->update(['MAP_B_Estatus' => 0]);
        }

        $nombrecampo='Motivo Cese Servicio';
        $motivo = 'Cese Servicio'; 
        $es = 1;
        $this->insertarlogAP($request->idfichabloq, $nombrecampo, $request->motivobloqueo, $motivo, $request->parroquiabloq,$es);

        Helpers::Sweetalert(true, 'success', '¡ÉXITO!', 'El Agente Pastoral ha sido cancelado');
    }

    public function bloquearAPlista(Request $request)
    {
        if($request->vista == 2){ 
            $ur=FichaUR::where('MAP_F_IdFicha', $request->idfichabloq)
            ->where('MAP_I_INCodigo', Helpers::ur_seleccionada(Auth::user())['IdInstitucion'])
            ->update(['MAP_Estado' => 0]);

            Participacion::where('MAP_F_IdFicha', $request->idfichabloq) 
            ->where('MAP_I_INCodigo', Helpers::ur_seleccionada(Auth::user())['IdInstitucion'])
            ->where('MAP_FechaTermino', null) 
            ->update(['MAP_FechaTermino' => date('Y-m-d')]); 
        }

        if($request->mot == 2){
            MapLogAP::where('MAP_B_IdFicha', $request->idfichabloq)
            ->where('MAP_B_INCodigo', Helpers::ur_seleccionada(Auth::user())['IdInstitucion'])
            ->where(function($query){ 
                $query-> where('MAP_B_Motivo','=','Cese Servicio')->orWhere('MAP_B_Motivo','=','Activación')
                ->orderby('updated_at','DESC'); 
            })
            ->update(['MAP_B_Estatus' => 0]);
        } 

        $nombrecampo='Motivo Cese Servicio';
        $motivo = 'Cese Servicio'; 
        $es = 1;

        $insert_bloqAP = new MapLogAP();
        $insert_bloqAP->MAP_B_IdFicha = $request->idfichabloq;
        $insert_bloqAP->MAP_B_ValorModificado = $request->motivobloqueo;
        $insert_bloqAP->MAP_B_CampoModificado = $nombrecampo;
        $insert_bloqAP->MAP_B_IdUsuarioModifico = Auth::user()->IdUsuario;
        $insert_bloqAP->MAP_B_Motivo = $motivo;
        $insert_bloqAP->MAP_B_INCodigo = Helpers::ur_seleccionada(Auth::user())['IdInstitucion'];
        $insert_bloqAP->MAP_B_Estatus = $es;
        $insert_bloqAP->save();

        Helpers::Sweetalert(true, 'success', '¡ÉXITO!', 'El Agente Pastoral ha sido cancelado');
    }

    public function activarAp(Request $request)
    {
        if($request->vista == 0){
            FichaUR::where('MAP_F_IdFicha', $request->idficha)
            ->where('MAP_I_INCodigo', $request->idparroquia)
            ->update(['MAP_Estado' => 1]);
        }
        else{ 
            FichaUR::where('MAP_F_IdFicha', $request->idficha)
            ->where('MAP_I_INCodigo', Helpers::ur_seleccionada(Auth::user())['IdInstitucion'])
            ->update(['MAP_Estado' => 1]);
        }

        if($request->mot == 1){
            MapLogAP::where('MAP_B_IdFicha', $request->idficha)
            ->where('MAP_B_INCodigo', $request->idparroquia)
            ->where(function($query){ 
                $query-> where('MAP_B_Motivo','=','Cese Servicio')->orWhere('MAP_B_Motivo','=','Activación')
                ->orderby('updated_at','DESC');
            })
            
            ->update(['MAP_B_Estatus' => 0]);
        }  

        $nombrecampo='Motivo Activación';
        $motivo = 'Activación'; 
        $es = 1;
        $this->insertarlogAP($request->idficha, $nombrecampo, $request->motivo, $motivo, $request->idparroquia,$es);

        Helpers::Sweetalert(true, 'success', '¡ÉXITO!', 'El Agente Pastoral ha sido Activado');
    }

    public function bloqparticipacion_actual($idficha, $incodigo)
    {

            $participacion_actual =  Participacion::with('cargos', 'areas')
            ->join('MAP_cargo', 'MAP_participacion.MAP_C_IdCargo', '=', 'MAP_cargo.MAP_IdCargo')
            ->join('MAP_area', 'MAP_participacion.MAP_A_IdArea', '=', 'MAP_area.MAP_IdArea')
            ->where('MAP_F_IdFicha', $idficha)  
            ->where('MAP_I_INCodigo', $incodigo) 
            ->where('MAP_FechaTermino', null) 
            ->select('MAP_participacion.*','MAP_cargo.MAP_Descripcion AS cargo_ap', 'MAP_area.MAP_Descripcion AS area_ap')
            ->get(); 
            $mensaje = "";
            $participaciones = "";
            if($participacion_actual != null or $participacion_actual != "") {
                foreach($participacion_actual as $pa)
                {
                    $participaciones .= $pa->cargo_ap. " en el área de ".$pa->area_ap." desde el ".date("d/m/Y",strtotime($pa->MAP_FechaInicio))."\n"; 
                }
            }
            if(strlen($participaciones) >= 5 ){
                $mensaje = "Agente Pastoral actualmente cumple funciones como: \n";
            }
            else{
                $mensaje = "El Agente no cuenta con Participaciones activas en esta Parroquia";
            }
            return $mensaje.$participaciones;
                 
    }

    public function bloqparticipacion_actuallistado($idficha)
    {
            $participacion_actual =  Participacion::with('cargos', 'areas')
            ->join('MAP_cargo', 'MAP_participacion.MAP_C_IdCargo', '=', 'MAP_cargo.MAP_IdCargo')
            ->join('MAP_area', 'MAP_participacion.MAP_A_IdArea', '=', 'MAP_area.MAP_IdArea')
            ->where('MAP_F_IdFicha', $idficha)  
            ->where('MAP_I_INCodigo', Helpers::ur_seleccionada(Auth::user())['IdInstitucion'])
            ->where('MAP_FechaTermino', null) 
            ->select('MAP_participacion.*','MAP_cargo.MAP_Descripcion AS cargo_ap', 'MAP_area.MAP_Descripcion AS area_ap')
            ->get(); 
            $mensaje = "";
            $participaciones = "";
            if($participacion_actual != null or $participacion_actual != "") {
                
                foreach($participacion_actual as $pa)
                {
                    $participaciones .= $pa->cargo_ap. " en el área de ".$pa->area_ap." desde el ".date("d/m/Y",strtotime($pa->MAP_FechaInicio))."\n"; 
                }
            }
            if(strlen($participaciones) >= 5){
                $mensaje = "Agente Pastoral actualmente cumple funciones como: \n";
            }
            else{
                $mensaje = "El Agente no cuenta con Participaciones activas en esta Parroquia";
            }
            return $mensaje.$participaciones;
                        
    }
}