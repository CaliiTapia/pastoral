<?php

namespace App\Http\Controllers;

use App\TipoRecaudacion;
use App\UnidadRecaudadora;
use App\TipoPago;
use App\Banco;
use App\Zona;
use App\Decanato;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Helpers;

use Illuminate\Http\Request;

class PreboletaController extends Controller
{
    public function Preboleta()
    {
        $tipoRec = TipoRecaudacion::where('Tipo', '=', 'BOLETA')->get();
        $unidadrec = UnidadRecaudadora::all()->where('Estatus', '=', '1');
        $tipo_pago = TipoPago::where('Estatus', '=', '1')->pluck('Nombre', 'IdTipoPago');
        $banco = Banco::where('Estatus', '=', '1')->pluck('Nombre', 'IdBanco');
        return view('modulos.unoporciento.precalculadora', compact('tipoRec', 'unidadrec', 'tipo_pago', 'banco'));
    }

    public function PDF(Request $request){
        $preboleta = array();
        //dd($request);
        $ur_acceso = Helpers::ur_seleccionada(Auth::user());
        $ur = UnidadRecaudadora::find($ur_acceso['IdUnidadRecaudadora']);
        $preboleta['unidadrecaudadora'] = $ur->Nombre;
        $preboleta['zona'] = isset(Zona::find($ur->Z_IdZona)->Nombre) ? Zona::find($ur->Z_IdZona)->Nombre : 'Sin Zona';
        $preboleta['decanato'] = isset(Decanato::find($ur->D_IdDecanato)->Nombre) ? Decanato::find($ur->D_IdDecanato)->Nombre : 'Sin Decanato';
        $preboleta['PorcentajeParroquial'] = isset($ur->aporte->where('TR_IdTipoRecaudacion', 1)->first()->PorcentajeParroquial) ?  $ur->aporte->where('TR_IdTipoRecaudacion', 1)->first()->PorcentajeParroquial : 0;
        $preboleta['NroContribuyente'] = $request->nro_contribuyente;
        $preboleta['FechaEstad'] = $request->fecha_estadistica;
        $preboleta['FechaContab'] = date('d-m-Y');
        $preboleta['NroVisitadora'] = $request->n_visitadores;
        $preboleta['NroCuota'] = $request->n_cuotas;
        $preboleta['MontoPapal'] = $request->aporte_papal;
        $preboleta['MontoAporte'] = $request->monto_aporte;
        $preboleta['PorcRecaudacion'] = $request->comision;
        $preboleta['MontoRecaudacion'] = $request->recaudacion;
        $preboleta['MontoGasto'] = $request->c_gastos;
        $preboleta['MontoDiocesano'] = $request->m_diocesano;
        $preboleta['MontoParroquial'] = $request->m_parroquial;
        $preboleta['Nombre'] = 'Desarrollo';
        $preboleta['tiporecaudacion'] = 'Rendicion oficina Arzobispado';

        $pdf = PDF::loadView('modulos.unoporciento.pdf.preboleta',compact('preboleta'));
        $pdf->setPaper('letter', 'portrait');
        return $pdf->stream('Boleta_'.$ur->Codigo.'.pdf');
    }


}
