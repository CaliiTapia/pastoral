<?php

namespace App\Http\Controllers;

use App\Cuentas;
use App\AreaNegocio;
use App\Comprobante;
use App\Movimientos;
use App\TipoDocumento;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use App\Imports\MovimientosImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Rules\CentroCostoByInstitution;
use Illuminate\Support\Facades\Validator;

class IngresoMasivoController extends Controller
{
    public function index()
    {
        $nroComprobante = Helpers::nuevo_numero_comprobante();
        $periodoActivo = Helpers::periodo_actual() != null ? Helpers::periodo_actual()->anoPeriod : null;
        $tipoDoc = TipoDocumento::where('TipDocStatus', 'A')->get();
        $areaNegocio = AreaNegocio::where('INCodigo', Helpers::codigo_inst_seleccionada())->where('areaStatus', 'A')->get();

        return view('modulos.contaparroquial.ingresoMasivo.index', compact('nroComprobante', 'periodoActivo', 'tipoDoc', 'areaNegocio'));
    }

    public function check(Request $request)
    {
        $cabecera = json_decode($request->cabecera);
        $file = $request->file;
        $message = "";

        $imported = Excel::toArray(new MovimientosImport(), $file);
        $movimientos = $imported[0];
        array_shift($movimientos); // remove headers

        $validator = Validator::make($movimientos, [
            '*.0' => 'required|exists:CP_pctas,pctCod',
            '*.1' => 'min:0',
            '*.2' => 'min:0',
            '*.3' => 'nullable|max:60',
            '*.4' => [new CentroCostoByInstitution],
            '*.5' => 'nullable|exists:CP_auxi,codAux',
            '*.6' => 'nullable|exists:CP_tipdoc,TipDoc',
            '*.7' => 'nullable|numeric',
        ], [
            '*.0.required' => 'Debe ingresar una cuenta contable.',
            '*.0.exist' => 'Cuenta contable no existe.',
            '*.1.min' => 'Valor Debe, debe ser mínimo 0.',
            '*.2.min' => 'Valor Debe, debe ser mínimo 0.',
            '*.3.max' => 'El detalle de la glosa debe contener máximo 60 caracteres.',
            '*.5.exists' => 'Auxiliar no existe.',
            '*.6.exists' => 'Tipo de documento no existe.',
        ]);

        foreach ($movimientos as $key => $item) {
            if (!isset($movimientos[$key][8])) {
                $movimientos[$key][8] = [];
            }
        }

        // add error messages to validate array
        foreach ($validator->errors()->toArray() as $key => $error) {
            $keyToFind = explode(".", $key)[0];
            array_push($movimientos[$keyToFind][8], $error[0]);
        }

        // add custom rules error messages
        foreach ($movimientos as $key => $item) {
            $cuentaContable = Cuentas::where('pctCod', $item[0])->first();

            if ($cuentaContable->pctCcos == 'S' && $item[4] == null) {
                array_push($movimientos[$key][8], 'Debe ingresar un centro de costos.');
            }
            if ($cuentaContable->pctAux == 'S' && $item[5] == null) {
                array_push($movimientos[$key][8], 'Debe ingresar un auxiliar.');
            }
            if ($cuentaContable->pctDoc == 'S' && $item[6] == null) {
                array_push($movimientos[$key][8], 'Debe ingresar un tipo de documento.');
            }
            if ($cuentaContable->pctDoc == 'S' && $item[7] == null) {
                array_push($movimientos[$key][8], 'Debe ingresar el numero de documento.');
            }
        }

        $totalDebe = array_sum(array_map(function ($item) {
            return floor($item[1]);
        }, $movimientos));

        $totalHaber = array_sum(array_map(function ($item) {
            return floor($item[2]);
        }, $movimientos));

        $passed = true;

        foreach ($movimientos as $key => $item) {
            if (count($movimientos[$key][8]) > 0) {
                $passed = false;
            }
        }

        if ($totalDebe != $totalHaber) {
            $passed = false;
        }

        if (count($movimientos) < 2) {
            $passed = false;
            $message = "el ingreso masivo debe contener al menos 2 movimientos para procesar.";
        }

        return response()->json([
            'passed' => $passed,
            'movimientos' => $movimientos,
            'errors' => $validator->errors(),
            'message' => $message,
            'totales' => ['debe' => $totalDebe, 'haber' => $totalHaber]
        ]);
    }

    public function process(Request $request)
    {
        $cabecera = json_decode($request->cabecera);
        $file = $request->file;

        $imported = Excel::toArray(new MovimientosImport(), $file);
        $movimientos = $imported[0];
        array_shift($movimientos); // remove headers

        $comprobanteGuardado = Comprobante::create([
            'InsCod' => Helpers::codigo_inst_seleccionada(),
            'cpbAno' => Helpers::periodo_actual() != null ? Helpers::periodo_actual()->idPeriod : null,
            'cpbNum' => Helpers::nuevo_numero_comprobante(),
            'cpbFec' => date("Y-m-d H:i:s", strtotime($cabecera->Fecha)),
            'cpbMes' => explode("/", $cabecera->Fecha)[1],
            'cpbEst' => ((float)$cabecera->totalDebe == (float)$cabecera->totalHaber) ? 'V' : 'P',
            'cpbGlo' => $cabecera->Glosa,
            'cpbTip' => $cabecera->Tipo,
            'usuario' => Auth::id(),
            'cpbFecIn' => date('Y-m-d H:i:s'),
        ]);

        $movimientosGuardados = [];
        foreach ($movimientos as $key => $item) {
            $temp = [
                'cpbAno' => $comprobanteGuardado->cpbAno,
                'cpbNum' => $comprobanteGuardado->cpbNum,
                'movNum' => ($key + 1),
                'areaCod' => $cabecera->areaNegocio,
                'ctaCod' => $item[0],
                'cpbFec' => $comprobanteGuardado->cpbFec,
                'cpbMes' => $comprobanteGuardado->cpbMes,
                'ccCod' => $item[4] ? $item[4] : null,
                'cajCod' => null,
                //'movIfCant' => null,
                'DetGCod' => null,
                //'movDetGCant' => null,
                'codAux' => $item[5] ? $item[5] : null,
                'TipDocCb' => null,
                //'NumDocCb' => null,
                'TipDocRef' => $item[6] ? $item[6] : null,
                'NumDocRef' => $item[7] ? $item[7] : 0,
                'movDebe' => (float) $item[1],
                'movHaber' => (float) $item[2],
                'movGlosa' => $item[3] != '' ? $item[3] : $cabecera->Glosa,
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
}
