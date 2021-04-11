<?php

namespace App\Http\Controllers;

use PDF;
use Auth;
use App\Cuentas;
use App\Auxiliar;
use Carbon\Carbon;
use App\AreaNegocio;
use App\Comprobante;
use App\Movimientos;
use App\CentroCostos;
use App\ComprobanteTipo;
use App\TipoDocumento;
use App\Helpers\Helpers;
use Illuminate\Http\Request;

class ComprobanteController extends Controller
{
    public function index()
    {
        $periodoActivo = Helpers::periodo_actual() != null ? Helpers::periodo_actual()->anoPeriod : null;
        $institucion = Helpers::info_inst_seleccionada();

        $comprobantes = Comprobante::with([
            'movimientos',
            'movimientos.cuenta',
            'movimientos.areaNegocio'
        ])
            ->where('InsCod', Helpers::codigo_inst_seleccionada())
            ->orderBy('cpbNum', 'desc')
            ->take(5)
            ->get();

        $cbtesVmes = Comprobante::where('InsCod', Helpers::codigo_inst_seleccionada())
            ->where('cpbEst', 'V')
            ->whereBetween('cpbFecIn', [
                date('Y-m-d H:i:s', strtotime(date('Y-m-01') . ' 00:00:00')),
                date('Y-m-d H:i:s', strtotime(date('Y-m-t') . ' 23:59:59'))
            ])
            ->orderBy('cpbNum', 'desc')
            ->count();

        $cbtesPmes = Comprobante::where('InsCod', Helpers::codigo_inst_seleccionada())
            ->where('cpbEst', 'P')
            ->whereBetween('cpbFecIn', [
                date('Y-m-d H:i:s', strtotime(date('Y-m-01') . ' 00:00:00')),
                date('Y-m-d H:i:s', strtotime(date('Y-m-t') . ' 23:59:59'))
            ])
            ->orderBy('cpbNum', 'desc')
            ->count();

        return view('modulos.contaparroquial.comprobantes.index', compact('periodoActivo', 'comprobantes', 'cbtesVmes', 'cbtesPmes', 'institucion'));
    }

    public function create()
    {
        $cuentas = Cuentas::get();
        $nroComprobante = Helpers::nuevo_numero_comprobante();
        $periodoActivo = Helpers::periodo_actual() != null ? Helpers::periodo_actual()->anoPeriod : null;
        $centrosDeCostos = CentroCostos::where('INCodigo', Helpers::codigo_inst_seleccionada())->where('estatus', 'A')->get();
        $auxiliares = Auxiliar::where('statusAux', 'A')->get();
        $tipoDoc = TipoDocumento::where('TipDocStatus', 'A')->get();
        $areaNegocio = AreaNegocio::where('INCodigo', Helpers::codigo_inst_seleccionada())->where('areaStatus', 'A')->get();

        $comprobantesTipo = ComprobanteTipo::with(['institucion', 'detalle', 'detalle.cuenta'])
            ->where('INCodigo', Helpers::codigo_inst_seleccionada())
            ->get();

        return view('modulos.contaparroquial.comprobantes.create', compact('periodoActivo', 'nroComprobante', 'cuentas', 'centrosDeCostos', 'auxiliares', 'tipoDoc', 'areaNegocio', 'comprobantesTipo'));
    }

