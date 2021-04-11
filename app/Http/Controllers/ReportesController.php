<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\FileController;
use App\Helpers\Helpers;
use App\Comprobante;
use Carbon\Carbon;
use App\AreaNegocio;
use App\CentroCostos;
use App\TipoDocumento;
use App\PlanDeCuentas;
use App\Auxiliar;
use App\Movimientos;
use App\Exports\AreaNegocioExport;
use App\Exports\CentroCostoExport;
use App\Exports\TipoDocumentoExport;
use App\Exports\PlanDeCuentasExport;
use App\Exports\AuxiliaresExport;
use App\Exports\GeneralExport;
use Auth;
use DB;
use Illuminate\Support\Collection as Collection;
use Maatwebsite\Excel\Facades\Excel;

class ReportesController extends Controller
{
    public function index(){
        return view('modulos.contaparroquial.mantenedores.reportes.index');
    }
    
    //AREA NEGOCIO
    public function downloadAreaNegocio(Request $request)
    {
        $areaNegocio = $this->filterAreaNegocio();

        $nombre = $this->nombreInstitucion();
        
        foreach($nombre as $c){
            $nombre= $c->INNombre;        
        }

        return Excel::download(new AreaNegocioExport($areaNegocio), 'Area-Negocio-'. $nombre .'-' . (new Carbon())->format('d-m-Y') . '.xlsx');
    }
    
    function filterAreaNegocio()
    {
        $areaNegocio = AreaNegocio::query()
            ->where('INCodigo', Helpers::codigo_inst_seleccionada());

        return $areaNegocio->get();
    }

    //CENTRO COSTO
    public function downloadCentroCosto(Request $request)
    {
        $centroCosto = $this->filterCentroCosto();

        $nombre = $this->nombreInstitucion();
        
        foreach($nombre as $c){
            $nombre= $c->INNombre;        
        }

        return Excel::download(new CentroCostoExport($centroCosto), 'Centro-Costo-'. $nombre .'-' . (new Carbon())->format('d-m-Y') . '.xlsx');
    }
    
    function filterCentroCosto()
    {
        $centroCosto = CentroCostos::query()
            ->where('INCodigo', Helpers::codigo_inst_seleccionada());

        return $centroCosto->get();
    }

    //TIPO DOCUMENTO
    public function downloadTipoDocumento(Request $request)
    {
        $tipoDocumento = $this->filterTipoDocumento();

        return Excel::download(new TipoDocumentoExport($tipoDocumento), 'Tipo-Documento-' . (new Carbon())->format('d-m-Y') . '.xlsx');
    }
    
    function filterTipoDocumento()
    {
        $tipoDocumento = TipoDocumento::query();

        return $tipoDocumento->get();
    }

    //PLAN DE CUENTAS
    public function downloadPlanDeCuentas(Request $request)
    {
        $planDeCuentas = $this->filterPlanDeCuentas();

        return Excel::download(new PlanDeCuentasExport($planDeCuentas), 'Plan-de-Cuentas-' . (new Carbon())->format('d-m-Y') . '.xlsx');
    }
    
    function filterPlanDeCuentas()
    {
        $planDeCuentas = PlanDeCuentas::query();

        return $planDeCuentas->get();
    }

    //AUXILIARES
    public function downloadAuxiliares(Request $request)
    {
        $auxiliares = $this->filterAuxiliares();

        return Excel::download(new AuxiliaresExport($auxiliares), 'Auxiliares-' . (new Carbon())->format('d-m-Y') . '.xlsx');
    }
    
    function filterAuxiliares()
    {
        $auxliares = Auxiliar::query();

        return $auxliares->get();
    }

    //GENERAL
    public function downloadGeneral(Request $request)
    {
        $general = $this->filterGeneral();

        $nombre = $this->nombreInstitucion();
        
        foreach($nombre as $c){
            $nombre= $c->INNombre;        
        }

        return Excel::download(new GeneralExport($general['areaNegocio'], $general['centroCosto']), 'Reporte-General-'. $nombre .'-'. (new Carbon())->format('d-m-Y') . '.xlsx');
        
    }

    function filterGeneral()
    {
        $areaNegocio = $this->filterAreaNegocio();
        $centroCosto = $this->filterCentroCosto();

        return ['areaNegocio' => $areaNegocio, 'centroCosto' => $centroCosto];
    }

    public function nombreInstitucion(){
        $idInstitucion = Helpers::codigo_inst_seleccionada();

        $nombre = \DB::table('institucion')
        ->select('INNombre')
        ->where('INCodigo', $idInstitucion)
        ->get();

        return $nombre;

    }


}