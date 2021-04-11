<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class GeneralExport implements FromView{

    public function __construct($areaNegocio, $centroCosto)
    {
        $this->areaNegocio = $areaNegocio;
        $this->centroCosto = $centroCosto;
    }

    public function view(): View
    {
        return view('modulos.contaparroquial.mantenedores.reportes.general', [
            'areaNegocio' => $this->areaNegocio,
            'centroCosto' => $this->centroCosto,
        ]);
    }

}