    public function edit($id = null)
    {
        $cuentas = Cuentas::get();
        $periodoActivo = Helpers::periodo_actual() != null ? Helpers::periodo_actual()->anoPeriod : null;
        $centrosDeCostos = CentroCostos::where('INCodigo', Helpers::codigo_inst_seleccionada())->where('estatus', 'A')->get();
        $auxiliares = Auxiliar::where('statusAux', 'A')->get();
        $tipoDoc = TipoDocumento::where('TipDocStatus', 'A')->get();
        $areaNegocio = AreaNegocio::where('INCodigo', Helpers::codigo_inst_seleccionada())->where('areaStatus', 'A')->get();
        $comprobante = Comprobante::with([
            'movimientos',
            'movimientos.cuenta',
            'movimientos.areaNegocio'
        ])
            ->where('InsCod', Helpers::codigo_inst_seleccionada())
            ->where('cpbNum', $id)
            ->firstOrFail();

        if ($comprobante->periodo->anoPeriod != $periodoActivo) {
            $errorObject = [
                'message' => 'Imposible editar, el comprobante se encuentra en un periodo cerrado.',
                'returnTo' => route('contaparroquial.contabilidad.comprobantes')
            ];
            return view('errors.401', compact('errorObject'));
        }

        $detalleMovimientos = [];

        foreach ($comprobante->movimientos as $key => $item) {
            $objeto = [
                'NMov' => $item->movNum,
                'Cuenta' => $item->ctaCod,
                'CuentaText' => $item->ctaCod . ' ' . $item->cuenta->pctNombre,
                'DetalleCuenta' => [
                    'pctCcos' => [
                        'required' => $item->cuenta->pctCcos,
                        'value' => $item->ccCod ? $item->ccCod : '',
                    ],
                    'pctAux' => [
                        'required' => $item->cuenta->pctAux,
                        'value' => $item->codAux ? $item->codAux : '',
                    ],
                    'pctDoc' => [
                        'required' => $item->cuenta->pctDoc,
                        'tipoDoc' => $item->TipDocRef ? $item->TipDocRef : '',
                        'numDoc' => $item->NumDocRef ? $item->NumDocRef : '',
                        'file' => '',
                    ],
                    'pctEDoc' => [
                        'required' => $item->cuenta->pctEDoc,
                        'validado' => $item->NumDocRef ? true : false,
                    ]
                ],
                'Debe' => $item->movDebe,
                'Haber' => $item->movHaber,
                'Descripcion' => $item->movGlosa,
            ];

            array_push($detalleMovimientos, $objeto);
        }

        $comprobante->detalleMovimientos = $detalleMovimientos;

        return view('modulos.contaparroquial.comprobantes.edit', compact('comprobante', 'periodoActivo', 'cuentas', 'centrosDeCostos', 'auxiliares', 'tipoDoc', 'areaNegocio'));
    }

