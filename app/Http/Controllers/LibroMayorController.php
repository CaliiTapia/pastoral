<?php

namespace App\Http\Controllers;

use App\Cuentas;
use App\Periodo;
use Carbon\Carbon;
use App\AreaNegocio;
use App\Movimientos;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Exports\MovimientosExport;
use Maatwebsite\Excel\Facades\Excel;

class LibroMayorController extends Controller
{
    public function index()
    {
        $periodos = Periodo::where('INCOdigo', Helpers::codigo_inst_seleccionada())->get();
        $periodoActivo = Helpers::periodo_actual() != null ? Helpers::periodo_actual() : null;
        $cuentas = Cuentas::get();
        $areaNegocio = AreaNegocio::where('INCodigo', Helpers::codigo_inst_seleccionada())->where('areaStatus', 'A')->get();

        return view('modulos.contaparroquial.libroMayor.index', compact('periodos', 'periodoActivo', 'cuentas', 'areaNegocio'));
    }

    public function generatePreview(Request $request)
    {
        $filtros = json_decode($request->filtros);
        $movimientos = $this->filterByParams($filtros);

        return response()->json([
            'data' => $movimientos
        ]);
    }

    public function download(Request $request)
    {
        $filtros = json_decode(json_encode($request->query()), FALSE);
        $comprobantes = $this->filterByParams($filtros);

        return Excel::download(new MovimientosExport($comprobantes, $filtros), 'libro-mayor-' . (new Carbon())->format('d-m-Y') . '.xlsx');
    }

    function filterByParams($filtros)
    {
        $query = Movimientos::query()
            ->with([
                'cuenta',
                'tipoDocumento',
                'auxiliar',
                'centroCosto',
                'areaNegocio',
                'comprobante',
                'comprobante.periodo',
            ])
            ->whereHas('comprobante', function ($q) {
                $q->where('InsCod', Helpers::codigo_inst_seleccionada());
            });

        if ($filtros->periodo != '') {
            $query->where('cpbAno', $filtros->periodo);
        }
        if (isset($filtros->cuentas) && $filtros->cuentas != null) {
            $query->whereIn('ctaCod', $filtros->cuentas);
        }
        if ($filtros->areaNegocio != '' && $filtros->areaNegocio != 'all') {
            $query->where('areaCod', $filtros->areaNegocio);
        }
        if ($filtros->desde != '' && $filtros->hasta != '') {
            $query->whereBetween('cpbFec', [
                date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $filtros->desde) . ' 00:00:00')),
                date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $filtros->hasta) . ' 23:59:59'))
            ]);
        }

        $query->orderBy('ctaCod');

        return $query->get();
    }
}
