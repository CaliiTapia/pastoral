<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helpers;
use App\Visitador;
use App\Cargo;
use Illuminate\Support\Facades\Auth;

class VisitadorController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        return view('modulos.mantenedores.visitadores.index');
    }
}
