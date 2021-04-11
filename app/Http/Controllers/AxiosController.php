<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cuentas;
use Illuminate\Database\Eloquent\Collection;
use Cookie;

class AxiosController extends Controller
{
    public function createCbte(){
        $collection = new Collection();
        $cuentas = Cuentas::get();
        $collection->push($cuentas);
        // $ur_accesos = Acceso::where('EnUso', 'true')->where('U_IdUsuario', Auth::user()->IdUsuario)->pluck('I_INCodigo');
        //valida si el acceso esta seleccionado
        // if($ur_accesos->isEmpty()){
            
        //     $response = ['status'=>'ERROR','route'=>route('urSeleccionar')];
        //     //se crea la cookie para saber su pagina de origen
        //     $rutaOrigen = asset('/pastoral/listado/'.$IdFicha.'/edit');
        //     $minutes = 1;
        //     Cookie::queue('BackPage', $rutaOrigen, $minutes);
        //     return response()->json($response);
        // }
        return response()->json($collection);
    }
}
