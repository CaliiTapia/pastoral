<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Acceso;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {
        $url = $request->session()->get('url');
        $url = isset($url['intended']) && $url['intended'] != null ? $url['intended'] : route('urSeleccionar'); // Cambiar ruta de inicio de sesion panel por otra como 'home'
        if (env('APP_ENV') === 'production') {
            $url = str_replace('http', 'https', $url);
        }
        $this->validate(request(), [
            'email' => 'required',
            'password' => 'required',
        ], [
            'email.required' => 'Debe ingresar un usuario',
            'password.required' => 'Debe ingresar contraseña',
        ]);
        $credenciales['email'] = $request->email;
        $credenciales['password'] = $request->password;

        //dd(Auth::attempt($credenciales),$request->password,$request->email);

        if (Auth::attempt($credenciales)) {
            $idUsr = Auth::user()->IdUsuario;
            $accesos = Acceso::where('U_idUsuario', $idUsr)->get(); //first();
            if (!empty($accesos) && count($accesos) > 1) {
                Acceso::where('U_idUsuario', $idUsr)->update(['EnUso' => 'false']);
            }
            // User::where('IdUsuario',$idUsr)->update(['UltimaConeccion'=>date('Y-m-d h:m:s')]);
            return redirect($url);  // Redireccionara a la ruta escrita arriba

        }
        return back()->withErrors(['password' => 'Usuario y/o contraseña no coinciden']);
    }
}
