<?php

namespace App\Http\Controllers;

use App\Cuentas;
use App\ComprobanteTipo;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\ComprobanteTipoDetalle;

class ComprobanteTipoController extends Controller
{
    public function index()
    {
        $comprobantesTipo = ComprobanteTipo::with([
            'institucion',
            'detalle',
            'detalle.cuenta',
        ])
            ->where('INCodigo', Helpers::codigo_inst_seleccionada())
            ->get();

        $cuentas = Cuentas::get();

        return view('modulos.contaparroquial.comprobanteTipo.maintainer', compact('comprobantesTipo', 'cuentas'));
    }

    public function store(Request $request)
    {
        $comprobanteTipo = json_decode($request->comprobanteTipo);
        $editingId = $request->editingId;

        if ($editingId > 0) {
            $comprobanteTipoGuardado = ComprobanteTipo::where('id', $editingId)->first();
            $comprobanteTipoGuardado->INCodigo = Helpers::codigo_inst_seleccionada();
            $comprobanteTipoGuardado->alias = $comprobanteTipo->alias;
            $comprobanteTipoGuardado->glosa = $comprobanteTipo->glosa;
            $comprobanteTipoGuardado->cpbTip = $comprobanteTipo->tipo;
            $comprobanteTipoGuardado->isActive = $comprobanteTipo->isActive;
            $comprobanteTipoGuardado->save();
        } else {
            $comprobanteTipoGuardado = ComprobanteTipo::create([
                'INCodigo' => Helpers::codigo_inst_seleccionada(),
                'alias' => $comprobanteTipo->alias,
                'glosa' => $comprobanteTipo->glosa,
                'cpbTip' => $comprobanteTipo->tipo,
                'isActive' => $comprobanteTipo->isActive,
            ]);
        }

        ComprobanteTipoDetalle::where('id_cpbte', $comprobanteTipoGuardado->id)->delete();

        $detallesGuardados = [];
        foreach ($comprobanteTipo->detalleMovimientos as $item) {
            $temp = [
                'id_cpbte' => $comprobanteTipoGuardado->id,
                'codCuenta' => $item->cuenta,
                'setDebe' => $item->debe,
                'setHaber' => $item->haber,
            ];
            $detalle = ComprobanteTipoDetalle::create($temp);
            array_push($detallesGuardados, $detalle);
        }

        if (!$comprobanteTipoGuardado || !$detallesGuardados) {
            return response()->json([
                'error' => true,
                'message' => 'Error al guardar el comprobante tipo, intente nuevamente'
            ]);
        }

        return response()->json([
            'error' => false,
            'message' => 'Comprobante tipo ingresado correctamente'
        ]);
    }

    public function findById($id = null)
    {
        $comprobanteTipo = ComprobanteTipo::with([
            'institucion',
            'detalle',
            'detalle.cuenta',
        ])
            ->where('id', $id)
            ->where('INCodigo', Helpers::codigo_inst_seleccionada())
            ->first();

        return response()->json([
            'comprobanteTipo' => $comprobanteTipo,
        ]);
    }
}
