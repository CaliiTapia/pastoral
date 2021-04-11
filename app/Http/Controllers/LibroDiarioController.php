<?php

namespace App\Http\Controllers;

use App\Periodo;
use Carbon\Carbon;
use App\AreaNegocio;
use App\Comprobante;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Exports\ComprobantesExport;
use Maatwebsite\Excel\Facades\Excel;

class LibroDiarioController extends Controller
{
    public function index()
    {
        $periodos = Periodo::where('INCOdigo', Helpers::codigo_inst_seleccionada())->get();
        $periodoActivo = Helpers::periodo_actual() != null ? Helpers::periodo_actual()->idPeriod : null;
        $institucion = Helpers::info_inst_seleccionada();
        $areaNegocio = AreaNegocio::where('INCodigo', Helpers::codigo_inst_seleccionada())->where('areaStatus', 'A')->get();

        return view('modulos.contaparroquial.libroDiario.index', compact('periodos', 'periodoActivo', 'institucion', 'areaNegocio'));
    }

    public function generatePreview(Request $request)
    {
        $filtros = json_decode($request->filtros);
        $comprobantes = $this->filterComprobantes($filtros);

        return response()->json([
            'data' => $comprobantes
        ]);
    }

    public function download(Request $request)
    {
        $filtros = json_decode(json_encode($request->query()), FALSE);

        $comprobantes = $this->filterComprobantes($filtros);

        return Excel::download(new ComprobantesExport($comprobantes, $filtros), 'libro-diario-' . (new Carbon())->format('d-m-Y') . '.xlsx');
    }

    function filterComprobantes($filtros)
    {
        $comprobantes = Comprobante::query()
            ->with([
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
            ->where('cpbEst', 'V');

        if ($filtros->periodo != '') {
            $comprobantes->where('cpbAno', $filtros->periodo);
        }
        if ($filtros->tipo != '' && $filtros->tipo != 'all') {
            $comprobantes->where('cpbTip', $filtros->tipo);
        }
        if ($filtros->desde != '') {
            $comprobantes->where('cpbNum', '>=', $filtros->desde);
        }
        if ($filtros->hasta != '') {
            $comprobantes->where('cpbNum', '<=', $filtros->hasta);
        }
        if ($filtros->areaNegocio != '' && $filtros->areaNegocio != 'all') {
            $comprobantes->whereHas('movimientos', function ($q) use ($filtros) {
                $q->where('areaCod', $filtros->areaNegocio);
            });
        }

        return $comprobantes->get();
    }
}
