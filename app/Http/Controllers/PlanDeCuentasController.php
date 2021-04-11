<?php

namespace App\Http\Controllers;

use App\Cuentas;
use App\Periodo;
use App\Comprobante;
use App\Movimientos;
use App\PlanDeCuentas;
use App\Helpers\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\PlanDeCuentasImport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class PlanDeCuentasController extends Controller
{
    public function index()
    {
        $planCuentas = \DB::table('CP_pctas')
            ->select('pctCod', 'pctNivel', 'pctNombre', 'pctTipo')
            ->get();

        return view('modulos.contaparroquial.mantenedores.planDeCuentas.index', compact('planCuentas'));
    }

    public function buscar(Request $request)
    {
        $planCuentas = \DB::table('CP_pctas')
            ->select('pctCod', 'pctNivel', 'pctNombre', 'pctTipo')
            ->where('pctCod', $request->txtBuscar)
            ->orWhere('pctNombre', $request->txtBuscar)

            ->get();

        return view('modulos.contaparroquial.mantenedores.planDeCuentas.index', compact('planCuentas'));
    }

    public function crear()
    {
        return view('modulos.contaparroquial.mantenedores.planDeCuentas.crear');
    }

    public function store(Request $request)
    {
        $PlanCuentasExiste = PlanDeCuentas::select('pctCod')
            ->where('pctCod', $request->idPC)
            ->get();

        $div1 = 0;
        $div2 = 0;
        $div3 = 0;
        $div4 = 0;
        $div5 = 0;
        $nivel = 0;

        $div1 = substr($request->idPC, 0, 1);
        $div2 = substr($request->idPC, 1, 2);
        $div3 = substr($request->idPC, 2, 4);
        $div4 = substr($request->idPC, 4, 7);
        $div5 = substr($request->idPC, 7, 10);

        if ($div1 > 0) {
            $nivel = 1;
        }

        if ($div2 > 0) {
            $nivel = 2;
        }

        if ($div3 > 0) {
            $nivel = 3;
        }

        if ($div4 > 0) {
            $nivel = 4;
        }

        if ($div5 > 0) {
            $nivel = 5;
        }

        if ($PlanCuentasExiste->isEmpty()) {
            try {
                $pdc = new PlanDeCuentas();

                $pdc->pctCod = $request->idPC;
                $pdc->pctNivel = $nivel;
                $pdc->pctNombre = $request->nombrePC;
                $pdc->pctTipo = $request->tipoPC;
                $pdc->pctCcos = $request->cc;
                $pdc->pctAux = $request->au;
                $pdc->pctDoc = $request->do;
                $pdc->pctEDoc = $request->aa;
                $pdc->pctConb = $request->cb;
                $pdc->pctMonAd = $request->ma;
                $pdc->pctDetG = $request->dg;
                $pdc->pctPptoCaja = $request->pc;
                $pdc->pctInFin = $request->if;
                $pdc->pctDetLi = $request->lb;

                $pdc->save();

                $notificacion = Helpers::Notificaciones(true, 'success', '¡Exito!', 'Su cuenta contable se creo con éxito');
            } catch (Exception $e) {
                $notificacion = Helpers::Notificaciones(true, 'error', 'Error!', 'Su cuenta contable no se registro con éxito.');
            }
        } else {
            $notificacion = Helpers::Notificaciones(true, 'error', 'Error!', 'El cuenta contable ya existe.');
        }

        return redirect()->action('PlanDeCuentasController@index')->with($notificacion);
    }

    public function editar($idPC)
    {
        $datos = \DB::table('CP_pctas')
            ->select('*')
            ->where('pctCod', $idPC)
            ->get();

        return view('modulos.contaparroquial.mantenedores.planDeCuentas.editar', compact('datos'));
    }

    public function edit(Request $request, $cod)
    {
        try {
            PlanDeCuentas::where('pctCod', '=', $cod)
                ->update([
                    'pctNombre' =>  $request->nombrePC,
                    'pctTipo' =>  $request->tipoPC,
                    'pctCcos' => $request->cc,
                    'pctAux' =>  $request->au,
                    'pctDoc' =>  $request->do,
                    'pctEDoc' =>  $request->aa,
                    'pctConb' =>  $request->cb,
                    'pctMonAd' =>  $request->ma,
                    'pctDetG' =>  $request->dg,
                    'pctPptoCaja' =>  $request->pc,
                    'pctInFin' =>  $request->if,
                    'pctDetLi' =>  $request->lb,
                ]);

            $notificacion = Helpers::Notificaciones(true, 'success', '¡Exito!', 'Su cuenta contable se modificó con éxito');
        } catch (\Exception $e) {
            $notificacion = Helpers::Notificaciones(true, 'error', 'Error!', 'Su cuenta contable no se modificó con éxito.');
        }
        return redirect()->action('PlanDeCuentasController@index')->with($notificacion);
    }

    public function eliminar($id)
    {
        try {

            $data = PlanDeCuentas::select('*')
                ->join('CP_movim', 'CP_pctas.pctCod', '=', 'CP_movim.ctaCod')
                ->where('CP_movim.ctaCod', $id)
                ->get();

            if (count($data) > 0) {
                $notificacion = Helpers::Notificaciones(true, 'error', 'Error!', 'Su cuenta contable no se puede eliminar porque tiene movimientos.');
            } else {
                PlanDeCuentas::where('pctCod', $id)->delete();
                $notificacion = Helpers::Notificaciones(true, 'success', '¡Exito!', 'Su cuenta contable se eliminó con éxito');
            }
        } catch (Exception $e) {
            $notificacion = Helpers::Notificaciones(true, 'error', 'Error!', 'Su cuenta contable no se eliminó');
        }
        return redirect()->action('PlanDeCuentasController@index')->with($notificacion);
    }

    public function cargaMasiva(Request $request)
    {
        $file = $request->file;

        $imported = Excel::toArray(new PlanDeCuentasImport(), $file);
        $movimientos = $imported[0];
        array_shift($movimientos); // remove excel headers

        $movimientosGuardados = [];
        $errors = [];
        foreach ($movimientos as $key => $item) {
            $firstDigitOfCode = substr($item[0], 0, 1);
            $temp = [
                'pctCod' => $item[0],
                'pctNivel' => $item[2] ?: null,
                'pctNombre' => $item[1] ?: null,
                'pctTipo' => ($firstDigitOfCode == 1 ? "A" : ($firstDigitOfCode == 2 ? "P" : ($firstDigitOfCode == 3 ? "X" : ($firstDigitOfCode == 4 ? "I" : ($firstDigitOfCode == 5 ? "G" : null))))),
                'pctCcos' => strtoupper($item[3]) ?: null,
                'pctAux' => strtoupper($item[4]) ?: null,
                'pctDoc' => strtoupper($item[5]) ?: null,
                'pctEDoc' => "N",
                'pctConb' => strtoupper($item[6]) ?: null,
                'pctMonAd' => strtoupper($item[7]) ?: null,
                'pctDetG' => strtoupper($item[8]) ?: null,
                'pctPptoCaja' => strtoupper($item[9]) ?: null,
                'pctInFin' => strtoupper($item[10]) ?: null,
                'pctDetLi' => strtoupper($item[11]) ?: null,
            ];

            try {
                Cuentas::create($temp);
                array_push($movimientosGuardados, $temp);
            } catch (\Illuminate\Database\QueryException $e) {
                array_push($errors, [
                    'codigo' => $temp['pctCod'],
                    'data' => $temp,
                    'error_message' => $e->errorInfo[2],
                    'error_code' => $e->errorInfo[1],
                    'error_message_formatted' => ($e->errorInfo[1] == 1062) ? "La cuenta contable {$temp['pctCod']} ya existe" : "La cuenta contable {$temp['pctCod']} contiene información errónea"
                ]);
            }
        }

        if ($errors) {
            return response()->json([
                'error' => $errors,
                'message' => 'Completado con errores'
            ]);
        }

        return response()->json([
            'error' => false,
            'message' => 'Carga masiva ingresada correctamente'
        ]);
    }
}
