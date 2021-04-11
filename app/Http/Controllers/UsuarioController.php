<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\ModelRole;
use App\Helpers\Helpers;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class UsuarioController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $usuario = DB::table('users as a')
        ->select('a.id','a.Nombre','a.Apellidos','a.email','a.estatus')
        ->orderBy('a.id','desc')
        ->get();
        return view('modulos.mantenedores.usuario.index', [
        'usuario' => $usuario]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('modulos.mantenedores.usuario.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = $this->validate(request(), [
            'nombre' => 'required|regex:/^[A-Za-z\s-_]+$/',
            'apellidos' => 'required|regex:/^[A-Za-z\s-_]+$/',
            'password' => 'required|min:8'
            //'role' => 'required'
        ],
            [
                'regex' => 'No puede ingresar simbolos',
                'email.required' => 'El email es un campo requerido',
                'apellidos.required' => 'Los apellidos son un campo requerido',
                'nombre.required' => 'El nombre es un campo requerido',
                //'role.required' => 'El role del usuario es requerido'
            ]

        );

        //if ($validator->fails())
        //  {
        //  return redirect()->back()->withErrors($validator ->errors());

        //  }else{

        $usuario= new User();
        $usuario->Nombre=mb_strtoupper($request->nombre);
        $usuario->Apellidos=mb_strtoupper($request->apellidos);
        //$usuario->Fono= $request->telefono;
        $usuario->Direccion= $request->direccion;
        $usuario->email= $request->email;
        //$usuario->C_IdComuna= $request->comuna;
        //$usuario->D_IdDiocesis= $request->diocesis;
        $usuario->created_at= date('Y-m-d h:m:s');
        //$usuario->UsuarioCreaModifica = Auth::user()->id;
        $usuario->password = Hash::make($request->password);
        $usuario->save();

        //extrae el ultimo id ingresado
        $iduser=$usuario->id;

        /*$model= new ModelRole();
        $model-> role_id=$request->role;
        $model-> model_id=$iduser;
        $model-> model_type='App\User';
        $model->save();*/

        return redirect()->action('UsuarioController@index');
        // }

    }
    public function cambio_pass(Request $request){
        $id_usuario = auth()->user()->IdUsuario;
        
        //dd($request->password,$request->password2,$id_usuario);
        if($request->password == $request->password2){
            try {
                
                $usuario = User::find($id_usuario);
                $usuario->password = bcrypt($request->password);
                $usuario->save();
                
                $mensaje=Helpers::Notificaciones(true, 'success', '¡EXITO! ', 'La contraseña se modifico correctamente');
            }catch(\Exception $e){
                
                $mensaje=Helpers::Notificaciones(true, 'error', '¡ERROR! ', 'Problemas al actualizar contraseña');
            }
        }else{
            $mensaje=Helpers::Notificaciones(true, 'warning', '¡ADVERTENCIA! ', 'Las contraseñas no coinciden');
            
        }
        return redirect()->back()->with($mensaje);
    }
    public function actual_pass(){
  
        return view('modulos.mantenedores.usuario.cambio_pass');
    }
    /*
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   /* public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function edit($id)
    {
        //

        $usuario = User:: where('IdUsuario',$id)->orderBy('IdUsuario', 'desc')->first();
        $roles = Role::all();
        $permisos_directos_usuario = $usuario->getDirectPermissions();
        $permisos_usuario = $usuario->getAllPermissions();
        $role_usuario = $usuario->getRoleNames();
        $role_usuario = Role::where('name', $role_usuario->first())->first();
        $permisos_restantes = Permission::whereNotIn('name', $role_usuario->permissions->pluck('name'))->get();
        //dd($permisos_restantes);

        return view('modulos.mantenedores.usuario.update', compact('usuario', 'roles', 'permisos_usuario', 'role_usuario', 'permisos_usuario','permisos_restantes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   /* public function update(Request $request, $id)
    {
        //
        $validator = $this->validate(request(), [
            'nombre' => 'required|regex:/^[A-Za-z\s-_]+$/',
            'apellidos' => 'required|regex:/^[A-Za-z\s-_]+$/',
            'password' => 'required|min:8',
            'email' => 'required|email'
        ],
            [
                'regex' => 'No puede ingresar simbolos',
                'email.required' => 'El email es un campo requerido',
                'apellidos.required' => 'Los apellidos son un campo requerido',
                'nombre.required' => 'El nombre es un campo requerido'
            ]);

        try{
            $usuario= User::find($id);
            $usuario->Nombre = mb_strtoupper($request->nombre);
            $usuario->Apellidos = mb_strtoupper($request->apellidos);
            $usuario->Fono = $request->telefono;
            $usuario->Direccion = $request->direccion;
            $usuario->email = $request->email;
            $usuario->C_IdComuna = $request->comuna;
            $usuario->D_IdDiocesis = $request->diocesis;
            $usuario->FechaModifica = date('Y-m-d h:m:s');
            $usuario->UsuarioCreaModifica = Auth::user()->IdUsuario;
            $usuario->password = Hash::make($request->password);
            $usuario->Estado = $request->estado;
            $usuario->save();
            $notificacion = Helpers::Notificaciones(true,'success','Usuario modificado','Se han modificado los datos de usuario');
        }catch (\Exception $e){
            dd($e);
            $notificacion = Helpers::Notificaciones(true,'error','No se pudo guardar','Problemas al modificar el usuario');
        }
        return redirect()->back()->with($notificacion);
    }
    */
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /*public function destroy($id)
    {
        //
    }
*/
  /*  public function cambio_estado($id_usuario, $id_estado){
        try {
            $usuario = User::find($id_usuario);
            $usuario->Estatus = $id_estado;
            $usuario->save();
            $mensaje = 'Estado actualizado';
        }catch(\Exception $e){
            $mensaje = 'Problemas al cambiar estado';
        }
        return response()->json($mensaje);
    }
*/
    /* Pestaña Roles */
   /* public function AjaxPermisosRole(Request $request){
        $role = Role::where('name', $request->input('role'))->first();
        $permisos_role = $role->permissions;
        return view('ajax.ajaxRoles', compact('permisos_role'));
    }

    public function AjaxCambiarRole(Request $request){
        $usuario = User::find($request->input('usuario'));
        $usuario->syncRoles($request->input('role'));
        return response()->json('Asignado');
    }

    /* Pestaña Todos los permisos 
    public function AjaxPermisosTodos(Request $request){
        $usuario = User::find($request->input('usuario'));
        $permisos_todos = $usuario->getAllPermissions();
        return view('ajax.ajaxPermisosTodos', compact('permisos_todos'));
    }*/

    /* Pestaña permisos especiales 
    public function AjaxPermisosUsuario(Request $request){
        $usuario = User::find($request->input('usuario'));
        $role_usuario = $usuario->roles->first();
        $permisos_restantes = Permission::whereNotIn('name', $role_usuario->permissions->pluck('name'))->get();
        return view('ajax.ajaxPermisosUsuario', compact('permisos_restantes', 'usuario'));
    }*/

   /* public function AjaxPermisosCambiar(Request $request){
        $usuario = User::find($request->input('usuario'));
        if($usuario->hasPermissionTo($request->input('permiso'))){
            $usuario->revokePermissionTo($request->input('permiso'));
            $mensaje = 'Permido Revocado';
        }else{
            $usuario->givePermissionTo($request->input('permiso'));
            $mensaje = 'Permido Asignado';
        }
        return response()->json($mensaje);
    }
*/
}
