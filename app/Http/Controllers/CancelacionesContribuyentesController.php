<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TipoRecaudacion;
use App\Contribuyente;
use App\CompromisoPago;
use App\Pago;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\ModelRole;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use PDF;
use Carbon\Carbon;

class CancelacionesContribuyentesController extends Controller
{
    public function __construc()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //$contribuyentes = Contribuyente::all();
        $pagos= Pago::where('UR_IdUnidadRecaudadora', Auth::user()->id_unidad_recaudadora)->limit(45);
        $tiposRecaudacion = TipoRecaudacion::all();
        $compromisos = CompromisoPago::where('UR_IdUnidadRecaudadora', Auth::user()->id_unidad_recaudadora)->pluck('C_IdContribuyente');
        $contribuyentes = Contribuyente::whereIn('IdContribuyente', $compromisos)
            ->select('IdContribuyente', 'Rut', 'Nombre', 'ApellidoPaterno')->get();

        //dd($contribuyentes->toArray());

        return view('modulos.informes.cancelaciones_contribuyentes.index', compact('contribuyentes', 'pagos', 'contribuyentes'));
    }

    public function generarInforme(Request $request)
    {
        $request->validate([
            'SelContribuyente' => 'required',
            'SelAno' => 'required',
        ]);
        
        $compromisos = CompromisoPago::with('contribuyente')
                ->where('UR_IdUnidadRecaudadora', Auth::user()->id_unidad_recaudadora)->get();

        //$tiposRecaudacion = TipoRecaudacion::select('IdTipoRecaudacion', 'Nombre', 'Codigo')->get(); 
        $ano = $request->SelAno;       
        //if($request->SelTipoInforme == 1)
        //{
                $detallePagoContribuyente = Pago::
                //->where('TR_IdTipoRecaudacion', [2,3,5,6,7,8,9,10,11])
                whereYear('FechaPago', (int)$request->SelAno)
                //->where('Estatus', 3)
                ->get();
                $detallePagoContribuyenteEnero = Pago::
                whereYear('FechaPago', (int)$request->SelAno)
                ->WhereMonth('FechaPago', '=', '01')
                ->get();
                $detallePagoContribuyenteFebrero = Pago::
                whereYear('FechaPago', (int)$request->SelAno)
                ->WhereMonth('FechaPago', '=', '02')
                ->get();
                $detallePagoContribuyenteMarzo = Pago::
                whereYear('FechaPago', (int)$request->SelAno)
                ->WhereMonth('FechaPago', '=', '03')
                ->get();
                $detallePagoContribuyenteAbril = Pago::
                whereYear('FechaPago', (int)$request->SelAno)
                ->WhereMonth('FechaPago', '=', '04')
                ->get();
                $detallePagoContribuyenteMayo = Pago::
                whereYear('FechaPago', (int)$request->SelAno)
                ->WhereMonth('FechaPago', '=', '05')
                ->get();
                $detallePagoContribuyenteJunio = Pago::
                whereYear('FechaPago', (int)$request->SelAno)
                ->WhereMonth('FechaPago', '=', '06')
                ->get();
                $detallePagoContribuyenteJulio = Pago::
                whereYear('FechaPago', (int)$request->SelAno)
                ->WhereMonth('FechaPago', '=', '07')
                ->get();
                $detallePagoContribuyenteAgosto = Pago::
                whereYear('FechaPago', (int)$request->SelAno)
                ->WhereMonth('FechaPago', '=', '08')
                ->get();
                $detallePagoContribuyenteSeptiembre = Pago::
                whereYear('FechaPago', (int)$request->SelAno)
                ->WhereMonth('FechaPago', '=', '09')
                ->get();
                $detallePagoContribuyenteOctubre = Pago::
                whereYear('FechaPago', (int)$request->SelAno)
                ->WhereMonth('FechaPago', '=', '10')
                ->get();
                $detallePagoContribuyenteNoviembre = Pago::
                whereYear('FechaPago', (int)$request->SelAno)
                ->WhereMonth('FechaPago', '=', '11')
                ->get();
                $detallePagoContribuyenteDiciembre = Pago::
                whereYear('FechaPago', (int)$request->SelAno)
                ->WhereMonth('FechaPago', '=', '12')
                ->get();

                $pdf= PDF::loadView('modulos.informes.cancelaciones_contribuyentes.tablaEstadPC', compact('compromisos', 'ano', 
                'contribuyentes', 'detallePagoContribuyente', 'detallePagoContribuyenteEnero', 'detallePagoContribuyenteFebrero',
                'detallePagoContribuyenteMarzo', 'detallePagoContribuyenteAbril', 'detallePagoContribuyenteMayo', 'detallePagoContribuyenteJunio',
                'detallePagoContribuyenteJulio', 'detallePagoContribuyenteAgosto', 'detallePagoContribuyenteSeptiembre',
                'detallePagoContribuyenteOctubre', 'detallePagoContribuyenteNoviembre', 'detallePagoContribuyenteDiciembre'));
                return $pdf->stream('detallePC.pdf');
       
    }
}

