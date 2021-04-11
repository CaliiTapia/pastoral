<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormacionController extends Controller
{
    //
    public function __construc()
    {
        $this->middleware('auth');
    }
    public function index(){
        Auth::user()->Pagina='formacion';
        return view('modulos.formacion.index');
    }
}