    public function store(Request $request)
    {
        $cabecera = json_decode($request->cabecera);
        $movimientos = json_decode($request->movimientos);

        $comprobanteGuardado = Comprobante::create([
            'InsCod' => Helpers::codigo_inst_seleccionada(),
            'cpbAno' => Helpers::periodo_actual() != null ? Helpers::periodo_actual()->idPeriod : null,
            'cpbNum' => Helpers::nuevo_numero_comprobante(),
            'cpbFec' => date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $cabecera->Fecha))),
            'cpbMes' => explode("/", $cabecera->Fecha)[1],
            'cpbEst' => ((float)$cabecera->totalDebe == (float)$cabecera->totalHaber) ? 'V' : 'P',
            'cpbGlo' => $cabecera->Glosa,
            'cpbTip' => $cabecera->Tipo,
            'usuario' => Auth::id(),
            'cpbFecIn' => date('Y-m-d H:i:s'),
        ]);

        $movimientosGuardados = [];
        foreach ($movimientos as $item) {
            $temp = [
                'cpbAno' => $comprobanteGuardado->cpbAno,
                'cpbNum' => $comprobanteGuardado->cpbNum,
                'movNum' => $item->NMov,
                'areaCod' => $cabecera->areaNegocio,
                'ctaCod' => $item->Cuenta,
                'cpbFec' => $comprobanteGuardado->cpbFec,
                'cpbMes' => $comprobanteGuardado->cpbMes,
                'ccCod' => $item->DetalleCuenta->pctCcos->value ? $item->DetalleCuenta->pctCcos->value : null,
                'cajCod' => null,
                //'movIfCant' => null,
                'DetGCod' => null,
                //'movDetGCant' => null,
                'codAux' => $item->DetalleCuenta->pctAux->value ? $item->DetalleCuenta->pctAux->value : null,
                'TipDocCb' => null,
                //'NumDocCb' => null,
                'TipDocRef' => $item->DetalleCuenta->pctDoc->tipoDoc ? $item->DetalleCuenta->pctDoc->tipoDoc : null,
                'NumDocRef' => $item->DetalleCuenta->pctDoc->numDoc ? $item->DetalleCuenta->pctDoc->numDoc : 0,
                'movDebe' => (float) $item->Debe,
                'movHaber' => (float) $item->Haber,
                'movGlosa' => $item->Descripcion,
                //'monCod' => null,
            ];
            $movimiento = Movimientos::create($temp);
            array_push($movimientosGuardados, $movimiento);
        }

        if (!$comprobanteGuardado || !$movimientosGuardados) {
            return response()->json([
                'error' => true,
                'message' => 'Error al guardar el comprobante, intente nuevamente'
            ]);
        }

        return response()->json([
            'error' => false,
            'message' => 'Comprobante ingresado correctamente'
        ]);
    }

    public function update(Request $request)
    {
        $cabecera = json_decode($request->cabecera);
        $movimientos = json_decode($request->movimientos);

        $comprobanteGuardado = Comprobante::where('cpbNum', $cabecera->Ncbte)->first();
        $comprobanteGuardado->cpbGlo = $cabecera->Glosa;
        $comprobanteGuardado->cpbEst = ((float)$cabecera->totalDebe == (float)$cabecera->totalHaber) ? 'V' : 'P';
        $comprobanteGuardado->cpbAno = Helpers::periodo_actual() != null ? Helpers::periodo_actual()->idPeriod : null;
        $comprobanteGuardado->cpbFec = date("Y-m-d H:i:s", strtotime(str_replace('/', '-', $cabecera->Fecha)));
        $comprobanteGuardado->usuario = Auth::id();
        $comprobanteGuardado->save();

        Movimientos::where('cpbNum', $comprobanteGuardado->cpbNum)->delete();

        $movimientosGuardados = [];
        foreach ($movimientos as $item) {
            $temp = [
                'cpbAno' => $comprobanteGuardado->cpbAno,
                'cpbNum' => $comprobanteGuardado->cpbNum,
                'movNum' => $item->NMov,
                'areaCod' => $cabecera->areaNegocio,
                'ctaCod' => $item->Cuenta,
                'cpbFec' => $comprobanteGuardado->cpbFec,
                'cpbMes' => $comprobanteGuardado->cpbMes,
                'ccCod' => $item->DetalleCuenta->pctCcos->value ? $item->DetalleCuenta->pctCcos->value : null,
                'cajCod' => null,
                //'movIfCant' => null,
                'DetGCod' => null,
                //'movDetGCant' => null,
                'codAux' => $item->DetalleCuenta->pctAux->value ? $item->DetalleCuenta->pctAux->value : null,
                'TipDocCb' => null,
                //'NumDocCb' => null,
                'TipDocRef' => $item->DetalleCuenta->pctDoc->tipoDoc ? $item->DetalleCuenta->pctDoc->tipoDoc : null,
                'NumDocRef' => $item->DetalleCuenta->pctDoc->numDoc ? $item->DetalleCuenta->pctDoc->numDoc : 0,
                'movDebe' => (float) $item->Debe,
                'movHaber' => (float) $item->Haber,
                'movGlosa' => $item->Descripcion,
                //'monCod' => null,
            ];
            $movimiento = Movimientos::create($temp);
            array_push($movimientosGuardados, $movimiento);
        }

        if (!$comprobanteGuardado || !$movimientosGuardados) {
            return response()->json([
                'error' => true,
                'message' => 'Error al guardar el comprobante, intente nuevamente'
            ]);
        }

        return response()->json([
            'error' => false,
            'message' => 'Comprobante ingresado correctamente'
        ]);
    }

    public function filter(Request $request)
    {
        $filter = $request->all();

        $query = Comprobante::query()
            ->with(['periodo', 'movimientos', 'movimientos.cuenta', 'movimientos.areaNegocio'])
            ->where('InsCod', Helpers::codigo_inst_seleccionada());

        if ($filter['n_cbte'] != null) {
            $query->where('cpbNum', $filter['n_cbte']);
        }
        if ($filter['desde_cbte'] != null && $filter['hasta_cbte'] != null) {
            $query->whereBetween('cpbFecIn', [
                date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $filter['desde_cbte']) . ' 00:00:00')),
                date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $filter['hasta_cbte']) . ' 23:59:59'))
            ]);
        }
        if ($filter['tipo_cbte'] != null && $filter['tipo_cbte'] != 'null') {
            $query->where('cpbTip', $filter['tipo_cbte']);
        }
        if ($filter['glosa_cbte'] != null) {
            $query->where('cpbGlo', $filter['glosa_cbte']);
        }
        if ($filter['estado_cbte'] != null && $filter['estado_cbte'] != 'null') {
            $query->where('cpbEst', $filter['estado_cbte']);
        }
        $comprobantes = $query->get();

        return response()->json([
            'comprobantes' => $comprobantes,
        ]);
    }

    public function updateMovimiento(Request $request)
    {
        try{
            $idComprobante = json_decode($request->Comprobante);
            $debe = json_decode($request->Debe);
            $haber = json_decode($request->Haber);
            $descripcion = json_decode($request->Descripcion);
            $NMov = json_decode($request->NMov);
            for($i=0;$i<6;$i++)
            {
                $debe = str_replace(".","",$debe);
                $haber = str_replace(".","",$haber);
    
            }


            $movimientoGuardado =            
            Movimientos::where('movNum',$NMov)
            ->where('cpbNum', $idComprobante)
            ->update(['movDebe' => floatval($debe),
            'movHaber' => floatval($haber),
            'movGlosa' => $descripcion]);
    
            return response()->json([
                'error' => false,
                'message' => 'Comprobante ingresado correctamente'
            ]); 
        }catch (\Exception $e){
            return response()->json([
                'error' => true,
                'message' => 'Error al editar movimiento, intente nuevamente'
        ]);
        }

    }


    public function print($id = null)
    {
        $comprobante = Comprobante::with([
            'periodo',
            'institucion',
            'movimientos',
            'movimientos.cuenta',
            'movimientos.tipoDocumento',
            'movimientos.auxiliar',
            'movimientos.centroCosto',
            'movimientos.areaNegocio',
        ])
            ->where('InsCod', Helpers::codigo_inst_seleccionada())
            ->where('cpbNum', $id)
            ->firstOrFail();

        $periodoActivo = Helpers::periodo_actual() != null ? Helpers::periodo_actual()->anoPeriod : null;
        if (($comprobante->total_debe != $comprobante->total_haber) && ($comprobante->total_debe > 0 && $comprobante->total_haber > 0)) {
            $errorObject = [
                'message' => 'Imposible imprimir, sus totales no cuadran.',
                'returnTo' => route('contaparroquial.contabilidad.comprobantes')
            ];
            return view('errors.401', compact('errorObject'));
        }

        $detalleMovimientos = [];

        foreach ($comprobante->movimientos as $key => $item) {
            $objeto = [
                'NMov' => $item->movNum,
                'Cuenta' => $item->ctaCod,
                'CuentaText' => $item->ctaCod . ' ' . $item->cuenta->pctNombre,
                'DetalleCuenta' => [
                    'pctCcos' => [
                        'required' => $item->cuenta->pctCcos,
                        'value' => $item->ccCod ? $item->ccCod : '',
                    ],
                    'pctAux' => [
                        'required' => $item->cuenta->pctAux,
                        'value' => $item->codAux ? $item->codAux : '',
                    ],
                    'pctDoc' => [
                        'required' => $item->cuenta->pctDoc,
                        'tipoDoc' => $item->TipDocRef ? $item->TipDocRef : '',
                        'numDoc' => $item->NumDocRef ? $item->NumDocRef : '',
                        'file' => '',
                    ],
                    'pctEDoc' => [
                        'required' => $item->cuenta->pctEDoc,
                        'validado' => $item->NumDocRef ? true : false,
                    ]
                ],
                'Debe' => $item->movDebe,
                'Haber' => $item->movHaber,
                'Descripcion' => $item->movGlosa,
            ];

            array_push($detalleMovimientos, $objeto);
        }

        $comprobante->detalleMovimientos = $detalleMovimientos;

        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('modulos.contaparroquial.comprobantes.print', ['comprobante' => $comprobante])->setPaper('a4');
        return $pdf->stream('comprobante-n' . str_pad($comprobante->cpbNum, 8, '0', STR_PAD_LEFT) . '-' . (new Carbon($comprobante->cpbFec))->format('dmY') . '.pdf');
    }
}
